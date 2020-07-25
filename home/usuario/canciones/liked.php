<?php require '../header.php';
error_reporting(E_ERROR | E_PARSE);
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT nombre, imagen, id_creador, id FROM liked_songs WHERE id_usuario=:id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetchAll();
    if(isset($_POST['playlist'])){
      $select = $_POST['playlist'];
      $song = $_POST['cancion'];
      $sql = $conn->prepare('INSERT INTO contienen (id_cancion, id_playlist) values (:id, :pl)');
      $sql->bindParam(':id', $song);
      $sql->bindParam(':pl', $select);
      $sql->execute();
    }

    if (count($results) > 0) {
        foreach ($results as $result){
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['unfollow'.$result['id']])){
              $like = $conn->prepare('DELETE FROM gustan where id_usuario=:usuario and id_cancion=:cancion');
              $like->bindParam(':usuario', $_SESSION['user_id']);
              $like->bindParam(':cancion', $result['id']);
              $like->execute();
              header("Refresh:0");   
            }
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST["añadir".$result['id']])){
              print '<div class="footer">';
              print '<form action="liked.php" method="POST">';
              print '<label for="playlist">Elige una playlist:</label>';
              print '<select name="playlist" id="playlist">';
              #hora de imprimir todas las playlist del usuario
              $playlist = $conn->prepare('SELECT id, nombre FROM playlist where id_creador=:id');
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
            $rec = $conn->prepare('SELECT usuario FROM users where id=:id');
            $rec->bindParam(':id', $result['id_creador']);
            $rec->execute();
            $res = $rec->fetchAll();
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="Cinque Terre" class="foto width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['nombre'].'</b><br>Creador: '.$res[0]['usuario'].'</div>';
            print '<form action="liked.php" method="post">';
            print '<input type="submit" class="button" name="añadir'.$result['id'].'" value="añadir" />';
            print '<input type="submit" class="button" name="unfollow'.$result['id'].'" value="Dejar de seguir" /></form></div>';
            
            }
            
      } else {
        print '<div class=":c"></div>';
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