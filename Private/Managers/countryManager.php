<?php

require_once "Database.php";

class countryManager
{


    /**
     * @return mixed
     */
    public static function getAll()
    {
        global $con;

        $stmt = $con->prepare("SELECT * FROM `countrys` ORDER BY countryName asc");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}