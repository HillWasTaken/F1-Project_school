<?php
require_once "Database.php";

class circuits
{
    public static function get_circuit_info($circuitId)
    {
        global $con;
        $stmt = $con->prepare("select * from circuits where circuitId = ?;");
        $stmt->bindValue(1, $circuitId);
        $stmt->execute();
        $result = $stmt->fetchObject();
        return $result;
    }

    public static function get_circuit_country($countryId)
    {
        global $con;
        $stmt = $con->prepare("select * from countrys where countryId = ?");
        $stmt->bindValue(1, $countryId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
//get all circuits
        public static function getAll()
        {
            global $con;

            $stmt = $con->prepare("SELECT * FROM  circuits");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

?>