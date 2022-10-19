<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/accountant_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/course_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/notification_class.php';

$setting = new Setting;
$accountant = new AccountantUser;
$course = new Course;
$notification = new Notification;
$msg = "";
$enrollments = array();
if (isset($_POST["enrollToApprove"])) {
    if ($accountant->approveEnrollment(trim($_POST["enrollToApprove"]), APPROVED)) {
        $msg = "<p class=\"alert alert-success text-center\">Trainee course enrollment successfully.</p>";
    } else {
        $msg = "<p class=\"alert alert-warning text-center\">Something went wrong, try again later.</p>";
    }
}
if (isset($_POST["sendNotification"])) {
    $enrollInfo = $course->getEnrollmentTotalPayment(trim($_POST["enrollNoToSend"]));
    if (!empty($enrollInfo)) {
        $notification->sendPaymentNotification(trim($enrollInfo["firstName"]), trim($enrollInfo["lastName"]), trim($enrollInfo["email"]), trim($enrollInfo["courseName"]), trim($enrollInfo["courseCode"]), trim($enrollInfo["amountToPay"]), trim($enrollInfo["paidAmount"]), trim($enrollInfo["amountToPay"] - $enrollInfo["paidAmount"]));
        $accountant->addLastNotificationTime(trim($_POST["enrollNoToSend"]));
        $msg = "<p class='alert alert-success text-center'>Payment notification sent successfully.</p>";
    }
}
if ($_SESSION["urole"] == ADMINISTRATOR || $_SESSION["urole"] == ACCOUNTANT) {
    $enrollments = $accountant->getAllEnrollments();
} else if ($_SESSION["urole"] == TRAINEE) {
    $accountant->setUserNo($_SESSION["uid"]);
    $enrollments = $accountant->getTraineeEnrollments();
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
    <link rel="stylesheet" href="<?php echo $setting->getUrl() ?>styles/datatables.min.css">
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/print.js"> </script>
    <style>
        @media print {
            .un-printable {
                visibility: hidden;
            }
        }
    </style>
    <title><?php echo $setting->getSiteName()  ?> || All Enrollments</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>enroll/enrollments" style="text-decoration: none;">Enrollments</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-3 pt-3" style="max-height: 450px;overflow: scroll;">
                <span><?php echo $msg; ?></span>
                <div id="printable">
                    <table class="table table-hover table-bordered" id="enrollmentsTable">
                        <thead class="bg-info text-light">
                            <tr>
                                <th> # </th>
                                <th> Trainee</th>
                                <th> Course Code </th>
                                <th> Course Name </th>
                                <th> Course Cost(Price)</th>
                                <th> Amount Paid</th>
                                <th> Amount Rest</th>
                                <th> Status</th>
                                <th> EnrolledAt At</th>
                                <?php
                                if ($_SESSION["urole"] == ADMINISTRATOR || $_SESSION["urole"] == ACCOUNTANT) {
                                ?>
                                    <th> Payment Reminded At</th>
                                    <th class="un-printable"> Action</th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody id="enrollmentsTable">
                            <?php
                            if (empty($enrollments)) {
                            ?>
                                <tr>
                                    <td colspan="8" class="text-center text-danger">There is no enrollment done yet.</td>
                                </tr>
                                <?php
                            } else {
                                $counter = 1;
                                foreach ($enrollments as $key) {
                                    $result = $course->getEnrollmentTotalPayment($key["enrollNo"]);
                                    $totalPayment = 0;
                                    if (!empty($result)) {
                                        $totalPayment = $result["paidAmount"];
                                    } else {
                                        $totalPayment = 0;
                                    }
                                    $rest = $key["amountToPay"] - $totalPayment;
                                ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $key["firstName"] . " " . $key["lastName"]; ?></td>
                                        <td><?php echo $key["courseCode"]; ?></td>
                                        <td><?php echo $key["courseName"]; ?></td>
                                        <td><?php echo $key["amountToPay"]; ?></td>
                                        <td><?php echo $totalPayment == "" ? "0" : $totalPayment; ?></td>
                                        <td><?php echo $rest; ?></td>
                                        <?php
                                        $date = date_format(date_create($key["createdAt"]), "d/m/Y");
                                        if ($key["lastNotification"] != "") {
                                            $reminder = date_format(date_create($key["lastNotification"]), "d/m/Y H:i");
                                        } else {
                                            $reminder = "";
                                        }
                                        if ($key["status"] == PENDING) {
                                        ?>
                                            <td><?php echo PENDING_STRING; ?></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><?php echo APPROVED_STRING; ?></td>
                                        <?php
                                        }
                                        ?>
                                        <td><?php echo $date; ?></td>
                                        <?php
                                        if ($_SESSION["urole"] == ADMINISTRATOR || $_SESSION["urole"] == ACCOUNTANT) {
                                        ?>
                                            <td><?php echo $reminder; ?></td>
                                            <td class="un-printable">
                                                <?php
                                                if ($_SESSION["urole"] == ADMINISTRATOR) {
                                                    if ($key["status"] == PENDING) {
                                                ?>
                                                        <button type="submit" data-enrollment="<?php echo $key["enrollNo"] ?>" class="btn btn-sm btn-success btn-approve"><i class="fa fa-check-circle"></i>Approve</button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button type="submit" data-enrollment="<?php echo $key["enrollNo"] ?>" class="btn btn-sm btn-success btn-approve" disabled><i class="fa fa-check-circle"></i>Approved</button>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if ($_SESSION["urole"] == ACCOUNTANT) {
                                                    if ($key["status"] == APPROVED && $rest > 0) {
                                                ?>
                                                        <form action="<?php echo $setting->getUrl() ?>payment/new-payment" method="post">
                                                            <input type="hidden" name="enrollNoToPay" id="enrollNoToPay" class="form-control" readonly value="<?php echo $key["enrollNo"] ?>">
                                                            <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i>Add Payment</button>
                                                        </form>

                                                        <form action="" method="post" class="mt-3">
                                                            <input type="hidden" name="enrollNoToSend" id="enrollNoToSend" class="form-control" readonly value="<?php echo $key["enrollNo"] ?>">
                                                            <button type="submit" class="btn btn-sm btn-info" name="sendNotification"><i class="fa fa-send"></i>Send Notification</button>
                                                        </form>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                            <?php
                                    $counter++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        if ($_SESSION["urole"] != TRAINEE) {
        ?>
            <button class="btn btn-info pl-4 pr-4 btn-sm" id="btnPrint"><i class="fa fa-print pr-2"></i>Print</button>
        <?php } ?>
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/enrollments.js"></script>
</body>

</html>