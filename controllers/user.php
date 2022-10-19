<?php
session_start();
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/trainee_class.php';
$user = new Trainee;
if (isset($_POST["checkUserEmail"]) and isset($_POST["email"])) {
    $userInfo = array();
    $user->setEmail(trim($_POST["email"]));
    $userInfo = $user->checkUserEmail();
    if (!empty($userInfo)) {
        echo "Email Found";
    } else {
        echo "Email Not Found";
    }
} else if (isset($_POST["checkUserEmailUpdate"]) && isset($_POST["email"])) {
    $userInfo = array();
    $user->setEmail(trim($_POST["email"]));
    $userInfo = $user->checkUserEmail();
    echo json_encode($userInfo);
}
