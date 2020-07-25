<?php require 'header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT nombre, imagen, id FROM album WHERE id_compositor = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetchAll();

    if (count($results) > 0) {
        foreach ($results as $result){
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ver_'.$result['id']])){
            $_SESSION['Album'] = $result['id'];
            header("Location: canciones.php");
          }
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['editar_'.$result['id']])){
            $_SESSION['Album'] = $result['id'];
            header("Location: editar.php");
          }
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="Cinque Terre" width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['nombre'].'</div>';
            print '<form action="ver.php" method="post">';
            print '<input type="submit" class="button" name="ver_'.$result['id'].'" value="ver" />';
            print '<input type="submit" class="button" name="editar_'.$result['id'].'" value="editar" /></form></div>';
        }
      } else {
        print ':c';
      }

?>
<head>
<style>
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 150px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: 100px;
}

div.desc {
  padding: 15px;
  text-align: center;
}
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 5px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
}
</style>
</head>
<body>