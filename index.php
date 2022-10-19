<?php
ob_start();
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/start-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/trainee_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
$msg = "";
$setting = new Setting;
$trainee = new Trainee;
if (isset($_POST["login"])) {
    $trainee->setEmail(trim($_POST["email"]));
    $userInfo = $trainee->login();
    if (!empty($userInfo)) {
        if ($trainee->checkPassword(trim($_POST["password"]), $userInfo["password"])) {
            if ($userInfo["accountStatus"] == 1) {
                $_SESSION["uid"] = $userInfo["userNo"];
                $_SESSION["uemail"] = $userInfo["email"];
                $_SESSION["urole"] = $userInfo["roleNo"];
                $_SESSION["name"] = $userInfo["firstName"] . " " . $userInfo["lastName"];
                $setting->redirect("users/dashboard");
            } else if ($userInfo["accountStatus"] == BLOCKED) {
                $msg = "<p class='alert alert-danger text-center mt-2'>Your account has been suspended.</p>";
            }
        } else {
            $msg = "<p class='alert alert-danger text-center mt-2'>Incorrect email or password.</p>";
        }
    } else {
        $msg = "<p class='alert alert-danger text-center mt-2'>Incorrect email or password.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/meta.php' ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/logo.php' ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/css.php' ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/partials/js.php' ?>
    <title><?php echo $setting->getSiteName() ?> || Sign in</title>
</head>

<body class="" style="background-color: #f5f7fb;">
    <div class="row mediaquery mt-5 pt-1">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 mt-5 pt-3">
            <div id="login_form" class="pt-4 pr-5">
                <form method="POST" class="pl-5" action="">
                    <div class="text-center">
                        <h4 class="text-info font-weight-bold">Welcome to STCMS</h4>
                        <p><span class="text-info font-weight-bold">S</span>chool and <span class="text-info font-weight-bold">T</span>raining <span class="text-info font-weight-bold">C</span>enter <span class="text-info font-weight-bold">M</span>anagement <span class="text-info font-weight-bold">S</span>ystem</p>
                    </div>
                    <div class="form-group pt-2">
                        <label>Email:</label>
                        <input type="email" name="email" id="email" class="form-control mt-2" placeholder="Enter email">
                        <p class="required_field text-danger d-none" id="email_required"></p>
                    </div>
                    <div class="form-group pt-1">
                        <label class="form-control-label">Password:</label>
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
                            <div class="input-group-append showPwd" id="showPwd" style="cursor: pointer;">
                                <span class="input-group-text"><i class="fa fa-eye" id="showPwdEye"></i></span>
                            </div>
                        </div>
                        <p class="required_field text-danger d-none" id="password_required"></p>
                    </div>

                    <p class="text-center"><?php echo $msg; ?></p>
                    <button type="submit" name="login" id="login" class="btn btn-info col-xs-10 col-sm-10 col-md-8 col-lg-6 col-xl-6 offset-xs-1 offset-sm-1 offset-md-2 offset-lg-3 offset-xl-3 btn-block mt-4">
                        <i class="fa fa-fw fa-sign-in pr-1 text-white" aria-hidden="true"></i>
                        Sign in
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script type="module" src="<?php echo $setting->getUrl() ?>scripts/login.js"></script>
</body>

</html>