<?php

$servername = "188.166.24.55";
$username = "jepsen5-anishanderson";
$password = "m4xM0z,)C&4gGrg}XN2<";
$dbname = "jepsen5-anishanderson";
$port = "";

$pdo = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id = $_POST['id'] ?? null;

if (!$id)
{
    header('Location:index.php');

}

$statement = $pdo->prepare('DELETE FROM hikes WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
header('Location:index.php');