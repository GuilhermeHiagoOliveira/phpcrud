<?php

$db_name = 'crud';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_port = 3306;

$conn = new PDO("mysql:host=$db_host;port=$db_port;dbname=" . $db_name, $db_user, $db_pass);
    // $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);