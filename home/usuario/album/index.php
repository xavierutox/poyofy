<?php require 'header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT id, nombre, imagen, id_compositor FROM album');
    $records->execute();
    $results = $records->fetchAll();
  
    if (count($results) > 0) {
        foreach ($results as $result){
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ver_'.$result['id']])){
            $_SESSION['Album'] = $result['id'];
            header("Location: canciones.php");
          }
      
          $rec = $conn->prepare('SELECT usuario FROM users where id=:id');
          $rec->bindParam(':id', $result['id_compositor']);
          $rec->execute();
          $res = $rec->fetchAll();
          print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
          print '<img src="'.$result['imagen'].'" alt="Cinque Terre" width="500" height="400" class="foto"></a>';
          print '<div class="desc"><b>'.$result['nombre'].'</b><br>Creador: '.$res[0]['usuario'].'</div>';
          print '<form action="index.php" method="post">';
          print '<input type="submit" class="button" name="ver_'.$result['id'].'" value="ver" />';
          print ' </form></div>';
        }
      } else {
        print ':c';
      }

?>
<head>
<style>
.galeria {
  overflow: hidden;
}
div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 150px;
}

div.gallery:hover {
  border: 1px solid #777;
}

.foto {
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
</head>
<body>