<?php

declare(strict_types = 1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

function sanitizeInput($value) {
    return htmlspecialchars( stripslashes( trim( $value) ) );
}

session_start();

require_once "inc.db_project2.php";

$colorVal = $param_id = $param_color = "";
$phpScript = sanitizeInput($_SERVER['PHP_SELF']);
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login_project2.php");
    exit;
}

$username = "{$_SESSION['username']}";

$sql = "SELECT id FROM Project.User WHERE username = '$username'";

$stmt = $pdo->query($sql, PDO::FETCH_ASSOC);
$record = $stmt->fetch();
$id = $record['id'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    $colorVals = $_POST['colors'];
    $values = array();
    
    foreach ($colorVals as $colorVal) {
    $values[] = " ('{$id}', '{$colorVal}') " ;  
    }

    $values = implode(",", $values);
    $sql = "INSERT INTO Project.FavColor (user\$id, favColor) VALUES {$values}";
         
        if($stmt = $pdo->prepare($sql)){
            if($stmt->execute()){
                echo "Color choice(s) selected!". "     ";
            } else{
                echo "Oops, try again later.";
            }
            unset($stmt);
        }


    $movieVals = $_POST['genres'];
    $values2 = array();

    foreach($movieVals as $movieVal) {
    $values2[] = " ('{$id}', '{$movieVal}') " ;
    }

    $values2 = implode(",", $values2);
    
    $sql = "INSERT INTO Project.FavMovieGenre (user\$id, favMovieGenre) VALUES {$values2}";

    if($stmt = $pdo->prepare($sql)){
        if($stmt->execute()){
            echo "Genre choice(s) selected! Please press 'View Records' to see your choices";
        } else{
            echo "Oops, try again later";
        }
        unset($stmt);
    }
}

?>
 
<!DOCTYPE html>
<html lang="en">
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
    <title>Welcome</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script type="text/javascript" src = "project.js"></script>
</head>
<body class="w3-container w3-light-blue">
<div id="outer-div" >
    <div id = "inner-div" class = "w3-panel w3-border w3-round-xlarge w3-container w3-pale-red">
        <h1 style = "text-align:center">Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h1>
        <h4>First, lets personalize your recommendations.</h4>
        <h2> Tell us a bit about yourself.... </h2>
        <h5> (Hold down ctrl and click one or more selections) </h5>
        <h3> What is your favorite color? </h3>
        <form action="<?php echo $phpScript; ?>" method="post" class = "w3-container">
        <label for="colors">Choose a color:</label>

               <select required name="colors[]" id="colors" multiple size = '10'>
                <option value="Red">Red</option>
                <option value="Pink">Pink</option>
                <option value="Orange">Orange</option>
                <option value="Yellow">Yellow</option>
                <option value="Green">Green</option>
                <option value="Blue">Blue</option>
                <option value="Purple">Purple</option>
                <option value="Brown">Brown</option>
                <option value="Black">Black</option>
                <option value="Other">Other</option>
               </select>

        <h3 > What is your favorite movie genre? </h3> 
        <label for="genres">Choose a genre:</label>

               <select required name="genres[]" id="genres" multiple size = '10'>
                <option value="Comedy">Comedy</option>
                <option value="Horror">Horror</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Sci-fi">Sci-fi</option>
                <option value="Thriller">Thriller</option>
                <option value="Action">Action</option>
                <option value="Romance">Romance</option>
                <option value="Mystery">Mystery</option>
                <option value="Drama">Drama</option>
                <option value="Western">Western</option>
              </select>
            <div>
              <input type="submit" value = "Submit" class = "w3-button w3-green">
              <a href = "view_records_project2.php"></button>View Records</a>
              <a href = "update_record_project2.php"></button>Update Choices<a>
            </div>
        </div>
    </div>
      <p style = "text-align:center">
        
        <a href="reset_project2.php"></button>Reset Your Password</a>
        <a href="logout_project2.php"></button>Sign Out of Your Account</a>
        <a href ="delete_project2.php"></button> Delete Account</a>
        <img style="display:none;" id="motivation" src="motivation" />
        <button onclick="showPicture()" class = "w3-button w3-green" >Click for motivation! (then scroll down)</button>
      </p>
</form>
</body>
</html>