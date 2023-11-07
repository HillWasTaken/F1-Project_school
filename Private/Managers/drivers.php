<?php

class drivers
{
    /**
     * @return mixed
     */
    public static function getAll()
    {
        global $con;

        $stmt = $con->prepare("SELECT drivers.*, countrys.countryName, teams.teamName FROM drivers INNER JOIN countrys ON drivers.driverCountryId=countrys.countryId INNER JOIN teams ON drivers.driverTeamId = teams.teamId ORDER BY driverPoints DESC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    //remove driver
    public static function removeDriver($removeDriver)
    {
        global $con;
        $stmt = $con->prepare("DELETE FROM drivers WHERE driverId = ?");
        $stmt->bindValue(1, $removeDriver);

        $stmt->execute();
    }


    //add driver

    public static function addDriver($driverName, $driverNumber, $driverPoints, $driverCountry, $driverTeam)
    {
        global $con;

        $stmt = $con->prepare("INSERT INTO drivers(driverName, driverNumber, driverPoints, driverCountryId, driverTeamId) VALUES(?,?,?,?,?)");
        $stmt->bindValue(1, $driverName);
        $stmt->bindValue(2, $driverNumber);
        $stmt->bindValue(3, $driverPoints);
        $stmt->bindValue(4, $driverCountry);
        $stmt->bindValue(5, $driverTeam);
        $stmt->execute();
    }

    //get driver for edit
    public static function getDriverForEdit($driverId)
    {
        global $con;

        $stmt = $con->prepare("SELECT * FROM drivers WHERE driverId = ?");
        $stmt->bindValue(1, $driverId);
        $stmt->execute();

        return $stmt->fetchObject();
    }

    //edit driver
    public static function editDriver($driverName, $driverNumber, $driverPoints, $driverCountry, $driverTeam, $editdriver)
    {
        global $con;

        $stmt = $con->prepare("UPDATE drivers SET driverName=?, driverNumber=?, driverPoints=?, driverCountryId=?, driverTeamId=? WHERE driverId=?");
        $stmt->bindValue(1, $driverName);
        $stmt->bindValue(2, $driverNumber);
        $stmt->bindValue(3, $driverPoints);
        $stmt->bindValue(4, $driverCountry);
        $stmt->bindValue(5, $driverTeam);
        $stmt->bindValue(6, $editdriver);
        $stmt->execute();
    }

    public static function getDriverPoints() {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ergast.com/api/f1/current/last/driverStandings.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($server_output);
        $info = $obj->MRData->StandingsTable->StandingsLists[0]->DriverStandings;
        return $info;
    }
    public static function getDriverPointsDB() {
        
    }

}