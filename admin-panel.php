<?php
// Initialize the session
session_start();
 
function databaseExists() {

    $testdb = new PDO("mysql:host=localhost;dbname=information_schema", "root", "");
    $testdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    try{ 
      $result = $testdb->query("SELECT SCHEMA_NAME
                                FROM INFORMATION_SCHEMA.SCHEMATA
                                WHERE SCHEMA_NAME = 'ergasiadb'");
  
      return (bool) $result->fetchAll();
  
    }catch(PDOException $e) {
      return false;
    }
  
}  

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once 'config.php';

try{
    
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $id = $_SESSION['id'];

    $sql = "SELECT user_type
            FROM users
            WHERE id=$id";

    $q = $pdo->query($sql);

    $user = $q->fetch();

    $type = $user['user_type'];

    if($type != 'admin'){
        header("location: form.php");
        exit;
    }
}catch(PDOException $e){
   echo "ERROR: " . $e->getMessage();
}
$pdo = null;
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }

        .btn-custom{
            margin: 1em;
            background-color:#708090;
            color:white;
            border-style:dotted;
            border-color:black;
        }

        .btn{ font-size: 3ch; border: 2px solid black; }

        .btn-custom{ margin-bottom:2em; }
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to the administration panel.</h1>

    <?php
        if(array_key_exists('button1', $_POST)) {

            if(include("createDB.php")){
                echo '<script>alert("Database created successfully. / Already exists.")</script>';
            }else {
                echo '<script>alert("Error creating database.")</script>';
            }
        }

        if(array_key_exists('button2', $_POST)){
            if(DatabaseExists()){
                header("location: showDB.php");
                exit;
            }
            
            if(!DatabaseExists()) echo '<script>alert("Cannot show database because database does not exist.")</script>';
            
        }   

        
        if(array_key_exists('button3', $_POST)){
            if(DatabaseExists()){
                header("location: searchDB.php");
                exit;
            }
            
            if(!DatabaseExists()) echo '<script>alert("Cannot search database because database does not exist.")</script>';

        }   
    ?>
  
    <form method="post">
        <input type="submit" name="button1" class="btn btn-custom" value="Create DB" />
        <input type="submit" name="button2" class="btn btn-custom" value="Show DB" />
        <input type="submit" name="button3" class="btn btn-custom" value="Search DB" />
    </form>

        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>

    </p>
</body>
</html>