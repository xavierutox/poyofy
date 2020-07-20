<?php require 'header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT nombre, imagen FROM canciones WHERE id_creador = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetchAll();

    if (count($results) > 0) {
        foreach ($results as $result){
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="Cinque Terre" width="500" height="400"></a>';
            print '<div class="desc"> Nombre de la cancion: '.$result['nombre'].'</div>';
            print '<input type="submit" class="button" name="eliminar" value="eliminar" />';
            print '<input type="submit" class="button" name="editar" value="editar" /></div>';
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
  height: auto;
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