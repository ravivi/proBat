<?php
require_once 'app/bd.php';
require 'app/function.php';
if(!empty($_POST))
{
    $nom = checkInput($_POST['nom']);
    $email = checkInput($_POST['login']);
    $tel = checkInput($_POST['tel']);
    $commune = checkInput($_POST['commune']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILES["image"]["name"]);
    $imagePath          = 'photo/expert/'. basename($image);
    $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
    $isSuccess          = true;
    $isUploadSuccess    = false;

                //declaration des parametre de la fonction insert
    $db_table = "workers";
    $db_column = "nom,login,telephone,id_cat,localite,photo";
    $db_inconnu = "?,?,?,?,?,?";
    $post_values = array($nom,$email,$tel,$category,$commune,$image);
    $errors=array();
    if(empty($_POST['nom'])){
        $errors['nom']="Vous avez pas mis de nom";
    }
    
    
    
    if(empty($_POST['tel'])){
        $errors['tel']="Vous avez pas mis Votre numero de téléphone";
    }
    
    if(empty($_POST['commune'])){
        $errors['commune']="Vous avez pas mis votre situation gégraphique";
    }
    if(empty($image)) 
    {
        $errors['image'] = "Vous n'avez pas mis de photo de profil";
        // $isSuccess = false;
    }
    else
    {
        // $isUploadSuccess = true;
        if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
        {
          $errors['image']= "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
            // $isUploadSuccess = false;
        }
        if(file_exists($imagePath)) 
        {
          $errors['image'] = "Le fichier existe deja";
            // $isUploadSuccess = false;
        }
        if($_FILES["image"]["size"] > 600000) 
        {
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
      move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath); 

        insert($bd,$db_table,$db_column,$db_inconnu,$post_values);
        echo"ce travailleur a bien été ajouté";
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


<div class="col-sm-3 zo">
        <h4>Ajout de travailleur</h4>
          <form class="form-horizontal"  method="post" action="" enctype="multipart/form-data">
               
               
            <!-- Champ du nom et prenom-->
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="nom" name="nom" placeholder="Nom" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="email" name="login" placeholder="email" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="tel" name="tel" placeholder="Telephone" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                      <div class="col-xm-6">
                      <input type="text" id="localite" name="commune" placeholder="Votre localisation" class="form-control input-lg">
                      </div>
                  </div>
                  <div class="form-group">
                        <label for="image">Sélectionner une photo de profil:</label>
                        <input type="file" id="image" name="image" class="form-control input-lg"> 
            
                    </div>
                      
                        <select class="form-control input-lg" id="category" name="category">
                        <option selected>Votre profession</option>
                        <?php
                        
                           foreach ($bd->query('SELECT * FROM categorie') as $row) 
                           {
                                echo '<option value="'. $row['id'] .'">'. $row['profession'] . '</option>';;
                           }
                           
                        ?>
                        </select>

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
      <button type="submit" class="col-lg-12 btn-lg btn-primary">Enregistrer</button>
 
            </form> 
    </div>
    
                      </div>
                      
                    
                   </div>
                      
           <!--   Fin du formulaire     -->


</body>
</html>
