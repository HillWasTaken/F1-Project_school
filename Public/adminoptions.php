<?php
//laad dingen
require "../Private/config.php";
$username = accountManager::getName($_SESSION["userid"]);
if (!isset($_SESSION["userid"]) || !isset($_SESSION['isadmin'])) {
    header("location: login_signup.php");
}
?>

<head>
    <?php require_once 'head.php' ?>
</head>

<body>
<?php require_once 'includes/menu.php' ?>

<div class="admin-welkom-container rounded_corners">


    <div class="admin-welkom rounded_corners">
        <p>
        <h1 style="color: white; text-align: center;">Welcome<h1>
                <?php

                echo "<h1 style='color: white; text-align: center;'>$username<h1>";
                ?>
    </div>
    <img id="admin-image" src="./img/image_7.jpg">

    <div class="tool-select">
        <form method="post" style="margin-bottom: 0px;">
            <button type="submit" class="tool-button" name="tool" value="user">UserTools</button>
            <button type="submit" class="tool-button" name="tool" value="driver">DriverTools</button>
            <button type="submit" class="tool-button" name="tool" value="race">RaceTools</button>
            <button type="submit" class="tool-button" name="tool" value="rank">Rank</button>
        </form>
    </div>



    <!-- admin opties bewerk users/race/drivers -->

    <?php
    if (isset($_POST['tool'])) {
        $selectedTool = $_POST['tool'];

        switch ($selectedTool) {
            case 'user':
                $_SESSION['adminTool'] = "user";
                break;
            case 'driver':
                $_SESSION['adminTool'] = "driver";
                break;
            case 'race':
                $_SESSION['adminTool'] = "race";
                break;
            case 'rank':
                $_SESSION['adminTool'] = "rank";
                break;
            default:
                $_SESSION['adminTool'] = "";
                break;
        }
    }

    if (isset($_SESSION['adminTool'])) {
        switch ($_SESSION['adminTool']) {
            case 'user':
                require_once 'includes/adminTools/userTools.php';
                break;
            case 'driver':
                require_once 'includes/adminTools/driverTools.php';
                break;
            case 'race':
                require_once 'includes/adminTools/raceTools.php';
                break;
            case 'rank':
                require_once 'includes/adminTools/rankTools.php';
                break;
        }
    }

    ?>

    <?php require_once "includes/footer.php"; ?>
</body>