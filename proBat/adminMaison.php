<?php
require_once 'app/bd.php';
require 'app/function.php';
$succes=false;
$msg="";
if(!empty($_POST))
{
    $nom = checkInput($_POST['nom']);
    $description = checkInput($_POST['description']);
    $prix = checkInput($_POST['prix']);
    $fondation = checkInput($_POST['fondation']);
    $montage = checkInput($_POST['montage']);
    $ciment_brique = checkInput($_POST['ciment_brique']);
    $ciment_montage = checkInput($_POST['ciment_montage']);
    $ciment_beton = checkInput($_POST['ciment_beton']);
    $image = checkInput($_FILES["image"]["name"]);
    $imagePath          = 'photo/maison/'. basename($image);
    $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
    $isSuccess          = true;
    $isUploadSuccess    = false;

                //declaration des parametre de la fonction insert
    $db_table = "maison";
    $db_column = "nom,description,prix,fondation,montage,ciment_brique,ciment_montage,ciment_beton,photo";
    $db_inconnu = "?,?,?,?,?,?,?,?,?";
    $post_values = array($nom,$description,$prix,$fondation,$montage,$ciment_brique,$ciment_montage,$ciment_beton,$image);
    $errors=array();
    if(empty($_POST['nom'])){
        $succes=false;
        $errors['nom']="Vous n'avez pas mis le type de la maison ";
    }
    if(empty($_POST['prix'])){
        $succes=false;
        $errors['prix']="Vous n'avez pas mis le prix de la maison";
    }
    
    if(empty($_POST['fondation'])){
        $succes=false;
        $errors['fondation']="Vous n'avez pas l'essentiel du materiel";
    }
    if(empty($_POST['description'])){
        $succes=false;
        $errors['description']="Vous n'avez pas mis la description de la maison ";
    }
    if(empty($_POST['montage'])){
        $succes=false;
        $errors['montage']="Vous n'avez pas mis le prix de la maison";
    }
    
    if(empty($_POST['ciment_brique'])){
        $succes=false;
        $errors['ciment_brique']="Vous n'avez pas l'essentiel du materiel";
    }
    if(empty($_POST['ciment_montage'])){
        $succes=false;
        $errors['ciment_montage']="Vous n'avez pas l'essentiel du materiel";
    }
    if(empty($_POST['ciment_beton'])){
        $succes=false;
        $errors['ciment_beton']="Vous n'avez pas l'essentiel du materiel";
    }
    if(empty($image)) 
    {
        $succes=false;
        $errors['image'] = "Vous n'avez pas mis de photo de profil";
        // $isSuccess = false;
    }
    else
    {
        // $isUploadSuccess = true;
        if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
        {
            $succes=false;
          $errors['image']= "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
            // $isUploadSuccess = false;
        }
        if(file_exists($imagePath)) 
        {
            $succes=false;
          $errors['image'] = "Le fichier existe deja";
            // $isUploadSuccess = false;
        }
        if($_FILES["image"]["size"] > 7000000) 
        {
            $succes=false;
          $errors['image'] = "Le fichier ne doit pas depasser les 500KB";
            // $isUploadSuccess = false;
        }
        // if($isUploadSuccess) 
        // {
        //     if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
        //     {
        //       $errors['image'] = "Il y a eu une erreur lors de l'upload";
        //         // $isUploadSuccess = false;
        //     } 
        // } 
      }

    if(empty($errors))
    { 
        $succes=true;
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
        insert($bd,$db_table,$db_column,$db_inconnu,$post_values);
        $msg="La maison a bien été ajouté";   
    }
    
}
function checkInput($data) 
{
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

?>




<!DOCTYPE html>
<html>
<head>
  <title>Pro-Bat</title>
  <meta charset="utf-8"/>

  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>

<?php if($succes==true): ?>
                        <div class="alert alert-success">
                          <p><?=$msg?></p>
                        </div>
                      <?php endif; ?>
      <div class="col-sm-3 zo">
        <h4>Ajouter une maison</h4>
          <form class="form-horizontal"  method="post" action="" enctype="multipart/form-data">
               
               
            
            <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="nom" name="nom" placeholder="Type de maison" class="form-control input-lg">
                        </div>
            </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="description" name="description" placeholder="Description de la maison" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="number" id="prix" name="prix" placeholder="Estimation du coût" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="number" id="fondation" name="fondation" placeholder="Brique pour la fondation" class="form-control input-lg">
                    </div>
                    </div>

                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="number" id="montage" name="montage" placeholder="Brique pour le montage" class="form-control input-lg">
                    </div>
                    </div>

                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="number" id="ciment_brique" name="ciment_brique" placeholder="Ciment pour les briques" class="form-control input-lg">
                    </div>
                    </div>

                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="number" id="ciment_montage" name="ciment_montage" placeholder="Ciment pour le montage" class="form-control input-lg">
                    </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="number" id="ciment_beton" name="ciment_beton" placeholder="Ciment pour le béton" class="form-control input-lg">
                    </div>
                    </div>
                  
                  <div class="form-group">
                        <label for="image">Sélectionner une photo de maison:</label>
                        <input type="file" id="image" name="image" class="form-control input-lg"> 
            
                    </div>
                    <?php if(!empty($errors)): ?>
                        <div class="alert alert-danger">
                          <p>Vous avez mal rempli ce formulaire</p>
                          <ul>
                            <?php foreach($errors as $error):?>
                              <li><?= $error; ?></li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                      <?php endif; ?>
                   
      <button type="submit" class="col-lg-12 btn-lg btn-primary">Ajouter</button>
 
            </form>
             
    </div>


</body>
</html>