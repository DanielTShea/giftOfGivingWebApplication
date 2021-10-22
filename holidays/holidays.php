<!-- Required PHP files -->
<?php require('../code/holidayscode.php');?>
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

        $( ".deleteButton" ).click(function(){
            if (confirm("Are your sure you want to delete?")) {
                ( ".deleteForm" ).submit();
            }else {
                return false;
            }
        })
    
    })
</script>
    
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift of Giving: Holidays</title>
</head>
<body>

    <!-- Div to display grid -->
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
            <a id="menuThree" class="menuItem" href="../birthdays/birthdays.php">Birthdays</a>
            <a id="menuFour" class="menuItem" href="holidays.php">Holidays</a>
        </div>


        <!-- Mobile Nav -->
        <div class="mobileNav">
            <img id="mobileNavClose" src="../images/mobileNavClose.png" alt="Close navigation">

            <div id="mobileNavContent">
                <a id="mNavOne" class="mNavItem" href="../home/home.php">Home</a>
                <a id="mNavTwo" class="mNavItem" href="../yourProfile/yourProfile.php">Your Profile</a>
                <a id="mNavThree" class="mNavItem" href="../birthdays/birthdays.php">Birthdays</a>
                <a id="mNavFour" class="mNavItem" href="holidays.php"> Holidays </a>
                <a id="mNavFive" class="mNavItem" href="../contactus/contactus.php"> Contact Us </a>
            </div>

        </div>
        
        <!-- Breadcrumb -->
        <div id="breadcrumb">
            <p id="breadcrumbContent"> Home > Your Profile > Holidays </p>    
        </div>

        <!-- Family Holiday Wishlist information -->
        <div id="familyHolidays">
            <div id="familyHolidaysWishlist">
                <h2 id="familyHolidaysWishlistHeader"> Your Family Holidays and Wishlist </h2>

                <div id="familyHolidaysWishlisttContent"> 
                    <table class="tables" >
                        <?php 
                        updateHolidayWishlistItem();
                        updateWishlistConfirm();
                        addHoliday();
                        updatefamilyHolidayInformation();
                        updateHolidayConfirm();
                        deleteHoliday();
                        familyHolidayWishlistInformation();
                        ?>
                    </table>
                </div>
            </div>
            <br><br>

            <div id="familyHolidayGiftHistory">
                <h2 id="familyHolidayGiftHistoryHeader"> Your Family Holiday Wishlist History </h2>
                    <div id="familyHolidayGiftHistoryContent"> 
                        <table class="tables" >
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
                            </tr>
                            <?php familyHolidayPurchasedWishlistInformation() ?>
                        </table>
                    </div>
            </div>
        </div>


        <!-- Family Member information -->
        <div id="yourFamilyInformation">
            <div id="yourFamilyMembers">
                <h2 id="yourFamilyMemberstHeader"> Your Family Members</h2>
                <div id="yourFamilyMemberstContent"> 
                    <table> <tr><th>First Name</th> <th>Last Name</th> <th>Link to their page</th></tr>
                    <?php familyMembers() ?> 
                    </table>
                </div>
            </div>

            <br><br>

            <!-- Upcoming Birthdays -->
            <div id="upcomingBirthdays">
                <h2 id="upcomingBirthdaysHeader"> Upcoming Birthdays</h2>
                <div id="upcomingBirthdayContent"> 
                    <table>
                    <tr><th>Date</th> <th>First Name</th> <th>Last Name</th> <th>Link to Birthdays</th></tr>
                    <?php familyMembersBirthdays() ?>
                    </table>
                </div>
            </div>

            <br><br>

        </div>






        <!-- Footer -->
        <div id="footer">
            <p> <a href="../home/home.php">Home</a> | <a href="../yourprofile/yourProfile.php">Your Profile</a> | <a href="../birthdays/birthdays.php">Birthdays</a> | <a href="holidays.php"> Holidays </a> | <a href="../contactus/contactus.php">Contact Us </a></p>
            <p id="disclaimer"> Gift of Giving © 2021 </p>
        </div>

    </div>
</body>
</html>