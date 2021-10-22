<?php
require ('classes/credentials.php');
require ('classes/userInformation.php');
require ('sharedfunctions.php');


// Defining variables
$userUsername = $userPasswordFinal = $userPasswordTest = "";  
$userFirstName = $userLastName = $userBirthDate= ""; 
$firstNameError = $lastNameError = $birthdayError = $usernameError = $passwordError = $confirmpasswordError ="";
$inputIsValid = false;


// Boolean value to provide code direction
$inputExists = false;
$inputIsValid = false;

// Regex Expressions to valid birthdate and password requirements
$dateRequirements = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
$passwordRequirements = "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/";  



    // Exception handling with if/else 
    if( $_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($_POST["firstName"])) {
            $firstNameError = "Your first name is required.";
        }
        elseif (empty($_POST["lastName"]) ) {
            $lastNameError = "Your last name is required.";
        } 
        elseif (empty($_POST["birthday"]) || !preg_match($dateRequirements , $_POST["birthday"]))  {
            $birthdayError = 'Your birthday is required and must be in the correct format "mm/dd/yyyy"';
        }
        elseif (empty($_POST["userName"]) ) {
            $usernameError = "A username is required";
        }
        elseif (empty($_POST["passwordTest"]) ) {
            $passwordError = "A password is required";
        }
        elseif (empty($_POST["passwordFinal"]) ) {
            $confirmpasswordError = "A password is required";
        }
        elseif($_POST["passwordTest"] != $_POST["passwordFinal"]){
            $confirmpasswordError ="Your passwords do not match.";
        }
        elseif(!preg_match($passwordRequirements, $_POST["passwordFinal"])){
            $confirmpasswordError ="Your password does not meet the requirements.";

        }
        else {
            $inputExists = true;
        }

        // Creating new Credential and userInformation class with sanitized user input
        if ($inputExists) {
            $userFirstName = test_form_input($_POST["firstName"]);
            $userLastName = test_form_input($_POST["lastName"]);
            $userBirthDate = test_form_input($_POST["birthday"]);
            $userUsername= test_form_input($_POST["userName"]);
            $userPasswordTest= test_form_input($_POST["passwordTest"]);
            $userPasswordFinal= test_form_input($_POST["passwordFinal"]);
            $userHashPassword = password_hash($userPasswordFinal, PASSWORD_BCRYPT);
            
            $newCred = new Credential();
            $newUser = new userInformation();

            $newCred->createTestCredential($userUsername,$userHashPassword);
            $newUser->createTestUser($userFirstName, $userLastName, $userBirthDate);


            // Confirming that username requested does not already exist
            
            try {
                $confirmUsername = $connection->prepare("SELECT * FROM login_information WHERE username = :username");
                $confirmUsername->bindParam(':username', $newCred->username, PDO::PARAM_STR, 32);
                $confirmUsername->execute();
                $doesUsernameExist= $confirmUsername->fetchObject('Credential');
                if ($doesUsernameExist->username != null){
                    $usernameError = "This username is already in use. Please create a new username";
                }
                else{
                    $inputIsValid = true;
                }
                }
    
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }



             // Creating new user in database
            if($inputIsValid) 
                try {
                    $loginInfoInsert = $connection->prepare("INSERT INTO login_information (username, login_password) VALUES (:username, :login_password)");
                    $loginInfoInsert->bindParam(':username', $newCred->username, PDO::PARAM_STR, 32);
                    $loginInfoInsert->bindParam(':login_password', $newCred->login_password, PDO::PARAM_STR, 60);
                    $loginInfoInsert->execute();
                    $last_id = $connection->lastInsertId();
                    $userInfoInsert = $connection->prepare("INSERT INTO user_information (login_information_id, first_name, last_name, birthday ) VALUES (:last_id, :first_name, :last_name, :birthday)");
                    $userInfoInsert->bindParam(':last_id', $last_id, PDO::PARAM_INT);
                    $userInfoInsert->bindParam(':first_name', $newUser->first_name, PDO::PARAM_STR,50);
                    $userInfoInsert->bindParam(':last_name', $newUser->last_name, PDO::PARAM_STR,50);
                    $userInfoInsert->bindParam(':birthday', $newUser->birthday, PDO::PARAM_STR);
                    $userInfoInsert->execute();
                    header('Location: ../login.php');
                }

                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }



        }



    }

   

?>