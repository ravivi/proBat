<?php
require_once 'bd.php';
require 'function.php';
if(!empty($_POST))
{
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $commune = $_POST['commune'];
    $password = $_POST['mdp1'];
    $image = checkInput($_FILES["image"]["name"]);
    $imagePath          = '../images/'. basename($image);
    $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
    $isSuccess          = true;
    $isUploadSuccess    = false;

                //declaration des parametre de la fonction insert
    $db_table = "users";
    $db_column = "nom,email,telephone,localite,password";
    $db_inconnu = "?,?,?,?,?";
    $post_values = array($nom,$email,$tel,$commune,sha1($password));
    $errors=array();
    if(empty($_POST['nom'])){
        $errors['nom']="Vous avez pas mis de nom";
    }
    if(empty($_POST['email']) || !filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)){
        $errors['email']="Vous avez pas mis un email valide";
    }else{
        $req = $bd->prepare('SELECT id FROM users WHERE email=?');
        $req->execute([$_POST['email']]);
        $dejaEmail=$req->fetch();
        if($dejaEmail){
          $errors['email']="Cet email est deja utilisé pour un autre compte";
        }
    }
    if(empty($_POST['tel'])){
        $errors['tel']="Vous avez pas mis Votre numero de téléphone";
    }else{
      $req = $bd->prepare('SELECT id FROM users WHERE telephone=?');
      $req->execute([$_POST['tel']]);
      $dejaTel=$req->fetch();
      if($dejaTel){
        $errors['tel']="Ce numero de telephone est deja utilisé pour un autre compte";
      }
    }
    if(empty($_POST['commune'])){
        $errors['commune']="Vous avez pas mis votre situation gégraphique";
    }
    if(empty($_POST['mdp1']) || $_POST['mdp1']!= $_POST['mdp2']){
        $errors['password']="Vous n'avez pas renseigné un mot de passe valide";
    }

    if(empty($errors))
    {
        insert($bd,$db_table,$db_column,$db_inconnu,$post_values);
        echo "c'est zo";
          
    }else{
        header('location:../users.php');
    }
    
}

?>
