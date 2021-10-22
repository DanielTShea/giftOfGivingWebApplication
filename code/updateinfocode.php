<?php
session_start();

//Required classes and functions
require ('classes/credentials.php');
require ('classes/userInformation.php');
require ('sharedfunctions.php');
require ('classes/userimage.php');


// Defining variables
$userUsername = $userPasswordUpdate = $userPasswordFinal = $userPasswordTest = "";  
$userFirstName = $userLastName = $userBirthDate= ""; 
$firstNameError = $lastNameError = $birthdayError = $usernameError = $passwordError = $passwordConfirmError = $confirmpasswordError = $currentpasswordError="";
$imageError = "";
$inputIsValid = false;

// Regex Expressions to valid birthdate and password requirements
$dateRequirements = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
$passwordRequirements = "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/";  

// Populating user information and image classes
$displayLoginInformation = new Credential();
$displayUserInformation = new userInformation();


// Displaying user information for update 
function displayInfo(){
    global 
    $displayLoginInformation, $displayUserInformation, $connection, $sessionID;
    
    
try {
    $lookupLoginInformation = $connection->prepare("SELECT * FROM login_information WHERE login_information_id = :login_information_id");
        $lookupLoginInformation->bindParam(':login_information_id', $sessionID , PDO::PARAM_INT);
        $lookupLoginInformation->execute();
        $displayLoginInformation = $lookupLoginInformation->fetchObject('Credential');


    $lookupUserInformation = $connection->prepare("SELECT*FROM user_information  WHERE login_information_id = :login_information_id");
        $lookupUserInformation->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
        $lookupUserInformation->execute();
        $displayUserInformation = $lookupUserInformation->fetchObject('userInformation');
   
    }
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }
}  
   



// function to upload new userimage to database
function userImageUpdate(){
    if($_FILES['userImage'] !=null){
        $imageExists = false;
        global $connection;
        global $sessionID;
        global $imageError;

        if(!file_exists($_FILES['userImage']['tmp_name'])){

            $imageError = "A image must be uploaded to update your user image.";

        }
        else{
            $imageExists = true;
        }

        if($imageExists){

            // Pulling uploaded image information
            try{
                $fileName = $_FILES['userImage']['name'];
                $size = $_FILES['userImage']['size'];
                $type = $_FILES['userImage']['type'];
                $tmpPath = $_FILES['userImage']['tmp_name'];


                if(!file_exists($tmpPath)){
                throw new \Exception("$filename not at temp location");
                }


                $handler = fopen($tmpPath, 'rb');
                $data = addslashes(fread($handler, $size));
                fclose($handler);
            }
            catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
            }


            // Creating userimage class with user input
            $userImageInput = new userimage();
            $userImageInput->createUserImage($sessionID, $fileName, $type, $data);


            //Lookup user image information
            try {
                $lookupUserImageInformation = $connection->prepare("SELECT*FROM user_image WHERE login_information_id = :login_information_id");
                $lookupUserImageInformation->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
                $lookupUserImageInformation->execute();
                $displayUserImageInformation = $lookupUserImageInformation->fetchObject('userimage');
            }
            catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            // Inserting or updating current user image
            if($displayUserImageInformation->login_information_id == null){
                try {
                    // Insert Image if first image
                    $insertUserImage = "INSERT INTO user_image (login_information_id, image_file_name, mime_type, user_image) VALUES('$sessionID', '$fileName', '$type', '$data' )";
                    $connection->query($insertUserImage);

                    // $updateUserImage = $connection->prepare("UPDATE user_image SET image_file_name = :image_file_name, mime_type = :mime_type , user_image =:user_image WHERE login_information_id = login_information_id");
                    // $updateUserImage->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
                    // $updateUserImage->bindParam(':image_file_name', $userImageInput->image_file_name, PDO::PARAM_STR);
                    // $updateUserImage->bindParam(':mime_type', $userImageInput->mime_type, PDO::PARAM_STR);
                    // $updateUserImage->bindParam(':user_image', $handler , PDO::PARAM_LOB);
                    // $updateUserImage->execute();
                }
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
            }
            else{
                try {
                    // Replace image if already exists
                    $updateUserImage = "UPDATE user_image SET image_file_name = '$fileName', mime_type = '$type' , user_image ='$data' WHERE login_information_id = '$sessionID'";
                    $connection->query($updateUserImage);

                    // $insertUserImage = $connection->prepare("INSERT INTO user_image (login_information_id, image_file_name, mime_type, user_image) VALUES(:login_information_id, :image_file_name, :mime_type , :user_image )");
                    // $insertUserImage->bindParam(':login_information_id', $userImageInput->login_information_id, PDO::PARAM_INT);
                    // $insertUserImage->bindParam(':image_file_name', $userImageInput->image_file_name, PDO::PARAM_STR);
                    // $insertUserImage->bindParam(':mime_type', $userImageInput->mime_type, PDO::PARAM_STR);
                    // $insertUserImage->bindParam(':user_image', $handler , PDO::PARAM_LOB);
                    // $insertUserImage->execute();

                }
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }

            }          
        }
    }
}








   
function updateUserInfo(){
    // Boolean value to provide code direction
    $inputExists = false;
    $inputIsValid = false;

    // Global variables
    global 
    $userUsername, $userFirstName, $userLastName, $userBirthDate, $userPasswordUpdate, 
    $firstNameError, $lastNameError, $birthdayError, $usernameError, $passwordConfirmError,  
    $dateRequirements, $connection,$sessionID;

    // Exception handling with if/else 
    if( $_POST["updateInformation"] == 1) {
        
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
        elseif (empty($_POST["passwordConfirm"]) ) {
                        $passwordConfirmError = "A password is required";
                    }
        else {
            $inputExists = true;
        }

        // Creating new Credential and userInformation class with sanitized user input
        if ($inputExists) {
            $userUsername = test_form_input($_POST["userName"]);
            $userFirstName = test_form_input($_POST["firstName"]);
            $userLastName = test_form_input($_POST["lastName"]);
            $userBirthDate = test_form_input($_POST["birthday"]);
            $userPasswordUpdate = "Poop123707";//test_form_input($_POST["passwordConfirm"]);
            
            $newCred = new Credential();
            $newUser = new userInformation();

            $newCred->createTestCredential($userUsername, $userPasswordUpdate);
            $newUser->updateUser($userFirstName, $userLastName, $userBirthDate);
        
        


            // Confirming that username requested does not already exist and password matches
            try {
                $confirmUsername = $connection->prepare("SELECT * FROM login_information WHERE login_information_id = :login_information_id");
                $confirmUsername->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
                $confirmUsername->execute();
                $doesUsernameExist= $confirmUsername->fetchObject('Credential');

                $confirmNewUsername = $connection->prepare("SELECT * FROM login_information WHERE username = :username");
                $confirmNewUsername->bindParam(':username', $newCred->username, PDO::PARAM_STR, 32);
                $confirmNewUsername->execute();
                $doesNewUsernameExist= $confirmNewUsername->fetchObject('Credential');
                
                if($doesUsernameExist->username != $newCred->username && $doesNewUsernameExist->username != null){
                    $usernameError = "This username is already in use. Please create a new username";
                }
                elseif(!password_verify($newCred->login_password,$doesUsernameExist->login_password)){
                    $passwordConfirmError = "Your password is incorrect. Please provide the correct password.";   
                }
                else{
                    $inputIsValid = true;
                }
                }
    
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }



             // Updating information in database
            if($inputIsValid) 
            try {
                $loginInfoInsert = $connection->prepare("UPDATE login_information SET username = :username WHERE login_information_id = :login_information_id");
                $loginInfoInsert->bindParam(':username', $newCred->username, PDO::PARAM_STR, 32);
                $loginInfoInsert->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
                $loginInfoInsert->execute();
                $userInfoInsert = $connection->prepare("UPDATE user_information SET first_name = :first_name, last_name = :last_name, birthday = :birthday WHERE login_information_id = :login_information_id");
                $userInfoInsert->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
                $userInfoInsert->bindParam(':first_name', $newUser->first_name, PDO::PARAM_STR,50);
                $userInfoInsert->bindParam(':last_name', $newUser->last_name, PDO::PARAM_STR,50);
                $userInfoInsert->bindParam(':birthday', $newUser->birthday, PDO::PARAM_STR);
                $userInfoInsert->execute();
                echo ("<script>alert('User Information Update');</script>");
            }

            catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            displayInfo();

        }



    }

}




