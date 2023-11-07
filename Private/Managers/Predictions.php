<?php

class Predictions
{
    /**
     * @param $prediction
     * @param $raceid
     * @return void
     */
    public static function makePrediction($prediction = null, $raceid = 0)
    {
        if ($prediction) {
            $prodiction1 = false;
            $prodiction2 = false;

            global $con;

            $stmt = $con->prepare("INSERT INTO prediction(predictionPosition, predictionDriver, predictionRaceId) VALUES (?, ?, ?)");

            foreach ($prediction as $item) {
                $prodiction1 = $prodiction1 . ',' . $item['driverId'];
                $prodiction2 = $prodiction2 . ',' . $item['positionId'];
            }
            $stmt->bindvalue(2, $prodiction1);
            $stmt->bindvalue(1, $prodiction2);
            $stmt->bindvalue(3, $raceid);

            $stmt->execute();

            $lastid = $con->lastInsertId();

            $stmt = $con->prepare("INSERT INTO userhasprediction(users_UserId, prediction_predictionId) VALUES (?, ?)");

            $stmt->bindvalue(1, $_SESSION['userid']);
            $stmt->bindvalue(2, $lastid);

            $stmt->execute();

            header('location: races.php');

        }
    }

    /**
     * @param $id
     * @return void
     */
    public static function getPrediction($id = 0)
    {
        if ($id !== 0) {
            global $con;

            $stmt = $con->prepare("SELECT * FROM prediction where predictionId =? ");
            $stmt->bindvalue(1, $id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public static function getuserhasprediction($userId)
    {
        global $con;

        $stmt = $con->prepare("select * from userhasprediction where users_UserId =?");

        $stmt->bindvalue(1, $userId);

        $stmt->execute();

        return $stmt->fetchAll();


    }

    public static function getallpredictinos()
    {
        global $con;

        $stmt = $con->prepare("select * from prediction join userhasprediction on prediction.predictionId = userhasprediction.prediction_predictionId");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


}