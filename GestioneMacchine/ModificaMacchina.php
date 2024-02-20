<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Ricetta</title>
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
    require_once "Macchina.php";
    require_once ("Connection.php");

    $logged = false;
    if(isset($_COOKIE['utente'])){
        $logged = true;
    }
    else{
        Header('Location: MacchineView.php');
        exit;
    }

    $connessione= new Connection();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['mod'])){
            $idMacchina = $_POST['carId'];

            if ($idMacchina !== null) {
                $carsDB = $connessione->getCars();

                foreach ($carsDB as $car) {

                    if($car['id'] == $idMacchina) {
                        $username = $_COOKIE['utente'];
                        $brand = $_POST['brand'];
                        $model = $_POST['model'];
                        $description = $_POST['description'];
                        $price = $_POST['price'];

                        $connessione->updateCar($idMacchina, $username, $brand, $model, $description, $price);
                    }
                }
                $connessione->closeConn();
                header('Location: MacchineView.php');
                exit;
            }
        }
        elseif(isset($_POST['back'])){
            // Se l'azione è tornare indietro
            $connessione->closeConn();
            header('Location: MacchineView.php');
            exit;
        }
        elseif(isset($_POST['delete'])){
            // Se l'azione è eliminare la ricetta

            $idMacchina = $_POST['carId'];

            if ($idMacchina !== null) {
                $carsDB = $connessione->getCars();

                foreach ($carsDB as $car) {

                    if($car['id'] == $idMacchina){
                        if($logged && $car['username'] == $_COOKIE['utente']){

                            $eliminato  = true;
                            $connessione->deleteCar($car['id']);

                        }
                    }
                }

                if(!isset($eliminato)){
                        // Se l'utente non è autorizzato a eliminare la ricetta
                        header('Location: MacchineView.php?message=' . urlencode("Solo l'utente che ha creato la ricetta può cancellarla"));
                        exit;
                }
                else{
                    $connessione->closeConn();
                    header('Location: MacchineView.php');
                    exit;
                }
           /* $macchineSalvate = json_decode(file_get_contents('Macchine.json'), true);

            $idMacchina = $_POST['carId'];
            foreach ($macchineSalvate as $key => &$macchina) {
                if ($macchina['id'] == $idMacchina) {
                    if ($logged && $macchina['nomeUtente'] == $_COOKIE['utente']) {
                        unset($macchineSalvate[$key]);
                        $fileJSON = json_encode($macchineSalvate, JSON_PRETTY_PRINT);
                        file_put_contents('Macchine.json', $fileJSON);
                        header('Location: MacchineView.php');
                        exit;
                    }*/


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
    <h1 class="text-3xl text-white font-semibold mb-6">Modifica Vettura</h1>
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $idMacchina = $_POST['carId'];

        if ($idMacchina !== null) {
            $carsDB = $connessione->getCars();
            $macchinaSelezionata = null;

            foreach ($carsDB as $car) {
                if ($car['id'] == $idMacchina) {
                    if ($logged && $car['username'] == $_COOKIE['utente']) {
                        $macchinaSelezionata = $car;
                        break;
                    } else {

                        $connessione->closeconn();
                        header('Location: MacchineView.php?message=' . urlencode("Solo l'utente che ha creato la ricetta può modificarla"));
                        exit;
                    }
                }
            }
            if ($macchinaSelezionata !== null) {
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                    <input type="hidden" name="carId" value="<?php echo $macchinaSelezionata['id'];?>">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="brand">Marca:</label>
                        <select id="brand" name="brand" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <?php
                            $marche_disponibili = array(
                                "Toyota", "Ford", "Chevrolet", "Honda", "BMW", "Mercedes-Benz", "Audi", "Volkswagen", "Ferrari",
                                "Lamborghini", "Porsche", "Tesla", "Nissan", "Subaru", "Mazda", "Hyundai", "Kia", "Jeep", "Volvo",
                                "Fiat", "Alfa Romeo", "Land Rover", "Jaguar", "Lexus", "Maserati", "Bentley", "Rolls-Royce", "McLaren", "Bugatti"
                            );

                            foreach ($marche_disponibili as $marca) {
                                $selected = ($macchinaSelezionata['brand'] == $marca) ? 'selected' : '';
                                echo "<option value=\"$marca\" $selected>$marca</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mt-4 text-gray-700 text-sm font-bold mb-2" for="model">Modello:</label>
                        <input type="text" id="model" name="model" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $macchinaSelezionata['model']; ?>">
                    </div>

                    <div class="mb-4">
                        <label class="block mt-4 text-gray-700 text-sm font-bold mb-2" for="description">Descrizione:</label>
                        <textarea id="description" name="description" rows="6" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo $macchinaSelezionata['description']; ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mt-4 text-gray-700 text-sm font-bold mb-2" for="price">Prezzo:</label>
                        <input type="number" id="price" name="price" step="100" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $macchinaSelezionata['price']; ?>">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" name="mod" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Modifica</button>
                        <button type="submit" name="back" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Torna indietro</button>
                    </div>
                </form>
                <?php
            }
        }
    }
    ?>
    <?php
    // Stampa il messaggio, se presente
    if(isset($message)){
        echo "<p class='text-red-500'>$message</p>";
    }
    ?>
</div>

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
