<?php
  session_start();

  require 'database.php';
  require 'log.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT name, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
  
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    
    $user = null;

    if (is_array($results) && count($results) > 0) {
      $user = $results;
     

    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Bienvenido</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php require 'partials/header.php' ?>

    <?php if(!empty($user)): ?>
    <br> Bienvenido <?php echo $user['name'] ; ?>

      
      <br>Ha iniciado sesión correctamente 
      <a href="logout.php">  <br>
        Cerrar sesion
      </a>
    <?php else: ?>
      
      <h1>Seleccione una opcion </h1>

      <a href="login.php">Ingrese</a> o
      <a href="signup.php">Regstreseº</a>
    <?php endif; ?>
  </body>
</html>
