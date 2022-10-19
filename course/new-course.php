<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/course_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';

$setting = new Setting;
$course = new Course;
$msg = "";

if ($_SESSION["urole"] != ADMINISTRATOR) {
    $setting->redirect("users/dashboard");
}

if (isset($_POST["addCoure"])) {
    if (trim($_POST["courseName"]) != "" && trim($_POST["courseCode"]) != "" && trim($_POST["courseCost"]) != "" && trim($_POST["courseCost"]) != "0" && trim($_POST["courseStartDate"]) != "" && trim($_POST["courseEndDate"]) != "") {
        $course->setCourseName(trim($_POST["courseName"]));
        $course->setCourseCode(trim($_POST["courseCode"]));
        $course->setCoursePrice(trim($_POST["courseCost"]));
        $course->setSatrtAt(trim($_POST["courseStartDate"]));
        $course->setEndAt(trim($_POST["courseEndDate"]));
        $course->setCourseStatus(ACTIVE);
        $course->setUserNo($_SESSION["uid"]);
        if ($course->addCourse() > 0) {
            $msg = "<p class='alert alert-success text-center'>Course added with successfully.</p>";
        } else {
            $msg = "<p class='alert alert-warning text-center'>Something went wrong, Try again later.</p>";
        }
    } else {
        $msg = "<p class='alert alert-warning text-center'>Please, Fill all fields.</p>";
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
    <link rel="stylesheet" href="<?php echo $setting->getUrl() ?>styles/tempusdominus.css">
    <title><?php echo $setting->getSiteName()  ?> || New Course / Module</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>course/new-course" style="text-decoration: none;">Add New Course / Module</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-3">
                <form method="POST" id="createAccountForm">
                    <h5 class="pt-2 text-center"><u>Register / Add New Course</u></h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group pt-0">
                                <label class="form-label">Course Name:</label>
                                <input type="text" name="courseName" id="courseName" class="form-control" placeholder="Enter Course Name" maxlength="255">
                                <p class="requiredField text-danger d-none" id="courseNameRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Course Code:</label>
                                <input type="text" name="courseCode" id="courseCode" class="form-control" placeholder="Enter Course Code" maxlength="255">
                                <p class="requiredField text-danger d-none" id="courseCodeRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Course Cost(Price):</label>
                                <input type="number" name="courseCost" min="1" id="courseCost" class="form-control" placeholder="Enter Cost for course" maxlength="10">
                                <p class="requiredField text-danger d-none" id="courseCostRequired"></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group pt-0">
                                <label class="form-label">Course Start At:</label>
                                <div class="input-group date startDate" id="startDate" data-target-input="nearest">
                                    <input onkeydown="return false;" type="text" id="courseStartDate" name="courseStartDate" class="form-control datetimepicker-input" data-target="#startDate" />
                                    <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <p class="requiredField text-danger d-none" id="startAtRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Course End At:</label>
                                <div class="input-group date endDate" id="endDate" data-target-input="nearest">
                                    <input onkeydown="return false;" type="text" id="courseEndDate" name="courseEndDate" class="form-control datetimepicker-input" data-target="#endDate" />
                                    <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <p class="requiredField text-danger d-none" id="endAtRequired"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center"><?php echo $msg; ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 pt-2 mb-3">
                        <button class="btn btn-info col-12" type="submit" name="addCoure" id="addCoure"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add Course</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/moment.js"></script>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/tempusdominus.js"></script>
    <script type="module" src="<?php echo $setting->getUrl() ?>scripts/add-course.js"></script>
</body>

</html>