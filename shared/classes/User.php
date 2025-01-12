<?php
    class User{
        public $userID;
        public $firstName;
        public $lastName;
        public $email;
        public $password;
        public $status;
        public $gender;
        public $contactNumber;
        public $address;
        public $accountCreationDate;
        public $accountUpdateDate;
        public $profilePicture;

        public function __construct($userID, $email, $password){
            $this->userID = $userID;
            $this->email = $email;
            $this->password = $password;
        }
    }
?>