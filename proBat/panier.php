<?php session_start();
require_once'app/bd.php';
$panier=$_SESSION['panier'];
// if(!isset($_SESSION['panier'])){
//     $_SESSION['panier'] = array();
// }
// if(isset($_GET['id'])){
//     $_SESSION['panier'][]=$_GET['id'];
//     // $_SESSION['panier']["nom"]=$_GET['nom'];
// }
// $nbre=count(array_keys($_SESSION['panier']),$_GET['id']);

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css"href="main.css">
    <title>panier</title>
  </head>
  <body>
<div class="container">
<div class="row" style="margin-top:50px">
<div class="col-sm-6">
  <h1 style="margin-bottom:50px">Votre panier</h1>
</div>
<div class="col-sm-6">
  <a class="btn btn-outline-success" href="expert.php">Retour au catalogue</a>
  <a class="btn btn-outline-danger" href="viderPanier.php">Vider le panier</a>
  </div>
</div>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Expert</th>
      <th scope="col">Nom</th>
      <th scope="col">action</th>

    </tr>
  </thead>
  <tbody>
   <?php
   $ids=array_keys($panier);
   if(empty($ids)){
       $items=array();
   }else{
    $req = $bd->query('SELECT * FROM workers WHERE id IN ('.implode(',',$ids).')');
    $items=$req->fetchAll();
   }
   

      foreach($items as $item) 
      {
          echo '<tr>';
          echo '<td><img src="photo/expert/'.$item['photo'].'" height="100"> </td>';
          echo '<td>' . $item['nom'] . '</td>';
          echo '<td>';
          echo '<a class="btn btn-outline-danger" href="del.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
          echo '</td>';
          echo '</tr>';
      }
    ?> 
</tbody>
  </tbody>
</table>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>