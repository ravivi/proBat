<?php
require_once '../app/bd.php';
require '../app/function.php';
$succes=false;
if(!empty($_POST))
{
    $nom = checkInput($_POST['nom']);
    $email = checkInput($_POST['email']);
    $tel = checkInput($_POST['tel']);
    $commune = checkInput($_POST['commune']);
    $password = checkInput($_POST['mdp1']);
    $image = checkInput($_FILES["image"]["name"]);
    $imagePath          = '../photo/client/'. basename($image);
    $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
    $isSuccess          = true;
    $isUploadSuccess    = false;
    $msg="";

                //declaration des parametre de la fonction insert
    $db_table = "users";
    $db_column = "nom,login,telephone,commune,mdp,photo";
    $db_inconnu = "?,?,?,?,?,?";
    $post_values = array($nom,$email,$tel,$commune,sha1($password),$image);
    $errors=array();
    if(empty($_POST['nom'])){
      $succes=false;
        $errors['nom']="Vous avez pas mis de nom";
    }
    if(empty($_POST['email']) || !filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)){
      $succes=false;  
      $errors['email']="Vous avez pas mis un email valide";
    }else{
        $req = $bd->prepare('SELECT id FROM users WHERE login=?');
        $req->execute([$_POST['email']]);
        $dejaEmail=$req->fetch();
        $pdo = $bd->prepare('SELECT id FROM workers WHERE login=?');
        $pdo->execute([$_POST['email']]);
        $dejaW=$pdo->fetch();
        if($dejaEmail){
          $succes=false;
          $errors['email']="Cet email est deja utilisé pour un autre compte";
        }if($dejaW){
          $succes=false;
          $errors['email']="Cet email est deja enregistré pour un compte expert";
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
        $pdo->execute([$_POST['email']]);
        $dejaT=$pdo->fetch();
      if($dejaTel){
        $succes=false;
        $errors['tel']="Ce numero de telephone est deja utilisé pour un autre compte";
      }if($dejaT){
        $succes=false;
        $errors['email']="Cet Numéro est deja enregistré pour un compte expert";
      }
    }
    if(empty($_POST['commune'])){
      $succes=false;
        $errors['commune']="Vous avez pas mis votre situation gégraphique";
    }
    if(empty($_POST['mdp1']) || $_POST['mdp1']!= $_POST['mdp2']){
      $succes=false;
        $errors['password']="Vous n'avez pas renseigné un mot de passe valide";
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
            $isUploadSuccess = false;
        }
        if(file_exists($imagePath)) 
        {
          $succes=false;
          $errors['image'] = "Le fichier existe deja";
            $isUploadSuccess = false;
        }
        if($_FILES["image"]["size"] > 7000000) 
        {
          $succes=false;
          $errors['image'] = "Le fichier ne doit pas depasser les 500KB";
            $isUploadSuccess = false;
        }
        // if($isUploadSuccess) 
        // {
        //     if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
        //     {
        //       $errors['image'] = "Il y a eu une erreur lors de l'upload";
        //         $isUploadSuccess = false;
        //     } 
        // } 
      }

    if(empty($errors))
    {
      $succes=true;
      move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
        insert($bd,$db_table,$db_column,$db_inconnu,$post_values);
        header("location: connect.php");
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
            <!-- <li role="presentation"><a href="#">Maisons</a></li>
            <li role="presentation"><a href="#">Habitats collectifs</a></li>
            <li role="presentation"><a href="#">Travaux</a></li>
            <li role="presentation"><a href="#">Nos terrains</a></li> -->
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
          <p class="sous">Pro-Bat est une plateforme spécialisée dans l'etude topographique et géothermique de vos terrains a Abidjan et vous fournir des details pour la construction de votre batiment.</p>
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
                        <input type="text" id="email" name="email" placeholder="email" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                        <div class="col-xm-6">
                        <input type="text" id="tel" name="tel" placeholder="Telephone" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="form-group">  
                    <select class="form-control input-lg" name="commune">
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
      <p class="sous">Ouvrier qualifié</p>
      <img src="../images/peintre.jpg">
    </figure>
  </div>

    <div class="zoom">
    <figure class="col-sm-4">
      <p class="sous">Besoin d'expert</p>
      <img src="../images/macon.jpg">
    </figure>
  </div>

    <div class="zoom">
    <figure class="col-sm-4">
      <p class="sous">Renovation de votre maison</p>
      <img src="../images/reno.jpg" alt="antiquité">
    </figure>
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
      <div class="col-sm-7">
        <p>
        Construction d'un immeuble, réaménagement d'une cafétéria, réhabilitation d'une maison, etc. Le maître d'œuvre de tous ces chantiers, c'est l'architecte. Il suit le projet de construction, de la commande à la livraison. Très créatif, surtout en phase de conception, l'architecte n'a rien d'un artiste qui travaillerait seul face à l'ordinateur. Et il ne suffit pas de dessiner un bâtiment pour qu'il voie le jour !

Le métier comporte aussi beaucoup de contraintes techniques : choix des matériaux, problèmes réglementaires et financiers, date d'achèvement du projet, etc. De plus, l'architecte doit concilier le besoin du client et des utilisateurs, négocier avec les entreprises et les bureaux d'études.

La majorité des architectes (près de 70 %) exerce en libéral, mais la plupart débutent comme salariés dans de toutes petites agences (moins de 4 personnes). Quelques-uns intègrent, par voie de concours, le secteur public.
Trouver ces professions et expert est très difficile voire impossible mais a Pro-Bat vous trouverez une equipe d'architecte pointue.
        </p>
  
      </div>
  
      <div class="col-sm-5">
        <!-- <img src="../images/gifts.jpg"> -->
        <iframe width="560" height="315" src="https://www.youtube.com/embed/1hLBCOlptq8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
  
    </div>
  
  </section>
  <section class="container">
      <div class="row">
        <p class="separateur">
        </p>
      </div>
    </section>
  <section class="container">

      <div class="row">
        <div class="col-sm-7">
          <p>
          Une fissure qui apparaît sur un mur, une façade, un sol ou un plafond, signifie que des tensions s’opèrent sur le bâtiment et il est souvent préférable de s’en inquiéter rapidement.
La survenue d’une fissure au sein d’une habitation peut avoir de multiples causes. Il peut entre autres s’agir d’un simple problème de fissuration de l’enduit, ou bien provenir d’un mouvement de sol, d’une infiltration d’eau, de la présence d’une malfaçon de la construction sur le bâtiment,…

Une fissure, selon sa cause d’apparition et son degré de gravité, risque d’avoir des conséquences plus ou moins désastreuses pour le logement et ses habitants. En effet, une fissure est parfois seulement inesthétique, mais présente dans certains cas de figure un risque d’effondrement pour la construction.
Ainsi, dès lors qu’une fissure se forme à l’intérieur ou à l’extérieur de votre logement, il est nécessaire de prendre le problème au sérieux, afin de limiter la prise de risque.
Ces fissures entrainent des consequences desastreuses comme l'effondrement de votre batiment.Voici l'un des plus gros problème en construction et donc ne brulez pas les étapes. Passez d'abord chez le géometre, le topographe avant de penser a l'architecte ou même l'ingenieur en batiment voire même la main d'oeuvre.
          </p>
    
        </div>
    
        <div class="col-sm-5">
          <!-- <img src="../images/gifts.jpg"> -->
          <iframe width="560" height="315" src="https://www.youtube.com/embed/8I6CgxUWYbk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
    <div class="col-sm-4">
      <p>
      
Les difficultés les plus courantes sont liées à l’achat du terrain : sa viabilisation d’une part, l’adaptation des fondations suite à la communication des résultats de l’étude de sol d’autre part.

Pour rappel, la viabilité de votre terrain concerne l’ensemble des frais nécessaires au raccordement des différents réseaux : eau, électricité, gaz, téléphone,… Sont aussi repris les frais liés à la réalisation du ou des chemin(s) d’accès à votre future maison.

Le plus souvent, ces travaux engendrent des coûts importants. Attention donc à les faire réaliser par des professionnels aguerris, qui vous auront livré des devis en bonne
et due forme au préalable. Pro-Bat vous fournir des experts depuis l'etude de votre terrains jusqu'a la construction de votre maison.
      </p>
    </div>

    <div class="zoom">
    <figure class="col-sm-4">
      <img src="../images/ingenieur.jpg">
    </figure>
  </div>

    <div class="col-sm-4">
      <p>
      Un autre problème de construction réside dans le fait que les entreprises peuvent très bien planifier les 3 prochains mois et prévoir les résultats, mais ne parviennent pas à identifier et à calculer le travail à faire la semaine d’après ou dans les 15 jours. Cela entraîne souvent des retards provoqués par l’indisponibilité d’un équipement ou de matériaux.
      Dans le cas où l’étude de sol entreprise confirme un risque réel pour la réalisation des travaux, nous adapterons votre chantier au sol avant d’aller plus loin, et ce afin d’éviter des problèmes d’affaissement, de glissement de terrain, de fissures ou de
stabilité qui pourraient transformer votre rêve en cauchemar.
      </p>
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
      L’architecte vous offre la garantie responsabilité civile. C’est également le cas du constructeur.

Le constructeur propose des garanties aussi complètes qu’essentielles, parmi lesquelles : la garantie responsabilité civile, la garantie biennale, la garantie décennale, la garantie de paiement des sous-traitants, la garantie de parfait achèvement, la garantie de remboursement de l’acompte et la garantie de livraison aux prix et délais convenus.
Fait confiance a des personnes peut qualifié est un risque qui peut être eviter si vous faites confiance a Pro-Bat  en rien.
Le maître d’œuvre ne propose aucune garantie.
  </p>
    </div>

    <div class="col-sm-3">
      <div class="zoom">
      <img src="../images/architecte.jpg">
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
