<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/trainee_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';

$setting = new Setting;
$user = new Trainee;
$msg = "";

$userInfo = array();
$user->setUserNo(trim($_SESSION["uid"]));
if (isset($_POST["update"])) {
    if (trim($_POST["firstName"]) != "" && trim($_POST["lastName"]) != "" && trim($_POST["email"]) != "") {
        $user->setFirstName(trim($_POST["firstName"]));
        $user->setLastName(trim($_POST["lastName"]));
        $user->setEmail(trim($_POST["email"]));
        if ($user->updateProfile()) {
            $msg = "<p class='alert alert-success text-center'>Your acoount information updated successfully.</p>";
        } else {
            $msg = "<p class='alert alert-warning text-center'>Something went wrong, Try again later.</p>";
        }
    } else {
        $msg = "<p class='alert alert-warning text-center'>Please, Fill all fields.</p>";
    }
}
$userInfo = $user->getUserInfo();

if (empty($userInfo)) {
    $setting->redirect("users/dashboard");
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
    <title><?php echo $setting->getSiteName()  ?> || Profile</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>users/profile" style="text-decoration: none;">Profile</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-3">
                <form method="POST" id="createAccountForm">
                    <h5 class="pt-2 text-center"><u>Your Profile Information</u></h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-3">
                            <div class="form-group pt-0">
                                <label class="form-label">First Name:</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter First Name" value="<?php echo $userInfo["firstName"] ?>" maxlength="255">
                                <input type="hidden" name="userNoo" id="userNoo" class="form-control" readonly value="<?php echo $userInfo["userNo"] ?>" maxlength="255">
                                <p class="requiredField text-danger d-none" id="firstNameRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Last Name:</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Enter Last Name" value="<?php echo $userInfo["lastName"] ?>" maxlength="255">
                                <p class="requiredField text-danger d-none" id="lastNameRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="<?php echo $userInfo["email"] ?>" maxlength="255">
                                <p class="requiredField text-danger d-none" id="emailRequired"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-3">
                        <p class="text-center"><?php echo $msg; ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 pt-2 mb-3">
                        <button class="btn btn-info col-12" type="submit" name="update" id="update"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
    <script type="module" src="<?php echo $setting->getUrl() ?>scripts/profile.js"></script>
</body>

</html>