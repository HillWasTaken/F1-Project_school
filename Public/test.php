<?php
require_once "../Private/config.php";

// $result = apiManager::getLastRace(7);
$result = drivers::getDriverPoints();
//$result = apiManager::getRaces(2023, 7);
//$result = apiManager::checkRace(7);
var_dump($result);
?>