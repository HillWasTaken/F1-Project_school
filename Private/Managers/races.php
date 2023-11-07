<?php

class races
{
    /**
     * @return mixed
     */
    public static function get_race_circuits()
    {
        global $con;
        $stmt = $con->prepare("Select races.*, circuits.* from races join circuits ON races.raceCircuit=circuits.circuitId WHERE raceDate >= NOW() order by raceId limit 1");

        $stmt->execute();
        return $stmt->fetchObject();
    }

    public static function get_last_race()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ergast.com/api/f1/current/last/circuits.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($server_output);
        $info = $obj->MRData->CircuitTable->Circuits[0]->circuitName;
        //$info = $obj->MRData;
        return $info;
    }

    public static function get_last_race_id()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ergast.com/api/f1/current/last/circuits.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($server_output);
        $info = $obj->MRData->CircuitTable->Circuits;
        //$info = $obj->MRData;
        return $info;
    }

    public static function get_race_info_by_id($raceid)
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ergast.com/api/f1/current/$raceid/circuits.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($server_output);
        $info = $obj->MRData->CircuitTable->Circuits;
        //$info = $obj->MRData;
        return $info;
    }

    public static function get_race_info($raceId)
    {
        global $con;
        $stmt = $con->prepare("select * from races where raceId = ?;");
        $stmt->bindValue(1, $raceId);
        $stmt->execute();
        $result = $stmt->fetchObject();
        return $result;
    }

    public static function extra_race_info($raceId)
    {
        global $con;
        $stmt = $con->prepare("select races.raceId, races.raceName, races.raceDate, circuits.circuitName, circuits.circuitsLaps, circuits.circuitsLengte, circuits.circuitsMin, countrys.countryName as country from races join circuits ON races.raceCircuit=circuits.circuitId join countrys on circuits.circuitCountryId=countrys.countryId where raceId = ?;");
        $stmt->bindValue(1, $raceId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public static function getAllRaces()
    {
        global $con;
        $stmt = $con->prepare("Select races.*, circuits.* from races join circuits ON races.raceCircuit=circuits.circuitId order by raceId");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getRace($id)
    {
        global $con;
        $stmt = $con->prepare("SELECT * FROM races where id = ?");
        $stmt->bindvalue(1, $id);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    //add race
    public static function addRace($raceName, $raceCircuit, $seasonId, $raceDate)
    {
        global $con;

        $stmt = $con->prepare("INSERT INTO races(raceName, raceCircuit, Season_seasonId, raceDate) VALUES(?,?,?,?)");
        $stmt->bindValue(1, $raceName);
        $stmt->bindValue(2, $raceCircuit);
        $stmt->bindValue(3, $seasonId);
        $stmt->bindValue(4, $raceDate);
        $stmt->execute();
    }


    //edit race
    public static function editRace($raceName, $raceCircuit, $Season_seasonId, $raceDate, $raceId)
    {
        global $con;

        $stmt = $con->prepare("UPDATE races SET raceName = ?, raceCircuit = ?, Season_seasonId = ?, raceDate = ? WHERE raceId = ?");
        $stmt->bindValue(1, $raceName);
        $stmt->bindValue(2, $raceCircuit);
        $stmt->bindValue(3, $Season_seasonId);
        $stmt->bindValue(4, $raceDate);
        $stmt->bindValue(5, $raceId);

        $stmt->execute();

    }


    //remove race
    public static function removeRace($removeRace)
    {
        global $con;
        $stmt = $con->prepare("DELETE FROM races WHERE raceId = ?");
        $stmt->bindValue(1, $removeRace);

        $stmt->execute();
    }


    public static function getRaceForEdit($raceId)
    {
        global $con;

        $stmt = $con->prepare("SELECT * FROM races WHERE raceId = ?");
        $stmt->bindValue(1, $raceId);
        $stmt->execute();

        return $stmt->fetchObject();
    }
    public static function getRaceResults($raceId) {
        global $con;

        $s = $con->prepare("select * from raceresults join drivers on raceresults.resultDriverId = drivers.driverId where raceresults.resultRaceId = ?;");
        $s->bindValue(1, $raceId);
        $s->execute();
        $result = $s->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
