<?php

declare(strict_types = 1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

require_once "inc.db_project2.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login_project2.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "GET"){

$id = $_SESSION["id"];

$sql = "DELETE FROM Project.favColor WHERE user\$id = '$id'";

$stmt = $pdo->query($sql);
$stmt->execute();

$sql = "DELETE FROM Project.FavMovieGenre WHERE user\$id = '$id'";

$stmt = $pdo->query($sql);
$stmt->execute();

$stmt = $pdo->query($sql);
if($stmt->execute()){
    header("location: welcome_project2.php");
    exit();
} else{
    echo "Oops! Something went wrong. Please try again later.";
}
unset($stmt);
unset($pdo);
}
?>