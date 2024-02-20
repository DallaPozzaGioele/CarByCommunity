<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Registrazione</title>

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

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

          $username = $_POST['username'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $cpassword = $_POST['confermaPassword'];

          if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $message = 'Formato email non valida';
          }
          else if ($password != $cpassword) {
              $message = 'Le password non coincidono';
          } else {

              $connessione = new Connection();

              $message = $connessione->checkValidUsername($username);

              if($message == ''){
                  $connessione->insertUser($username, $email, $password);
                  $connessione->closeConn();
                  Header('Location: Login.php');
                  exit();
              }
          }
      }      
    ?>
</head>
<body>
<header class="bg-orange-500 p-4 flex justify-between items-center">
    <a href="MacchineView.php">
        <h1 class="text-white text-6xl font-serif font-extrabold">DRIVE PASSION</h1>
    </a>

    <nav class="flex items-center space-x-4">
        <a href="MacchineView.php" class="text-white hover:text-white text-2xl font-bold underline-center">HOME</a>
        <a href="Login.php" class="text-white hover:text-white text-2xl font-bold underline-center">ACCEDI</a>
    </nav>
</header>
<div class="w-full h-full flex flex-col items-center justify-start mt-16">
    <h1 class="text-2xl font-bold text-white mb-4">Registrazione</h1>

    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class="w-full max-w-5xl px-4 py-8 bg-white rounded-lg shadow-lg">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
            <input type="text" name="username" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:shadow-outline-blue">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="text" name="email" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:shadow-outline-blue">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:shadow-outline-blue">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" name="confermaPassword" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:shadow-outline-blue">
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-700">Registrati</button>
    </form>

    <p class="mt-4 text-white text-sm">Hai un account? <a href="Login.php" class="text-blue-500">Accedi</a></p>

    <p class="mt-4 text-red-600 text-sm">
        <?php if (isset($message)) : ?>
            <?php echo $message; ?>
        <?php endif; ?>
    </p>

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