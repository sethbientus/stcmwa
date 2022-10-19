<?php

/**
 * lass for courses
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/configurations/database_operation.php';
$instance = new Database_operation();

class Course
{
    private $courseNo;
    private $courseName;
    private $courseCode;
    private $userNo;
    private $startAt;
    private $endAt;
    private $coursePrice;
    private $courseStatus;

    //Setters
    public function setCourseNo($course)
    {
        $this->courseNo = htmlspecialchars($course);
    }
    public function setCourseName($name)
    {
        $this->courseName = htmlspecialchars($name);
    }
    public function setCourseCode($code)
    {
        $this->courseCode = htmlspecialchars($code);
    }
    public function setUserNo($uid)
    {
        $this->userNo = htmlspecialchars($uid);
    }
    public function setSatrtAt($start)
    {
        $this->startAt = htmlspecialchars($start);
    }
    public function setEndAt($end)
    {
        $this->endAt = htmlspecialchars($end);
    }
    public function setCoursePrice($price)
    {
        $this->coursePrice = htmlspecialchars($price);
    }
    public function setCourseStatus($stat)
    {
        $this->courseStatus = htmlspecialchars($stat);
    }

    //Getters
    public function getCourseNo()
    {
        global $instance;
        return $instance->escape_string($this->courseNo);
    }
    public function getCourseName()
    {
        global $instance;
        return $instance->escape_string($this->courseName);
    }
    public function getCourseCode()
    {
        global $instance;
        return $instance->escape_string($this->courseCode);
    }
    public function getUserNo()
    {
        global $instance;
        return $instance->escape_string($this->userNo);
    }
    public function getStartAt()
    {
        global $instance;
        return $instance->escape_string($this->startAt);
    }
    public function getEndAt()
    {
        global $instance;
        return $instance->escape_string($this->endAt);
    }
    public function getCoursePrice()
    {
        global $instance;
        return $instance->escape_string($this->coursePrice);
    }
    public function getCourseStatus()
    {
        global $instance;
        return $instance->escape_string($this->courseStatus);
    }

    public function checkCourseCode()
    {
        global $instance;
        $query = "CALL STCMSCheckCourseCode('" . $this->getCourseCode() . "')";
        $result = $instance->getOneRow($query);
        return $result;
    }

    public function addCourse()
    {
        global $instance;
        $query = "CALL STCMSAddCourse('" . $this->getCourseName() . "','" . $this->getCourseCode() . "',
            '" . $this->getUserNo() . "','" . $this->getStartAt() . "', '" . $this->getEndAt() . "',
            '" . $this->getCoursePrice() . "', '" . $this->getCourseStatus() . "', @courseNo)";
        $instance->store($query);
        $sql = "SELECT @courseNo AS courseNo";
        $result = $instance->getOneRow($sql);
        $this->setCourseNo($result["courseNo"]);
        if ($this->getCourseNo() > 0) {
            return $this->getCourseNo();
        } else {
            return 0;
        }
    }

    public function getAllCourses()
    {
        global $instance;
        $query = "CALL STCMSGetAllCourses()";
        $result = $instance->getMultipleRows($query);
        return $result;
    }

    public function getActiveCourses()
    {
        global $instance;
        $query = "CALL STCMSGetActiveCourses('" . $this->getCourseStatus() . "')";
        $result = $instance->getMultipleRows($query);
        return $result;
    }

    public function getEnrollmentTotalPayment($enrollNo)
    {
        global $instance;
        $query = "CALL STCMSGetEnrollmentTotalPayment('" . $enrollNo . "')";
        $result = $instance->getOneRow($query);
        return $result;
    }

    public function payCourse($enroll, $doneBy, $monta)
    {
        global $instance;
        $query = "CALL STCMSAddPayment('" . $enroll . "','" . $doneBy . "', '" . $monta . "', @payNo)";
        $instance->store($query);
        $sql = "SELECT @payNo AS payNo";
        $result = $instance->getOneRow($sql);
        if ($result["payNo"] > 0) {
            $result["payNo"];
        } else {
            return 0;
        }
    }

    public function changeCourseStatus()
    {
        global $instance;
        $query = "CALL STCMSChangeCourseStatus('" . $this->getCourseNo() . "', '" . $this->getCourseStatus() . "')";
        $result = $instance->update($query);
        return $result;
    }

    public function getCourse()
    {
        global $instance;
        $query = "CALL STCMSGetCourse('" . $this->getCourseNo() . "')";
        $result = $instance->getOneRow($query);
        return $result;
    }

    public function updateCourse()
    {
        global $instance;
        $query = "CALL STCMSUpdateCourse('" . $this->getCourseNo() . "', '" . $this->getCourseName() . "', '" . $this->getCourseCode() . "', '" . $this->getUserNo() . "', '" . $this->getStartAt() . "', '" . $this->getEndAt() . "', '" . $this->getCoursePrice() . "')";
        $result = $instance->update($query);
        return $result;
    }
}
