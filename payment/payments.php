<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/accountant_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/course_class.php';

$setting = new Setting;
$accountant = new AccountantUser;
$course = new Course;
$msg = "";
$payments = array();
if ($_SESSION["urole"] == ADMINISTRATOR || $_SESSION["urole"] == ACCOUNTANT) {
    $payments = $accountant->getAllPayments();
} else if ($_SESSION["urole"] == TRAINEE) {
    $accountant->setUserNo($_SESSION["uid"]);
    $payments = $accountant->getTraineePayments();
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
    <title><?php echo $setting->getSiteName()  ?> || All Payments</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>payment/payments" style="text-decoration: none;">Payments</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-3 pt-3" style="max-height: 435px;overflow: scroll;">
                <span><?php echo $msg; ?></span>
                <div id="printable">
                    <table class="table table-hover table-bordered" id="paymentstable">
                        <thead class="bg-info text-light">
                            <tr>
                                <th> # </th>
                                <th> Trainee</th>
                                <th> Course Code </th>
                                <th> Course Name </th>
                                <th> Amount Paid</th>
                                <th> Done By</th>
                                <th> Paid At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (empty($payments)) {
                            ?>
                                <tr>
                                    <td colspan="8" class="text-center text-danger">There is no payments done yet.</td>
                                </tr>
                                <?php
                            } else {
                                $counter = 1;
                                foreach ($payments as $key) {
                                ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo $key["fTrainee"] . " " . $key["lTrainee"]; ?></td>
                                        <td><?php echo $key["courseCode"]; ?></td>
                                        <td><?php echo $key["courseName"]; ?></td>

                                        <td><?php echo $key["amountPaid"]; ?></td>
                                        <td><?php echo $key["fDoneBy"] . " " . $key["lDoneBy"]; ?></td>
                                        <?php
                                        $date = date_format(date_create($key["createdAt"]), "d/m/Y");
                                        ?>
                                        <td><?php echo $date; ?></td>
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
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/payments.js"></script>
</body>

</html>