function updatePasswrod(){
    // Boolean value to provide code direction
    $inputExists = false;
    $inputIsValid = false;

    // Global variables
    global   
    $sessionID, $passwordError, $confirmpasswordError, $passwordRequirements, $currentpasswordError,
    $connection;

    // Exception handling with if/else 
    if( $_POST["updatePassword"] == 1) {
        
        if(empty($_POST["passwordCurrent"]) ) {
            $currentpasswordError = "Your current password is required";
        }
        elseif (empty($_POST["passwordTest"]) ) {
            $passwordError = "A new password is required";
        }
        elseif (empty($_POST["passwordFinal"]) ) {
            $confirmpasswordError = "A new password is required";
        }
        elseif($_POST["passwordTest"] != $_POST["passwordFinal"]){
            $confirmpasswordError ="Your new passwords do not match.";
        }
        elseif(!preg_match($passwordRequirements, $_POST["passwordFinal"])){
            $confirmpasswordError ="Your password does not meet the requirements.";

        }
        else {
            $inputExists = true;
        }

        // Creating new Credential and userInformation class with sanitized user input
        if ($inputExists) {
            $userCurrentPassword = test_form_input($_POST["passwordCurrent"]);
            $userPasswordFinal= test_form_input($_POST["passwordFinal"]);
            $userHashPassword = password_hash($userPasswordFinal, PASSWORD_BCRYPT);
            
            $currPass = new Credential();
            $newPass = new Credential();

            
            $currPass->updatePassword($userCurrentPassword);
            $newPass->updatePassword($userHashPassword);

            // Confirming that username requested does not already exist
            
            try {
                $confirmPassword = $connection->prepare("SELECT * FROM login_information WHERE login_information_id = :login_information_id ");
                $confirmPassword->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
                $confirmPassword->execute();
                $doesPasswordExist= $confirmPassword->fetchObject('Credential');
                if (!password_verify($currPass->login_password,$doesPasswordExist->login_password)){
                    $currentpasswordError = "Your password is incorrect. Please provide the correct password.";   
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
                $loginInfoInsert = $connection->prepare("UPDATE login_information SET login_password = :login_password WHERE login_information_id = :login_information_id");
                $loginInfoInsert->bindParam(':login_password', $newPass->login_password, PDO::PARAM_STR, 60);
                $loginInfoInsert->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
                $loginInfoInsert->execute();
                echo ("<script>alert('User Password Updated');</script>");
            }

            catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            

        }

    displayInfo();

    }

}
 


   

?>