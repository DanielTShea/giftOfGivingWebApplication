<?php
require ('classes/userimage.php');
require ('sharedfunctions.php');

    $imageID = $_GET['id'] ?? 0;

    global $connection;

    try{
    $getImage = $connection->prepare("SELECT * FROM user_image WHERE login_information_id = :login_information_id");
    $getImage->bindParam(':login_information_id', $imageID, PDO::PARAM_INT);
    $getImage->execute();
    $displayUserImage = $getImage->fetchObject('userimage');
    header('Content-Type: ' . $displayUserImage->mime_type);
    echo $displayUserImage->user_image;


    }catch(PDOException){
       // log exception here
        die();
    }
     

?>
