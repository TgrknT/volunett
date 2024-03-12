<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "volunet";
try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset-utf8","$username","$password");
    //echo "basarili" ;
} catch (PDOExpection $db) {
    echo $db->getMessage();
    //echo "basarisiz";
}






?>