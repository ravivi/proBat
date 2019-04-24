<?php session_start();
require_once'app/bd.php';
if(!isset($_SESSION['panier'])){
    $_SESSION['panier'] = array();
}
if(!empty($_GET['id'])){
$id=$_GET['id'];
$_SESSION['panier'][$id]=$id;
}

$req=$bd->query('SELECT workers.id, workers.nom, workers.login, workers.telephone, workers.localite, workers.photo, categorie.profession, workers.date_add FROM workers,categorie WHERE workers.id_cat=categorie.id');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="styles.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style>body{
    background-image: url(images/wood.png);
}</style>
<body>
<script>function add(id){
    location.href="expert.php?id="+id;
}
</script>
	<div class="row" style="margin-top:50px">
<div class="col-sm-6">
  <h1 style="margin-left:50px">Nos expert en batiment</h1>
</div>
<div class="col-sm-6">
  <a class="btn btn-outline-success" href="panier.php">Voir mon panier</a>
  <?php
            echo '<a class="btn btn-outline-danger" href="users/actionU.php?id='.$_SESSION['id'].'"><span class="glyphicon glyphicon-remove"></span> Retour</a>';
            ?>
  </div>
</div>
	<div class="container">

		<div class="row">
        <?php while ($item = $req->fetch())
           { 
            echo'
           <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <div id="box_produit" class="wrapper ">
        <div style="height:22px;"></div> 
            <div id="box_galerie2">
            <a href="#">
                <img src="photo/expert/' . $item['photo'] . '" class="img-responsive">
            </a>
        </div>
        
            <div id="titro_produit">Nom: ' .$item['nom']. '</div>
        
        <div id="prix_produit">Profession: '.$item['profession']. '</div>
                <div id="descrip-produit" align="center">
                    </div>
        <div id="panier_produit">
                            <p>
                        <button type="button" onClick="add('.$item['id'].')" class="btn btn-success">Besoin de vos services</button>
        
                </p>
                            
        </div>

    </div>
</div>
';}?>
        </div>
        </div>
</body>
</html>