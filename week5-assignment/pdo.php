<?php
// File to perform the mysql connection
// put equire_once "pdo.php"; in the files to establish the connection
// user and password mut be changed for your configuration

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc','user','password');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>