<?php
$lastRace = races::get_race_circuits();
$raceId = $lastRace->raceId;
//var_dump($lastRace);
?>
<footer style="
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    align-content: center;
    align-items: center;
    display:flex ;
    justify-content: space-around;">

    <container style="height: 100%; width: 80%;">
        <div id="container" style="display: flex; align-items: center;  ">
            <img width="75px" src="https://www.gran-turismo.com/gtsport/decal/4899991239217120768_1.png" alt="">
            <h3 style="color: white; display: inline; margin:0; font-weight: 600;">F1 group project</h3>
        </div>
        <div style="color: white; width: 50%; height: 70%; display: inline; float: left; padding: 30px 0 0 30px;">
            <?php echo "<a href='results.php?raceId=$raceId' class='footerText' style='display: block;'>Results</a>"; ?>
            <!-- <a href="results.php?raceId=$raceId" class="footerText" style="display: block;">Results</a> -->
            <a href="races.php" class="footerText" style="display: block;">Races</a>
            <a href="predictions.php" class="footerText" style="display: block;">Predictions</a>
        </div>
        <div style="color: white; width: 50%; height: 70%; float: left; display: inline; padding: 30px 0 0 30px;">
            <?php if (!empty($_SESSION["login"])) { ?>
                <a href="account.php" class="footerText" style="display: block;">Account</a>
                <a href="logout.php" class="footerText" style="display: block;">Logout</a>
            <?php } else { ?>
                <a href="login_signup.php" class="footerText" style="display: block;">Sign up/Log in</a>
            <?php } ?>
        </div>
    </container>
</footer>