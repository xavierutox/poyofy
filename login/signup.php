<?php

  require 'database.php';

  $message = '';

  if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['tipo']) && !empty($_POST['nombre']) && !empty($_POST['imagen'])) {
    $sql = "INSERT INTO users (email, password, tipo, usuario, imagen, seguidores) VALUES (:email, :password, :tipo, :nombre, :imagen, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':tipo', $_POST['tipo']);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':imagen', $_POST['imagen']);

    # Comprobemos si el usuario o correo no existe

    $check = $conn->prepare('SELECT id FROM users WHERE usuario = :usuario or email= :email');
    $check->bindParam(':usuario', $_POST['nombre']);
    $check->bindParam(':email', $_POST['email']);
    $check->execute();
    
    if ($check->fetch(PDO::FETCH_ASSOC) == 0) {
        if ($stmt->execute()) {
            $message = 'Usuario creado';
          } else {
            $message = 'Ocurrio un error :c';
          }
    }else{
        $message = 'El usuario o correo ya existe';
    }
    
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registrate</title>
    <?php require '../header.php' ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Registrate</h1>

    <form action="signup.php" method="POST">
      <input name="nombre" type="text" placeholder="Nombre de usuario">
      <input name="email" type="text" placeholder="Correo">
      <input name="tipo" type="text" placeholder="Tipo de cuenta artista/usuario">
      <input name="imagen" type="text" placeholder="Url imagen de perfil">
      <input name="password" type="password" placeholder="Ingrese contraseña">
      <input type="submit" value="Submit">
    </form>

  </body>
</html>