<?php 

try {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ergasiaDB";
    $tableName = "formParticipants";

    $db =  new PDO("mysql:host=$servername", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $db->query("CREATE DATABASE IF NOT EXISTS $dbname");
    $db->query("use $dbname");


    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            fullname VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            website VARCHAR(50),
            gender VARCHAR(10),
            message VARCHAR(500),
            reg_date TIMESTAMP)";

    $db->exec($sql);

}catch(PDOException $e){ echo "Error: " . $e->getMessage(); }

$db = null;
?>