<?php

session_start();
require ('../code/sharedfunctions.php');
require ('../code/classes/userinformation.php');
require ('../code/classes/family.php');
require ('../code/classes/wishlistitem.php');
require ('../code/classes/holiday.php');
require ('../code/classes/credentials.php');
require ('../code/classes/userimage.php');

$sessionID = $_SESSION['login_information_id'];
isLoggedIn();
redirect(isLoggedIn());

$familyMemberid = $_GET['familyMemberID'];


//SQL Queries
try {
    
    $lookupLoginInformation = $connection->prepare("SELECT * FROM login_information WHERE login_information_id = :login_information_id");
    $lookupLoginInformation->bindParam(':login_information_id', $familyMemberid, PDO::PARAM_INT);
    $lookupLoginInformation->execute();
    $displayLoginInformation = $lookupLoginInformation->fetchObject('Credential');
    
    
    $lookupUserInformation = $connection->prepare("SELECT * FROM user_information WHERE login_information_id = :login_information_id");
    $lookupUserInformation->bindParam(':login_information_id', $familyMemberid, PDO::PARAM_INT);
    $lookupUserInformation->execute();
    $displayUserInformation = $lookupUserInformation->fetchObject('userInformation');
    
    $lookupFamilyName = $connection->prepare("SELECT * FROM family WHERE family_id = :family_id");
    $lookupFamilyName->bindParam(':family_id', $displayUserInformation->family_id, PDO::PARAM_INT);
    $lookupFamilyName->execute();
    $displayFamilyName = $lookupFamilyName->fetchObject('family');
    
    $lookupUserImageInformation = $connection->prepare("SELECT*FROM user_image WHERE login_information_id = :login_information_id");
    $lookupUserImageInformation->bindParam(':login_information_id', $familyMemberid, PDO::PARAM_INT);
    $lookupUserImageInformation->execute();
    $displayUserImageInformation = $lookupUserImageInformation->fetchObject('userimage');

    $lookupFamilyMembers = $connection->prepare("SELECT*FROM user_information WHERE family_id = :family_id");
    $lookupFamilyMembers->bindParam(':family_id', $displayUserInformation->family_id, PDO::PARAM_INT);
    $lookupFamilyMembers->execute();
    $displayFamilyMemberResults = $lookupFamilyMembers->fetchAll(PDO::FETCH_CLASS, "userinformation");

    $lookupFamilyHolidays = $connection->prepare("SELECT*FROM holiday WHERE family_id = :family_id");
    $lookupFamilyHolidays->bindParam(':family_id', $displayUserInformation->family_id, PDO::PARAM_INT);
    $lookupFamilyHolidays->execute();
    $displayFamilyHolidays= $lookupFamilyHolidays->fetchAll(PDO::FETCH_CLASS, 'holiday');
    
    
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    function displayFamilyName(){
        global $displayUserInformation; 
        echo ("$displayUserInformation->first_name $displayUserInformation->last_name");
    }



    function profileinformation(){
        global $displayUserInformation;
        global $displayFamilyName;
        global $displayLoginInformation;
        echo"
            <tr><th>User Information</th></tr>
            <td>Username: {$displayLoginInformation->username}</td></tr>
            <tr><td>{$displayUserInformation->first_name}</td></tr>
            <tr><td>{$displayUserInformation->last_name}</td></tr>
            <tr><td>{$displayUserInformation->birthday}</td></tr>
            <tr><th>Family Information</th></tr>
            <tr><td>{$displayFamilyName->family_name}</td></tr>
            </table>";
        
    }


$isArray= array("No","Yes");


// Function to display wishlists by family birthdays
function familyWishlistInformation(){
    global $familyMemberid;
    global $isArray;
    global $connection;
    if($_GET["update"] == null){ 
        try{
        $lookupFamilyBirthdaylist = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
        $lookupFamilyBirthdaylist->bindParam(':login_information_id', $familyMemberid, PDO::PARAM_INT);
        $lookupFamilyBirthdaylist->execute();
        $displayFamilyBirthdayList = $lookupFamilyBirthdaylist->fetchAll(PDO::FETCH_CLASS, 'wishlistitem');
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        
        foreach($displayFamilyBirthdayList as $value){
            $wishlistItem1 = new wishlistItem;
            $wishlistItem1 = $value;
            if ($wishlistItem1->already_purchased == false  && $wishlistItem1->birthday_gift == 1)  {
                echo " 
                <tr><td>{$wishlistItem1->item_name}</td>
                <td>{$wishlistItem1->item_description}</td>
                <td><a href='{$wishlistItem1->item_link}' target='_blank'>$wishlistItem1->item_link</a></td>
                <td>{$wishlistItem1->quantity}</td>
                <td>{$wishlistItem1->item_price}</td>
                <td>{$isArray[$wishlistItem1->birthday_gift]}</td>
                <td>{$isArray[$wishlistItem1->holiday_gift]}</td>
                <td>{$isArray[$wishlistItem1->already_purchased]}</td>
                </tr>";
            }

        } 
    
        
        
    }    
    
}


// Function to display purchased wishlist items by family birthdays
function familyPurchasedWishlist(){
    global $isArray;
    global $connection;
    global $familyMemberid;
    if($_GET["update"] == null){
        try{
            $lookupFamilyBirthdaylist = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
            $lookupFamilyBirthdaylist->bindParam(':login_information_id', $familyMemberid, PDO::PARAM_INT);
            $lookupFamilyBirthdaylist->execute();
            $displayFamilyBirthdayList = $lookupFamilyBirthdaylist->fetchAll(PDO::FETCH_CLASS, 'wishlistitem');
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        foreach($displayFamilyBirthdayList as $value){
            $wishlistItem5 = new wishlistItem;
            $wishlistItem5 = $value;
                if ($wishlistItem5 ->already_purchased == 1)  {
                    echo " 
                    <tr><td>{$wishlistItem5->item_name}</td>
                    <td>{$wishlistItem5->item_description}</td>
                    <td><a href='{$wishlistItem5->item_link}' target='_blank'>$wishlistItem5->item_link</a></td>
                    <td>{$wishlistItem5->quantity}</td>
                    <td>{$wishlistItem5->item_price}</td>
                    <td>{$isArray[$wishlistItem5->birthday_gift]}</td>
                    <td>{$isArray[$wishlistItem5->holiday_gift]}</td>
                    <td>{$isArray[$wishlistItem5->already_purchased]}</td>
                    </tr>";
                } 
        }   
    }        
    

    
}




//Function to display family members
function familyMembers(){
    global $displayFamilyMemberResults; 
    global $familyMemberid;   
    foreach($displayFamilyMemberResults as $values){
        $familyMemberInformation = new userInformation();
        $familyMemberInformation = $values;

        if($familyMemberInformation->login_information_id != $familyMemberid)
        echo 
            "<form action='../familymember/familymember.php' method='get'>
            <input type='hidden' name='familyMemberID' value='{$familyMemberInformation->login_information_id}'>
            <td>{$familyMemberInformation->first_name}</td>
            <td>{$familyMemberInformation->last_name}</td>
            <td><input type='submit' value='See their page'></td>
            </tr></form>";
    }
}

//function to display family member birthdays
function familyMembersBirthdays(){
    global $displayFamilyMemberResults;
    global $familyMemberid;     
    foreach($displayFamilyMemberResults as $values){
        $familyMemberBirthday = new userInformation();
        $familyMemberBirthday  = $values;
    if($familyMemberBirthday->login_information_id != $familyMemberid)
    echo
        "<tr><td>{$familyMemberBirthday->birthday}</td>
        <td>{$familyMemberBirthday->first_name}</td>
        <td>{$familyMemberBirthday->last_name}</td>
        <td><a href='../birthdays/birthdays.php'>Link to Birthdays</a></td>";
    } 
}

//Function to display family holidays
function familyHolidays(){
    global $displayFamilyHolidays;
    foreach($displayFamilyHolidays as $values){
        $familyHolidays = new userInformation();
        $familyHolidays  = $values;
    echo"<tr><td>{$familyHolidays->holiday_date}</td>
        <td>{$familyHolidays->holiday_name}</td>
        <td>{$familyHolidays->gift_exchange_type}</td>
        <td><a href='../holidays/holidays.php'>Link to Holidays</a></td></tr>";
    }

}








?>