<?php

$forum_naam = "Siltech";
$base_url = "http://localhost/forum/";

$host = 'localhost';
$username = 'root';
$password = 'root';
$db = 'forum';

$dbc = mysqli_connect($host, $username, $password, $db) or die('Siltech -> Kon niet verbinden met de database.');
?>
