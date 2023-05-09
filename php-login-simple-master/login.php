<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /php-login');
  }
  require_once 'database.php';
  require_once 'log.php';


  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];

      //guardar_registro('email',false,'');
      guardar_registro($_POST['email'], false, '', $_SERVER['REMOTE_ADDR'], true);


      header("Location: index.php");
    } else {
      $message = 'Lo sentimos, no se';
      guardar_registro($_POST['email'], true, '', $_SERVER['REMOTE_ADDR'], false);
    }
  }

?>

<!DOCTYPE html>
<html>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://www.google.com/recaptcha/api.js"></script>

  <head>
    <meta charset="utf-8">
    <title>Ingresar</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Ingresar</h1>
    <span>o <a href="signup.php">Crear Cuenta</a></span>

    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Ingrese correo electronico">
      <input name="password" type="password" placeholder="Ingrese su contraseña">
      <input type="submit" value="Enviar">
    </form>
  </body>
</html>
