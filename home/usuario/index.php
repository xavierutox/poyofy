<?php require 'header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
    $records = $conn->prepare('SELECT usuario, imagen, tipo, seguidores FROM users WHERE id != :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetchAll();
    

    if (count($results) > 0) {
        foreach ($results as $result){
            $seguidores = $result['seguidores'];
            if ($seguidores==null){
              $seguidores=0;
            }
            print '<div class="gallery"><a target="_blank" href="'.$result['imagen'].'">';
            print '<img src="'.$result['imagen'].'" alt="Cinque Terre" width="500" height="400"></a>';
            print '<div class="desc"> Nombre: '.$result['usuario'].'<br> Tipo: ' .$result['tipo'].'</div>';
            print '<input type="submit" class="button" name="seguir" value="seguir" />';
            print '<input type="submit" class="button" name="ver" value="ver" />';
            print ' &nbsp; <img src="https://lh3.googleusercontent.com/proxy/jTDMftX1opiWvdoNnDTCcQ1R4Xs_LGR2O1xlWow4QNdjMQFY_SEb226boQrn_03bxqJ1ezQ1pF_ILcDYFGoweSWyoU5m6jRu6uTpRl3fsWBxPy_3xDnMQTvN_T_6fOXtxh7FGp2VRy8uYn4msr-APWxP726oNxo" style=width:10px height:10px; > &nbsp;'.$seguidores.'</form></div>';
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