<?php session_start();
require '../app/bd.php';
?>

<?php
 $succes=false;
 $msg="";
  $login=$mdp="";
  $messageError="";
  $verif=false;
  $messageError=false;
  if(isset($_POST['login']) AND isset($_POST['mdp']))
    
  {
      if(!empty($_POST['login']) OR !empty($_POST['mdp']))
      {
          
      
      $login = $_POST['login'];
      $mdp = sha1($_POST['mdp']);
      //on selectionne tout dans la bdd avec le log et mdp poster
    $req = $bd->prepare("SELECT * FROM users WHERE login = ? and mdp = ?");
    $req->execute(array($login, $mdp));
    $userexist = $req->rowCount();
    if($userexist == 1)
    {
      $userexist=$req->fetch();
      $_SESSION['id'] = $userexist['id'];
      $_SESSION['login'] = $userexist['login'];
      $_SESSION['mdp'] = $userexist['mdp'];
      header("Location: actionU.php?id=".$_SESSION['id']);
    }
    else{
      $succes=true;
      $msg="Login ou mot de passe incorrect";   

    } 
          }
  }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="../connect.css">
    <title>Prob-Bat</title>
</head>
<body>

    <div class="logo">
        <img src="../espace.png" class="avatar" alt="">
        <h1>Connectez-vous</h1>
        <form method="post">
            <p>Login</p>
            <input type="text" name="login" placeholder="Entrez votre email">
            <p>Mot de passe</p>
            <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe">
            <input type="submit" name="" value="connexion">   
        </form>
        <?php if($succes==true): ?>
                        <div class="alert alert-danger">
                          <p><?=$msg?></p>
                        </div>
                      <?php endif; ?>
    </div>
</body>
</html>