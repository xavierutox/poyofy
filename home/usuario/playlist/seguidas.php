<?php require '../header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT nombre, imagen, id_creador, id, usuario FROM liked_playlist WHERE id_usuario=:id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetchAll();

    if (count($results) > 0) {
        foreach ($results as $result){
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="Cinque Terre" class="foto width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['nombre'].'</b><br>Creador: '.$result['usuario'].'</div>';
            print '<form action="seguidas.php" method="post">';
            print '<input type="submit" class="button" name="unfollow'.$result['id'].'" value="Dejar de seguir" />';
            print '<input type="submit" class="button" name="ver'.$result['id'].'" value="ver" /></div>';

            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['unfollow'.$result['id']])){
                $like = $conn->prepare('DELETE FROM subscriben where id_usuario=:usuario and id_playlist=:playlist');
                $like->bindParam(':usuario', $_SESSION['user_id']);
                $like->bindParam(':playlist', $result['id']);
                $like->execute();
                header("Refresh:0");   
              }
              if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ver'.$result['id']])){

              }
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