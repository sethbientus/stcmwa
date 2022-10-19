<?php
session_start();
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/course_class.php';
$course = new Course;
if (isset($_POST["checkCourseCode"]) && isset($_POST["courseCode"])) {
    $courseInfo = array();
    $course->setCourseCode(trim($_POST["courseCode"]));
    $courseInfo = $course->checkCourseCode();
    if (!empty($courseInfo)) {
        echo "Code Found";
    } else {
        echo "Code Not Found";
    }
} else if (isset($_POST["checkCourseCodeUpdate"]) && isset($_POST["courseCode"])) {
    $courseInfo = array();
    $course->setCourseCode(trim($_POST["courseCode"]));
    $courseInfo = $course->checkCourseCode();
    echo json_encode($courseInfo);
}
