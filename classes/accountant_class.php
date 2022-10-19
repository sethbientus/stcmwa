<?php

/**
 * Accountant class
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/user_class.php';
class AccountantUser extends AppUser
{
    public function register()
    {
        global $instance;
        $query = "CALL STCMSRegisterUser('" . $this->getFirstName() . "','" . $this->getLastName() . "',
            '" . $this->getEmail() . "','" . $this->getPassword() . "', '" . $this->getRoleNo() . "',
            '" . $this->getAccountStatus() . "',@userNo)";
        $instance->store($query);
        $userQuery = "SELECT @userNo AS userNo";
        $result = $instance->getOneRow($userQuery);
        $this->setUserNo($result["userNo"]);
        if ($this->getUserNo() > 0) {
            return $this->getUserNo();
        } else {
            return 0;
        }
    }

    public function getAllEnrollments()
    {
        global $instance;
        $query = "CALL STCMSGetAllEnrollment()";
        $result = $instance->getMultipleRows($query);
        return $result;
    }

    public function getTraineeEnrollments()
    {
        global $instance;
        $query = "CALL STCMSGetTraineeEnrollment('" . $this->getUserNo() . "')";
        $result = $instance->getMultipleRows($query);
        return $result;
    }

    public function approveEnrollment($enroll, $status)
    {
        global $instance;
        $query = "CALL STCMSApproveEnrollment('" . $enroll . "', '" . $status . "')";
        $result = $instance->update($query);
        return $result;
    }

    public function getAllPayments()
    {
        global $instance;
        $query = "CALL STCMSGetAllPayments()";
        $result = $instance->getMultipleRows($query);
        return $result;
    }

    public function getTraineePayments()
    {
        global $instance;
        $query = "CALL STCMSGetTraineePayments('" . $this->getUserNo() . "')";
        $result = $instance->getMultipleRows($query);
        return $result;
    }

    public function addLastNotificationTime($enroll)
    {
        global $instance;
        $query = "CALL STCMSAddLastNotificationTime('" . $enroll . "')";
        $result = $instance->update($query);
        return $result;
    }
}
