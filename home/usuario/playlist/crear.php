<?php

  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

  
  require '../database.php';


  if (!empty($_POST['nombre']) && !empty($_POST['imagen'])) {
    $sql = "INSERT INTO playlist (nombre, imagen, id_creador, seguidores) VALUES (:nombre, :imagen, :creador, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':imagen', $_POST['imagen']);
    $stmt->bindParam(':creador', $_SESSION['user_id']);
    if ($stmt->execute()) {
      print ' <div class="footer">se creo la playlist</div>';
    } else {
      print  'Ocurrio un error al crear la playlist';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'header.php' ?>
    <meta charset="utf-8">
    <title>Crear playlist</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="/login/assets/css/style.css">
  </head>
  <body>



    <h1>Crear Playlist</h1>

    <form action="crear.php" method="POST">
      <input name="nombre" type="text" placeholder="Ingrese nombre de la playlist">
      <input name="imagen" type="text" placeholder="Ingrese imagen">
      <input type="submit" value="Submit">
    </form>

  </body>
  <style>
  .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    padding: 10px;
}
</style>
</html>