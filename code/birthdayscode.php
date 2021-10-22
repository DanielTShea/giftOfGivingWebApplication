<?php 
// Session start
session_start();

// Required PHP files and classes
require ('../code/sharedfunctions.php');
require ('../code/classes/userinformation.php');
require ('../code/classes/family.php');
require ('../code/classes/wishlistitem.php');
require ('../code/classes/holiday.php');


// Functions to confirm login
isLoggedIn();
redirect(isLoggedIn());


// mySql queries
try{
    $lookupUserInformation = $connection->prepare("SELECT * FROM user_information WHERE login_information_id = :login_information_id");
    $lookupUserInformation->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
    $lookupUserInformation->execute();
    $displayUserInformation = $lookupUserInformation->fetchObject('userInformation');

    $lookupWishList = $connection->prepare("SELECT*FROM wishlist WHERE login_information_id = :login_information_id");
    $lookupWishList->bindParam(':login_information_id', $sessionID, PDO::PARAM_INT);
    $lookupWishList->execute();
    $displayWishListResults = $lookupWishList->fetchAll(PDO::FETCH_CLASS, "wishlistitem");
    
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




// Function to display wishlists by family birthdays
function familyWishlistInformation(){
    global $sessionID;
    global $isArray;
    global $connection;
    global $displayFamilyMemberResults;
    if($_POST["update"] == null){
        foreach($displayFamilyMemberResults as $value){
            $familymember1 = new userinformation();
            $familymember1 = $value;

            if($familymember1->login_information_id != $sessionID){

                echo "<tr><td class='familyRow' colspan='9'>{$familymember1->first_name} {$familymember1->last_name}:{$familymember1->birthday}</td> </tr>";
                
                try{
                $lookupFamilyBirthdaylist = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
                $lookupFamilyBirthdaylist->bindParam(':login_information_id', $familymember1->login_information_id, PDO::PARAM_INT);
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
                        <td>
                        <form method='post'>
                        <input type='hidden' name='update' value='{$wishlistItem1->wishlist_id}'>
                        <input type='submit' formaction='birthdays.php' value='Update'>
                        </form>
                        </td>
                        </tr>";
                   }

                } 
            }
        }
        
    }    
    
}


