<!-- Required PHP file -->
<?php require('../code/familymembercode.php'); ?>
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
    <title>Gift of Giving: <?php echo("$displayLoginInformation->username") ?></title>
</head>
<body>

    <!-- Div to manage grid display -->
    <div class="container">

        <!-- Header -->
        <div class="header">
            <div id="logo">
                <img id="logoImage" src="../images/gift.png" alt="gift with bow">
            </div>
            <h1 id="headline"> Gift of Giving</h1>
            <div class="hamburgerMenu">
                <img  id="hamburgerMenuImage" src="../images/hamburger.png" alt="hamburger menu">
            </div>
        </div>

        <!-- Desktop Menu -->
        <div class="desktopMenu"> 
            <a id="menuOne" class="menuItem" href="../home/home.php">Home</a>
            <a id="menuTwo" class="menuItem" href="../yourProfile/yourProfile.php"> Your Profile </a>
            <a id="menuThree" class="menuItem" href="../birthdays/birthdays.php">Birthdays</a>
            <a id="menuFour" class="menuItem" href="../holidays/holidays.php">Holidays</a>
        </div>


        <!-- Mobile Nav -->
        <div class="mobileNav">
            <img id="mobileNavClose" src="../images/mobileNavClose.png" alt="Close navigation">

            <div id="mobileNavContent">
                <a id="mNavOne" class="mNavItem" href="../home/home.php">Home</a>
                <a id="mNavTwo" class="mNavItem" href="../yourProfile/yourProfile.php">Your Profile</a>
                <a id="mNavThree" class="mNavItem" href="../birthdays/birthdays.php">Birthdays</a>
                <a id="mNavFour" class="mNavItem" href="../holidays/holidays.php"> Holidays </a>
                <a id="mNavFive" class="mNavItem" href="../contactus/contactus.php"> Contact Us </a>

            </div>

        </div>

        <!-- Breadcrumb -->
        <div id="breadcrumb">
            <p id="breadcrumbContent"> Home > Your Profile > <?php displayFamilyName(); ?> </p>    
        </div>


        <!--Family Member wishlist  -->
        <div id="yourInformation">
            <div id="yourWishList">
            <h2 id="yourContenttHeader"> Wish list </h2>

                <div id="yourWishListtContent"> 
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

                        <?php 
                        familyWishlistInformation(); 
                        ?>    
                    </table>
                </div>
            </div>

            <br><br>

            <div id="yourGiftHistory">
                <h2 id="yourGiftHistoryHeader"> Gift History </h2>
                    <div id="yourGiftHistoryContent"> 
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


        <!-- Family Member Proifile -->
        <div id="yourFamilyInformation">
            <div id="familyMemberProfile">
            <h2 id="yourFamilyMemberstHeader"> <?php displayFamilyName(); ?> </h2>
                <div id="familyMemberContent">
                    <table>
                        <tr><th>User Profile Image</th></tr>
                        <tr><td><img id="currentUserImage" src="../code/getimagecode.php?id=<?=$familyMemberid?>"></td></tr>
                        <?php profileinformation() ?>

                    </table>

                </div>
            </div>

            <br><br>

            <div id="upcomingBirthdays">
                <h2 id="upcomingBirthdaysHeader"> Upcoming Birthdays</h2>
                <div id="upcomingBirthdayContent"> 
                    <table>
                    <?php familyMembersBirthdays(); ?>
                    </table>
                </div>
            </div>

            <br><br>

            <div id="upcomingHolidays">
                <h2 id="upcomingHolidaysHeader"> Upcoming Holidays</h2>
                <div id="upcomingHolidayContent">
                    <table>
                        <?php familyHolidays() ?>
                    </table>
                </div>
            </div>
            <br><br>
        </div>


        <!-- Footer -->
        <div id="footer">
            <p> <a href="../home/home.php">Home</a> | <a href="../yourProfile/yourProfile.php">Your Profile</a> | <a href="../birthdays/birthdays.php">Birthdays</a> | <a href="../holidays/holidays.php"> Holidays </a> | <a href="../contactus/contactus.php">Contact Us </a> </p>
            <p id="disclaimer"> Gift of Giving © 2021 </p>
        </div>

    </div>
</body>
</html>