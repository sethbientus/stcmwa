<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/start-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';
$setting = new Setting();
if (!isset($_SESSION["uid"]) || !isset($_SESSION["urole"])) {
    $setting->redirect("");
}
