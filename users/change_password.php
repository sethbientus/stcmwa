<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/trainee_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';

$setting = new Setting;
$user = new Trainee;
$msg = "";

if (isset($_POST["changePassword"])) {
    if (trim($_POST["oldPassword"]) != "" && trim($_POST["newPassword"]) != "" && trim($_POST["reNewPassword"]) != "") {
        if (trim($_POST["newPassword"]) == trim($_POST["reNewPassword"])) {
            if (trim($_POST["oldPassword"]) != trim($_POST["newPassword"])) {
                $user->setUserNo(trim($_SESSION["uid"]));
                $userInfo = $user->getUserInfo();
                if (!empty($userInfo)) {
                    if ($user->checkPassword(trim($_POST["oldPassword"]), $userInfo["password"])) {
                        $user->setPassword(trim($_POST["newPassword"]));
                        if ($user->changePassword()) {
                            $msg = "<p class='text-success text-center'>Your Password changed successfully.</p>";
                        } else {
                            $msg = "<p class='text-warning text-center'>Something went wrong, try again later.</p>";
                        }
                    } else {
                        $msg = "<p class='text-text text-center'>Old Password is incorrect.</p>";
                    }
                } else {
                    $setting->redirect("users/dashboard");
                }
            } else {
                $msg = "<p class='alert alert-warning text-center'>New Passwords must be different to old password.</p>";
            }
        } else {
            $msg = "<p class='alert alert-warning text-center'>New Passwords do no match.</p>";
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
    <title><?php echo $setting->getSiteName()  ?> || Change Password</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>users/change_password" style="text-decoration: none;">Change Password</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pt-3">
                <form method="POST" id="createAccountForm">
                    <h5 class="pt-2 text-center"><u>Change Password</u></h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-6 offset-md-1 offset-lg-2 offset-xl-3">
                            <div class="form-group pt-0">
                                <div class="form-group pt-0">
                                    <label class="form-label">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" readonly value="<?php echo $_SESSION["uemail"] ?>" maxlength="255">
                                    <p class="requiredField text-danger d-none" id="emailRequired"></p>
                                </div>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Old Password:</label>
                                <div class="input-group mb-3">
                                    <input type="password" name="oldPassword" id="oldPassword" class="form-control" placeholder="Enter Old Password">
                                    <div class="input-group-append showOldPwd" id="showOldPwd" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fa fa-eye" id="showOldPwdEye"></i></span>
                                    </div>
                                </div>
                                <p class="requiredField text-danger d-none" id="oldPwdRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">New Password:</label>
                                <div class="input-group mb-3">
                                    <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="Enter New Password">
                                    <div class="input-group-append showNewPwd" id="showNewPwd" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fa fa-eye" id="showNewPwdEye"></i></span>
                                    </div>
                                </div>
                                <p class="requiredField text-danger d-none" id="newPwdRequired"></p>
                            </div>
                            <div class="form-group pt-0">
                                <label class="form-label">Confirm Password:</label>
                                <div class="input-group mb-3">
                                    <input type="password" name="reNewPassword" id="reNewPassword" class="form-control" placeholder="Re-enter New Password">
                                    <div class="input-group-append showReNewPwd" id="showReNewPwd" style="cursor: pointer;">
                                        <span class="input-group-text"><i class="fa fa-eye" id="showReNewPwdEye"></i></span>
                                    </div>
                                </div>
                                <p class="requiredField text-danger d-none" id="reNewPwdRequired"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center"><?php echo $msg; ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 offset-md-4 offset-lg-4 offset-xl-4 pt-2 mb-3">
                        <button class="btn btn-info col-12" type="submit" name="changePassword" id="changePassword"><i class="fa fa-fw fa-lg fa-check-circle"></i>Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
    <script type="module" src="<?php echo $setting->getUrl() ?>scripts/change-password.js"></script>
</body>

</html>