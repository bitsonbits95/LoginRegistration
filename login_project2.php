<?php

declare(strict_types = 1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

function sanitizeInput($value) {
    return htmlspecialchars( stripslashes( trim( $value) ) );
}

session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome_project2.php");
    exit;
}
 
require_once "inc.db_project2.php";
 
$username = $password = $usernameError = $passwordError = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(sanitizeInput($_POST["username"]))){
        $usernameError = "Please enter your username";
    } else{
        $username = sanitizeInput($_POST["username"]);
    }
    
    if(empty(sanitizeInput($_POST["password"]))){
        $passwordError = "Please enter your password";
    } else{
        $password = sanitizeInput($_POST["password"]);
    }
    
    if(empty($usernameError) && empty($passwordError)){
        
        $sql = "SELECT id, username, password FROM User WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":username", $paramUname, PDO::PARAM_STR);
            
        $paramUname = sanitizeInput($_POST["username"]);
            
        if($stmt->execute()){
         if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()){
                $id = $row["id"];
                $username = $row["username"];
                $hashPass = $row["password"];
                if(password_verify($password, $hashPass)){
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;                            
                    header("location: welcome_project2.php");
                } else {
                $passwordError = "The password you entered was not valid.";
                }
            }
        } else {
        $usernameError = "Username does not exist.";
        }
        } else {
        echo "Oops! Something went wrong. Please try again later.";
        }
        unset($stmt);
        }
    }
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang = "en">
<head>
<style>
      #outer-div {
        width: 100%;
        text-align: center;
      }
      #inner-div {
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <title>Login</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script type="text/javascript" src = "project.js"></script>
</head>

<body class="w3-container w3-light-blue" >
   <div id="outer-div" >
    <h2>Login</h2>
    <div id="inner-div"class = "w3-panel w3-border w3-round-xlarge w3-container w3-pale-red">
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo sanitizeInput($_SERVER["PHP_SELF"]); ?>" method="post" onSubmit = "return validateLogin()" class = "w3-container w3-pale-red">
            <p>
                <label>Username</label>
                <span class = "w3-text-red"><?php echo $usernameError; ?></span>
                <input type = "text" id = "username" name = "username" class = "w3-input w3-border" value="<?php echo $username; ?>">
            </p>    
            <p>
                <label>Password</label>
                <span class = "w3-text-red"><?php echo $passwordError; ?></span>
                <input type = "password" id = "password" name = "password" class= "w3-input w3-border">

             </p>
            <p>
                <input type="submit" class = "w3-btn w3-green" value="Login">
             </p>
            <p style = "text-align: center";>Don't have an account? <a href="register_project2.php">Sign up now</a>.
             </p>
        </form>
    </div>
</body>
</html>