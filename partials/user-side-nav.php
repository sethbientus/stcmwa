<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <h6 class="app-sidebar__user-name text-light"><?php echo $_SESSION["name"]; ?></h6>
        </div>
    </div>
    <ul class="app-menu">
        <li class="pl-1">
            <a class="app-menu__item h6 font-weight-bold <?php echo basename($_SERVER["REQUEST_URI"]) == 'dashboard.php' || basename($_SERVER["REQUEST_URI"]) == 'dashboard' ? 'active' : '' ?>" href="<?php echo $setting->getUrl() ?>users/dashboard">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li class="pl-1">
            <a class="app-menu__item h6 font-weight-bold <?php echo basename($_SERVER["REQUEST_URI"]) == 'profile.php' || basename($_SERVER["REQUEST_URI"]) == 'profile' ? 'active' : '' ?>" href="<?php echo $setting->getUrl() ?>users/profile">
                <i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">Profile</span>
            </a>
        </li>
        <li class="pl-1">
            <a class="app-menu__item h6 font-weight-bold <?php echo basename($_SERVER["REQUEST_URI"]) == 'change_password.php' || basename($_SERVER["REQUEST_URI"]) == 'change_password' ? 'active' : '' ?>" href="<?php echo $setting->getUrl() ?>users/change_password">
                <i class="app-menu__icon fa fa-undo"></i>
                <span class="app-menu__label">Change Password</span>
            </a>
        </li>
        <?php
        if ($_SESSION["urole"] == ADMINISTRATOR || $_SESSION["urole"] == ACCOUNTANT) {
        ?>
            <li class="treeview pl-1">
                <a class="app-menu__item h6 font-weight-bold <?php echo basename($_SERVER["REQUEST_URI"]) == 'users.php' || basename($_SERVER["REQUEST_URI"]) == 'users' ? 'active' : '' ?> <?php echo basename($_SERVER["REQUEST_URI"]) == 'register.php' || basename($_SERVER["REQUEST_URI"]) == 'register' ? 'active' : '' ?> " href="#" data-toggle="treeview">
                    <i class="app-menu__icon icon fa fa-users fa-1.5x"></i>
                    <span class="app-menu__label">Users</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <?php
                    if ($_SESSION["urole"] == ADMINISTRATOR) {
                    ?>
                        <li>
                            <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>users/users">
                                <i class="fa fa-users pr-2"></i>Users' List
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li>
                        <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>users/register">
                            <i class="fa fa-user-plus pr-2"></i>Regiter User
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview pl-1">
                <a class="app-menu__item h6 font-weight-bold <?php echo basename($_SERVER["REQUEST_URI"]) == 'new-course.php' || basename($_SERVER["REQUEST_URI"]) == 'new-course' ? 'active' : '' ?> <?php echo basename($_SERVER["REQUEST_URI"]) == 'courses.php' || basename($_SERVER["REQUEST_URI"]) == 'courses' ? 'active' : '' ?>" href="#" data-toggle="treeview">
                    <i class="app-menu__icon icon fa fa-book fa-1.5x"></i>
                    <span class="app-menu__label">Courses / Modules</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>course/courses" rel="noopener">
                            <i class="icon fa fa-book"></i> View Modules
                        </a>
                    </li>
                    <?php
                    if ($_SESSION["urole"] == ADMINISTRATOR) {
                    ?>
                        <li>
                            <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>course/new-course">
                                <i class="icon fa fa-plus-square"></i>Add New Module
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
        ?>
        <li class="treeview pl-1">
            <a class="app-menu__item h6 font-weight-bold <?php echo basename($_SERVER["REQUEST_URI"]) == 'new-enroll.php' || basename($_SERVER["REQUEST_URI"]) == 'new-enroll' ? 'active' : '' ?> <?php echo basename($_SERVER["REQUEST_URI"]) == 'enrollments.php' || basename($_SERVER["REQUEST_URI"]) == 'enrollments' ? 'active' : '' ?>" href="#" data-toggle="treeview">
                <i class="app-menu__icon icon fa fa-list fa-1.5x"></i>
                <span class="app-menu__label">Course Enrollment</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <?php
                if ($_SESSION["urole"] == TRAINEE) {
                ?>
                    <li>
                        <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>enroll/new-enroll">
                            <i class="icon fa fa-plus"></i> Enroll on Course
                        </a>
                    </li>
                <?php
                }
                ?>
                <li>
                    <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>enroll/enrollments">
                        <i class="icon fa fa-list"></i> Enrollemts
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview pl-1">
            <a class="app-menu__item h6 font-weight-bold <?php echo basename($_SERVER["REQUEST_URI"]) == 'payments.php' || basename($_SERVER["REQUEST_URI"]) == 'payments' ? 'active' : '' ?>" href="#" data-toggle="treeview">
                <i class="app-menu__icon icon fa fa-money fa-1.5x"></i>
                <span class="app-menu__label">Payments</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <?php
                if ($_SESSION["urole"] == ADMINISTRATOR || $_SESSION["urole"] == ACCOUNTANT) {
                ?>
                    <?php
                    if ($_SESSION["urole"] == ACCOUNTANT) {
                    ?>
                        <li>
                            <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>enroll/enrollments">
                                <i class="icon fa fa-money"></i>New Payment
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li>
                        <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>payment/payments">
                            <i class="icon fa fa-money"></i>Trainees Payments
                        </a>
                    </li>
                <?php
                } else {
                ?>
                    <li>
                        <a class="treeview-item h6" href="<?php echo $setting->getUrl() ?>payment/payments">
                            <i class="icon fa fa-money"></i>Your Payments
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </li>
        <li class="d-none">
            <input type="hidden" class="form-control d-none" value="<?php echo $setting->getUrl() ?>" readonly name="globalLink" id="globalLink" />
        </li>
        <li>
            <div class="form-group pt-0 d-none">
                <input type="hidden" name="userNo" id="userNo" class="form-control d-none" readonly value="<?php echo $_SESSION["uid"] ?>">
            </div>
        </li>
        <li>
            <div class="form-group pt-0 d-none">
                <input type="hidden" name="roleNo" id="roleNo" class="form-control d-none" readonly value="<?php echo $_SESSION["urole"] ?>">
            </div>
        </li>
    </ul>
</aside>