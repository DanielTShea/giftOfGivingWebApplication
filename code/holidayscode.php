<?php
// Session Start
session_start();

//Required PHP files and classes
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


// Function to display wishlists by Holidays
function familyHolidayWishlistInformation(){
    global $isArray;
    global $connection;
    global $displayFamilyHolidays;
    global $displayFamilyMemberResults;
    if($_POST["update"] == null && $_POST["updateHoliday"] == null){
        foreach($displayFamilyHolidays as $value){
            $familyHoliday1 = new holiday();
            $familyHoliday1 = $value;

            echo "<tr class='familyRow'>
                    <td colspan='3'> Holiday Date: {$familyHoliday1->holiday_date}</td>
                    <td colspan='2'> Holiday Name: {$familyHoliday1->holiday_name}</td> 
                    <td colspan='3'> Gift Exchange Type: {$familyHoliday1->gift_exchange_type}</td> 
                    <td colspan='2'> Gift Price Limit: {$familyHoliday1->price_limit}</td> 
                    <td>
                    <form method='post'>
                    <input type='hidden' name='updateHoliday' value='{$familyHoliday1->holiday_id}'>
                    <input type='submit' formaction='holidays.php' value='Update'>
                    </form>
                    <form class='deleteForm' method='post'>
                    <input type='hidden' name='delete' value='{$familyHoliday1->holiday_id}'>
                    <input type='submit' class='deleteButton' formaction='holidays.php' value='Delete'>
                    </form>
                    </td>
                </tr>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Item Name</th>
                    <th>Item Description </th>
                    <th>Item Link </th>
                    <th>Quantity </th>
                    <th>Item Price</th>
                    <th>Birthday Gift</th>
                    <th>Holiday Gift</th>
                    <th>Already Purchased</th>
                    <th>Add/Delete/Update</th>
                </tr>";

            foreach($displayFamilyMemberResults as $value)  {
                $familyMember1 = new userInformation();
                $familyMember1 = $value;

                try{
                    $lookupFamilyHolidayList = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
                    $lookupFamilyHolidayList->bindParam(':login_information_id', $familyMember1->login_information_id, PDO::PARAM_INT);
                    $lookupFamilyHolidayList->execute();
                    $displayFamilyHolidayList= $lookupFamilyHolidayList->fetchAll(PDO::FETCH_CLASS, 'wishlistitem');
                    }
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                
                foreach($displayFamilyHolidayList as $value){
                    $wishlistItem1 = new wishlistItem;
                    $wishlistItem1 = $value;
                    if ($wishlistItem1->already_purchased == false  && $wishlistItem1->holiday_gift == 1)  {
                        echo " 
                        <tr>
                        <td>{$familyMember1->first_name}</td>
                        <td>{$familyMember1->last_name}</td>
                        <td>{$wishlistItem1->item_name}</td>
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
                        <input type='submit' formaction='holidays.php' value='Update'>
                        </form>
                        </td>
                        </tr>
                        ";
                    }

                } 
            }
        }
        echo "
                <form method='get' action='holidays.php'>
                <input type='hidden' name='add' value='1'>
                <tr class='familyRow'><td colspan='4'><label for='addHolidayDate'> Holiday Date:</label><input type='date' class='wishListItemAdd' name='addHolidayDate' size='12'></td>
                <td colspan='1'><label for='addHolidayName'> Holiday Name:</label><input type='text' class='wishListItemAdd' name='addHolidayName' size='10' maxlength='50'></td>
                <td colspan='3'><label for='addGiftExchangeType'> Gift Exchange Type:</label><input type='text' class='wishListItemAdd' name='addGiftExchangeType' size='10' maxlength='50'></td>
                <td colspan='2'><label for='addGiftPriceLimit'> Gift Price Limit:</label><input type='text' class='wishListItemAdd' name='addGiftPriceLimit' size='5' maxlength='20'></td>
                <td><input type='submit' value='Add'></td></tr>
                </form>";
    }    
    
}


