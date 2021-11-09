<?php

declare(strict_types = 1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

function sanitizeInput($value) {
    return htmlspecialchars( stripslashes( trim( $value) ) );
}

session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login_project2.php");
    exit;
}
 
require_once "inc.db_project2.php";
 
$newPassword = $confirmPass = $newPassError = $confirmPassError = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    $newPass = sanitizeInput($_POST["new_password"]);

    if(empty(sanitizeInput($_POST["new_password"]))){
        $newPassError = "Please enter a password.";     
    } elseif(!preg_match("/^[a-zA-Z0-9_-]{5,16}$/", $newPass)){
        $newPassError = "Password must: be at least 5 characters and 16 characters or less, and only include _ and - for special characters";
    } else{
        $newPassword = sanitizeInput($_POST["new_password"]);
    }
    if(empty(sanitizeInput($_POST["confirm_password"]))){
        $confirmPassError = "Please confirm password.";
    } else{
        $confirmPass = sanitizeInput($_POST["confirm_password"]);
        if(empty($newPassError) && ($newPassword != $confirmPass)){
            $confirmPassError = "Passwords don't match.";
        }
    }
        
    if(empty($newPassError) && empty($confirmPassError)){
      
        $sql = "UPDATE Project.User SET password = :password WHERE id = :id";
        
        if($stmt = $pdo->prepare($sql)){
            
            $stmt->bindParam(":password", $paramPass, PDO::PARAM_STR);
            $stmt->bindParam(":id", $paramId, PDO::PARAM_INT);
            
            $paramPass = password_hash($newPassword, PASSWORD_DEFAULT);
            $paramId = $_SESSION["id"];
            
            
            if($stmt->execute()){
                session_destroy();
                header("location: login_project2.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" type = "text/css" href = "style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script type="text/javascript" src = "project.js"></script>
</head>

<body class="w3-container w3-light-blue" >
<h2>Reset Password</h2>
    <div class = "w3-panel w3-border w3-round-xlarge w3-container w3-pale-red">
        <p>Complete all fields to reset your password.</p>
        <form action = "<?php echo sanitizeInput($_SERVER["PHP_SELF"]); ?>" method = "post" onSubmit = "return validateResetPass()" class = "w3-container w3-pale-red"> 
            <p>
                <label>New Password</label>
                <span class="w3-text-red"><?php echo $newPassError; ?></span>
                <input id = "password" type="password" name="new_password" class="w3-input w3-border"value="<?php echo $newPassword; ?>">
             </p>
            <p>
                <label>Confirm Password</label>
                <span class="w3-text-red"><?php echo $confirmPassError; ?></span>
                <input id = "confirmpass" type="password" name="confirm_password" class="w3-input w3-border">
                
             </p>
            <p>
                <input type="submit" class = "w3-button w3-green" value="Submit">
                <a href="welcome_project2.php">Go Back</a>
             </p>
        </form>
    </div>    
</body>
</html>