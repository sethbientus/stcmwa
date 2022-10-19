<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/course_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/trainee_class.php';

$setting = new Setting;
$course = new Course;
$trainee = new Trainee;
$msg = "";
if ($_SESSION["urole"] != TRAINEE) {
    $setting->redirect("users/dashboard");
}
$course->setCourseStatus(ACTIVE);
$courses = $course->getActiveCourses();

if (isset($_POST["btn_enroll"])) {
    $trainee->setUserNo(trim($_SESSION["uid"]));
    $course->setCourseNo(trim($_POST["courseNo"]));
    $course->setCoursePrice(trim($_POST["amount"]));
    $course->setCourseStatus(PENDING);
    if ($trainee->enrollCourse($course)) {
        $course->setCourseStatus(ACTIVE);
        $courses = $course->getActiveCourses();
        $msg = "<p class=\"alert alert-success text-center\">You have enrolled on the course successfully, Please wait for administrator to approve it.</p>";
    }
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
    <title><?php echo $setting->getSiteName()  ?> || Enroll on Course</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>enroll/new-enroll" style="text-decoration: none;">Course Enroll</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-3 pt-3" style="max-height: 450px;overflow: scroll;">
                <span><?php echo $msg; ?></span>
                <div class="row">
                    <?php
                    foreach ($courses as $key) {
                        $trainee->setUserNo($_SESSION["uid"]);
                        $course->setCourseNo(trim($key["courseNo"]));
                        $result = $trainee->checkIfCourseEnrolled($course);
                        $isEnrolled = false;
                        if (!empty($result)) {
                            $isEnrolled = true;
                        }
                    ?>
                        <div class="col-lg-12 col-xl-12 mt-2">
                            <div class="p-4 border border-info" style="background-color: #ffffff;">
                                <address>
                                    <p class="h4 font-weight-bold" style="color: black;">Course: <?php echo $key["courseName"]; ?></p>
                                    <p class="h6">Course Code: <?php echo $key["courseCode"]; ?></p>
                                    <p class="h6">Course Price(Cost): <?php echo $key["coursePrice"]; ?></p>
                                    <p class="h6"><i class="fa fa-calendar pr-2" aria-hidden="true"></i>Start at: <?php echo date_format(date_create($key["startAt"]), "M, d , Y"); ?></p>
                                    <p class="h6"><i class="fa fa-clock-o pr-2" aria-hidden="true"></i> End At: <?php echo date_format(date_create($key["endAt"]), "M, d , Y"); ?></p>
                                </address>
                                <?php
                                $endAt = date_format(date_create($key["endAt"]), "Y-m-d");
                                $today = date_format(date_create(date("Y-m-d")), "Y-m-d");
                                $result = new DateTime($today) > new DateTime($endAt);
                                ?>
                                <form method="POST" action="" class="mb-2">
                                    <input type="hidden" name="courseNo" class="form-control d-none" value="<?php echo ($key["courseNo"]) ?>" readonly>
                                    <input type="hidden" name="amount" class="form-control d-none" value="<?php echo ($key["coursePrice"]) ?>" readonly>
                                    <?php
                                    if ($isEnrolled) {
                                    ?>
                                        <button type="submit" class="btn btn-sm btn-success border text-light font-weight-bold col-xs-6 col-sm-4 col-md-4 col-lg-3 col-xl-3" disabled>Enrolled</button>
                                        <?php } else {
                                        if ($result) {
                                        ?>
                                            <button type="button" class="btn btn-sm btn-danger border text-light font-weight-bold col-xs-6 col-sm-4 col-md-4 col-lg-3 disabled col-xl-3" name="btn_enroll">Course Ended</button>
                                        <?php
                                        } else {
                                        ?>

                                            <button type="submit" class="btn btn-sm btn-info border text-light font-weight-bold col-xs-6 col-sm-4 col-md-4 col-lg-3 col-xl-3" name="btn_enroll">Enroll</button>
                                    <?php }
                                    } ?>
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
</body>

</html>