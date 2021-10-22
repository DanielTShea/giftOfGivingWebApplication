<?php

class userimage {
    public $user_image_id;
    public $login_information_id;
    public $image_file_name;
    public $mime_type;
    public $user_image;



function createUserImage(int $login_information_id, string $image_file_name, string $mime_type, string $user_image){
    $this->login_information_id = $login_information_id;
    $this->image_file_name = $image_file_name;
    $this->mime_type = $mime_type;
    $this->user_image = $user_image;
    
}






}


?>