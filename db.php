<?php

$host = 'localhost';
$dbname = 'music_library';
$username = 'root';
$password = 'eko';

try{
    $pdo = new PDO("mysql:host=$host;$dbname;charset=utf8mb4",$username,$password);
    $pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   
} catch(PDOException $e){
    die("Failed to connect to DB: ". $e->getMessage());
}

?>