<?php
header("X-Frame-Options: DENY");
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/auth/user-session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/admin_class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/constants.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/stcmwa/classes/setting_class.php';

$setting = new Setting;
$admin = new AdministratorUser;
$msg = "";

if ($_SESSION["urole"] != ADMINISTRATOR) {
    $setting->redirect("users/dashboard");
}
$users = $admin->getAllUsers();

if (isset($_POST["userToSuspend"])) {
    $admin->setUserNo(trim($_POST["userToSuspend"]));
    $admin->setAccountStatus(BLOCKED);
    if ($admin->changeUserAccountStatus()) {
        $users = $admin->getAllUsers();
        $msg = "<p class=\"alert alert-success text-center\">User's account suspended successfully.</p>";
    }
} else if (isset($_POST["userToActivate"])) {
    $admin->setUserNo(trim($_POST["userToActivate"]));
    $admin->setAccountStatus(ACTIVE);
    if ($admin->changeUserAccountStatus()) {
        $users = $admin->getAllUsers();
        $msg = "<p class=\"alert alert-success text-center\">User's account activated successfully.</p>";
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
    <title><?php echo $setting->getSiteName()  ?> || Registered Users</title>
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
                <li class="breadcrumb-item"><a class="text-info" href="<?php echo $setting->getUrl() ?>users/users" style="text-decoration: none;">Registered Users</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-3 pt-3" style="max-height: 450px;overflow: scroll;">
                <span><?php echo $msg; ?></span>
                <table class="table table-hover table-bordered" id="usersTable">
                    <thead class="bg-info text-light">
                        <tr>
                            <th> # </th>
                            <th> User Names</th>
                            <th> User Email </th>
                            <th> User Type / Role</th>
                            <th> Account Status</th>
                            <th> Registered At</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <?php
                        if (empty($users)) {
                        ?>
                            <tr>
                                <td colspan="7" class="text-center text-danger">There is no user registered yet.</td>
                            </tr>
                            <?php
                        } else {
                            $counter = 1;
                            foreach ($users as $key) {
                            ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $key["firstName"] . " " . $key["lastName"]; ?></td>
                                    <td><?php echo $key["email"]; ?></td>
                                    <?php
                                    if ($key["roleNo"] == ADMINISTRATOR) {
                                    ?>
                                        <td><?php echo ADMINISTRATOR_STRING ?></td>
                                    <?php
                                    } else if ($key["roleNo"] == ACCOUNTANT) {
                                    ?>
                                        <td><?php echo ACCOUNTANT_STRING ?></td>
                                    <?php
                                    } else {
                                    ?>
                                        <td><?php echo TRAINEE_STRING ?></td>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $date = date_format(date_create($key["createdAt"]), "d/m/Y");
                                    if ($key["accountStatus"] == ACTIVE) {
                                    ?>
                                        <td><?php echo ACTIVE_STRING ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td>
                                            <button type="submit" data-user="<?php echo $key["userNo"] ?>" class="btn btn-sm btn-danger btn-supsend" <?php echo $key["userNo"] == $_SESSION["uid"] ? "disabled" : ""; ?>><i class="fa fa-trash"></i>Suspend</button>
                                        </td>
                                    <?php
                                    } else {
                                    ?>
                                        <td><?php echo BLOCKED_STRING ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td>
                                            <button type="submit" data-user="<?php echo $key["userNo"] ?>" class="btn btn-sm btn-success btn-activate" <?php echo $key["userNo"] == $_SESSION["uid"] ? "disabled" : ""; ?>><i class="fa fa-check-circle"></i>Activate</button>
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
    </main>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/dashboard.js"></script>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $setting->getUrl() ?>scripts/users.js"></script>
</body>

</html>