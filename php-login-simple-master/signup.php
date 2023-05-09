<?php

  require 'database.php';

  $message ='';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $sql = "INSERT INTO users (email, password, name) VALUES (:email, :password, :name)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':email', $_POST['email']);  
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':name', $_POST['name']);  

    if ($stmt->execute()) {
      $message = 'Usuario creado exitosammente';
    } else {
      $message = 'Lo sentimos, hubo un error al crear la cuenta. Vuelva a intentarlo';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registrate</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  </head>
  <body>

    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Crear Cuenta</h1>
    <span>o <a href="login.php">Ingresar</a></span>

    <form action="signup.php" method="POST">
      <input name="name" type="text" placeholder="Ingrese un nombre">
      <input name="email" type="text" placeholder="Ingresar correo electronico">
      <input name="password" type="password" placeholder="Ingrese una contraseña">
      <input name="confirm_password" type="password" placeholder="Confirme la contraseña">
      
      <div class="mb-3" id="UNO">
        <div class="g-recaptcha" id="DOS" data-sitekey="6LcBCNclAAAAAMBSiFqGWuc-mut8KmNVtNdPAtv0"> 
  
         </div>

      </div>

      <input type="submit" value="Enviar">
    </form>

  </body>
</html>
