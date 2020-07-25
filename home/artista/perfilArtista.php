<?php require 'header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$user = $conn->prepare('SELECT usuario, imagen, seguidores FROM users where id=:id');
$user->bindParam(':id', $_SESSION['otro_id']);
$user->execute();
$user = $user->fetchAll();
if (count($user) > 0) {
    print '<div class="profile">';
    print '<b>'.$user[0]['usuario'].'&nbsp; <img src="http://clipart-library.com/img/1118478.png" style=width:15px height:15px; > &nbsp;'.$user[0]['seguidores'].'</b><br><br>';
    print '<img src="'.$user[0]['imagen'].'" alt="avatar" width="150" height="150"><br>';
    print '<b>Seguidores</b><div class="canciones"><br>';
    $records = $conn->prepare('SELECT usuario, imagen, tipo, seguidores FROM vista_seguidores WHERE id_seguido = :id');
    $records->bindParam(':id', $_SESSION['otro_id']);
    $records->execute();
    $results = $records->fetchAll();
    if (count($results) > 0) {
        foreach ($results as $result){
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="foto" class="foto" width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['usuario'].'</b></div>';
            print '<div class="dsdds"><b>Tipo: '.$result['tipo'].'</b></div>';
            print ' &nbsp; <img src="http://clipart-library.com/img/1118478.png" style=width:15px height:15px; > &nbsp;<b>'.$result['seguidores'].'</b></div>';
        }
    }
    print "</div><br>";
    print '<b> Canciones creadas</b><div class="canciones"> <br>';
    $records = $conn->prepare('SELECT nombre, imagen, id, id_creador FROM canciones WHERE id_creador = :id');
    $records->bindParam(':id',$_SESSION['otro_id']);
    $records->execute();
    $results = $records->fetchAll();
    if (count($results) > 0) {
        foreach ($results as $result){
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="foto" class="foto" width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['nombre'].'</div></div>';
        }
    }
    print "</div><br>";
    print '<b>Albumes creados</b><div class="canciones"><br>';
    $records = $conn->prepare('SELECT nombre, imagen, id, id_compositor FROM album WHERE id_compositor = :id');
    $records->bindParam(':id', $_SESSION['otro_id']);
    $records->execute();
    $results = $records->fetchAll();
    if (count($results) > 0) {
        foreach ($results as $result){
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="foto" class="foto" width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['nombre'].'</div></div>';
        }
    }
    print "</div><br>";
    print '<b>Playlist seguidas</b><div class="canciones"><br>';
    $records = $conn->prepare('SELECT nombre, imagen, usuario, seguidores FROM vista_sub WHERE id_usuario = :id');
    $records->bindParam(':id', $_SESSION['otro_id']);
    $records->execute();
    $results = $records->fetchAll();
    if (count($results) > 0) {
        foreach ($results as $result){
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="foto" class="foto" width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['nombre'].'</div>';
            print ' &nbsp; <img src="http://clipart-library.com/img/1118478.png" style=width:15px height:15px; > &nbsp;'.$result['seguidores'].'</div>';
        }
    }
    print "</div><br>";
    print '<b>Usuarios seguidos</b><div class="canciones"><br>';
    $records = $conn->prepare('SELECT usuario, imagen, tipo, seguidores, id_seguido FROM vista_seguidos WHERE id_seguidor = :id');
    $records->bindParam(':id', $_SESSION['otro_id']);
    $records->execute();
    $results = $records->fetchAll();
    if (count($results) > 0) {
        foreach ($results as $result){
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['unfollow'.$result['id_seguido']])){
              $like = $conn->prepare('DELETE FROM seguidores where id_seguidor=:usuario and id_seguido=:seguido');
              $like->bindParam(':usuario', $_SESSION['otro_id']);
              $like->bindParam(':seguido', $result['id_seguido']);
              $like->execute();
              $delay = 0;
              echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">'; 
            }
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="foto" class="foto" width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['usuario'].'</b></div>';
            print 'Tipo: '.$result['tipo'].'<br>';
            print '<form action="perfil.php" method="post">';
            print '<input type="submit" class="button" name="unfollow'.$result['id_seguido'].'" value="dejar de seguir" />';
            print ' &nbsp; <img src="http://clipart-library.com/img/1118478.png" style=width:15px height:15px; > &nbsp;'.$result['seguidores'].'</form></div>';
        }
    }
    print "</div><br>";
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