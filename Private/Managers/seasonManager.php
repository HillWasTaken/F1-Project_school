<?php

class seasonManager
{

    //get season
    public static function getAll()
    {
        global $con;

        $stmt = $con->prepare("SELECT * FROM season");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
