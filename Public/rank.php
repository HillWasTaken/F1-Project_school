<?php
//A=10-(abs(p-r)+(abs(p-r)>=1)x2); p = prediction, r = result, A = punten per driver.
require_once "../Private/config.php";
$results = Predictions::getallpredictinos();
$raceid = apiManager::getNextRaceNumb();
$race = races::getRaceResults($raceid);
$r = [];
$resultArray = [];
foreach($race as $k) {
    array_push($r, intval($k->resultDriverId));
}
foreach($results as $result){
    
    $driverIdsArray = explode(',', $result->predictionDriver);
    $positionsArray = explode(',', $result->predictionPosition);

    for ($i = 0; $i <count($driverIdsArray); $i++) {
        $driverId = intval($driverIdsArray[$i]);
        $position = intval($positionsArray[$i]);

        $resultArray[$position] = $driverId;
    }

    var_dump($resultArray);
}
var_dump($r);
foreach($r as $r) {
    foreach($resultArray as $p) {
        echo $p . " " . $r;
    }
}
?>