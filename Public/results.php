<?php
$raceId = (int)$_GET['raceId'];
$race = $raceId - 1;
require_once "../Private/config.php";
$raceResults = apiManager::checkRace($raceId);
// var_dump($raceResults);
if (!$raceResults) {
    $results = apiManager::getRaces(2023, $raceId);
    // var_dump($results);
    if ($results) {
        $lastRace = races::get_last_race();
        foreach ($results as $r) {
            $driverId = $r->number;
            $finished = $r->position;
            $points = $r->points;
            apiManager::addToDB($driverId, $raceId, $finished, $points);
        }
    } else {
        header('location: races.php');
    }


}
$raceInfo = races::get_race_info_by_id($raceId);
// var_dump($raceInfo);
$raceInfoByName = raceresults::get_race_info($raceInfo[0]->circuitName);
// var_dump($raceInfoByName);
$countryId = $raceInfoByName->circuitCountryId;
$result = races::get_race_info($raceId);

$country = circuits::get_circuit_country($countryId)[0]->countryName;
$raceResult = apiManager::getLastRace($raceId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="./css/results.css">
    <?php require_once "./head.php" ?>
</head>

<body>
<?php require_once "../Public/includes/menu.php"; ?>
<div class="infoField">
    <div class="row">
        <h1>Resultaten van de laatste race:</h1>
        <div class="column" style="display: flex; width: 95%;
    margin-top: 20px;
    margin-bottom:20px;;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-around;">
            <?php
            $aankomenderace = races::get_race_circuits();
            $lastRace = races::get_last_race();
            $imgpath = "header.avif";
            $circuitLayout = "imgnotfound.png";
            $circuit = $raceInfoByName->circuitName;

            $imgtypes = ['png', 'jpg', 'avif', 'jpeg', 'gif', 'raw'];
            foreach ($imgtypes as $imgtype) {
                if (file_exists("./includes/images/$circuit.$imgtype")) {
                    $circuitLayout = $circuit . '.' . $imgtype;
                    break;
                }
                // var_dump($circuitLayout);
                // var_dump($raceInfo[0]->circuitName);
            }
            echo "<img src='./includes/Images/$circuitLayout' style='width: 400px; display: inline;     object-fit: contain;
            '>";
            ?>
            <div id="textField" style="width: 500px;">
                <h2 style="font-weight: 600; display: inline;">Circuit name:</h2>
                <h3 style="display: inline;"><?php echo $raceInfoByName->circuitName; ?></h3><br/>
                <h2 style="font-weight: 600; display: inline;">Circuit laps: </h2>
                <h3 style="display: inline;"><?php echo $raceInfoByName->circuitsLaps; ?></h3><br/>
                <h2 style="font-weight: 600; display: inline;">Circuit Lengte: </h2>
                <h3 style="display: inline;"><?php echo $raceInfoByName->circuitsLengte ?></h3><br/>
                <h2 style="font-weight: 600; display: inline;">Snelste Ronde: </h2>
                <h3 style="display: inline;"><?php echo $raceInfoByName->circuitsMin ?></h3> <br/>
                <h2 style="font-weight: 600; display: inline;">Circuit Locatie: </h2>
                <h3 style="display: inline;"><?php echo $country ?></h3> <br/>
                <h2 style="font-weight: 600; display: inline;">Race Datum: </h2>
                <h3 style="display: inline;"><?php $datetime = date_create($result->raceDate);
                        $date = date_format($datetime, 'G:i d-m-Y');
                        echo $date; ?></h3>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="column">
                <?php
                for ($i = 0; $i < 10; $i++) {
                    $positie = $raceResult[$i]->resultFinishedPosition;
                    $name = $raceResult[$i]->driverName;
                    $points = $raceResult[$i]->resultPoints;
                    echo "<h3>$positie. $name - Punten: $points</h3>";
                    echo "<hr class='solid'>";
                }
                ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="column">
                <?php
                for ($i = 10; $i < 20; $i++) {
                    $positie = $raceResult[$i]->resultFinishedPosition;
                    $name = $raceResult[$i]->driverName;
                    $points = $raceResult[$i]->resultPoints;
                    echo "<h3>$positie. $name - Punten: $points</h3>";
                    echo "<hr class='solid'>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php require_once "../Public/includes/footer.php"; ?>
</body>

</html>