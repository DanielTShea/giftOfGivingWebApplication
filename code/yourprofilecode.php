<?php
session_start();


//Required functions and classes
require ('../code/sharedfunctions.php');
require ('../code/classes/userinformation.php');
require ('../code/classes/family.php');
require ('../code/classes/wishlistitem.php');
require ('../code/classes/holiday.php');


// Is logged in functions
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


// Function to display wishlist information
function wishlistInformation(){
    global $displayWishListResults;
    global $isArray;
    if($_POST["update"] == null){
        foreach($displayWishListResults as $value){
            $wishlistItem1 = new wishlistItem;
            $wishlistItem1 = $value;
            if ($wishlistItem1->already_purchased == false)  {
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
                <input type='submit' formaction='yourprofile.php' value='Update'>
                </form>
                <form class='deleteForm' method='post'>
                <input type='hidden' name='delete' value='{$wishlistItem1->wishlist_id}'>
                <input type='submit' class='deleteButton' formaction='yourprofile.php' value='Delete'>
                </td></tr>
                </form>";
            }
        }
        
        echo "
                <form method='get' action='yourprofile.php'>
                <input type='hidden' name='add' value='1'>
                <tr><td><input type='text' class='wishListItemAdd' name='itemName' size='10' maxlength='255'></td>
                <td><input type='text' class='wishListItemAdd' name='itemDescription' size='10' maxlength='255'></td>
                <td><input type='text' class='wishListItemAdd' name='itemLink' size='10' maxlength='255'></td>
                <td><input type='text' class='wishListItemAdd' name='itemQuantity' size='5' maxlength='20'></td>
                <td><input type='text' class='wishListItemAdd' name='itemPrice' size='5' maxlength='20'></td>
                <td><input type='checkbox' class='wishListItemAdd' name='birthdayGift' value='true'></td>
                <td><input type='checkbox' class='wishListItemAdd' name='holidayGift' value='true'></td>
                <td><input type='checkbox' class='wishListItemAdd' name='alreadyPurchased' value='true'></td>
                <td><input type='submit' value='Add'></td></tr>
                </form>";
    }    
    
}


// Function to display purchased wishlist
function purchasedWishlist(){
    global $displayWishListResults;
    global $isArray;
    foreach($displayWishListResults as $value){
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
            </tr>"
            ;
        }
    }

    
}




