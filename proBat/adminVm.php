<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css"href="main.css">
    <title>ProBat</title>
  </head>
  <body>
<div class="container">
<div class="row" style="margin-top:50px">
<div class="col-sm-6">
  <h1 style="margin-left:20px">Liste des maisons</h1>
</div>
<div class="col-sm-6">
  <a class="btn btn-outline-success" style="margin-left:60%" href="adminA.php">Retour</a>
  </div>
</div>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Photo</th>
      <th scope="col">Nom</th>
      <th scope="col">Description</th>
      <th scope="col">prix</th>
      <th scope="col">Ajoutée depuis</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php session_start();
    require_once'app/bd.php';
    $req=$bd->query('SELECT* FROM maison ORDER BY date_add DESC');
      while($item = $req->fetch()) 
      {
          echo '<tr>';
          echo '<td><img src="photo/maison/'.$item['photo'].'" height="100"> </td>';
          echo '<td>'. $item['nom'] . '</td>';
          echo '<td>'. $item['description'] . '</td>';
          echo '<td>'. $item['prix'] . '</td>';
          echo '<td>'. $item['date_add'] . '</td>';
          echo '<td width=350>';
          echo '<a class="btn btn-outline-primary" href="profilMaison.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span>Voir le profil</a>';
          echo ' ';
          echo '<a class="btn btn-outline-danger" href="deleteM.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
          echo '</td>';
          echo '</tr>';
      }
    ?>
</tbody>
</table>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>