<?php

session_start();
require "config.php";

$pdostatement = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['post_id_to_delete']);
$pdostatement->execute();
$_SESSION['successMsg'] = 'A post deleted successfully';
header('location: index.php');