// Function to add wishlist item
function addWishlistItem(){
    if ($_GET["add"] == '1'){
        global $connection;
        global $sessionID;
        global $error;

        $wishlistItemExists = false;

        if (empty($_GET["itemName"])) {
            echo "<script language='javascript'>";
            echo("alert('Item Name is required to add item to wishlist');");
            echo "</script>";
        }
        elseif (empty($_GET["itemDescription"]) ) {
           echo("<script>alert('Item Description is required to add item to wishlist');</script>");
        } 
        elseif (empty($_GET["itemLink"]))  {
            echo("<script>alert('Item Link is required to add item to wishlist');</script>");
        }
        elseif (!empty($_GET["itemQuantity"]) && !is_numeric($_GET["itemQuantity"]) ) {
            echo("<script>alert('Item quantity must be a number');</script>");
        }
        elseif (!empty($_GET["itemPrice"]) && !is_numeric($_GET["itemPrice"]) ) {
            echo("<script>alert('Item price must be a number');</script>");
        }
        elseif(empty($_GET["birthdayGift"]) && empty($_GET["birthdayGift"])) {
            echo("<script>alert('A wishlist item has to be for a birthday or holiday. Please select one');</script>");

        }
        else {
            $wishlistItemExists = true;
        }
        
        if($wishlistItemExists){
            $newitemLoginID = $sessionID;
            $newitemName = test_form_input($_GET["itemName"]);
            $newitemDescription = test_form_input($_GET["itemDescription"]);
            $newitemLink = test_form_input($_GET["itemLink"]);
            $newitemQuantity = test_form_input($_GET["itemQuantity"]);
            $newitemPrice = test_form_input($_GET["itemPrice"]);
            $newitemBirthdayGift = test_form_input($_GET["birthdayGift"]);
            $newitemHolidayGift = test_form_input($_GET["holidayGift"]);
            $newitemAlreadyPurchased = test_form_input($_GET["alreadyPurchased"]);
            
            $newWishlistItem = new wishlistItem;
            $newWishlistItem->addWishlistItemClass(
            $newitemLoginID,
            $newitemName, 
            $newitemDescription, 
            $newitemLink, 
            $newitemQuantity, 
            $newitemPrice, 
            $newitemBirthdayGift, 
            $newitemHolidayGift, 
            $newitemAlreadyPurchased);


            $addWishlistItemSQL =$connection->prepare("INSERT INTO wishlist (login_information_id, item_name, item_description, item_link, quantity, item_price, birthday_gift, holiday_gift, already_purchased) 
            VALUES(:login_information_id, :item_name, :item_description, :item_link, :quantity, :item_price, :birthday_gift, :holiday_gift, :already_purchased)");
            $addWishlistItemSQL->bindParam(':login_information_id', $newWishlistItem->login_information_id, PDO::PARAM_INT);
            $addWishlistItemSQL->bindParam(':item_name', $newWishlistItem->item_name, PDO::PARAM_STR, 255);
            $addWishlistItemSQL->bindParam(':item_description', $newWishlistItem->item_description, PDO::PARAM_STR, 255);
            $addWishlistItemSQL->bindParam(':item_link', $newWishlistItem->item_link, PDO::PARAM_STR, 255);
            $addWishlistItemSQL->bindParam(':quantity', $newWishlistItem->quantity);
            $addWishlistItemSQL->bindParam(':item_price', $newWishlistItem->item_price);
            $addWishlistItemSQL->bindParam(':birthday_gift', $newWishlistItem->birthday_gift, PDO::PARAM_BOOL);
            $addWishlistItemSQL->bindParam(':holiday_gift', $newWishlistItem->holiday_gift, PDO::PARAM_BOOL);
            $addWishlistItemSQL->bindParam(':already_purchased', $newWishlistItem->already_purchased, PDO::PARAM_BOOL);
            $addWishlistItemSQL->execute();
            echo ("<script>alert('wishlist item added');</script>");
            header('Location: yourprofile.php');
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



//Function to display updated wishlist item as table
function updateWishlistItem(){
    if ($_POST["update"] != null){
        global $displayWishListResults;
        foreach($displayWishListResults as $value){
            $wishlistItem3 = new wishlistItem;
            $wishlistItem3 = $value;
                if ($wishlistItem3->already_purchased == false && $wishlistItem3->wishlist_id == $_POST["update"])  {
                        $isBirthday = isChecked($wishlistItem3->birthday_gift);
                        $isHoliday = isChecked($wishlistItem3->holiday_gift);
                        
                        echo"<form method='get' action='yourprofile.php'>
                        <input type='hidden' name='updateWishlistID' value='{$wishlistItem3->wishlist_id}'>
                        <tr><td><input type='text' class='wishListItemAdd' name='updateItemName' size='10' maxlength='255' value='{$wishlistItem3->item_name}'></td>
                        <td><input type='text' class='wishListItemAdd' name='updateItemDescription' size='10' maxlength='255' value='{$wishlistItem3->item_description}'></td>
                        <td><input type='text' class='wishListItemAdd' name='updateItemLink' size='10' maxlength='255' value='{$wishlistItem3->item_link}'></td>
                        <td><input type='text' class='wishListItemAdd' name='updateItemQuantity' size='5' maxlength='20' value='{$wishlistItem3->quantity}'></td>
                        <td><input type='text' class='wishListItemAdd' name='updateItemPrice' size='5' maxlength='20' value='{$wishlistItem3->item_price}'></td>
                        <td><input type='checkbox' class='wishListItemAdd' name='updateBirthdayGift' value='true' {$isBirthday}> </td>
                        <td><input type='checkbox' class='wishListItemAdd' name='updateHolidayGift' value='true' {$isHoliday}></td>
                        <td><input type='checkbox' class='wishListItemAdd' name='updateAlreadyPurchased' value='true'></td></td>
                        <td><input type='submit' formaction='yourprofile.php' value='Update'></td></tr>
                        </form>";
                }

                    else{
                        if ($wishlistItem3->already_purchased == false){
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


//function to apply updates to mySQL table
function updateConfirm(){
    if($_GET["updateWishlistID"] != null){
        global $connection;
        global $sessionID;
        global $error;

        $wishlistItemExists = false;

        if (empty($_GET["updateItemName"])) {
            echo "<script language='javascript'>";
            echo("alert('Item Name is required to add item to wishlist');");
            echo "</script>";
        }
        elseif (empty($_GET["updateItemDescription"]) ) {
           echo("<script>alert('Item Description is required to add item to wishlist');</script>");
        } 
        elseif (empty($_GET["updateItemLink"]))  {
            echo("<script>alert('Item Link is required to add item to wishlist');</script>");
        }
        elseif (!empty($_GET["updateItemQuantity"]) && !is_numeric($_GET["updateItemQuantity"]) ) {
            echo("<script>alert('Item quantity must be a number');</script>");
        }
        elseif (!empty($_GET["updateItemPrice"]) && !is_numeric($_GET["updateItemPrice"]) ) {
            echo("<script>alert('Item price must be a number');</script>");
        }
        elseif(empty($_GET["updateHolidayGift"]) && empty($_GET["updateBirthdayGift"])) {
            echo("<script>alert('A wishlist item has to be for a birthday or holiday. Please select one');</script>");

        }
        else {
            $wishlistItemExists = true;
        }
        
        if($wishlistItemExists){
            $updateitemLoginID = $sessionID;
            $updateitemName = test_form_input($_GET["updateItemName"]);
            $updateitemDescription = test_form_input($_GET["updateItemDescription"]);
            $updateitemLink = test_form_input($_GET["updateItemLink"]);
            $updateitemQuantity = test_form_input($_GET["updateItemQuantity"]);
            $updateitemPrice = test_form_input($_GET["updateItemPrice"]);
            $updateitemBirthdayGift = test_form_input($_GET["updateBirthdayGift"]);
            $updateitemHolidayGift = test_form_input($_GET["updateHolidayGift"]);
            $updateitemAlreadyPurchased = test_form_input($_GET["updateAlreadyPurchased"]);


            $updateWishlistItem = new wishlistItem;
            $updateWishlistItem->addWishlistItemClass(
            $updateitemLoginID,
            $updateitemName, 
            $updateitemDescription, 
            $updateitemLink , 
            $updateitemQuantity, 
            $updateitemPrice, 
            $updateitemBirthdayGift, 
            $updateitemHolidayGift, 
            $updateitemAlreadyPurchased);




            $updateWishlistItemSQL =$connection->prepare("UPDATE  wishlist SET 
            login_information_id = :login_information_id, item_name = :item_name, item_description = :item_description, item_link = :item_link, quantity = :quantity, item_price = :item_price, birthday_gift = :birthday_gift, holiday_gift = :holiday_gift, already_purchased = :already_purchased
            WHERE wishlist_id = :wishlist_id");
                $updateWishlistItemSQL->bindParam(':login_information_id', $updateWishlistItem->login_information_id, PDO::PARAM_INT);
                $updateWishlistItemSQL->bindParam(':item_name', $updateWishlistItem->item_name, PDO::PARAM_STR, 255);
                $updateWishlistItemSQL->bindParam(':item_description', $updateWishlistItem->item_description, PDO::PARAM_STR, 255);
                $updateWishlistItemSQL->bindParam(':item_link', $updateWishlistItem->item_link, PDO::PARAM_STR, 255);
                $updateWishlistItemSQL->bindParam(':quantity', $updateWishlistItem->quantity);
                $updateWishlistItemSQL->bindParam(':item_price', $updateWishlistItem->item_price);
                $updateWishlistItemSQL->bindParam(':birthday_gift', $updateWishlistItem->birthday_gift, PDO::PARAM_BOOL);
                $updateWishlistItemSQL->bindParam(':holiday_gift', $updateWishlistItem->holiday_gift, PDO::PARAM_BOOL);
                $updateWishlistItemSQL->bindParam(':already_purchased', $updateWishlistItem->already_purchased, PDO::PARAM_BOOL);
                $updateWishlistItemSQL->bindParam(':wishlist_id', $_GET["updateWishlistID"], PDO::PARAM_INT);
                $updateWishlistItemSQL->execute();
            
            header('Location: yourprofile.php');
            echo ("<script>alert('wishlist item updated');</script>");
        }
    }
    

}


//Function to delete wishlist item
function deleteWishListItem(){
    global $connection;
    if( $_POST["delete"] != null) {
        try {
        $deleteWishListItem = $connection->prepare("DELETE FROM wishlist WHERE wishlist_id = :wishlist_id");
        $deleteWishListItem->bindParam(':wishlist_id', $_POST["delete"], PDO::PARAM_INT);
        $deleteWishListItem->execute();
        header('Location: yourprofile.php');
        echo ("<script>alert('wishlist item deleted');</script>");
        }
    
        catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        }
    }
}


//Function to display family members
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

//function to display family member birthdays
function familyMembersBirthdays(){
    global $displayFamilyMemberResults;
    global $sessionID;     
    foreach($displayFamilyMemberResults as $values){
        $familyMemberBirthday = new userInformation();
        $familyMemberBirthday  = $values;
    if($familyMemberBirthday->login_information_id != $sessionID)
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