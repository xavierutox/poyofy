<?php

  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

  
  require 'database.php';

  $message = '';

  if (!empty($_POST['nombre']) && !empty($_POST['imagen'])) {
    $sql = "INSERT INTO canciones (nombre,imagen, id_creador, seguidores) VALUES (:nombre, :imagen, :creador, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':imagen', $_POST['imagen']);
    $stmt->bindParam(':creador', $_SESSION['user_id']);
    if ($stmt->execute()) {
      $message = 'Se subio la cancion';
    } else {
      $message = 'Ocurrio un error al subir la cancion';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'header.php' ?>
    <meta charset="utf-8">
    <title>Agregar cancion</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="/login/assets/css/style.css">
  </head>
  <body>


    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Agregar cancion</h1>

    <form action="crear.php" method="POST">
      <input name="nombre" type="text" placeholder="Ingrese nombre de la cancion">
      <input name="imagen" type="text" placeholder="Ingrese imagen">
      <input type="submit" value="Submit">
    </form>

  </body>
</html>