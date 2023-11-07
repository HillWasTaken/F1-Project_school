<?php
require_once "../private/config.php";
require_once "../Public/head.php";

//get user for profile picture
if (isset($_SESSION["userid"])) {
    $dbuser = accountManager::getUser($_SESSION["userid"]);
}

function active($currect_page)
{
    $url_array =  explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if ($currect_page == $url) {
        echo 'active'; //class name in css 
    } else {
        echo 'text-white';
    }
}
?>
<style>
    .profile-img {
        display: block;
        height: 54px;
        width: 54px;
        object-fit: cover;
        border-radius: 50%;
        transform: scale(1.2);
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light color-navbar p-2">
    <div class="w-100 p-2" style="display: flex; justify-content:space-between;">
        <a class="navbar-brand" href="index.php">
            <img src="/includes/Images/f1_logo.svg" width="160" height="40" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active" style="align-self: center;">
                <a class="nav-link text-navbar text-end <?php active('index.php') ?>" href="index.php">Home</a>
            </li>
            <li class="nav-item active" style="align-self: center;">
                <a class="nav-link text-navbar text-end <?php active('races.php') ?>" href="races.php">Race's</a>
            </li>
            <li class="nav-item active" style="align-self: center;">
                <a class="nav-link text-navbar text-end <?php active('predictions.php') ?>" href="predictions.php">Voorspellen</a>
            </li>
            <?php if (isset($_SESSION["isadmin"]) == true) { ?>
                <li class="nav-item active" style="align-self: center;">
                    <a class="nav-link text-navbar text-end <?php active('adminoptions.php') ?>" href="adminoptions.php">Admin opties</a>
                </li>
            <?php } ?>
            <?php if (isset($_SESSION["login"]) == true) { ?>
                <li class="nav-item active" style="align-self: center;">
                    <a class="nav-link text-navbar text-end <?php active('loguit.php') ?>" href="loguit.php">Afmelden</a>
                </li>
            <?php } ?>
            <?php if (!empty($_SESSION["login"])) { ?>
                <li class="nav-item active" style="align-self: center;">
                    <a class="nav-link text-navbar text-end <?php active('account.php') ?>" href="account.php">Account</a>
                </li>
            <?php } else { ?>
                <li class="nav-item active" style="align-self: center;">
                    <a class="nav-link text-navbar text-end <?php active('login_signup.php') ?>" href="login_signup.php">Account</a>
                </li>
            <?php } ?>
            <li class="nav-item active style='align-self: center;'">
                <div class="rounded-circle bg-white border border-white d-none d-lg-block">
                    <?php if (!empty($_SESSION["login"])) { ?>
                        <a class="nav-link text-navbar text-end <?php active('account.php') ?>" href="account.php">
                    <?php } else { ?>
                        <a class="nav-link text-navbar text-end <?php active('login_signup.php') ?>" href="login_signup.php">
                    <?php } ?>

                    <!-- profile photo of the user -->
                    <?php
                    if (isset($dbuser["profilePicturePath"])) {
                        echo "<img class='profile-img d-none d-lg-block' src='" . $dbuser["profilePicturePath"] . "' >";
                    } else {
                        echo "<img class='profile-img d-none d-lg-block' src='includes/Images/acc_image.png' >";
                    }
                    ?>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