// Function to display purchased wishlist items by Holidays
function familyHolidayPurchasedWishlistInformation(){
    global $isArray;
    global $connection;
    global $displayFamilyMemberResults;
    foreach($displayFamilyMemberResults as $value)  {
        $familyMember1 = new userInformation();
        $familyMember1 = $value;

        try{
            $lookupFamilyHolidayList = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
            $lookupFamilyHolidayList->bindParam(':login_information_id', $familyMember1->login_information_id, PDO::PARAM_INT);
            $lookupFamilyHolidayList->execute();
            $displayFamilyHolidayList= $lookupFamilyHolidayList->fetchAll(PDO::FETCH_CLASS, 'wishlistitem');
            }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        foreach($displayFamilyHolidayList as $value){
            $wishlistItem1 = new wishlistItem;
            $wishlistItem1 = $value;
            if ($wishlistItem1->already_purchased == true  && $wishlistItem1->holiday_gift == 1)  {
                echo " 
                <tr>
                <td>{$familyMember1->first_name}</td>
                <td>{$familyMember1->last_name}</td>
                <td>{$wishlistItem1->item_name}</td>
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


// Function to provide check value to checkbox display
function isChecked($value){
    if($value){
        return 'checked';
    }
    else{
        return ''; 
    }
}

// Function to display update table for Holiday wishlist item
function updateHolidayWishlistItem(){
    global $isArray;
    global $connection;
    global $displayFamilyHolidays;
    global $displayFamilyMemberResults;
    if($_POST["update"] != null){
        foreach($displayFamilyHolidays as $value){
            $familyHoliday1 = new holiday();
            $familyHoliday1 = $value;

            echo "<tr class='familyRow'>
                    <td colspan='3'> Holiday Date: {$familyHoliday1->holiday_date}</td>
                    <td colspan='2'> Holiday Name: {$familyHoliday1->holiday_name}</td> 
                    <td colspan='3'> Gift Exchange Type: {$familyHoliday1->gift_exchange_type}</td> 
                    <td colspan='2'> Gift Price Limit: {$familyHoliday1->price_limit}</td>
                    <td></td> 
                </tr>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Item Name</th>
                    <th>Item Description </th>
                    <th>Item Link </th>
                    <th>Quantity </th>
                    <th>Item Price</th>
                    <th>Birthday Gift</th>
                    <th>Holiday Gift</th>
                    <th>Already Purchased</th>
                    <th>Add/Delete/Update</th>
                </tr>";

            foreach($displayFamilyMemberResults as $value)  {
                $familyMember1 = new userInformation();
                $familyMember1 = $value;

                try{
                    $lookupFamilyHolidayList = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
                    $lookupFamilyHolidayList->bindParam(':login_information_id', $familyMember1->login_information_id, PDO::PARAM_INT);
                    $lookupFamilyHolidayList->execute();
                    $displayFamilyHolidayList= $lookupFamilyHolidayList->fetchAll(PDO::FETCH_CLASS, 'wishlistitem');
                    }
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                
                foreach($displayFamilyHolidayList as $value){
                    $wishlistItem3 = new wishlistItem;
                    $wishlistItem3= $value;
                    if ($wishlistItem3->already_purchased == false && $wishlistItem3->wishlist_id == $_POST["update"]) {
                        $isBirthday = isChecked($wishlistItem3->birthday_gift);
                        $isHoliday = isChecked($wishlistItem3->holiday_gift);
                        echo"<form method='get' action='holidays.php'>
                            <input type='hidden' name='updateWishlistID' value='{$wishlistItem3->wishlist_id}'>
                            <tr><td><input type='text' class='wishListItemAdd' name='firstName' size='10' maxlength='50' value='{$familyMember1->first_name}}' readonly></td>
                            <td><input type='text' class='wishListItemAdd' name='lastName' size='10' maxlength='50' value='{$familyMember1->last_name}' readonly></td>
                            <td><input type='text' class='wishListItemAdd' name='updateItemName' size='10' maxlength='255' value='{$wishlistItem3->item_name}' readonly></td>
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
                            <tr>
                            <td>{$familyMember1->first_name}</td>
                            <td>{$familyMember1->last_name}</td>
                            <td>{$wishlistItem3->item_name}</td>
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


//Update wishlist confirm function
function updateWishlistConfirm(){
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

        header('Location: holidays.php');
    }
    

}



// Function to display update to Holiday
function updatefamilyHolidayInformation(){
    global $isArray;
    global $connection;
    global $displayFamilyHolidays;
    global $displayFamilyMemberResults;
    if($_POST["updateHoliday"] != null){
        foreach($displayFamilyHolidays as $value){
            $familyHoliday1 = new holiday();
            $familyHoliday1 = $value;
            if ($familyHoliday1->holiday_id == $_POST["updateHoliday"]){
                echo
                "   <form method='get' action='holidays.php'>
                    <input type='hidden' name='updateHolidayID' value='{$familyHoliday1->holiday_id}'>
                    <tr class='familyRow'>
                    <td colspan='4'><label for='updateHolidayDate'> Holiday Date:</label><input type='date' class='wishListItemAdd' name='updateHolidayDate' size='12' value='{$familyHoliday1->holiday_date}'></td>
                    <td colspan='1'><label for='updateHolidayName'> Holiday Name:</label><input type='text' class='wishListItemAdd' name='updateHolidayName' size='10' maxlength='50' value='{$familyHoliday1->holiday_name}'></td>
                    <td colspan='3'><label for='updateGiftExchangeType'> Gift Exchange Type:</label><input type='text' class='wishListItemAdd' name='updateGiftExchangeType' size='10' maxlength='50' value='{$familyHoliday1->gift_exchange_type}'></td>
                    <td colspan='2'><label for='updateGiftPriceLimit'> Gift Price Limit:</label><input type='text' class='wishListItemAdd' name='updateGiftPriceLimit' size='5' maxlength='20' value='{$familyHoliday1->price_limit}'></td>
                    <td><input type='submit'  value='Update'></td></tr>
                    </form>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Item Name</th>
                    <th>Item Description </th>
                    <th>Item Link </th>
                    <th>Quantity </th>
                    <th>Item Price</th>
                    <th>Birthday Gift</th>
                    <th>Holiday Gift</th>
                    <th>Already Purchased</th>
                    <th>Add/Delete/Update</th>
                </tr>";
            }
            else{
                echo "<tr class='familyRow'>
                        <td colspan='3'> Holiday Date: {$familyHoliday1->holiday_date}</td>
                        <td colspan='2'> Holiday Name: {$familyHoliday1->holiday_name}</td> 
                        <td colspan='3'> Gift Exchange Type: {$familyHoliday1->gift_exchange_type}</td> 
                        <td colspan='2'> Gift Price Limit: {$familyHoliday1->price_limit}</td> 
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Item Name</th>
                        <th>Item Description </th>
                        <th>Item Link </th>
                        <th>Quantity </th>
                        <th>Item Price</th>
                        <th>Birthday Gift</th>
                        <th>Holiday Gift</th>
                        <th>Already Purchased</th>
                        <th>Add/Delete/Update</th>
                    </tr>";
            }
            foreach($displayFamilyMemberResults as $value)  {
                $familyMember1 = new userInformation();
                $familyMember1 = $value;

                try{
                    $lookupFamilyHolidayList = $connection->prepare("SELECT * FROM wishlist WHERE login_information_id = :login_information_id");
                    $lookupFamilyHolidayList->bindParam(':login_information_id', $familyMember1->login_information_id, PDO::PARAM_INT);
                    $lookupFamilyHolidayList->execute();
                    $displayFamilyHolidayList= $lookupFamilyHolidayList->fetchAll(PDO::FETCH_CLASS, 'wishlistitem');
                    }
                catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                
                foreach($displayFamilyHolidayList as $value){
                    $wishlistItem1 = new wishlistItem;
                    $wishlistItem1 = $value;
                    if ($wishlistItem1->already_purchased == false  && $wishlistItem1->holiday_gift == 1)  {
                        echo " 
                        <tr>
                        <td>{$familyMember1->first_name}</td>
                        <td>{$familyMember1->last_name}</td>
                        <td>{$wishlistItem1->item_name}</td>
                        <td>{$wishlistItem1->item_description}</td>
                        <td><a href='{$wishlistItem1->item_link}' target='_blank'>$wishlistItem1->item_link</a></td>
                        <td>{$wishlistItem1->quantity}</td>
                        <td>{$wishlistItem1->item_price}</td>
                        <td>{$isArray[$wishlistItem1->birthday_gift]}</td>
                        <td>{$isArray[$wishlistItem1->holiday_gift]}</td>
                        <td>{$isArray[$wishlistItem1->already_purchased]}</td>
                        <td>
                        </tr>
                        ";
                    }

                } 
            }
        }
        
    }    
    
}




//function to apply updates Holiday to mySQL table
function updateHolidayConfirm(){
    $dateRequirements = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
    if($_GET['updateHolidayID'] != null){
        global $connection;
        global $displayUserInformation;
        $holidayExists = false;

        if (empty($_GET['updateHolidayName'])) {
            echo("<script>alert('Holiday name is required.');</script>");
        }
        elseif (empty($_GET['updateHolidayDate']) || !preg_match($dateRequirements , $_GET["updateHolidayDate"] )) {
            echo("<script>alert('A holiday date is required and must be a valid date.');</script>");
        } 
        elseif (empty($_GET['updateGiftExchangeType'])){
            echo("<script>alert('The holidays gift exchange type is required.');</script>");
        }
        elseif (empty($_GET['updateGiftPriceLimit']) || !is_numeric($_GET["updateGiftPriceLimit"]) ) {
            echo("<script>alert('Price limit is required must be a number.');</script>");
        }
        else {
            $holidayExists = true;
        }
        
        if($holidayExists){
            $updateFamilyID = $displayUserInformation->family_id;
            $updateHolidayName = test_form_input($_GET["updateHolidayName"]);
            $updateHolidayDate = test_form_input($_GET["updateHolidayDate"]);
            $updateGiftExchangeType = test_form_input($_GET["updateGiftExchangeType"]);
            $updatePriceLimit = test_form_input($_GET["updateGiftPriceLimit"]);


            $updateHoliday = new holiday();
            $updateHoliday->createHoliday(
            $updateFamilyID,
            $updateHolidayName,
            $updateHolidayDate,
            $updateGiftExchangeType, 
            $updatePriceLimit);

            $updateHolidaySQL =$connection->prepare("UPDATE  holiday SET 
            family_id = :family_id, holiday_name = :holiday_name, holiday_date = :holiday_date, gift_exchange_type = :gift_exchange_type, price_limit = :price_limit 
            WHERE holiday_id = :holiday_id");
                $updateHolidaySQL->bindParam(':family_id', $updateHoliday->family_id, PDO::PARAM_INT);
                $updateHolidaySQL->bindParam(':holiday_name', $updateHoliday->holiday_name, PDO::PARAM_STR, 50);
                $updateHolidaySQL->bindParam(':holiday_date', $updateHoliday->holiday_date, PDO::PARAM_STR);
                $updateHolidaySQL->bindParam(':gift_exchange_type', $updateHoliday->gift_exchange_type, PDO::PARAM_STR, 50);
                $updateHolidaySQL->bindParam(':price_limit', $updateHoliday->price_limit);
                $updateHolidaySQL->bindParam(':holiday_id', $_GET["updateHolidayID"], PDO::PARAM_INT);
                $updateHolidaySQL->execute();

            echo ("<script>alert('Holiday updated');</script>");
            header('Location: holidays.php');
        }
    }
    

}



            

// Function to add wishlist item
function addHoliday(){
    if ($_GET["add"] == '1'){
        $dateRequirements = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
        global $connection;
        global $displayUserInformation;
        $holidayExists = false;

        if (empty($_GET['addHolidayName'])) {
            echo("<script>alert('Holiday name is required.');</script>");
        }
        elseif (empty($_GET['addHolidayDate']) || !preg_match($dateRequirements , $_GET["addHolidayDate"] )) {
            echo("<script>alert('A holiday date is required and must be a valid date.');</script>");
        } 
        elseif (empty($_GET['addGiftExchangeType'])){
            echo("<script>alert('The holidays gift exchange type is required.');</script>");
        }
        elseif (empty($_GET['addGiftPriceLimit']) || !is_numeric($_GET["addGiftPriceLimit"]) ) {
            echo("<script>alert('Price limit is required must be a number.');</script>");
        }
        else {
            $holidayExists = true;
        }
        
        if($holidayExists){
            echo("<script>alert('Item Description is required to add item to wishlist');</script>");
            $addFamilyID = $displayUserInformation->family_id;
            $addHolidayName = test_form_input($_GET["addHolidayName"]);
            $addHolidayDate = test_form_input($_GET["addHolidayDate"]);
            $addGiftExchangeType = test_form_input($_GET["addGiftExchangeType"]);
            $addPriceLimit = test_form_input($_GET["addGiftPriceLimit"]);


            $addHoliday = new holiday();
            $addHoliday->createHoliday(
            $addFamilyID,
            $addHolidayName,
            $addHolidayDate,
            $addGiftExchangeType, 
            $addPriceLimit);

            $addHolidaySQL =$connection->prepare("INSERT INTO  holiday (family_id, holiday_name, holiday_date, gift_exchange_type, price_limit)
            VALUES (:family_id, :holiday_name, :holiday_date, :gift_exchange_type, :price_limit)");
                $addHolidaySQL->bindParam(':family_id', $addHoliday->family_id, PDO::PARAM_INT);
                $addHolidaySQL->bindParam(':holiday_name', $addHoliday->holiday_name, PDO::PARAM_STR, 50);
                $addHolidaySQL->bindParam(':holiday_date', $addHoliday->holiday_date, PDO::PARAM_STR);
                $addHolidaySQL->bindParam(':gift_exchange_type', $addHoliday->gift_exchange_type, PDO::PARAM_STR, 50);
                $addHolidaySQL->bindParam(':price_limit', $addHoliday->price_limit);
                $addHolidaySQL->execute();

            echo ("<script>alert('Holiday added');</script>");    
            header('Location: holidays.php');


        }    
    }
}



//Function to delete wishlist item
function deleteHoliday(){
    global $connection;
    if( $_POST["delete"] != null) {
        try {
        $deleteHoliday = $connection->prepare("DELETE FROM holiday WHERE holiday_id = :holiday_id");
        $deleteHoliday->bindParam(':holiday_id', $_POST["delete"], PDO::PARAM_INT);
        $deleteHoliday->execute();
        echo ("<script>alert('holiday deleted');</script>");
        header('Location: holidays.php');
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



?>

