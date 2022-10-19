<header class="app-header">
    <a class="app-header__logo" href="<?php echo $setting->getUrl() ?>users/dashboard">
        <span class="font-weight-bold">STCMWA</span>
    </a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <div class="row" style="width: 80%;">
        <form method="POST" class="pl-3 pt-3 offset-xs-2 offset-sm-6 offset-md-9 offset-lg-10 offset-xl-10" id="logoutForm" action="<?php echo $setting->getUrl() ?>auth/logout">
            <input type="hidden" name="signout" id="signout">
            <a class="pt-3 h6" href="#" onclick="logout()" style="text-decoration: none; cursor: pointer; color: white; right: 0">
                <i class="fa fa-sign-out"></i>
                <span class="font-weight-bold">Log out</span>
            </a>
        </form>
    </div>
</header>
<script>
    function logout() {
        document.getElementById("logoutForm").submit();
    }
</script>