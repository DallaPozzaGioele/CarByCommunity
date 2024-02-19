<?php

class Connection
{
    private $servername = "localhost";

    private $username = "root";

    private $password = "";

    private $conn;

    private $database = "gestione_macchine";

    public function __construct()
    {
        $this->connect();
        $this->selectOrCreateDatabase();
        $this->createTableUser();
        $this->createTableCar();
    }

    public function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password);

        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function selectOrCreateDatabase()
    {
        $query = "CREATE DATABASE IF NOT EXISTS $this->database";

        if (!mysqli_query($this->conn, $query)) {
            die("Errore durante la creazione del database: " . mysqli_error($this->conn));
        }

        mysqli_select_db($this->conn, $this->database);
    }

    public function createTableUser()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS user (
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            PRIMARY KEY (username)
        )";

            if ($this->conn->query($sql) !== TRUE) {
                throw new Exception("Error creating table utente: " . $this->conn->error);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function createTableCar()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS car (
            id INT NOT NULL AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL,
            brand VARCHAR(255) NOT NULL,
            model VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL,
            price FLOAT NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (username) REFERENCES user (username)
        )";

            if ($this->conn->query($sql) !== TRUE) {
                throw new Exception("Error creating table car: " . $this->conn->error);
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertUser(string $username, string $email, string $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashedPassword);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Utente inserito correttamente";
            } else {
                echo "Errore durante l'inserimento dell'utente";
            }

            $stmt->close();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertCar(string $username, string $brand, string $model, string $description, float $price)
    {
        try {

            $sql = "INSERT INTO car (username, brand, model, description, price) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssd", $username, $brand, $model, $description, $price);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Macchina inserito correttamente";
            } else {
                echo "Errore durante l'inserimento della macchina";
            }

            $stmt->close();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function checkValidUsername(string $username): string
    {
        $message = '';
        $sql = "SELECT COUNT(*) AS num_rows
            FROM user
            WHERE username = '{$username}';";

        $result = $this->conn->query($sql);

        if ($result === false) {
            throw new Exception("Error checking existing username: " . $this->conn->error);
        }

        $row = $result->fetch_assoc();
        $numRows = $row['num_rows'];

        if ($numRows > 0) {
            $message = 'Nome utente già in uso';
        }

        return $message;
    }

    public function login(string $username, string $password) : bool
    {
        $sql = "SELECT * FROM user WHERE username = '{$username}'";
        $result = $this->conn->query($sql);

        if ($result === false) {
            throw new Exception("Error executing login query: " . $this->conn->error);
        }

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getCars()
    {
        $sql = "SELECT * FROM car";
        $result = $this->conn->query($sql);

        if ($result === false) {
            throw new Exception("Error executing getCars query: " . $this->conn->error);
        }

        $cars = array(); // Inizializza un array per salvare le auto

        while ($row = $result->fetch_assoc()) {
            $cars[] = $row; // Aggiungi la riga corrente all'array delle auto
        }

        return $cars;
    }

    public function updateCar($idMacchina, $username, $brand, $model, $description, $price)
    {
        try
        {
            $sql = "UPDATE car SET username=?, brand=?, model=?, description=?, price=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("ssssdi", $username, $brand, $model, $description, $price, $idMacchina);

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Macchina aggiornata correttamente";
            } else {
                echo "Nessuna modifica apportata alla macchina";
            }


            $stmt->close();
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function deleteCar($carId)
    {
        try {
            $sql = "DELETE FROM car WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $carId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Macchina eliminata correttamente";
            } else {
                echo "Nessuna macchina eliminata";
            }

            $stmt->close();
        } catch (Exception $e) {
            echo "Errore durante l'eliminazione della macchina: " . $e->getMessage();
        }
    }

    public function search($testo)
    {
        $sql = "SELECT * FROM car WHERE 
            username LIKE '%$testo%' OR 
            brand LIKE '%$testo%' OR 
            description LIKE '%$testo%' OR 
            price LIKE '%$testo%'";

        $result = $this->conn->query($sql);

        if ($result === false) {
            throw new Exception("Error executing search query: " . $this->conn->error);
        }

        $cars = array();

        while ($row = $result->fetch_assoc()) {
            $cars[] = $row;
        }

        return $cars;
    }
    public function closeConn()
    {
        $this->conn->close();
    }


}

?>