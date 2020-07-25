<?php require 'header.php';
error_reporting(E_ERROR | E_PARSE);
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
$records = $conn->prepare('SELECT nombre, imagen, id, id_creador, seguidores, usuario FROM playlist_owner');
$records->execute();
$results = $records->fetchAll();


if (count($results) > 0) {
    foreach ($results as $result){
      if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ver'.$result['id']])){
        $_SESSION['playlist'] = $result['id'];
        header("Location: canciones.php");
      }
      if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['seguir'.$result['id']])){
        $check = $conn->prepare('SELECT id FROM subscriben WHERE id_usuario = :usuario and id_playlist= :playlist');
        $check->bindParam(':usuario', $_SESSION['user_id']);
        $check->bindParam(':playlist', $result['id']);
        $check->execute();
        if ($check->fetch(PDO::FETCH_ASSOC) == 0) {
            $like = $conn->prepare('INSERT INTO subscriben (id_usuario, id_playlist) values(:usuario,:playlist)');
            $like->bindParam(':usuario', $_SESSION['user_id']);
            $like->bindParam(':playlist', $result['id']);
            $like->execute();
            $delay = 0;
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
            }
        else{
            print ' <div class="footer">ya la sigues</div>';
          }
      }
      $seguidores = $result['seguidores'];
      if ($seguidores==null){
        $seguidores=0;
      }
      print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
      print '<img src="'.$result['imagen'].'" alt="Cinque Terre" class="foto" width="500" height="400"></a>';
      print '<div class="desc"> <b> '.$result['nombre'].'</b><br> Creador: ' .$result['usuario'].'</div>';
      print '<form action="ver.php" method="post">';
      print '<input type="submit" class="button" name="seguir'.$result['id'].'" value="seguir" />';
      print '<input type="submit" class="button" name="ver'.$result['id'].'" value="ver" />';
      print ' &nbsp; <img src="http://clipart-library.com/img/1118478.png" style=width:15px height:15px; > &nbsp;'.$seguidores.'</form></div>';
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