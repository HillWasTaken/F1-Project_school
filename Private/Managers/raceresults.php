<?php

class raceresults
{
    /**
     * @param int $aantal
     * @return mixed
     */
    public static function get_standen(int $aantal = 10)
    {
        global $con;
        $stmt = $con->prepare("SELECT driverName, driverPoints FROM drivers order by driverPoints desc;");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function get_race_info($raceName)
    {
        global $con;
        $stmt = $con->prepare("select * from circuits where circuitName = ?;");
        $stmt->bindValue(1, $raceName);
        $stmt->execute();
        $result = $stmt->fetchObject();
        return $result;
    }
}