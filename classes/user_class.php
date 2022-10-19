<?php

/**
 * Abstract class for users
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/configurations/database_operation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/PasswordHash.php';
$instance = new Database_operation();
$wp_hash = new PasswordHash(8, true);

abstract class AppUser
{
    private $userNo;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $roleNo;
    private $accountStatus;

    //Setters
    public function setUserNo($uid)
    {
        $this->userNo = htmlspecialchars($uid);
    }
    public function setFirstName($fName)
    {
        $this->firstName = htmlspecialchars($fName);
    }
    public function setLastName($lName)
    {
        $this->lastName = htmlspecialchars($lName);
    }
    public function setEmail($email)
    {
        $this->email = htmlspecialchars($email);
    }
    public function setPassword($pwd)
    {
        $this->password = htmlspecialchars($pwd);
    }
    public function setPhoneNumber($phone)
    {
        $this->phoneNumber = htmlspecialchars($phone);
    }
    public function setRoleNo($right)
    {
        $this->roleNo = htmlspecialchars($right);
    }
    public function setAccountStatus($stat)
    {
        $this->accountStatus = htmlspecialchars($stat);
    }

    //Getters
    public function getUserNo()
    {
        global $instance;
        return $instance->escape_string($this->userNo);
    }
    public function getFirstName()
    {
        global $instance;
        return $instance->escape_string($this->firstName);
    }
    public function getLastName()
    {
        global $instance;
        return $instance->escape_string($this->lastName);
    }
    public function getEmail()
    {
        global $instance;
        return $instance->escape_string($this->email);
    }
    public function getPassword()
    {
        global $instance;
        global $wp_hash;
        $hashes = $wp_hash->HashPassword($this->password);
        return $instance->escape_string($hashes);
    }
    public function getRoleNo()
    {
        global $instance;
        return $instance->escape_string($this->roleNo);
    }
    public function getAccountStatus()
    {
        global $instance;
        return $instance->escape_string($this->accountStatus);
    }

    public function login()
    {
        global $instance;
        $query = "CALL STCMSLogin('" . $this->getEmail() . "')";
        $result = $instance->getOneRow($query);
        return $result;
    }

    public function checkPassword($pwd, $hashes)
    {
        global $wp_hash;
        if ($wp_hash->CheckPassword($pwd, $hashes)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUserEmail()
    {
        global $instance;
        $query = "CALL STCMSCheckUserEmail('" . $this->getEmail() . "')";
        $result = $instance->getOneRow($query);
        return $result;
    }

    public function generatePassword($length = 3)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#@$%!*?';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getUserInfo()
    {
        global $instance;
        $query = "CALL STCMSGetUserInfo('" . $this->getUserNo() . "')";
        $result = $instance->getOneRow($query);
        return $result;
    }

    public function updateProfile()
    {
        global $instance;
        $query = "CALL STCMSUserProfile('" . $this->getUserNo() . "', '" . $this->getFirstName() . "', '" . $this->getLastName() . "', '" . $this->getEmail() . "')";
        $result = $instance->update($query);
        return $result;
    }

    public function changePassword()
    {
        global $instance;
        $query = "CALL STCMSChangePassword('" . $this->getUserNo() . "', '" . $this->getPassword() . "')";
        $result = $instance->update($query);
        return $result;
    }
}
