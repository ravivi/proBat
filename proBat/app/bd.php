<?php
$bd = new PDO('mysql:host=localhost;dbname=bat', 'root', '');
$bd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>