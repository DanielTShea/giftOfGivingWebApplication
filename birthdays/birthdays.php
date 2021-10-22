<!-- Required PHP files -->
<?php require('../code/birthdayscode.php');?>
<!DOCTYPE html>
<html lang="en">
<head>


    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $( document).ready(function(){
            $( "#hamburgerMenuImage").click(function(){
                $( ".mobileNav").css("width", "50%");
            })

            $( "#mobileNavClose").click(function(){
                $( ".mobileNav").css("width", "0%");
            })
        })
    </script>
    
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift of Giving: Birthdays</title>
</head>
<body>
    <!-- Div for grid area -->
    <div class="container">

        <!-- Header -->
        <div class="header">
            <div id="logo">
                <img id="logoImage" src="../images/gift.png" alt="gift with bow">
            </div>
            <h1 id="headline">Gift of Giving </h1>

            <div class="hamburgerMenu">
                <img  id="hamburgerMenuImage" src="../images/hamburger.png" alt="hamburger menu">
            </div>
        </div>

        <!-- Desktop Menu -->
        <div class="desktopMenu"> 
            <a id="menuOne" class="menuItem" href="../home/home.php">Home</a>
            <a id="menuTwo" class="menuItem" href="../yourProfile/yourProfile.php"> Your Profile </a>
            <a id="menuThree" class="menuItem" href="birthdays.php">Birthdays</a>
            <a id="menuFour" class="menuItem" href="../holidays/holidays.php">Holidays</a>
        </div>


        <!-- Mobile Nav -->
        <div class="mobileNav">
            <img id="mobileNavClose" src="../images/mobileNavClose.png" alt="Close navigation">

            <div id="mobileNavContent">
            <a id="mNavOne" class="mNavItem" href="../home/home.php">Home</a>
            <a id="mNavTwo" class="mNavItem" href="../yourProfile/yourProfile.php">Your Profile</a>
            <a id="mNavThree" class="mNavItem" href="birthdays.php">Birthdays</a>
            <a id="mNavFour" class="mNavItem" href="../holidays/holidays.php"> Holidays </a>
            <a id="mNavFive" class="mNavItem" href="../contactus/contactus.php"> Contact Us </a>
            </div>

        </div>

        <!-- Breadcrumb -->
        <div id="breadcrumb">
            <p id="breadcrumbContent"> Home > Your Profile > Birthdays</p>    
        </div>


        <!-- Birthday Content -->
        <div id="birthdays">
            <div id="familyBirthdays">
                <h2 id="familyBirthdaysHeader"> Your Family's Birthdays </h2>

                <div id="familyBirthdaysContent"> 
                    <table class="tables" >
                        <tr>
                        <th>Item Name</th>
                        <th>Item Description </th>
                        <th>Item Link </th>
                        <th>Quantity </th>
                        <th>Item Price</th>
                        <th>Birthday Gift</th>
                        <th>Holiday Gift</th>
                        <th>Already Purchased</th>
                        <th>Add/Delete/Update</th>
                        </tr>
                        <?php 
                        familyWishlistInformation();
                        updateWishlistItem();
                        updateConfirm();
                        // deleteWishListItem();
                        // wishlistInformation(); 
                        ?> 
                    </table>
                </div>
            </div>
            <br><br>
            
            <!-- Birthday Gift History -->
            <div id="familyGiftHistory">
                <h2 id="familyGiftHistoryHeader"> Family Gift History </h2>
                <div id="familyGiftHistoryContent"> 
                    <table class="tables" >
                        <tr>
                        <th>Item Name</th>
                        <th>Item Description </th>
                        <th>Item Link </th>
                        <th>Quantity </th>
                        <th>Item Price</th>
                        <th>Birthday Gift</th>
                        <th>Holiday Gift</th>
                        <th>Already Purchased</th>
                        </tr>

                        <?php familyPurchasedWishlist() ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Family Information -->
        <div id="yourFamilyInformation">
            <div id="yourFamilyMembers">
            <h2 id="yourFamilyMemberstHeader"> Your Family Members</h2>
                <div id="yourFamilyMemberstContent"> 
                    <table>
                    <table> <tr><th>First Name</th> <th>Last Name</th> <th>Link to their page</th></tr>
                    <?php familyMembers() ?> 
                    </table>
                </div>
            </div>

            <br><br>

            <!-- Upcoming Hoidays -->
            <div id="upcomingHolidays">
                <h2 id="upcomingHolidaysHeader"> Upcoming Holidays</h2>
                <div id="upcomingHolidayContent">
                    <table>
                    <tr><th>Date</th> <th>Holiday Name</th>  <th>Gift Exchange Type</th><th>Links to Holidays</th></tr>
                    <?php familyHolidays() ?>
                </table>
                </div>
            </div>
            <br><br>

        </div>

        <!-- Footer -->
        <div id="footer">
            <p> <a href="../home/home.php">Home</a> | <a href="../yourprofile/yourProfile.php">Your Profile</a> | <a href="birthdays.php">Birthdays</a> | <a href="../holidays/holidays.php"> Holidays </a> | <a href="../contactus/contactus.php">Contact Us </a></p>
            <p id="disclaimer"> Gift of Giving © 2021 </p>
        </div>
    </div>
</body>
</html>