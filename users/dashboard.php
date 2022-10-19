<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/admin_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/accountant_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/trainee_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/course_class.php';

$setting = new Setting;
$admin = new AdministratorUser;
$course = new Course;
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
    <title><?php echo $setting->getSiteName()  ?> || Dashboard</title>
</head>

<body class="app sidebar-mini rtl">
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/user-header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/user-side-nav.php';
    ?>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?php echo $setting->getUrl() ?>" style="text-decoration: none;">
                        <i class="fa fa-home fa-lg"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo $setting->getUrl() ?>users/dashboard" style="text-decoration: none;">Dashboard</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <?php
                if ($_SESSION["urole"] == ADMINISTRATOR) {
                ?>
                    <a href="<?php echo $setting->getUrl() ?>users/users" class="col-md-4 col-lg-4 col-xl-4" style="text-decoration: none;" rel="noopener">
                        <div class="col-12">
                            <div class="widget-small primary coloured-icon" style="height: 60px;">
                                <i class="icon fa fa-users fa-1x"></i>
                                <div class="info">
                                    <p class="h6">Registered Users</p>
                                    <?php
                                    echo count($admin->getAllUsers());
                                    ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                }
                ?>
                <?php
                if ($_SESSION["urole"] == ADMINISTRATOR || $_SESSION["urole"] == ACCOUNTANT) {
                ?>
                    <a href="<?php echo $setting->getUrl() ?>course/courses" class="col-md-4 col-lg-4 col-xl-4" style="text-decoration: none;" rel="noopener">
                        <div class="col-12">
                            <div class="widget-small warning coloured-icon" style="height: 60px;">
                                <i class="icon fa fa-book fa-1x"></i>
                                <div class="info">
                                    <p class="h6">Courses</p>
                                    <?php
                                    echo count($course->getAllCourses());
                                    ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                } else if ($_SESSION["urole"] == TRAINEE) {
                ?>
                    <a href="<?php echo $setting->getUrl() ?>enroll/new-enroll" class="col-md-4 col-lg-4 col-xl-4" style="text-decoration: none;" rel="noopener">
                        <div class="col-12">
                            <div class="widget-small warning coloured-icon" style="height: 60px;">
                                <i class="icon fa fa-book fa-1x"></i>
                                <div class="info">
                                    <p class="h6">Courses</p>
                                    <?php
                                    $course->setCourseStatus(ACTIVE);
                                    echo count($course->getActiveCourses());
                                    ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                }
                ?>
                <a href="<?php echo $setting->getUrl() ?>enroll/enrollments" class="col-md-4 col-lg-4 col-xl-4" style="text-decoration: none;" rel="noopener">
                    <div class="col-12">
                        <div class="widget-small info coloured-icon" style="height: 60px;">
                            <i class="icon fa fa-list fa-1x"></i>
                            <div class="info">
                                <p class="h6">Enrollments</p>
                                <?php
                                if ($_SESSION["urole"] == ADMINISTRATOR || $_SESSION["urole"] == ACCOUNTANT) {
                                    echo count($admin->getAllEnrollments());
                                } else if ($_SESSION["urole"] == TRAINEE) {
                                    $admin->setUserNo($_SESSION["uid"]);
                                    echo count($admin->getTraineeEnrollments());
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>
</body>
<script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>

</html>