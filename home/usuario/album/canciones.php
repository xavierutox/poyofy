<?php require '../header.php';
error_reporting(E_ERROR | E_PARSE);
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT id, nombre, imagen, id_creador, seguidores FROM album_content WHERE id_album=:id');
    $records->bindParam(':id', $_SESSION['Album']);
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
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['añadir_'.$result['id']])){
            print '<div class="footer">';
            print '<form action="canciones.php" method="POST">';
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
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['like_'.$result['id']]))
          {
            $check = $conn->prepare('SELECT id FROM gustan WHERE id_usuario = :usuario and id_cancion= :cancion');
            $check->bindParam(':usuario', $_SESSION['user_id']);
            $check->bindParam(':cancion', $result['id']);
            $check->execute();
            if ($check->fetch(PDO::FETCH_ASSOC) == 0) {
                $like = $conn->prepare('INSERT INTO gustan (id_usuario, id_cancion) values(:usuario,:cancion)');
                $like->bindParam(':usuario', $_SESSION['user_id']);
                $like->bindParam(':cancion', $result['id']);
                $like->execute();
                $delay = 0;
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
                }
            else{
                print ' <div class="footer">ya te gusta</div>';
              }
          }
      
          $rec = $conn->prepare('SELECT usuario FROM users where id=:id');
          $rec->bindParam(':id', $result['id_creador']);
          $rec->execute();
          $res = $rec->fetchAll();
          $seguidores = $result['seguidores'];
          if ($seguidores==null){
            $seguidores=0;
          }
          print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
          print '<img src="'.$result['imagen'].'" alt="Cinque Terre" width="500" height="400" class="foto"></a>';
          print '<div class="desc"><b>'.$result['nombre'].'</b><br>Creador: '.$res[0]['usuario'].'</div>';
          print '<form action="canciones.php" method="post">';
          print '<input type="submit" class="button" name="añadir_'.$result['id'].'" value="añadir" />';
          print '<input type="submit" class="button" name="like_'.$result['id'].'" value="like" />';
          print ' &nbsp; <img src="http://clipart-library.com/img/1118478.png" style=width:15px height:15px; > &nbsp;'.$seguidores.'</form></div>';
        }
      } else {
        print ':c';
      }

?>
<head>
<style>
.canciones{
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