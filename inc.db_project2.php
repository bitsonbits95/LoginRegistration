<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

declare(strict_types = 1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

const HOST = 'localhost';
const USER = 'root';
const PWD = 'root';
//const DB = 'school';
// Set up the DSN (Data Source Name) for mysql
const DSN = 'mysql:host=' . HOST;

function getPDO(): PDO {
    return new PDO('mysql:host=localhost;dbname=Project', 'root', 'root');
}

function createDB(string $db) {
    // We will establish a connection to the server and create
    // the database first.
    $pdo = new PDO(DSN, USER, PWD);
    $sql = "CREATE DATABASE IF NOT EXISTS $db";
    $status = $pdo->exec($sql) or die('Server error.');
    $pdo = null;
    // echo "DB create status: $status<br>";
}

function createUserTable(PDO $pdo) {
    $sql = "
    CREATE TABLE IF NOT EXISTS Project.User (
        id INT UNSIGNED AUTO_INCREMENT NOT NULL,
        username VARCHAR(50) NOT NULL,
        password TEXT(225) NOT NULL,
        PRIMARY KEY(id)
    );";
    $status = $pdo->exec($sql);
    // echo "User table create status: $status<br>";
}

function createFavColorTable(PDO $pdo) {
    $sql = "
    Create TABLE IF NOT EXISTS Project.FavColor (
        user\$id INT UNSIGNED NOT NULL,
        favColor TEXT(15) NOT NULL,
        FOREIGN KEY(user\$id) REFERENCES Project.User(id)
        
    );";
    $status = $pdo->exec($sql);
    // echo "FavColor table create status: $status<br>";
}

function createFaveMovieGenreTable(PDO $pdo) {
    $sql = "
    CREATE TABLE IF NOT EXISTS Project.FavMovieGenre (
        user\$id INT UNSIGNED NOT NULL,
        favMovieGenre TEXT(15) NOT NULL,
        FOREIGN KEY(user\$id) REFERENCES Project.User(id)
);";
    $status = $pdo->exec($sql);
    // echo "FavColor table create status: $status<br>";
}

try{

    $db = 'Project';
    createDB($db);

    $pdo = getPDO();
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    createUserTable($pdo);
    createFavColorTable($pdo);
    createFaveMovieGenreTable($pdo);

} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>