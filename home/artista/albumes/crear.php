<?php

  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

  
  require '../database.php';


  if (!empty($_POST['nombre']) && !empty($_POST['imagen'])) {
    $sql = "INSERT INTO album (nombre, id_compositor, imagen) VALUES (:nombre, :imagen, :creador)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':imagen', $_POST['imagen']);
    $stmt->bindParam(':creador', $_SESSION['user_id']);
    if ($stmt->execute()) {
      print 'Se creo el album';
    } else {
      print  'Ocurrio un error al crear el album';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'header.php' ?>
    <meta charset="utf-8">
    <title>Crear album</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="/login/assets/css/style.css">
  </head>
  <body>



    <h1>Crear album</h1>

    <form action="crear.php" method="POST">
      <input name="nombre" type="text" placeholder="Ingrese nombre de la playlist">
      <input name="imagen" type="text" placeholder="Ingrese imagen">
      <input type="submit" value="Submit">
    </form>

  </body>
</html>