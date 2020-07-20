<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /login');
  }
  require 'database.php';

  if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
    $message = '';
    $records = $conn->prepare('SELECT id, password FROM users WHERE usuario = :usuario');
    $records->bindParam(':usuario', $_POST['usuario']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
        $_SESSION['user_id'] = $results['id'];
        header("Location: /login");
      } else {
        $message = 'Contraseña incorrecta :c';
      }
    

  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Ingresa</title>
    <?php require '../header.php' ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Ingresa</h1>

    <form action="login.php" method="POST">
      <input name="usuario" type="text" placeholder="Ingresa tu nombre de usuario">
      <input name="password" type="password" placeholder="Ingresa tu contraseña">
      <input type="submit" value="Submit">
    </form>
  </body>
</html>