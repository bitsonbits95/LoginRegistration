<?php

declare(strict_types = 1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

function sanitizeInput($value) {
    return htmlspecialchars( stripslashes( trim( $value) ) );
}


require_once "inc.db_project2.php";
 

$username = $password = $confirmPass = $usernameError = $passwordError = $confirmPassError = "";
$phpScript = sanitizeInput($_SERVER['PHP_SELF']);
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    $uname = sanitizeInput($_POST["username"]);
    if (!preg_match("/^[a-zA-Z0-9_-]{5,16}$/", $uname)) {
     $usernameError = "Username must: be at least 5 characters and 16 characters or less, and only include _ and - for special characters";
    }
    elseif(empty(sanitizeInput($_POST["username"]))){
     $usernameError = "Please enter a username.";
    } else{
      
        $sql = "SELECT id FROM User WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = sanitizeInput($_POST["username"]);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $usernameError = "This username is already taken.";
                } else{
                    $username = sanitizeInput($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }

    $pname = sanitizeInput($_POST["password"]);

    if(empty(sanitizeInput($_POST["password"]))){
        $passwordError = "Please enter a password.";     
    } elseif(!preg_match("/^[a-zA-Z0-9_-]{5,16}$/", $pname)){
        $passwordError = "Password must: be at least 5 characters and 16 characters or less, and only include _ and - for special characters";
    } else{
        $password = sanitizeInput($_POST["password"]);
    }
    
    if(empty(sanitizeInput($_POST["confirm_password"]))){
        $confirmPassError = "Please confirm password.";     
    } else{
        $confirmPass = sanitizeInput($_POST["confirm_password"]);
        if(empty($passwordError) && ($password != $confirmPass)){
            $confirmPassError = "Passwords don't match.";
        }
    }
    
    
    if(empty($usernameError) && empty($passwordError) && empty($confirmPassError)){

        $sql = "INSERT INTO Project.User (username, password) VALUES (:username, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_BCRYPT); 
           
            if($stmt->execute()){
                header("location: login_project2.php");
            } else{
                echo "Something went wrong. Please try again later.";
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

    <title>Register</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" type = "text/css" href = "style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script type="text/javascript" src = "project.js"></script>
</head>

<body class="w3-container w3-light-blue w3-center">
    <div id = "outer-div">
    <h2>Sign Up</h2>
      <div id = "inner-div" class = "w3-panel w3-border w3-round-xlarge w3-container w3-pale-red" >
        <p>Complete all fields to create an account.</p>
        <form name = "myForm" action="<?php echo $phpScript; ?>" method="post" onSubmit= "return allValidate()" class = "w3-container w3-pale-red">
            <p>
                <label>Username</label>
                <span class="w3-text-red"><?php echo $usernameError; ?></span>
                <input type="text" id = "username" name="username" class="w3-input w3-border" value="<?php echo $username; ?>" >
             </p>    
            <p>
                <label>Password</label>
                <span class="w3-text-red"><?php echo $passwordError; ?></span>
                <input type="password" id = "password"  name="password" class="w3-input w3-border" value="<?php echo $password; ?>">
             </p>
            <p>
                <label>Confirm Password</label>
                <span class="w3-text-red"><?php echo $confirmPassError; ?></span>
                <input type="password" id = "confirmpass"  name="confirm_password" class="w3-input w3-border" value="<?php echo $confirmPass; ?>">
             </p>
            <p>
                
                <input id = "button" class = "w3-btn w3-green" type="submit" value="Submit">
                <input id = "button" class = "w3-btn w3-green" type="reset" value="Clear">
             </p>
            <p style = "text-align: center">Already have an account? <a href="login_project2.php">Login here</a>.</p>
         </form>
        </div>
    </div>    
    
</body>
</html>