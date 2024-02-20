<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Ricette</title>
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

        .message {
            margin-top: 20px;
            margin-left: 9rem;
            margin-right: 9rem;
        }

        body{
            background: url("https://images.pexels.com/photos/2631489/pexels-photo-2631489.jpeg") no-repeat center;
            background-size: cover;
            min-height: 150vh;
            overflow-y: auto;
            background-position: center;
            background-attachment: fixed;
        }

        .car-form {
            border: 1px solid rgba(0, 0, 0, 0.5); /* Aggiungi un bordo con colore e spessore specificati */
            background-color: rgba(255, 255, 255, 0.7); /* Sfondo opaco */
            padding: 1rem; /* Aggiungi spazio intorno al contenuto */
            margin-left: 17rem; /* Aggiungi margine sinistro per allineare con il resto del contenuto */
            margin-right: 15rem; /* Aggiungi margine destro per allineare con il resto del contenuto */
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
    require_once "Connection.php";

    $logged = false;
    $isSearch = false;
    if(isset($_COOKIE['utente'])){
        $logged = true;
    }

    $connessione = new Connection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['logout'])){
            if ($logged) {
                unset($_COOKIE['utente']);
                setcookie('utente', '', time() - (86100 * 15), "/");
                $logged = false;
            } else {
                $message = "Non hai eseguito l'accesso";
            }
        }
        else if(isset($_POST['add'])){
            if($logged){
                $connessione->closeConn();
                Header('Location: InserisciMacchina.php');
                exit;
            }
            else{
                $message = 'Serve effettuare l\'accesso per aggiungere o modificare ricette';
            }
        }
        else if(isset($_POST['login'])){
            $connessione->closeConn();
            header('Location: Login.php');
            exit;
        }
        else if(isset($_POST['search'])){
            $testo = $_POST['searchtxt'];
            $carsDb = $connessione->search($testo);
            $isSearch = true;
        }

    }
    ?>
</head>
<body>
<header class="bg-orange-500 p-4 flex justify-between items-center">
    <a href="MacchineView.php">
        <h1 class="text-white text-6xl font-serif font-extrabold">DRIVE PASSION</h1>
    </a>

    <nav class="flex w-90 items-center">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class="container flex flex-row items-center w-90 mr-10 mt-4">
            <input type="search" id="default-search" name="searchtxt" class="w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" value="<?php echo isset($testo) ? htmlspecialchars($testo) : '' ?>" required/>
            <button type="submit" name="search" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
        </form>

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class="flex items-center">
            <button type="submit" name="add" class="text-white hover:text-white text-2xl font-bold underline-center mr-10 mt-2">AGGIUNGI</button>
            <?php if ($logged) : ?>
                <button type="submit" name="logout" class="text-white hover:text-white text-2xl font-bold underline-center mr-3 mt-2">DISCONNETTITI</button>
            <?php else : ?>
                <button type="submit" name="login" class="text-white hover:text-white text-2xl font-bold underline-center mr-3 mt-2">ACCEDI</button>
            <?php endif; ?>
        </form>
    </nav>
</header>

<div class="message">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl text-white font-bold mb-4 ml-11 mt-3">Car by community</h1>
        <p class="text-red-600 font-bold mr-11">
            <?php if (isset($message)) : ?>
                <?php echo $message; ?>
            <?php elseif (isset($_GET['message'])) : ?>
                <?php $message = htmlspecialchars($_GET['message']); ?>
                <?php echo $message; ?>
            <?php endif; ?>
        </p>
    </div>
</div>
<?php


if(!$isSearch){
    $carsDb = $connessione->getCars();
}


if(empty($carsDb)) {
    echo '<div class="border border-gray-300 p-4 mb-5 mx-auto max-w-xl text-center text-white text-4xl">';
    echo '<p>The current page is empty</p>';
    echo '</div>';
}
else{
    foreach ($carsDb as $currentCar){
        $objectCar = new Macchina($currentCar['id'], $currentCar['username'] , $currentCar['brand'], $currentCar['model'], $currentCar['description'], $currentCar['price']);
        echo '<form action="ModificaMacchina.php" method="post" class="car-form">';
        echo '<input type="hidden" name="carId" value="' . $objectCar->getId() . '">';
        echo '<button type="submit" name="delete" class="float-right font-bold text-xl text-red-800">X</button>';
        echo '<h2 class="text-xl font-bold mb-2">' . $objectCar->getMarca() . ' ' . $objectCar->getModello() . '</h2>';
        echo '<p>Macchina di ' . $objectCar->getUser() . '</p>';
        echo '<p><strong>Descrizione:</strong> ' . $objectCar->getDescrizione() . '</p>';
        echo '<p><strong>Prezzo:</strong> ' . $objectCar->getPrezzo() . '</p>';
        echo '<button type="submit" name="modifica" class="bg-blue-500 text-white px-4 py-2 mt-2">Modifica Caratteristiche</button>';
        echo '</form>';
    }
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
