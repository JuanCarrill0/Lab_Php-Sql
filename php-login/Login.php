<?php
    require 'Database.php';

      //Register PHP
    $accountNumber=rand(1000000000000000,999999999999999);
    $message = '';
    if (!empty($_POST['usernameRegister']) && !empty($_POST['passwordRegister']) && !empty($_POST['emailRegister']) && !empty($_POST['celnumberRegister'])) {
        $sql = "INSERT INTO users (username, email, password, numTelefono, accountNumber) VALUES (:usernameRegister, :emailRegister, :passwordRegister, :celnumberRegister,:accountNumber)";
        $stmt = $conn->prepare($sql);

        // Set parameters
        $paramUsername =  $_POST['usernameRegister'];
        $paramEmail =  $_POST['emailRegister'];
        $password = password_hash($_POST['passwordRegister'], PASSWORD_BCRYPT);
        $paramnumTelefono =  $_POST['celnumberRegister'];
        $paramNumber = $accountNumber;
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':usernameRegister', $paramUsername);
        $stmt->bindParam(':emailRegister', $paramEmail);
        $stmt->bindParam(':passwordRegister', $password);
        $stmt->bindParam(':celnumberRegister',$paramnumTelefono );
        $stmt->bindParam(':accountNumber',$paramNumber);
        // Attempt to execute the prepared statement
        if ($stmt->execute()){
          $message = 'Successfully created new user';
        } else {
          $message = 'Sorry there must have been an issue creating your account';
        }
    }

      //Login PHP

      session_start();

      if (isset($_SESSION['user_id'])) {
        $Sesion = true;
        header('Location: /php-login');
      }

      if (!empty($_POST['usernameLogin']) && !empty($_POST['passwordLogin'])) {
        $records = $conn->prepare('SELECT id, username, password FROM users WHERE username = :usernameLogin');
        $records->bindParam(':usernameLogin', $_POST['usernameLogin']);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
    
        $message = '';
    
        if (count($results) > 0 && password_verify($_POST['passwordLogin'], $results['password'])) {
          $_SESSION['user_id'] = $results['id'];
          $Sesion = true;
          $message = 'Loogeado';
          header("Location: /php-login");
        } else {
          $message = 'Sorry, those credentials do not match';
        }
      }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Alata&family=Josefin+Sans:wght@300&display=swap"
      rel="stylesheet"
    />
    <link rel="shortcut icon" href="/assets/favicon.png" type="image/x-icon" />

    <link rel="stylesheet" href="assets/css/styles_Login.css" />
    <title>Login</title>
  </head>

  <body style='background-image: url("assets/images/bg-Login.png");'>
    <main class="content">
      <!-- Left Content  -->
      <section class="argument">
        <h2 class="title">Manage your money effectively</h2>
        <p class="text text-position">
          We help you to make the control in your monthly expenses .
          <br />
          Is time to make better control of your expenses and set a strategy.
          <br />
          ¡Register Now!.
        </p>
      </section>
      <!-- Right Content -->
      <div class="aside">
        <div class="topBox" id="topBox">
          <p>
            <span class="text-White"> Enter your data - </span>
            <span class="text-Green">Is time to take care your economy</span>
          </p>
        </div>

        <!-- Form "Iniciar Sesion"-->
        <div class="form-sesion" id="form-sesion">
          
        <?php if(!empty($message)): ?>
          <p> <?= $message ?></p>
        <?php endif; ?>

          <form action="" id="formSesion" method="POST">
            <input
              class="form-input"
              type="text"
              id="userName"
              placeholder="User Name"
              autocomplete="off"
              name="usernameLogin"
            />
            <input
              class="form-input"
              type="password"
              id="password"
              placeholder="password"
              name="passwordLogin"
            />
            <input class="link" type="submit" id="login" value="Login" />
          </form>
          <div class="text-min">
            <p class="text-gray">
              Do not you have account? ¡Create you account!
            </p>
          </div>
          <div class="text-red" id="button-register">Click Here</div>
        </div>


        <!-- Form "Registrarse" -->
        <div class="form-register" id="form-register" >
        <?php if(!empty($message)): ?>
            <p> <?= $message ?></p>
        <?php endif; ?>
          <form action="" id="formRegister" method="POST">
            <input
              class="form-input"
              type="text"
              id="userNameRegister"
              placeholder="User Name"
              name="usernameRegister"

            />
            <input
              class="form-input"
              type="email"
              id="email"
              placeholder="E-Mail"
              name="emailRegister"
            />
            <input
              class="form-input"
              type="number"
              id="numCel"
              placeholder="Cel Number"
              name="celnumberRegister"
            />
            <input
              class="form-input"
              type="password"
              id="passwordRegister"
              placeholder="New Password"
              name="passwordRegister"
            />
            <input
              class="form-input"
              type="password"
              id="confirmPassword"
              placeholder="Confirm Password"
              name="passwordRegister"
            />
            <input class="link" type="submit" id="register" value="Register" />
          </form>
          <a class="text-red" href="Login.php">Back</a>
        </div>
      </div>
    </main>
    <script src="assets/js/app_Login.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>


