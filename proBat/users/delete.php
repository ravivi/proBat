<?php
    require '../app/bd.php';
 
    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        $req = $bd->prepare("DELETE FROM users WHERE id = ?");
        $req->execute(array($id));
        header("Location: users.php"); 
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
        <title>probat</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../main.css">
    </head>
    
    <body>
         <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer mon compte</strong></h1>
                <br>
                <form class="form" action="delete.php" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer votre compte?</p>
                    <div class="form-actions">
                      <button type="submit" class="btn btn-warning">Oui</button>
                      <a class="btn btn-default" href="sonProfil.php">Non</a>
                    </div>
                </form>
            </div>
        </div>   
    </body>
</html>

