<?php
    require_once 'app/bd.php';

    if(!empty($_GET['id'])){
        $id= $_GET['id'];
    } 
    $req=$bd->prepare('SELECT * FROM maison WHERE id=?');
    $req->execute([$id]);
    $item=$req->fetch();

?>



<!DOCTYPE html>
<html>
    <head>
        <title>Pro-Bat</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="main.css">
        <script src="load.js"></script>
    </head>
    
    <body>
        <div class="container">
            <div class="row"style="margin-top:100px">
               <div class="col-sm-6">
                    <h1><strong>Voir les détails</strong></h1>
                    <br>
                    <form>
                      <div class="form-group">
                        <label>Nom: <?php echo '  '.$item['nom'];?>
                      </div>
                      <div class="form-group">
                        <label>Description: <?php echo '  '.$item['description'];?></label>
                      </div>
                      <div class="form-group">
                        <label>Estimation coût: <?php echo '  '.number_format($item['prix'], 2, '.', '')?>Fcfa</label>
                      </div>
                      <div class="form-group">
                        <label>Estimation matériels:</label>
                      </div>
                      <div class="form-group">
                        <label>Estimation de Brique: <?php echo '  '.$item['montage']+$item['fondation'];?> briques</label>
                      </div>
                      <div class="form-group">
                        <label>Fondation: <?php echo '  '.$item['fondation'];?> briques pleines</label>
                        </div>
                        <div class="form-group">
                        <label>Montage: <?php echo '  '.$item['montage'];?> briques creuses</label>
                        </div>
                        <div class="form-group">
                        <label>Estimation de ciment: <?php echo '  '.$item['ciment_brique']+$item['ciment_montage']+$item['ciment_beton'];?> Tonnes de ciment</label>
                      </div>
                        <div class="form-group">
                        <label>Ciment pour la confection des briques: <?php echo '  '.$item['ciment_brique'];?> tonnes</label>
                        </div>
                        <div class="form-group">
                        <label>Ciment pour le montage des briques: <?php echo '  '.$item['ciment_montage'];?> tonnes</label>
                        </div>
                        <div class="form-group">
                        <label>Ciment pour beton: <?php echo '  '.$item['ciment_beton'];?> tonnes</label>
                        </div>
                    </form>
                    <br>
                    <div class="form-actions">
                      <a href="adminVm.php"><button type="button" class="btn btn-primary">Retour</button></a>
                    </div>
                </div> 
                <div class="col-sm-6">
                        <div class="zoom">
                    
                        <img src="<?php echo 'photo/maison/'.$item['photo'];?>" alt="...">
                        
                    
                    </div>
                </div>
            </div>
        </div>   
    </body>
</html>