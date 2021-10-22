<?php
// Staring session
session_start();

//Required code
require 'classes/credentials.php';
require 'sharedfunctions.php';


// Defining variables
$userUsername = $userPassword = $loginError = "";  

// Boolean values to provide code direction
$inputExists = false;
$inputIsValid = false;

    // Exception handling with if/else 
    if( $_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["userName"]) ||empty($_POST["password"]) ) {
            $loginError = "*Your username and password is required";
        }
        else {
            $inputExists = true;
        }
    }

    // Sanitizing input and creating new Credential class
    if ($inputExists) {
        $userUsername= test_form_input($_POST["userName"]);
        $userPassword= test_form_input($_POST["password"]);

        $testCred = new Credential();
        $testCred->createTestCredential($userUsername, $userPassword);
        

        // Lookup user provided information and validate credentials
        try {

            $lookupUsername = $connection->prepare("SELECT * FROM login_information WHERE username = :username");
            $lookupUsername->bindParam(':username', $testCred->username, PDO::PARAM_STR, 32);
            $lookupUsername->execute();
            $doesUsernameExist = $lookupUsername->fetchObject('Credential');
            //$lookupUsername = $connection->query("SELECT * FROM login_information WHERE username = '$testCred->username'")->fetchObject('Credential');

            if( $doesUsernameExist->username == null){
                $loginError = "*Your username was not found";

            }
            elseif(!password_verify($testCred->login_password,$doesUsernameExist->login_password)){
                $loginError = "Your password is incorrect. Please provide the correct password.";
                
            }
            else{
                $inputIsValid = true;
            }
                
            
            // If valid credentials assign session id and login into home
            if($inputIsValid){
                $_SESSION['login_information_id']=$doesUsernameExist->login_information_id;
                header('Location:home/home.php');
                    }
            
            
            
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

?>