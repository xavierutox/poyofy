<?php

  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

  
  require 'database.php';

  $message = '';

  if (!empty($_POST['nombre']) && !empty($_POST['imagen'])) {
    $sql = "UPDATE album set nombre=:nombre, imagen=:imagen where id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['Album']);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':imagen', $_POST['imagen']);
    if ($stmt->execute()) {
      $message = 'Se actualizo la playlist';
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
    <title>editar album</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  </head>
  <body>


    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Editar album</h1>
    <?php 
    $sql = "SELECT * from album where id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['Album']);
    $stmt->execute();
    $user = $stmt->fetchAll()
    ?>

    <form action="editar.php" method="POST">
      <input name="nombre" type="text" placeholder="Ingrese nuevo nombre" value="<?php echo $user[0]['nombre'] ?>">
      <input name="imagen" type="text" placeholder="Ingrese nueva imagen" value="<?php echo $user[0]['imagen'] ?>">
      <input type="submit" class="send" value="Submit"><br>
      <input type="submit" name="borrar" class="delete" value="Eliminar album">
    </form>

  </body>
</html>
<?php 
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['borrar'])){
    $sql = "DELETE from album where id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['Album']);
    $stmt->execute();
    header("Location: ver.php");
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