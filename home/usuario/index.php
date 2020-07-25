<?php require 'header.php';
error_reporting(E_ERROR | E_PARSE);
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT usuario, imagen, tipo, seguidores,id FROM users WHERE id != :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetchAll();
    

    if (count($results) > 0) {
        foreach ($results as $result){
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['seguir_'.$result['id']])){
            $check = $conn->prepare('SELECT id FROM seguidores WHERE id_seguidor = :usuario and id_seguido= :user');
            $check->bindParam(':usuario', $_SESSION['user_id']);
            $check->bindParam(':user', $result['id']);
            $check->execute();
            if ($check->fetch(PDO::FETCH_ASSOC) == 0) {
                $like = $conn->prepare('INSERT INTO seguidores (id_seguidor, id_seguido) values(:usuario,:user)');
                $like->bindParam(':usuario', $_SESSION['user_id']);
                $like->bindParam(':user', $result['id']);
                $like->execute();
                $delay = 0;
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=' . $location . '">';
                }
            else{
                print ' <div class="footer">ya lo sigues</div>';
              }
          }
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['ver_'.$result['id']])){
            print 'falta el codigo de ver';
            if ($result['tipo']=='artista'){
              $_SESSION['otro_id']=$result['id'];
              header("location: perfilArtista.php");
            }
            if ($result['tipo']=='usuario'){
              $_SESSION['otro_id']=$result['id'];
              header("location: perfilUsuario.php");
            }
          }



            $seguidores = $result['seguidores'];
            if ($seguidores==null){
              $seguidores=0;
            }
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="Cinque Terre" class="foto" width="500" height="400"></a>';
            print '<div class="desc"> <b> '.$result['usuario'].'</b><br> Tipo: ' .$result['tipo'].'</div>';
            print '<form action="index.php" method="post">';
            print '<input type="submit" class="button" name="ver_'.$result['id'].'" value="ver" />';
            print '<input type="submit" class="button" name="seguir_'.$result['id'].'" value="seguir" />';
            print ' &nbsp; <img src="http://clipart-library.com/img/1118478.png" style=width:15px height:15px; > &nbsp;'.$seguidores.'</form></div>';
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