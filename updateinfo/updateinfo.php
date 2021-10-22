<?php require ('../code/updateinfocode.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Javascript -->
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
    <title>Gift of Giving: Update Your Information</title>
</head>

<body>

    <div class="container">

        <!-- Header-->
        <div class="header">
            <div id="logo">
                <img id="logoImage" src="../images/gift.png" alt="gift with bow">
            </div>
            <h1 id="headline"> Gift of Giving </h1>

            <div class="hamburgerMenu">
                <img  id="hamburgerMenuImage" src="../images/hamburger.png" alt="hamburger menu">
            </div>
        </div>


        <!-- Desktop Nav -->
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
            <p id="breadcrumbContent"> Home > Your Profile > Update Your Information </p>    
        </div>

        <!-- Upate Information forms -->
        <div id="updateInfo">
            <div id="updateInfoHeader">
                <h2>Update Your Information</h2>
            </div>

            <div id="updateInfoContent">

                    <!-- Update User information -->
                    <?php 
                    displayInfo(); 
                    updateUserInfo();
                    updatePasswrod();?>
                    <fieldset class="updateInfoFieldset" id="updateUserInformation">
                        <legend>Update User Information</legend>
                        <br>
                        <form class="form" method="post" action="updateinfo.php">
                            
                            <input type="hidden" name="updateInformation" value="1">
                            
                            <label class="signUplabels" for="firstName"> First Name: </label>
                            <input type="text" class="signUpBoxes" id="firstName" name="firstName" size="35" maxlength="50" value="<?php echo ($displayUserInformation->first_name);?>"> 
                            <span class="signUpError"><?php echo $firstNameError; ?> </span><br><br>

                            <label  class="signUplabels"  for="LastName"> Last Name: </label>
                            <input type="text" class="signUpBoxes" id="lastName" name="lastName" size="35" maxlength="50" value="<?php echo( $displayUserInformation->last_name); ?>"> 
                            <span class="signUpError"><?php echo $lastNameError; ?> </span> <br><br>

                            <label class="signUplabels"  for="birthday"> Birthday: </label>
                            <input type="date" class="signUpBoxes" id="birthday" name="birthday" size="35" value="<?php echo($displayUserInformation->birthday); ?>"> 
                            <span class="signUpError"><?php echo $birthdayError; ?> </span> <br><br>

                            <label  class="signUplabels" for="userName"> Change User Name: </label><br>
                            <input type="text" class="signUpBoxes" id="userName" name="userName" size="32" maxlength="32" value="<?php echo($displayLoginInformation->username); ?>"> 
                            <span class="signUpError"><?php echo $usernameError; ?> </span> <br><br>

                            <label  class="signUplabels" for="passwordConfirm"> Password (Required to update information) </label><br>
                            <input type="password" class="signUpBoxes" id="passwordTest" name="passwordConfirm" size="16" maxlength="16" > 
                            <span class="signUpError"><?php echo $passwordConfirmError; ?> </span> <br><br>
                            
                            <div class="submitButton">
                                <br><input class="buttons" type="submit" value="Update"><br><br> 
                            </div>
                        </form>
                    </fieldset>
                    <br><br> 

                <!-- Update User Image -->
                <?php userImageUpdate()?>
                <div id="updateImage">
                    <fieldset class="updateInfoFieldset" id="signUpFieldset">
                        <legend>Update User Image</legend><br>

                        <form class="form" method="post" action="updateinfo.php" enctype="multipart/form-data">
                                <table id="imageTable">
                                    <tr>
                                        <th>Current User Image</th>
                                        <th>Change User Image</th>
                                    </tr>

                                    <tr>  
                                        <td>
                                            <img id="currentUserImage" src="../code/getimagecode.php?id=<?=$sessionID?>" alt="User Image">
                                        </td> 
                                        <td>
                                            <label  class="signUplabels" for="userImage"> Select New Image: (Reccomended Dimensions - 150 x 200 pixels) </label><br>
                                            <input type="file" name="userImage" id="userImage"><br>
                                            <span class="signUpError"><?php echo($imageError); ?> <span>
                                        </td>
                                    </tr>
                                </table> 
                            <br><br>

                            <div class="submitButton">
                                    <br><input class="buttons" type="submit" value="Update"><br><br> 
                            </div>

                        </form>
                    </fieldset> 
                    <br><br>   
                </div>

                <!-- Update password form                 -->
                <form class="form" id="updatePassword" action="updateinfo.php" method="post">
                    <fieldset class="updateInfoFieldset" id="updatePassword">
                        <legend>Update Password</legend>
                        <br>
                        <input type="hidden" name="updatePassword" value ="1">
                            <label  class="signUplabels" for="passwordCurrent"> Current Password </label><br>
                                <input type="password" class="signUpBoxes" id="passwordCurrent" name="passwordCurrent" size="16" maxlength="16" > 
                                <span class="signUpError"><?php echo $currentpasswordError; ?> </span> <br><br>

                            <label  class="signUplabels" for="passwordTest"> New Password (8 characters minimum, one capital letter, and number required): </label><br>
                            <input type="password" class="signUpBoxes" id="passwordTest" name="passwordTest" size="16" maxlength="16" > 
                            <span class="signUpError"><?php echo $passwordError; ?> </span> <br><br>

                            <label class="signUplabels"  for="passwordFinal"> Re-enter New Password: </label><br>
                            <input type="password" class="signUpBoxes" id="passwordFinal" name="passwordFinal" size="16" maxlength="16"> 
                            <span class="signUpError"><?php echo $confirmpasswordError; ?> </span><br><br>
                            
                            <div class="submitButton">
                                <br><input class="buttons" type="submit" value="Update"><br><br> 
                            </div> 
                    </fieldset>
                </form>
                        
                        <br><br>
                        

            </div>
            <br>
            <br>

            <!-- Home Button -->
            <div class="submitButton">
                <br>
                <form action="../home/home.php">
                    <input class="buttons" id="Home" type="submit"  value="Home"><br><br> 
                </form>
            </div>
            <br>
            <br>


        </div>


        
        
        
        <!-- Footer -->
        <div id="footer">
            <p> <a href="../home/home.php">Home</a> | <a href="../yourprofile/yourProfile.php">Your Profile</a> | <a href="../birthdays/birthdays.php">Birthdays</a> | <a href="../holidays/holidays.php"> Holidays </a> | <a href="../contactus/contactus.php">Contact Us </a> </p>
            <p id="disclaimer"> Gift of Giving © 2021 </p>
        </div>

        
    </div>

</body>
</html>