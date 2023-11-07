<?php

class teamManager
{


    public static function getAll()
    {
        global $con;

        $stmt = $con->prepare("SELECT * FROM  teams ORDER BY teamName asc");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}


?>