<?php

/**
 * Trainee class
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/user_class.php';
class Trainee extends AppUser
{
    public function enrollCourse($course)
    {
        global $instance;
        $query = "CALL STCMSEnrollCourse('" . $this->getUserNo() . "','" . $course->getCourseNo() . "',
            '" . $course->getCoursePrice() . "','" . $course->getCourseStatus() . "', @enrollNo)";
        $instance->store($query);
        $sql = "SELECT @enrollNo AS enrollNo";
        $result = $instance->getOneRow($sql);
        if ($result["enrollNo"] > 0) {
            return $result["enrollNo"];
        } else {
            return 0;
        }
    }

    public function checkIfCourseEnrolled($course)
    {
        global $instance;
        $query = "CALL STCMSCheckUserCourseEnroll('" . $this->getUserNo() . "','" . $course->getCourseNo() . "')";
        $result = $instance->getOneRow($query);
        return $result;
    }
}
