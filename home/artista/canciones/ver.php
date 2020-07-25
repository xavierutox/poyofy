<?php require 'header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT nombre, imagen, id, id_creador FROM canciones WHERE id_creador = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetchAll();

    if(isset($_POST['album'])){
      $check = $conn->prepare('SELECT id FROM contienen_album WHERE id_cancion = :id and id_album = :al');
      $check->bindParam(':id', $_POST['cancion']);
      $check->bindParam(':al', $_POST['album']);  
      $check->execute();
      if ($check->fetch(PDO::FETCH_ASSOC) == 0) {
          $select = $_POST['album'];
          $song = $_POST['cancion'];
          $sql = $conn->prepare('INSERT INTO contienen_album (id_cancion, id_album) values (:id, :al)');
          $sql->bindParam(':id', $song);
          $sql->bindParam(':al', $select);
          $sql->execute();
          print ' <div class="footer">se añadio al album</div>'; 
          }
      else{
          print ' <div class="footer">ya esta en el album</div>';
        }
    }

    if (count($results) > 0) {
        foreach ($results as $result){
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['añadir_'.$result['id']])){
            print '<div class="footer">';
            print '<form action="ver.php" method="POST">';
            print '<label for="album">Elige un album:</label>';
            print '<select name="album" id="album">';
            #hora de imprimir todas las playlist del usuario
            $playlist = $conn->prepare('SELECT id, nombre FROM album where id_compositor=:id');
            $playlist->bindParam(':id', $_SESSION['user_id']);
            $playlist->execute();
            $plist = $playlist->fetchAll();
            if (count($plist) > 0) {
              foreach ($plist as $pl){
                print '<option value="'.$pl['id'].'">'.$pl['nombre'].'</option>';
              }
            }
            print '</select>';
            print '<input type="text" name="cancion" value="'.$result['id'].'"style="display: none" />';
            print '<input type="submit" name="submit"  value="Añadir">';
            print '</form>';
            print '</div>';
          }
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['eliminar_'.$result['id']])){
            print 'falta el codigo de eliminar';
          }
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['editar_'.$result['id']])){
            $_SESSION['cancion'] = $result['id'];
            header("Location: editar.php");
          }


            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="Cinque Terre" class="foto" width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['nombre'].'</div>';
            print '<form action="ver.php" method="post">';
            print '<input type="submit" class="button" name="añadir_'.$result['id'].'" value="añadir" />';
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