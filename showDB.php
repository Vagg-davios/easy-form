<?php 
require 'createDB.php';

$PDO = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $PDO->prepare("SELECT * FROM $tableName");
try{
    $stmt->execute();
}catch(PDOException $e){
   echo "ERROR: " . $e->getMessage();
}
$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        th { background-color: #6897BB;}
    </style>
 </head>
 <body>
   <h2>Form participants</h2>
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Gender</th>
                <th>Message</th>
                <th>Date of submition </th>
            </tr>
        </thead>
        <tbody>
            <?php while ($result=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($result['id']) ?></td>
                    <td><?php echo htmlspecialchars($result['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($result['email']); ?></td>
                    <td><?php echo htmlspecialchars($result['website']); ?></td>
                    <td><?php echo htmlspecialchars($result['gender']); ?></td>
                    <td><?php echo htmlspecialchars($result['message']); ?></td>
                    <td><?php echo htmlspecialchars($result['reg_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
   <a href="admin-panel.php" class="btn btn-danger ml-3">Back to admin panel</a>
 </body>
</html>
