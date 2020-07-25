<?php

  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

  
  require 'database.php';

  $message = '';

  if (!empty($_POST['nombre']) && !empty($_POST['imagen']) && !empty($_POST['correo']) && !empty($_POST['password']) && !empty($_POST['tipo'])) {
    $sql = "UPDATE users set usuario=:nombre, email=:email,imagen=:imagen, tipo=:tipo, password=:password where id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['correo']);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':tipo', $_POST['tipo']);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':imagen', $_POST['imagen']);
    if ($stmt->execute()) {
      $message = 'Se actualizo el perfil';
      header("Location: /login/logout.php");
    } else {
      $message = 'Ocurrio un error al actualizar el perfil';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require 'header.php' ?>
    <meta charset="utf-8">
    <title>editar usuario</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  </head>
  <body>


    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Editar usuario</h1>
    <?php 
    $sql = "SELECT * from users where id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetchAll()
    ?>

    <form action="config.php" method="POST">
      <input name="nombre" type="text" placeholder="Ingrese nuevo nombre" value="<?php echo $user[0]['usuario'] ?>">
      <input name="correo" type="text" placeholder="Ingrese nuevo correo" value="<?php echo $user[0]['email'] ?>">
      <input name="imagen" type="text" placeholder="Ingrese nueva imagen" value="<?php echo $user[0]['imagen'] ?>">
      <input name="tipo" type="text" placeholder="Ingrese nuevo tipo" value="<?php echo $user[0]['tipo'] ?>">
      <input name="password" type="password" placeholder="Ingrese nueva contraseña">
      <input type="submit" class="send" value="Submit"><br>
      <input type="submit" name="borrar" class="delete" value="Borrar cuenta">
    </form>

  </body>
</html>
<?php 
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['borrar'])){
    $sql = "DELETE from users where id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $sql = "DELETE from subscriben where id_usuario=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $sql = "DELETE from gustan where id_usuario=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $sql = "DELETE from seguidores where id_seguidor=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $sql = "DELETE from seguidores where id_seguido=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    header("Location: /login/logout.php");
}
?>

<style>
/* General */
body {
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
    text-align: center;
    background-color: #a4ec9a;
  }
  
  /* Input Forms*/
  input[type="text"], input[type="password"]{
    outline: none;
    padding: 20px;
    display: block;
    width: 300px;
    border-radius: 3px;
    border: 1px solid rgb(146, 233, 161);
    margin: 20px auto;
  }
  
  input[class="send"] {
    padding: 10px;
    color: #fff;
    background: #31dd65;
    width: 320px;
    margin: 20px auto;
    margin-top: 0;
    border: 0;
    border-radius: 3px;
    cursor: pointer;
  }
  input[class="send"]:hover {
    background-color: #083602;
  }
  input[class="delete"] {
    padding: 10px;
    color: #fff;
    background: #dd4831;
    width: 320px;
    margin: 20px auto;
    margin-top: 0;
    border: 0;
    border-radius: 3px;
    cursor: pointer;
  }
  input[class="delete"]:hover {
    background-color: #360c02;
  }
  

 
  </style>