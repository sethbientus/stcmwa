<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/course_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';

$setting = new Setting;
$course = new Course;
$msg = "";
if ($_SESSION["urole"] == TRAINEE) {
    $setting->redirect("users/dashboard");
}
if (isset($_POST["courseToRemove"])) {
    $course->setCourseNo(trim($_POST["courseToRemove"]));
    $course->setCourseStatus(BLOCKED);
    if ($course->changeCourseStatus()) {
        $msg = "<p class=\"alert alert-success text-center\">Course removed from the enrollment courses list successfully.</p>";
    } else {
        $msg = "<p class=\"alert alert-warning text-center\">Something went wrong, try again later.</p>";
    }
} else if (isset($_POST["courseToAddBack"])) {
    $course->setCourseNo(trim($_POST["courseToAddBack"]));
    $course->setCourseStatus(ACTIVE);
    if ($course->changeCourseStatus()) {
        $msg = "<p class=\"alert alert-success text-center\">Course added back to the enrollment courses list successfully.</p>";
    } else {
        $msg = "<p class=\"alert alert-warning text-center\">Something went wrong, try again later.</p>";
    }
}
$courses = $course->getAllCourses();
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
    <title><?php echo $setting->getSiteName()  ?> || All Courses</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>course/courses" style="text-decoration: none;">Courses</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-3 pt-3" style="max-height: 450px;overflow: scroll;">
                <span><?php echo $msg; ?></span>
                <table class="table table-hover table-bordered" id="coursesTable">
                    <thead class="bg-info text-light">
                        <tr>
                            <th> # </th>
                            <th> Course Name</th>
                            <th> Course Code </th>
                            <th> Course Cost(Price)</th>
                            <th> Start At</th>
                            <th> End At</th>
                            <th> Added By</th>
                            <th> Added At</th>
                            <?php
                            if ($_SESSION["urole"] == ADMINISTRATOR) {
                            ?>
                                <th> Edit</th>
                                <th> Action</th>
                            <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody id="coursesTableBody">
                        <?php
                        if (empty($courses)) {
                        ?>
                            <tr>
                                <td colspan="8" class="text-center text-danger">There is no course added yet.</td>
                            </tr>
                            <?php
                        } else {
                            $counter = 1;
                            foreach ($courses as $key) {
                            ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $key["courseName"]; ?></td>
                                    <td><?php echo $key["courseCode"]; ?></td>
                                    <td><?php echo $key["coursePrice"]; ?></td>
                                    <td><?php echo $key["startAt"]; ?></td>
                                    <td><?php echo $key["endAt"]; ?></td>
                                    <td><?php echo $key["firstName"] . " " . $key["lastName"]; ?></td>
                                    <td><?php echo date_format(date_create($key["createdAt"]), "d/m/Y"); ?></td>
                                    <?php
                                    $date = date_format(date_create($key["createdAt"]), "d/m/Y");
                                    if ($_SESSION["urole"] == ADMINISTRATOR) {
                                    ?>
                                        <td>
                                            <form action="<?php echo $setting->getUrl() ?>course/edit-course" method="post">
                                                <input type="hidden" name="courseToEdit" id="courseToEdit" class="form-control" readonly value="<?php echo $key["courseNo"] ?>">
                                                <button type="submit" class="btn btn-sm btn-info btn-edit"><i class="fa fa-edit"></i>Edit</button>
                                            </form>
                                        </td>
                                        <?php
                                        if ($key["courseStatus"] == ACTIVE) {
                                        ?>
                                            <td>
                                                <button type="submit" data-course="<?php echo $key["courseNo"] ?>" class="btn btn-sm btn-danger btn-remove"><i class="fa fa-trash"></i>Remove</button>
                                            </td>
                                        <?php
                                        } else {
                                        ?>
                                            <td>
                                                <button type="submit" data-course="<?php echo $key["courseNo"] ?>" class="btn btn-sm btn-info btn-add-back"><i class="fa fa-check-circle"></i>Add back</button>
                                            </td>
                                    <?php
                                        }
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
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/courses.js"></script>
</body>

</html>