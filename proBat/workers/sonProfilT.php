<?php
    require_once '../app/bd.php';

    if(!empty($_GET['id'])){
        $id= $_GET['id'];
    } 
    $req=$bd->prepare('SELECT workers.id, workers.nom, workers.login, workers.telephone, workers.localite, workers.photo, categorie.profession, workers.date_add FROM workers,categorie WHERE workers.id_cat=categorie.id AND workers.id=?');
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
        <link rel="stylesheet" href="../main.css">
        
    </head>
    
    <body>
            
        <div class="container">
            <div class="row"style="margin-top:100px">
               <div class="col-sm-6">
                    <h1><strong>Voir les détails</strong></h1>
                    <br>
                    <form>
                      <div class="form-group">
                        <label>Nom:</label><?php echo '  '.$item['nom'];?>
                      </div>
                      <div class="form-group">
                        <label>Email:</label><?php echo '  '.$item['login'];?>
                      </div>
                      <div class="form-group">
                        <label>Telephone:</label><?php echo '  '.$item['telephone'];?>
                      </div>
                      <div class="form-group">
                        <label>Localité:</label><?php echo '  '.$item['localite'];?>
                      </div>
                      <div class="form-group">
                        <label>Profession:</label><?php echo '  '.$item['profession'];?>
                      </div>
                      <div class="form-group">
                        <label>Image:</label><?php echo '  '.$item['photo'];?>
                      </div>
                      <div class="form-group">
                        <label>Inscrire:</label><?php echo 'le  '.$item['date_add'];?>
                      </div>
                    </form>
                    <br>
                    <div class="form-actions">
                    <?php
            echo '<a class="btn btn-primary" href="actionW.php?id='.$item['id'].'">Retour</a>';
            ?>
                      <?php
            echo '<a class="btn btn-success" href="update.php?id='.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier mon profil</a>';
            ?>
            <?php
            echo '<a class="btn btn-danger" href="delete.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer mon Compte</a>';
            ?>
            

                    </div>
                </div> 
                <div class="col-sm-6">
                        <div class="zoom">
                    
                        <img src="<?php echo '../photo/expert/'.$item['photo'];?>" alt="...">
                        
                    
                    </div>
                </div>
            </div>
        </div>   
    </body>
</html>