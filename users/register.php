<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/accountant_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/notification_class.php';

$setting = new Setting;
$accountant = new AccountantUser;
$notification = new Notification;
$msg = "";

if ($_SESSION["urole"] == TRAINEE) {
    $setting->redirect("users/dashboard");
}

if (isset($_POST["register"])) {
    if (trim($_POST["firstName"]) != "" && trim($_POST["lastName"]) != "" && trim($_POST["email"]) != "" && trim($_POST["userType"]) != "0") {
        $pwd = $accountant->generatePassword();
        $accountant->setFirstName(trim($_POST["firstName"]));
        $accountant->setLastName(trim($_POST["lastName"]));
        $accountant->setEmail(trim($_POST["email"]));
        $accountant->setPassword($pwd);
        $accountant->setRoleNo(trim($_POST["userType"]));
        $accountant->setAccountStatus(ACTIVE);
        if ($accountant->register() > 0) {
            $notification->sendEmailNotification(trim($_POST["firstName"]), trim($_POST["lastName"]), trim($_POST["email"]), $pwd);
            $msg = "<p class='alert alert-success text-center'>User's account created with success, Go and ckeck user email inbox to get user's credentials.</p>";
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
    <title><?php echo $setting->getSiteName()  ?> || New User</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>users/register" style="text-decoration: none;">Add New User</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-3">
                <form method="POST" id="createAccountForm">
                    <h5 class="pt-2 text-center"><u>Register / Add New User</u></h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group pt-0">
                                <label class="form-label">First Name:</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter First Name" maxlength="255">
                                <p class="requiredField text-danger d-none" id="firstNameRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Last Name:</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Enter Last Name" maxlength="255">
                                <p class="requiredField text-danger d-none" id="lastNameRequired"></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group pt-0">
                                <label class="form-label">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" maxlength="255">
                                <p class="requiredField text-danger d-none" id="emailRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">User Type/Role:</label>
                                <select name="userType" id="userType" class="form-control">
                                    <option value="0">-- Select user type role --</option>
                                    <option value="<?php echo TRAINEE ?>">Trainee</option>
                                    <option value="<?php echo ACCOUNTANT ?>">Accountant</option>
                                    <?php
                                    if ($_SESSION["urole"] == ADMINISTRATOR) {
                                    ?>
                                        <option value="<?php echo ADMINISTRATOR ?>">Administrator</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <p class="requiredField text-danger d-none" id="roleRequired"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center"><?php echo $msg; ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 pt-2 mb-3">
                        <button class="btn btn-info col-12" type="submit" name="register" id="register"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
    <script type="module" src="<?php echo $setting->getUrl() ?>scripts/register.js"></script>
</body>

</html>