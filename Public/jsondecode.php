<?php

require_once '../Private/config.php';
// Retrieve the JSON data from the request
$jsonData = file_get_contents('php://input');

// Parse the JSON data into a PHP array
$array = json_decode($jsonData, true);

// Access the array values
Predictions::makePrediction($array, $array[0]['raceId']);

