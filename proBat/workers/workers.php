<?php
require_once '../app/bd.php';
require '../app/function.php';

if(!empty($_POST))
{
    $nom = checkInput($_POST['nom']);
    $email = checkInput($_POST['login']);
    $tel = checkInput($_POST['tel']);
    $commune = checkInput($_POST['commune']);
    $password = checkInput($_POST['mdp1']);
    $category = checkInput($_POST['category']);
    $image = checkInput($_FILES["image"]["name"]);
    $imagePath          = '../photo/expert/'. basename($image);
    $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
    $isSuccess          = true;
    
    $isUploadSuccess    = false;
    $msg="";

                //declaration des parametre de la fonction insert
    $db_table = "workers";
    $db_column = "nom,login,telephone,id_cat,localite,mdp,photo";
    $db_inconnu = "?,?,?,?,?,?,?";
    $post_values = array($nom,$email,$tel,$category,$commune,sha1($password),$image);
    $errors=array();
    if(empty($_POST['nom'])){
      
        $errors['nom']="Vous avez pas mis de nom";
    }
    
    
    
    if(empty($_POST['login']) || !filter_var($_POST['login'] , FILTER_VALIDATE_EMAIL)){
      $succes=false;  
      $errors['email']="Vous avez pas mis un email valide";
    }else{
        $req = $bd->prepare('SELECT id FROM users WHERE login=?');
        $req->execute([$_POST['login']]);
        $dejaEmail=$req->fetch();
        $pdo = $bd->prepare('SELECT id FROM workers WHERE login=?');
        $pdo->execute([$_POST['login']]);
        $dejaW=$pdo->fetch();
        if($dejaEmail){
          $succes=false;
          $errors['email']="Cet email est deja utilisé pour un compte client";
        }if($dejaW){
          $succes=false;
          $errors['email']="Cet email est deja enregistré pour un autre compte expert";
        }
    }
    if(empty($_POST['tel'])){
      $succes=false;
        $errors['tel']="Vous avez pas mis Votre numero de téléphone";
    }else{
      $req = $bd->prepare('SELECT id FROM users WHERE telephone=?');
      $req->execute([$_POST['tel']]);
      $dejaTel=$req->fetch();
      $pdo = $bd->prepare('SELECT id FROM workers WHERE login=?');
        $pdo->execute([$_POST['tel']]);
        $dejaT=$pdo->fetch();
      if($dejaTel){
        $succes=false;
        $errors['tel']="Ce numero de telephone est deja utilisé pour un compte client";
      }if($dejaT){
        $succes=false;
        $errors['tel']="Ce Numéro est deja enregistré pour un autre compte expert";
      }
    }
    
    if(empty($_POST['commune'])){
      
        $errors['commune']="Vous avez pas mis votre situation gégraphique";
    }
    if(empty($_POST['mdp1']) || $_POST['mdp1']!= $_POST['mdp2']){
      
        $errors['password']="Vous n'avez pas renseigné un mot de passe valide";
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
        if($_FILES["image"]["size"] > 2967234) 
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
        header("location: connectW.php");   
   
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
  <link rel="stylesheet" type="text/css" href="../main.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  
  <script src="../load.js"></script>
</head>

<body>
  <div id=loader>
    <div class="load">
      <img src="../images/cons.gif">
    </div>
  </div>

  <header class="container">
    <div class="row">
      <div class="col-sm-4">
        <h1><span><img src="../images/logo.jpg" alt="" class="logo"></span>Pro-Bat</h1>
        
      </div>
      <div class="col-sm-8">
       <div>
        <h2 class="text-right">Le meilleur de Batiment</h2>
       </div>
       </br>
       <div>
        <nav>
          
            <ul class="nav nav-pills">
            <li role="presentation" style="margin-top:8px;" class="active"><a href="../index.php">Accuiel</a></li>
          </ul>

        </nav>
       </div>
      </div>
    </div>
  </header>

  <section class="jumbotron">

    <div class="container">
      <div class="row text-center">
      <h2>Pro-Bat</h2>
        <h3>Quand les pro du batiment sont à vos services</h3>
      </div>
    </div>

  </section>
  <section>
    <div class="row cal">
      <div class="col-sm-8">
          <h2 class="titre">Etude – Construction neuve – Renovation</h2>
          <p class="sous">Pro-Bat est une plateforme spécialisée dans l'etude topographique de vos terrains a Abidjan et vous fournir des details pour la construction de votre batiment.</p>
            <div class="decal">
              <p class="contact col-sm-4">77129951</p>
            </div>
            <div class="decal">
                <p class="contact col-sm-4">53888861</p>
              </div>
              <div class="decal">
                  <p class="contact col-sm-4">04744422</p>
                </div>
              
            
          </div>
      <div class="col-sm-3 zo">
        <h4>Inscrivez-vous</h4>
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
                        <select class="form-control input-lg" id="category" name="category">
                        <option selected>Votre profession</option>
                        <?php
                           require_once'../app/bd.php';
                           foreach ($bd->query('SELECT * FROM categorie') as $row) 
                           {
                                echo '<option value="'. $row['id'] .'">'. $row['profession'] . '</option>';;
                           }
                           
                        ?>
                        </select>
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
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="password" id="mdp1" name="mdp1" placeholder="Mot de passe" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="password" id="mdp2" name="mdp2" placeholder="Retaper le Mot de passe" class="form-control input-lg">
                        </div>
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
      <button type="submit" class="col-lg-12 btn-lg btn-primary">Enregistrer</button>
 
            </form> 
    </div>
    
                      </div>
                      
                    
                   </div>
                      
           <!--   Fin du formulaire     -->
      </div>
    </div>
  </section>

  <section class="container">

<div class="row"style="margin-top:50px;"> <!-- première rangée -->
  <div class="zoom">
  <figure class="col-sm-4">
    <p class="sous">Vous êtes un ouvrier qualifié</p>
    <img src="../images/électricien.jpg">
  </figure>
</div>

  <div class="zoom">
  <figure class="col-sm-4">
    <p class="sous">Inscrivez vous</p>
    <img src="../images/macon.jpg">
  </figure>
</div>

  <div class="zoom">
  <figure class="col-sm-4">
    <p class="sous">Devenez l'un de nos expert</p>
    <img src="../images/plombier.jpg" alt="antiquité">
  </figure>
</div>
</div>

</section>

</br>
</br>
</br>


<section class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="zoom">
      <p></p>
      <img src="../images/fotopleinecran.JPG">
    </div>
    </div>
  </div>
</section>

</br>
</br>
</br>

<section class="container">
  <div class="row">
    <p class="separateur">
    </p>
  </div>
</section>

</br>
</br>
</br>

<section class="container">
  <div class="row">
    <div class="col-sm-9">
      <p>
      Les personnes qui travaillent dans le bâtiment passent souvent devant leurs propres travaux de construction. « Il est agréable de réaliser un projet que l’on peut ensuite contempler et dont on peut être fier. Il s’agit d’une réalisation tangible, admirée par beaucoup de gens.
      Et cette fierté vous l'aurez chaque jour encore plus lorsque vous verrez un sourire sur le visage de nos clients.
      Le secteur contribue au développement des innovations technologiques. Il y a de grandes chances que vous puissiez contribuer à l’élaboration de nouveaux processus de production, à l’amélioration de logiciels, au développement de robots, à la mise en oeuvre de nouvelles méthodes de construction, à la construction virtuelle à l’aide de la 3D et du BIM, etc.
      
      </p>
    </div>

    <div class="col-sm-3">
      <div class="zoom">
      <img src="../images/maison5.jpg">
    </div>
    </div>
  </div>
</section>

</br>
</br>
</br>

<section class="container">
  <div class="row">
    <p class="separateur">
    </p>
  </div>
</section>

</br>
</br>
</br>

<section class="container">
  <div class="row">
      <div class="zoom">
    <figure class="col-sm-4">
      <img src="../images/maison2.jpg" class="img-circle">
    </figure>
    </div>
    
    <div class="zoom">
    <figure class="col-sm-4">
      <img src="../images/maison4.jpg" class="img-circle">
    </figure>
  </div>

  <div class="zoom">
  <figure class="col-sm-4">
      <img src="../images/maison3.jpg" class="img-circle">
    </figure>
  </div>
</div>
</section>
</br>
</br>

<section class="container">
  <div class="row">
    <p class="separateur">
    </p>
  </div>
</section>

</br>
</br>
</br>


<footer class="container">
  <div class="row">
    <p class="col-sm-4">&copy; 2019 Pro-Bat</p>
    <ul class="col-sm-8">
      <li class="col-sm-1"> <img src="../images/facebook.png" alt=""> </li>
      <li class="col-sm-1"> <img src="../images/instagram.png" alt=""> </li>
      <li class="col-sm-1"> <img src="../images/medium.png" alt=""> </li>
    </ul>
  </div>
</footer>


</body>
</html>
