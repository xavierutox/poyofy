<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $message = '';
    $records = $conn->prepare('SELECT id, email, tipo, usuario FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;
    if (count($results) > 0) {
      $user = $results;
    }
  }
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="/home/style.css">
  </head>
  <body>
    <div class="navbar">
        <a href="/home/usuario/index.php">Home</a>
        <div class="dropdown">
            <button class="dropbtn">Canciones
            <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <a href="/home/usuario/canciones">Descubrir</a>
            <a href="/home/usuario/canciones/liked.php">Me gustan</a>
            </div>
        </div>
        <a href="/home/usuario/index.php">Albumes</a>
        <div class="dropdown">
            <button class="dropbtn">Playlist
            <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <a href="#">Ver</a>
            <a href="#">Seguidas</a>
            <a href="/home/usuario/playlist/crear.php">Crear</a>
            </div>
        </div>
        <div class="dropdown">
            <button class="dropbtn"><?= $user['usuario']; ?>
            <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
            <a href="#">Ver perfil</a>
            <a href="#">Seguidos</a>
            <a href="#">Configuracion</a>
            <a href="/login/logout.php">Cerrar sesion</a>
            </div>
        </div>
    </div>
    
  </body>
</html>








