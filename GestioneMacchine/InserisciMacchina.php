<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Macchina</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        window.addEventListener('scroll', function() {
            var footer = document.getElementById('footer');
            var scrollPosition = window.scrollY;

            if (scrollPosition > 100) { // Puoi modificare 100 con la posizione desiderata
                footer.style.bottom = '0';
            } else {
                footer.style.bottom = '-100px';
            }
        });
    </script>


    <style>
        .underline-center {
            position: relative;
            display: inline-block;
            box-sizing: border-box;
        }

        .underline-center::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background-color: white;
            transition: width 0.3s;
        }

        .underline-center:hover::after {
            width: 100%;
        }

        body{
            background: url("https://images.pexels.com/photos/2631489/pexels-photo-2631489.jpeg") no-repeat center;
            background-size: cover;
            min-height: 150vh;
            overflow-y: auto;
            background-position: center;
            background-attachment: fixed;
        }

        .footer {
            position: fixed;
            bottom: -100px; /* Nascondi il footer inizialmente */
            left: 0;
            width: 100%;
            background-color: #000;
            color: #fff;
            padding: 20px;
            text-align: center;
            transition: bottom 0.3s ease; /* Aggiungi transizione per un effetto più fluido */
        }
    </style>

    <?php
    require_once('Connection.php');

    $logged = false;
    if(isset($_COOKIE['utente'])){
        $logged = true;
    }
    else{
        Header('Location: MacchineView.php');
        exit;
    }

    $connessione = new Connection();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['back'])){
            Header('Location: MacchineView.php');
            exit;
        }
        else if(isset($_POST['add'])){
            $brand = $_POST['brand'];
            $model = $_POST['model'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $username = $_COOKIE['utente'];

            if (empty($brand) || empty($model) || empty($description) || empty($price)) {
                $message = "Compila tutti i campi del form";
            }
            else{

                $connessione->insertCar($username, $brand, $model, $description, $price);
                $connessione->closeConn();
                Header('Location: MacchineView.php');
                exit;
            }
        }
    }
    ?>

</head>
<body class="bg-gray-100">
<header class="bg-orange-500 p-4 flex justify-between items-center">
    <a href="MacchineView.php">
        <h1 class="text-white text-6xl font-serif font-extrabold">DRIVE PASSION</h1>
    </a>
    <nav class="flex items-center space-x-4">
        <a href="MacchineView.php" class="text-white hover:text-white text-2xl font-bold underline-center mr-3">HOME</a>
    </nav>
</header>
<div class="max-w-md mx-auto mt-8 px-4">
    <h1 class="text-3xl text-white font-semibold mb-6">Aggiungi Vettura</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="brand">Marca:</label>
        <select id="brand" name="brand" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="Toyota">Toyota</option>
            <option value="Ford">Ford</option>
            <option value="Chevrolet">Chevrolet</option>
            <option value="Honda">Honda</option>
            <option value="BMW">BMW</option>
            <option value="Mercedes-Benz">Mercedes-Benz</option>
            <option value="Audi">Audi</option>
            <option value="Volkswagen">Volkswagen</option>
            <option value="Ferrari">Ferrari</option>
            <option value="Lamborghini">Lamborghini</option>
            <option value="Porsche">Porsche</option>
            <option value="Tesla">Tesla</option>
            <option value="Nissan">Nissan</option>
            <option value="Subaru">Subaru</option>
            <option value="Mazda">Mazda</option>
            <option value="Hyundai">Hyundai</option>
            <option value="Kia">Kia</option>
            <option value="Jeep">Jeep</option>
            <option value="Volvo">Volvo</option>
            <option value="Fiat">Fiat</option>
            <option value="Alfa Romeo">Alfa Romeo</option>
            <option value="Land Rover">Land Rover</option>
            <option value="Jaguar">Jaguar</option>
            <option value="Lexus">Lexus</option>
            <option value="Maserati">Maserati</option>
            <option value="Bentley">Bentley</option>
            <option value="Rolls-Royce">Rolls-Royce</option>
            <option value="McLaren">McLaren</option>
            <option value="Bugatti">Bugatti</option>
        </select>
        <label class="block mt-4 text-gray-700 text-sm font-bold mb-2" for="model">Modello:</label>
        <input type="text" id="model" name="model" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <label class="block mt-4 text-gray-700 text-sm font-bold mb-2" for="description">Descrizione:</label>
        <textarea id="description" name="description" rows="6" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        <label class="block mt-4 text-gray-700 text-sm font-bold mb-2" for="price">Prezzo:</label>
        <input type="number" id="price" name="price" step="100" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <div class="mt-6 flex justify-between">
            <button type="submit" name="add" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Aggiungi</button>
            <button type="submit" name="back" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Torna indietro</button>
        </div>
    </form>
    <?php
    if(isset($message)){
        echo "<p class='text-red-500 mt-4'>$message</p>";
    }
    ?>


    <footer class="footer" id="footer">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <p class="text-gray-200">© 2024 Drive Passion</p>
                <p class="text-gray-200">Autore: Gioele Dalla Pozza</p>
                <p class="text-gray-200">Email: dpgioele@gmail.com</p>
                <p class="text-gray-200">Telefono: 3703053842</p>
            </div>
            <div class="flex space-x-4">
                <a href="#" class="text-gray-200 hover:text-blue-600">Termini di servizio</a>
                <a href="#" class="text-gray-200 hover:text-blue-600">Privacy Policy</a>
            </div>
        </div>
    </footer>
</body>
</html>
