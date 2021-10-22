<?php
class userInformation {
    public $user_information_id;
    public $login_information_id;
    public $first_name;
    public $last_name;
    public $birthday;
    public $userFamilyID;



public function createTestUser(string $first_name, string $last_name, string $birthday){
$this->first_name = $first_name;
$this->last_name = $last_name;
$this->birthday = $birthday;
}


public function updateUser(string $first_name, string $last_name, string $birthday){
    $this->first_name = $first_name;
    $this->last_name = $last_name;
    $this->birthday = $birthday;

}

public function __toString(){
    return $this->login_information_id;
    return $this->first_name;
    return $this->last_name;
    return $this->userFamilyID;

    
}



}

?>