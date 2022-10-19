<?php

/**
 * Administrator class
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/accountant_class.php';
class AdministratorUser extends AccountantUser
{
    public function getAllUsers()
    {
        global $instance;
        $query = "CALL STCMSGetAllUsers()";
        $result = $instance->getMultipleRows($query);
        return $result;
    }

    public function changeUserAccountStatus()
    {
        global $instance;
        $query = "CALL STCMSChangeUserStatus('" . $this->getUserNo() . "', '" . $this->getAccountStatus() . "')";
        $result = $instance->update($query);
        return $result;
    }
}
