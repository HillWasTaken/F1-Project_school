<?php

class apiManager
{
    public static function getRaces($year, $race)
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ergast.com/api/f1/$year/$race/results.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($server_output);
        $info = $obj->MRData->RaceTable->Races[0]->Results;
        return $info;
        // Further processing ...
        // if ($server_output == "OK") {  } else {  }
    }

    public static function getNextRaceNumb()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ergast.com/api/f1/current/last/results.json");
        //curl_setopt($ch, CURLOPT_URL, "http://ergast.com/api/f1/current");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($server_output);
        $info = $obj->MRData->RaceTable->Races[0]->round;
        return $info;
    }

    public static function getTracks($year)
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ergast.com/api/f1/$year/circuits.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($server_output);
        $info = $obj->MRData->CircuitTable->Circuits;
        return $info;
    }

    public static function checkRace($raceId)
    {
        global $con;
        $stmt = $con->prepare("select * from raceresults where resultRaceid = ?");
        $stmt->bindValue(1, $raceId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public static function addToDB($driverId, $raceId, $finished, $points)
    {
        global $con;
        $stmt = $con->prepare("insert into raceresults (resultDriverId, resultRaceid, resultFinishedPosition, resultPoints) values (?, ?, ?, ?);");
        $stmt->bindValue(1, $driverId);
        $stmt->bindValue(2, $raceId);
        $stmt->bindValue(3, $finished);
        $stmt->bindValue(4, $points);
        $stmt->execute();
    }

    public static function checkLastRace($id) {
        global $con;
        $s = $con->prepare("select raceDate from races where raceId = ?;");
        $s->bindValue(1, $id);
        $s->execute();
        $r = $s->fetchObject();
        return $r;
    }

    public static function getLastRace($raceId)
    {
        global $con;
        $stmt = $con->prepare("
            SELECT
                raceresults.raceResultsId,
                drivers.driverName,
                raceresults.resultFinishedPosition,
                raceresults.resultPoints,
                races.raceName
            FROM 
                raceresults
            JOIN 
                races ON resultRaceid = races.raceId
            JOIN
                drivers ON resultDriverId = drivers.driverId where resultRaceid = ?");
        $stmt->bindValue(1, $raceId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
