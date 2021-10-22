<?php
// Session Start
session_start();

// Required php files
require ('../code/sharedfunctions.php');
require ('../code/classes/userinformation.php');
require ('../code/classes/family.php');
require ('../code/classes/credentials.php');
require ('../code/classes/userimage.php');

// Functions to ensure user is logged in
isLoggedIn();
redirect(isLoggedIn());

// Populating user information and image classes
$displayLoginInformation = new Credential();
$displayUserInformation = new userInformation();
$displayUserImageInformation = new userimage();
$displayFamilyName = new family();

//function to display information
function displayInfo(){
    global 
    $displayLoginInformation, $displayUserInformation, $displayFamilyName,$displayUserImageInformation, $connection, $sessionID;
    try {
        
        $lookupLoginInformation = $connection->prepare("SELECT * FROM login_information WHERE login_information_id = :login_information_id");
        $lookupLoginInformation->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
        $lookupLoginInformation->execute();
        $displayLoginInformation = $lookupLoginInformation->fetchObject('Credential');


        $lookupUserInformation = $connection->prepare("SELECT * FROM user_information WHERE login_information_id = :login_information_id");
        $lookupUserInformation->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
        $lookupUserInformation->execute();
        $displayUserInformation = $lookupUserInformation->fetchObject('userInformation');

        $lookupFamilyName = $connection->prepare("SELECT * FROM family WHERE family_id = :family_id");
        $lookupFamilyName->bindParam(':family_id', $displayUserInformation->family_id, PDO::PARAM_INT);
        $lookupFamilyName->execute();
        $displayFamilyName = $lookupFamilyName->fetchObject('family');

        $lookupUserImageInformation = $connection->prepare("SELECT*FROM user_image WHERE login_information_id = :login_information_id");
        $lookupUserImageInformation->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
        $lookupUserImageInformation->execute();
        $displayUserImageInformation = $lookupUserImageInformation->fetchObject('userimage');

    }

    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

}


// Function to display welcome and username
function welcomeUser(){
    global $displayUserInformation; 
    echo "Welcome, {$displayUserInformation->first_name}!";
}

// Function to display user information
function profileinformation(){
    global $displayUserInformation;
    global $displayFamilyName;
    global $displayLoginInformation;
    if($displayUserInformation->family_id == null){
        echo"
        <tr><th>User Information</th></tr>
        <tr><td>Username: {$displayLoginInformation->username}</td></tr>
        <tr><td>{$displayUserInformation->first_name}</td></tr>
        <tr><td>{$displayUserInformation->last_name}</td></tr>
        <tr><td>{$displayUserInformation->birthday}</td></tr>
        <tr><td><a href='../updateinfo/updateinfo.php'>Update User Information</a></td></tr>
        <tr><th>Family Information</th></tr>
        <tr><td>No Family Yet</td></tr>
        </table>";

    }
    else{
        echo"
        <tr><th>User Information</th></tr>
        <td>Username: {$displayLoginInformation->username}</td></tr>
        <tr><td>{$displayUserInformation->first_name}</td></tr>
        <tr><td>{$displayUserInformation->last_name}</td></tr>
        <tr><td>{$displayUserInformation->birthday}</td></tr>
        <tr><td><a href='../updateinfo/updateinfo.php'>Update User Information</a></tr></td>
        <tr><th>Family Information</th></tr>
        <tr><td>{$displayFamilyName->family_name}</td></tr>
        </table>";
    }
}


// Display Family function
function displayFamily(){
    if($_GET["familySearch"]!=null){
        global $connection;

        $userFamilySearch = test_form_input($_GET["familySearch"]);

        $searchFamily = new family();
        $searchFamily->searchFamily($userFamilySearch);

        try{
            $familyResults = $connection->prepare("SELECT*FROM family WHERE family_name = :family_name");
            $familyResults->bindParam(':family_name', $searchFamily->family_name, PDO::PARAM_STR,50);
            $familyResults->execute();
            $displayFamilyResults = $familyResults->fetchAll(PDO::FETCH_CLASS, "family");

        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        foreach($displayFamilyResults as $value){
            $family1 = new family;
            $family1 = $value;

            $familyMemberResults = $connection->prepare("SELECT*FROM user_information WHERE family_id = :family_id");
            $familyMemberResults->bindParam(':family_id', $family1->family_id, PDO::PARAM_STR,50);
            $familyMemberResults->execute();
            $displayFamilyMemberResults = $familyMemberResults->fetchAll(PDO::FETCH_CLASS, "userinformation");
            
            if($displayFamilyMemberResults == null){
                echo "<form type='hidden' method='get' enctype='application/x-www-form-urlencoded'>
                    <input type='hidden' name='family_id' value={$family1->family_id} /></td> 
                    <tr><td>{$family1->family_id} 
                    <td>{$family1->family_name}</td>
                    <td></td>
                    <td></td>
                    <td><input formaction='home.php' type='submit' value='Join Family'></td> 
                    </tr></form>";
            }
            else{
                foreach($displayFamilyMemberResults as $value){
                    $familyMember1 = new userInformation;
                    $familyMember1 = $value;
                        echo "<form type='hidden' method='get' enctype='application/x-www-form-urlencoded'>
                            <input type='hidden' name='family_id' value={$family1->family_id} /></td> 
                            <tr><td>{$family1->family_id} 
                            <td>{$family1->family_name}</td>
                            <td>{$familyMember1->first_name}</td>
                            <td>{$familyMember1->last_name}</td>
                            <td><input formaction='home.php' type='submit' value='Join Family'></td> 
                            </tr></form>";
                }
            }
        }
    }
}




// Create Family function
function createFamily(){
if( $_GET["familyNameCreate"]!=null){
    global $connection;
    global $sessionID;
    global $refresh;
 

    $userFamilyCreate = test_form_input($_GET["familyNameCreate"]);
    $createFamily = new family();
    $createFamily->searchFamily($userFamilyCreate);

    try{
        $createFamilySQL = $connection->prepare("INSERT INTO family (family_name) VALUES (:family_name)");
        $createFamilySQL->bindParam(':family_name', $createFamily->family_name, PDO::PARAM_STR,50);
        $createFamilySQL->execute();

        $last_id = $connection->lastInsertId();

        $userWithFamily = $connection->prepare("UPDATE user_information SET family_id = :family_id WHERE login_information_id =:login_information_id");
        $userWithFamily->bindParam(':family_id', $last_id, PDO::PARAM_INT);
        $userWithFamily->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
        $userWithFamily->execute();  
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    displayInfo(); 
}

}

// Join family function
function joinFamily(){
    global $connection;
    global $sessionID;
    if( $_GET['family_id'] != null){

        $_SESSION['family_id'] = $_GET["family_id"];

        try{
        $updateUserFamilyID = $connection->prepare("UPDATE user_information SET family_id =:family_id  WHERE login_information_id = :login_information_id"); 
        $updateUserFamilyID->bindParam(':family_id', $_SESSION['family_id'], PDO::PARAM_INT);
        $updateUserFamilyID->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
        $updateUserFamilyID->execute();
        displayInfo();
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        displayInfo(); 
    }
}




?>