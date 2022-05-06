<?php 
require 'createDB.php';

$name_keyword = $provider_keyword = $stmt = "";

$flag = false;

$pdo = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {


        if(!empty($_POST["name"])){
            $stmt = $pdo->prepare("SELECT * FROM $tableName WHERE fullname LIKE :name_keyword;");
            $name_keyword = $_POST["name"] ;
            $stmt->bindValue(':name_keyword','%'.$name_keyword.'%');
            $flag=true;
            
        }


        if(!empty($_POST["provider"])){
            $stmt = $pdo->prepare("SELECT * FROM $tableName WHERE email LIKE :provider_keyword;");
            $provider_keyword = $_POST['provider'];
            $stmt->bindValue(':provider_keyword','%'.$provider_keyword.'%');
            $flag=true;
        }
        

        if(!empty($_POST["name"]) && !empty($_POST['provider'])){
            $stmt = $pdo->prepare("SELECT * FROM $tableName WHERE fullname LIKE :name_keyword AND email LIKE :provider_keyword;");
            $name_keyword = $_POST["name"] ;
            $provider_keyword = $_POST['provider'];
            $stmt->bindValue(':name_keyword','%'.$name_keyword.'%');
            $stmt->bindValue(':provider_keyword','%'.$provider_keyword.'%');
            $flag=true;
        }else if(empty($_POST["name"]) && empty($_POST['provider'])){
            echo "<script>alert('Please insert a value in at least one of the fields.')</script>";

        }

        if($flag){
            try{
                $stmt->execute();
            }
            catch(PDOException $err)
            {
            $err->getMessage();
            }   
        }
}
$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; margin-top: 1em; }

        .search-box{
            font-size: 20px;
            margin: 2em auto;
            background-color: #a9a9a9;
  
            width: 30%;
            height: 14rem;
            padding: 2em;
            border-radius: 10px;
        }

        .search-box, input, select {
            border-style:solid;
            border-color:black;
            border-width: 2px;
        }

        .btn { border-width: 2px; border-color: black; }

        th { background-color: #6897BB;}
    
    </style>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <h1> Form participants </h1>

        <div class="search-box">

            First name: <input type="search" name="name" placeholder="First name">
        
            <br><br>
        
            <label for="provider">Email provider:</label>
        
            <select name="provider">
                <option disabled selected value>Select an option</option>
                <option value="gmail">Gmail</option>
                <option value="outlook">Outlook</option>
                <option value="yahoo">Yahoo</option>
            </select>
        
            <br><br>
        
            <input type="submit" value="Search" class="btn btn-warning">

        </div>

        <br>

        <?php if($stmt!=null && $stmt->rowCount() > 0) :?> 
            <h1><?php echo $stmt->rowcount()?> result(s) found</h1>
            <br><br>
            <?php else : ?>
                <h1></h1>
            <?php endif; ?>

    <table class="table table-bordered table-condensed">

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $flag) :
            if($stmt->rowCount() > 0) : ?>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Gender</th>
                    <th>Message</th>
                    <th>Date of submition</th>
                </tr>
            </thead>
        <tbody>
             <?php  while ($r=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php  echo $r['id'] . " " ;?></td>
                    <td><?php  echo $r['fullname'] . " " ;?></td>
                    <td><?php  echo $r['email'] . " " ; ?></td>
                    <td><?php  echo $r['website'] . " " ;?></td>
                    <td><?php  echo $r['gender'] . " " ;?></td>
                    <td><?php  echo $r['message'] . " " ;?></td>
                    <td><?php  echo $r['reg_date'] . "<br>";?></td>
                </tr>
             <?php endwhile; ?>
            <?php else : ?>
                <h1>No results found..</h1>
            <?php endif; ?>
        <?php endif; ?>

        </tbody>

    </table> <br><br>
   <a href="admin-panel.php" class="btn btn-warning" >Back to admin panel</a>
  </form>
 </body>
</html>