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
    <title>Bienvenido a poyofy</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php if(!empty($user) && $user['tipo']=='usuario'): ?>
        <?php header('Location: /home/usuario'); ?>
    <?php elseif(!empty($user) && $user['tipo']=='artista'): ?>
        <?php header('Location: /home/artista'); ?>
    <?php else: ?>
      <h1>Por favor ingresa o registrate</h1>

      <a href="login.php">Ingresa</a> o <a href="signup.php">Registrate</a>
    <?php endif; ?>
  </body>
</html>