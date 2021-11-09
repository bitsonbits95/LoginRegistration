<?php

declare(strict_types = 1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

function sanitizeInput($value) {
    return htmlspecialchars( stripslashes( trim( $value) ) );
}

session_start();

require_once "inc.db_project2.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login_project2.php");
    exit;
}

$username = $_SESSION["username"];
$id = $_SESSION["id"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" type = "text/css" href = "style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        div {
            position:absolute; 
            top:0; 
            right:0;
        }
    </style>
</head>
<body class="w3-container w3-light-blue"  >

<table>
<tr>
    <th>Username</th>
</tr>

<?php
$sql = "SELECT username from Project.User WHERE username = '$username'";
$stmt = $pdo->query($sql);
if ($stmt-> rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
               <td>" . $row['username'] . "</td>
              </tr>"; 
        }
        echo "</table>";
} 
?>

<table>
    <tr>
        <th>Favorite Colors</th>
   </tr>

<?php
$sql = "SELECT favColor from Project.favColor WHERE user\$id = '$id'";
$stmt = $pdo->query($sql);
if ($stmt-> rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
               <td>" . $row['favColor'] . "</td>
              </tr>"; 
        }
        echo "</table>";
} else {
    echo "No data to display";
}
?>

<table>
    <tr>
        <th>Favorite Movie Genres</th>
    <tr>
<?php
$sql = "SELECT favMovieGenre from Project.FavMovieGenre WHERE user\$id = '$id'";
$stmt = $pdo->query($sql);
if ($stmt-> rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
               <td>" . $row['favMovieGenre'] . "</td>
              </tr>"; 
        }
        echo "</table>";
} else {
    echo "No data to display";
}
?>

<div>
<a href = "update_record_project2.php" style = "float:right;"></button>Clear and/or Update Choices<a><br>
<a href = "welcome_project2.php" style = "float:right;"></button>Go Back<a>
</div>
</body>
</html>