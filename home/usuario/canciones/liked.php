<?php require '../header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT nombre, imagen, id_creador, id FROM liked_songs WHERE id_usuario=:id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetchAll();

    if (count($results) > 0) {
        foreach ($results as $result){
            $rec = $conn->prepare('SELECT usuario FROM users where id=:id');
            $rec->bindParam(':id', $result['id_creador']);
            $rec->execute();
            $res = $rec->fetchAll();
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="Cinque Terre" width="500" height="400"></a>';
            print '<div class="desc"><b>'.$result['nombre'].'</b><br>Creador: '.$res[0]['usuario'].'</div>';
            print '<form action="liked.php" method="post">';
            print '<input type="submit" class="button" name="unfollow'.$result['id'].'" value="Dejar de seguir" /></div>';

            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['unfollow'.$result['id']])){
                $like = $conn->prepare('DELETE FROM gustan where id_usuario=:usuario and id_cancion=:cancion');
                $like->bindParam(':usuario', $_SESSION['user_id']);
                $like->bindParam(':cancion', $result['id']);
                $like->execute();
                header("Refresh:0");   
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