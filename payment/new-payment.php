<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/course_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/notification_class.php';

$setting = new Setting;
$course = new Course;
$notification = new Notification;

if ($_SESSION["urole"] == TRAINEE) {
    $setting->redirect("users/dashboard");
}

$msg = "";
$enrollInfo = array();
$enrollToPay = 0;
if (isset($_POST["payCourse"])) {
    if (trim($_POST["courseCostToPay"]) != "") {
        $enrollToPay = trim($_POST["enrollNoo"]);
        $rest = trim($_POST["courseCost"]) - trim($_POST["coursePaidCost"]) - trim($_POST["courseCostToPay"]);
        if ($course->payCourse(trim($_POST["enrollNoo"]), $_SESSION["uid"], trim($_POST["courseCostToPay"])) > 0) {
        }
        $paid = trim($_POST["coursePaidCost"]) + trim($_POST["courseCostToPay"]);
        $notification->sendPaymentEmailNotification(trim($_POST["fName"]), trim($_POST["lName"]), trim($_POST["email"]), trim($_POST["courseName"]), trim($_POST["courseCode"]), trim($_POST["courseCost"]), trim($paid), trim($rest));
        $msg = "<p class='alert alert-success text-center'>Course Payment done successfully.</p>";
        $enrollInfo = $course->getEnrollmentTotalPayment(trim($_POST["enrollNoo"]));
    } else {
        $setting->redirect("enroll/enrollments");
    }
} else if (isset($_POST["enrollNoToPay"])) {
    $enrollToPay = trim($_POST["enrollNoToPay"]);
    $enrollInfo = $course->getEnrollmentTotalPayment(trim($_POST["enrollNoToPay"]));
    if (empty($enrollInfo)) {
        $setting->redirect("enroll/enrollments");
    }
} else {
    $setting->redirect("enroll/enrollments");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/meta.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/logo.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/user-css.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/user-js.php';
    ?>
    <title><?php echo $setting->getSiteName()  ?> || Pay Course / Module</title>
</head>

<body class="app sidebar-mini rtl">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/user-header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/user-side-nav.php';
    ?>
    <main class="app-content bg-light">
        <div class="app-title">
            <div>
                <h3><i class="fa fa-dashboard pr-3"></i>Dashboard</h3>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a class="text-info" href="<?php echo $setting->getUrl() ?>users/dashboard" style="text-decoration: none;">
                        <i class="fa fa-home fa-lg"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>enroll/enrollments" style="text-decoration: none;">Course / Module Payment</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-3">
                <form method="POST" id="createAccountForm">
                    <h5 class="pt-2 text-center"><u>Add Payment for Course</u></h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group pt-0">
                                <label class="form-label">Course Name:</label>
                                <input type="text" name="courseName" id="courseName" class="form-control" placeholder="Enter Course Name" value="<?php echo $enrollInfo["courseName"] ?>" maxlength="255" readonly>
                                <input type="hidden" name="enrollNoo" id="enrollNoo" class="form-control d-none" value="<?php echo $enrollToPay ?>" maxlength="255" readonly>
                                <input type="hidden" name="fName" id="fName" class="form-control d-none" value="<?php echo $enrollInfo["firstName"] ?>" maxlength="255" readonly>
                                <input type="hidden" name="lName" id="lastName" class="form-control d-none" value="<?php echo $enrollInfo["lastName"] ?>" maxlength="255" readonly>
                                <input type="hidden" name="email" id="email" class="form-control d-none" value="<?php echo $enrollInfo["email"] ?>" maxlength="255" readonly>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Course Code:</label>
                                <input type="text" name="courseCode" id="courseCode" class="form-control" placeholder="Enter Course Code" maxlength="255" readonly value="<?php echo $enrollInfo["courseCode"] ?>">
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Course Cost(Price):</label>
                                <input type="number" name="courseCost" min="1" id="courseCost" class="form-control" placeholder="Enter Cost for course" maxlength="10" readonly value="<?php echo $enrollInfo["amountToPay"] ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group pt-0">
                                <label class="form-label">Amount Paid:</label>
                                <input type="number" name="coursePaidCost" min="1" id="coursePaidCost" class="form-control" placeholder="Amount Paid" maxlength="10" readonly value="<?php echo $enrollInfo["paidAmount"] == "" ? "0" : $enrollInfo["paidAmount"] ?>">
                            </div>
                            <div class=" form-group pt-0">
                                <label class="form-label">Amount Rest:</label>
                                <input type="number" name="courseUnPaidCost" min="1" id="courseUnPaidCost" class="form-control" placeholder="Amount Rest to pai" maxlength="10" readonly value="<?php echo $enrollInfo["amountToPay"] - $enrollInfo["paidAmount"] ?>">
                            </div>
                            <div class=" form-group pt-0">
                                <label class="form-label">Amount To Pay:</label>
                                <input type="number" name="courseCostToPay" min="1" id="courseCostToPay" class="form-control" placeholder="Enter amount to pay" maxlength="10">
                                <p class="requiredField text-danger d-none" id="amountToPayRequired"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center"><?php echo $msg; ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 pt-2 mb-3">
                        <button class="btn btn-info col-12" type="submit" name="payCourse" id="payCourse"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
    <script type="module" src="<?php echo $setting->getUrl() ?>scripts/add-payment.js"></script>
</body>

</html>