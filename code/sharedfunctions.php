<?php
error_reporting(E_ERROR | E_PARSE);

// Get connection to database
$serverName = "localhost";
$username = "root";
$connection = new PDO("mysql:host=$serverName;dbname=giftOfGivingdb", $username);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Function to verify login credentials
function isLoggedIn(): bool {
    return isset($_SESSION['login_information_id']);
}

function redirect(bool $isLoggedIn) {
    global $hello;
    if(!isLoggedIn()){
        header('Location:../login.php');
    }

    
}

// Global variables
$sessionID = $_SESSION['login_information_id'];

// Global arrays
$isArray= array("No","Yes");


// Function to confirm form security
function test_form_input($input){
    $input = trim($input);
    $input = strip_tags($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}



?>