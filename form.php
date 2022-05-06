
<?php

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

function filter_data($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ergasiaDB";
$tableName = "formParticipants";


try {

  $pdo =  new PDO("mysql:host=$servername", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $pdo->query("use $dbname");


  // Binding vars to actual form inputs
  $stmt = $pdo->prepare("INSERT INTO $tableName (fullname, email, website, gender, message)
  VALUES (:fullname, :email, :website, :gender, :message)");
  $stmt->bindParam(':fullname', $fullname);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':website', $website);
  $stmt->bindParam(':gender', $gender);
  $stmt->bindParam(':message', $message);
  

} 
catch(PDOException $e) {  }



// define variables and set to empty values

$nameErr = $emailErr = $websiteErr = $genderErr = "";

$name = $email = $website = $gender = $message = "";

$count = 0;


if ($_SERVER["REQUEST_METHOD"] == "POST") {


  // Name data filter
   if(empty($_POST["name"])) $nameErr = "Name is required"; 
    else { 
      $fullname = filter_data($_POST["name"]);
      $count++;
      }

    // Email data filter + validation
   if(empty($_POST["email"])) $emailErr = "Email is required"; 
    else {
      $email = filter_data($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $emailErr = "Invalid email format"; 
        else{
          $count++;
        }
    }


    // Website data filter + validation
   if(empty($_POST["website"])) $websiteErr = "Website is required"; 
    else {
      $website = filter_data($_POST["website"]);
      if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
        $websiteErr = "Invalid URL"; 
      }
      else{
        $count++;
      }
    }
  
    if(empty($_POST["gender"])) $genderErr = "Selecting a gender is required";
    else{
      $gender = $_POST["gender"];
      $count++;
    }

  if(!empty($_POST["message"])) $message = filter_data($_POST["message"]);


  if($count==4) {

    if(databaseExists()){
      $stmt->execute(); 
      echo '<script>alert("Your form has been submitted successfully")</script>';
    } 

    if(!databaseExists()) 
      echo '<script>alert("No database created. If you wish to create one, log in as administrator.");</script>';
  }

}
$pdo = null;
?>

<!DOCTYPE html>
<head>
  <title>Contact Form</title>
  <script defer>
    // Prevents the form from re-submitting if the page is refreshed.
    if (window.history.replaceState) { window.history.replaceState(null, null, window.location.href); }
  </script>
  <!-- echo time() forces the browser to reload the css -->
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>


<div class="main-container">

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

    <h1>Contact Form</h1>

    <br>

    <span class="labels">Full name:</span> <span class="error">* <?php echo $nameErr;?></span>
    <input type="text" name="name" placeholder="Enter your name" autocomplete="off">
    

    <br><br>

    <span class="labels">Email:</span> <span class="error">* <?php echo $emailErr;?></span>
    <input type="text" name="email" placeholder="Enter your email address" autocomplete="off">
    

    <br><br>
    
    <span class="labels">Website:</span> <span class="error">* <?php echo $websiteErr;?></span>
    <input type="text" name="website" placeholder="Website" autocomplete="off"> 
    
    <br><br>

    <label for="gender"><span class="labels">Gender:</span></label> <span class="error">* <?php echo $genderErr;?></span> <br>
    <select name="gender" autocomplete="off">
        <option disabled selected value>Select a gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>

    <br><br>

    <label for="message"><span class="labels">Message:</span></label> 
    <textarea name="message" rows="4" cols="50" placeholder="Your message here..."></textarea>

    <br><br>

    <input type="submit" class="submit" value="Υποβολή">

    <br><br>

    <span class="error">*</span> Fields are mandatory.

  </form> 

  </div>
  <a href="logout.php" class="btn">Sign Out of Your Account</a>
</body>
</html>