// Function to display purchased wishlist items by family birthdays
function familyPurchasedWishlist(){
    global $isArray;
    global $connection;
    global $displayFamilyMemberResults;
    global $sessionID;
    if($_POST["update"] == null){
        foreach($displayFamilyMemberResults as $value){
            $familymember1 = new userinformation();
            $familymember1 = $value;

            if($familymember1->login_information_id != $sessionID){

                echo "<tr><td class='familyRow' colspan='9'>{$familymember1->first_name} {$familymember1->last_name}:{$familymember1->birthday}</td> </tr>";
                try{
                    $lookupFamilyBirthdaylist = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
                    $lookupFamilyBirthdaylist->bindParam(':login_information_id', $familymember1->login_information_id, PDO::PARAM_INT);
                    $lookupFamilyBirthdaylist->execute();
                    $displayFamilyBirthdayList = $lookupFamilyBirthdaylist->fetchAll(PDO::FETCH_CLASS, 'wishlistitem');
                }
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                
                foreach($displayFamilyBirthdayList as $value){
                    $wishlistItem5 = new wishlistItem;
                    $wishlistItem5 = $value;
                        if ($wishlistItem5 ->already_purchased == 1 && $wishlistItem5->birthday_gift == 1)  {
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
    }

    
}


// Function to provide check value to checkbox display
function isChecked($value){
    if($value){
        return 'checked';
    }
    else{
        return ''; 
    }
}

// Function to display update table for wishlist item
function updateWishlistItem(){
    if ($_POST["update"] != null){
        global $sessionID;
        global $connection;
        global $displayFamilyMemberResults;
        foreach($displayFamilyMemberResults as $value){
            $familymember1 = new userinformation();
            $familymember1 = $value;

            if($familymember1->login_information_id != $sessionID){

                echo "<tr><td class='familyRow' colspan='9'>{$familymember1->first_name} {$familymember1->last_name}:{$familymember1->birthday}</td> </tr>";
                try{
                    $lookupFamilyBirthdaylist = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
                    $lookupFamilyBirthdaylist->bindParam(':login_information_id', $familymember1->login_information_id, PDO::PARAM_INT);
                    $lookupFamilyBirthdaylist->execute();
                    $displayFamilyBirthdayList = $lookupFamilyBirthdaylist->fetchAll(PDO::FETCH_CLASS, 'wishlistitem');
                }
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                
                foreach($displayFamilyBirthdayList as $value){
                    $wishlistItem3 = new wishlistItem;
                    $wishlistItem3= $value;
                    if ($wishlistItem3->already_purchased == false && $wishlistItem3->wishlist_id == $_POST["update"]) {
                        $isBirthday = isChecked($wishlistItem3->birthday_gift);
                        $isHoliday = isChecked($wishlistItem3->holiday_gift);
                        echo"<form method='get' action='birthdays.php'>
                            <input type='hidden' name='updateWishlistID' value='{$wishlistItem3->wishlist_id}'>
                            <tr><td><input type='text' class='wishListItemAdd' name='updateItemName' size='10' maxlength='255' value='{$wishlistItem3->item_name}' readonly></td>
                            <td><input type='text' class='wishListItemAdd' name='updateItemDescription' size='10' maxlength='255' value='{$wishlistItem3->item_description}' readonly></td>
                            <td><input type='text' class='wishListItemAdd' name='updateItemLink' size='10' maxlength='255' value='{$wishlistItem3->item_link}' readonly></td>
                            <td><input type='text' class='wishListItemAdd' name='updateItemQuantity' size='5' maxlength='20' value='{$wishlistItem3->quantity}' readonly></td>
                            <td><input type='text' class='wishListItemAdd' name='updateItemPrice' size='5' maxlength='20' value='{$wishlistItem3->item_price}' readonly></td>
                            <td><input type='checkbox' class='wishListItemAdd' name='updateBirthdayGift' value='true' checked disabled {$isBirthday}></td>
                            <td><input type='checkbox' class='wishListItemAdd' name='updateHolidayGift' value='true' checked disabled {$isHoliday}></td>
                            <td><input type='checkbox' class='wishListItemAdd' name='updateAlreadyPurchased' value='true'></td>
                            <td><input type='submit'  value='Update'></td></tr>
                            </form>";
                    }
                    elseif ($wishlistItem3->already_purchased == false){
                            echo "  
                            <tr><td>{$wishlistItem3->item_name}</td>
                            <td>{$wishlistItem3->item_description}</td>
                            <td><a href='{$wishlistItem3->item_link}' target='_blank'>$wishlistItem3->item_link</a></td>
                            <td>{$wishlistItem3->quantity}</td>
                            <td>{$wishlistItem3->item_price}</td>
                            <td>{$wishlistItem3->birthday_gift}</td>
                            <td>{$wishlistItem3->holiday_gift}</td>
                            <td>{$wishlistItem3->already_purchased}</td>
                            <td>
                            </td></tr>
                            </form>";
                        }
                }    
            }
        }
    }  
}


//Update confirm function
function updateConfirm(){
    if($_GET["updateWishlistID"] != null){
        global $connection;
        
        $updatedWishlistItemID = test_form_input($_GET["updateWishlistID"]);
        $updateitemAlreadyPurchased = test_form_input($_GET["updateAlreadyPurchased"]);
        
        $updateFamilyWishlistItem = new wishlistItem;
        $updateFamilyWishlistItem->updateFamilyWishlist($updatedWishlistItemID, $updateitemAlreadyPurchased);

    
        try{
            $updateFamilyWishlistItemSQL = $connection->prepare("UPDATE wishlist SET already_purchased = :already_purchased WHERE wishlist_id = :wishlist_id ");
            $updateFamilyWishlistItemSQL->bindParam(':already_purchased', $updateFamilyWishlistItem->already_purchased, PDO::PARAM_BOOL);
            $updateFamilyWishlistItemSQL->bindParam(':wishlist_id', $updateFamilyWishlistItem->wishlist_id, PDO::PARAM_INT);
            $updateFamilyWishlistItemSQL->execute();
            echo ("<script>alert('wishlist item updated');</script>");
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        header('Location: birthdays.php');
    }
    

}



// Function to display family members
function familyMembers(){
    global $displayFamilyMemberResults; 
    global $sessionID;   
    foreach($displayFamilyMemberResults as $values){
        $familyMemberInformation = new userInformation();
        $familyMemberInformation = $values;

        if($familyMemberInformation->login_information_id != $sessionID)
        echo 
            "<form action='../familymember/familymember.php' method='get'>
            <input type='hidden' name='familyMemberID' value='{$familyMemberInformation->login_information_id}'>
            <td>{$familyMemberInformation->first_name}</td>
            <td>{$familyMemberInformation->last_name}</td>
            <td><input type='submit' value='See their page'></td>
            </tr></form>";
    }
}


// Function to display family Holidays
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

