<?php

/* Database credentials. */
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "loginSystem";
$tablename = "users";

// Admin user 1 
$admin_name = "webadmin1";
$admin_password = $admin_name;
$u_type = "admin";

// Admin user 2
$admin_name1 = "webadmin2";
$admin_password1 = $admin_name1;

/* Attempt to connect to MySQL database */
try{

    $pdo = new PDO("mysql:host=$servername", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->query("use $dbname"); 

    $sql = "CREATE TABLE IF NOT EXISTS $tablename (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        user_type VARCHAR(100),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );";

    $pdo->exec($sql);


    $sql = "INSERT IGNORE INTO users (username, password, user_type) VALUES (:username, :password, :user_type)";
    $stmt = $pdo->prepare($sql);


    // Admin 1
    $param_username = $admin_name;
    $param_password = password_hash($admin_password, PASSWORD_DEFAULT);
    $param_type = $u_type;
    
    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
    $stmt->bindParam(":user_type", $param_type, PDO::PARAM_STR);

    $stmt->execute();


    // Admin 2
    $param_username = $admin_name1;
    $param_password = password_hash($admin_password1, PASSWORD_DEFAULT);
    $param_type = $u_type;
    
    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
    $stmt->bindParam(":user_type", $param_type, PDO::PARAM_STR);

    $stmt->execute();


} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>

