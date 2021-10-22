<?php 
//Class test credentials

class Credential {
    public $login_information_id;
    public $username;
    public $login_password;
    
    public function createTestCredential(string $username, string $login_password){
        $this->username = $username;
        $this->login_password = $login_password;
    }

    public function updatePassword($login_password){
        $this->login_password = $login_password;
    }

    public function updateCredential(string $username){
        $this->username = $username;
    }




    public function __toString(){
        return $this->username;
    }



}
?>