<?php

    require_once '../app/bd.php';
    $succes=false;

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)) 
        {
                $nom = checkInput($_POST['nom']);
                $email = checkInput($_POST['email']);
                $tel = checkInput($_POST['tel']);
                $commune = checkInput($_POST['commune']);
                $msg="";
                // $image = checkInput($_FILES["image"]["name"]);
                // $imagePath          = '../images/'. basename($image);
                // $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
                // $isSuccess          = true;
                // $isUploadSuccess    = false;
                $errors=array();
                if(empty($_POST['nom'])){
                    $succes=false;
                    $errors['nom']="Vous avez pas mis de nom";
                }
                if(empty($_POST['email']) || !filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)){
                    $succes=false;
                    $errors['email']="Vous avez pas mis un email valide";
                }
                if(empty($_POST['tel'])){
                    $succes=false;
                    $errors['tel']="Vous avez pas mis Votre numero de téléphone";
                }
                if(empty($_POST['commune'])){
                    $succes=false;
                    $errors['commune']="Vous avez pas mis votre situation gégraphique";
                }
            //     if(empty($_POST['mdp1']) || $_POST['mdp1']!= $_POST['mdp2']){
            //         $errors['password']="Vous n'avez pas renseigné un mot de passe valide";
            //     }
            //     if(empty($image)) 
            // {
            //     $errors['image'] = "Vous n'avez pas mis de photo de profil";
            //     // $isSuccess = false;
            //     $isImageUpdated = false;
            // }
            if(empty($error)){
                $succes=true;
                $req = $bd->prepare("UPDATE users  set nom = ?, login = ?, telephone=?, commune = ? WHERE id = ?");
                $req->execute(array($nom,$email,$tel,$commune,$id));
                $msg="Votre compte a bien été modifié";
            }
        }
        else 
        {
            $req = $bd->prepare("SELECT * FROM users where id = ?");
            $req->execute(array($id));
            $item = $req->fetch();
            $nom  = $item['nom'];
            $email= $item['login'];
            $tel  = $item['telephone'];
            $commune=$item['localite'];
           
        }
    // else
    // {
    //     // $isUploadSuccess = true;
    //     $isImageUpdated = true;
    //     $isUploadSuccess =true;
    //     if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
    //     {
    //       $errors['image']= "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
    //         $isUploadSuccess = false;
    //     }
    //     if(file_exists($imagePath)) 
    //     {
    //       $errors['image'] = "Le fichier existe deja";
    //         $isUploadSuccess = false;
    //     }
    //     if($_FILES["image"]["size"] > 600000) 
    //     {
    //       $errors['image'] = "Le fichier ne doit pas depasser les 500KB";
    //         $isUploadSuccess = false;
    //     }
    //     if($isUploadSuccess) 
    //     {
    //         if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
    //         {
    //             $errors['image'] = "Il y a eu une erreur lors de l'upload";
    //             $isUploadSuccess = false;
    //         } 
    //     }
      
    // } 
         
        // if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
        // { 
        //     if($isImageUpdated)
        //     {
        //         $req = $bd->prepare("UPDATE users  set nom = ?, login = ?, telephone=?, localite = ?, mdp = ?,photo = ? WHERE id = ?");
        //         $req->execute(array($nom,$login,$tel,$commune,$password,$image,$id));
        //     }
        //     else
        //     {
        //         $req = $bd->prepare("UPDATE users  set nom = ?, login = ?, telephone=?, localite = ?, mdp = ? WHERE id = ?");
        //         $req->execute(array($nom,$login,$tel,$commune,$password,$id));
        //     }
        //     header("Location: sonProfil.php");
        // }
        // else if($isImageUpdated && !$isUploadSuccess)
        // {
        //     $req = $bd->prepare("SELECT * FROM users where id = ?");
        //     $req->execute(array($id));
        //     $item = $$req->fetch();
        //     $image = $item['image'];
           
        // }
        // }
 

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
        <title>proBat</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../main.css">
    </head>
    
    <body>
        <h1><span class="glyphicon glyphicon-pencil"></span> Modification de mes infos</h1>
         <div class="container admin">
            <div class="row">
            <?php if($succes==true): ?>
                        <div class="alert alert-success">
                          <p><?=$msg?></p>
                        </div>
                      <?php endif; ?>
                <!-- <div class="col-sm-6">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                       </div>
                    </form>
                </div> -->



          <form class="form-horizontal"  method="post" action="<?php echo 'update.php?id='.$id;?>"" enctype="multipart/form-data">
               
               
            <!-- Champ du nom et prenom-->
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="nom" name="nom" placeholder="Nom" value="<?php echo $nom;?>" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="email" name="email" placeholder="email" value="<?php echo $email;?>" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="tel" name="tel" placeholder="Telephone" value="<?php echo $tel;?>" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                    <select class="form-control input-lg" id="category" name="commune">
                        <option selected>Localisation</option>
                        <?php
                           require_once'../app/bd.php';
                           foreach ($bd->query('SELECT * FROM localisation') as $row) 
                           {
                                echo '<option value="'. $row['id'] .'">'. $row['lieu'] . '</option>';;
                           }
                           
                        ?>
                        </select>
                  </div>
                  <!-- <div class="form-group">
                        <label for="image">Sélectionner une photo de profil:</label>
                        <input type="file" id="image" name="image" class="form-control input-lg" value=""> 
            
                    </div> -->
                    <!-- <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="password" id="mdp1" name="mdp1" placeholder="Mot de passe" value="" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="password" id="mdp2" name="mdp2" placeholder="Retaper le Mot de passe" value="<?php echo $password;?>" class="form-control input-lg">
                        </div>
                    </div> -->
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
                     <?php echo '<a class="col-lg-1 btn btn-success" style="margin-right:20px" href="sonProfil.php?id='.$id.'"><span class="glyphicon glyphicon-house"></span> retour</a>';?>
      <button type="submit" class="col-lg-1 btn btn-primary">Enregistrer</button>
 
            </form>
             




                <!-- <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="" alt="...">
                        <div class="price"></div>
                          <div class="caption">
                            <h4></h4>
                            <p></p>
                            <a href="#" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Commander</a>
                          </div>
                    </div>
                </div> -->
            </div>
        </div>   
    </body>
</html>
