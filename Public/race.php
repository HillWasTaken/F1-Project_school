<?php
require_once "../Private/config.php";
$raceId = $_GET["id"];
//$raceId = 9;
$result = races::get_race_info($raceId);
$circuit = races::extra_race_info($raceId);
$race = races::extra_race_info($raceId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race</title>
    <link rel="stylesheet" href="./css/race.css">
    <!-- <link rel="stylesheet" href="./css/style.css" -->
    <?php require_once "./includes/menu.php"; ?>
</head>

<body>
<div id="infoField">
    <?php
    $aankomenderace = races::get_race_circuits();
    $imgpath = "header.avif";
    $circuitLayout = "";
    $imgtypes = ['png', 'jpg', 'avif', 'jpeg', 'gif', 'raw'];
    foreach ($imgtypes as $imgtype) {
        $circuitname = $race->circuitName;
        //var_dump("$circuitname.$imgtype");
        if (file_exists("./includes/Images/$circuitname.$imgtype")) {
            $circuitLayout = $circuitname . '.' . $imgtype;
            break;
        } else {
            $circuitLayout = "imgnotfound.png";
        }
        //var_dump($circuitLayout);
    }
    // foreach ($imgtypes as $imgtype) {
    //     if (file_exists("./img/circuit/$aankomenderace->circuitName.$imgtype")) {
    //         $imgpath = $aankomenderace->circuitName . '.' . $imgtype;
    //     }
    //     $circuitname = $circuit[0]->circuitName;
    //     if (file_exists("./includes/images/$circuitname . $imgtype")) {
    //         $imgpath2 = $aankomenderace->circuitName . '.' . $imgtype;
    //     }
    // }
    echo "<img src='./includes/images/$circuitLayout' style='width: 400px; display: inline'>";
    ?>
    <div id="textField">
        <h2 style="font-weight: 600; display: inline;">Circuit name:</h2>
        <h3 style="display: inline;"><?php echo $circuit->circuitName; ?></h3> <br>
        <h2 style="font-weight: 600; display: inline;">Circuit laps: </h2>
        <h3 style="display: inline;"><?php echo $circuit->circuitsLaps; ?></h3><br/>
        <h2 style="font-weight: 600; display: inline;">Circuit Lengte: </h2>
        <h3 style="display: inline;"><?php echo $circuit->circuitsLengte ?></h3><br/>
        <h2 style="font-weight: 600; display: inline;">Snelste Ronde: </h2>
        <h3 style="display: inline;"><?php echo $circuit->circuitsMin ?></h3> <br/>
        <h2 style="font-weight: 600; display: inline;">Circuit Locatie: </h2>
        <h3 style="display: inline;"><?php echo $circuit->country ?></h3> <br/>
        <h2 style="font-weight: 600; display: inline;">Race Datum: </h2>
        <h3 style="display: inline;"><?php echo $circuit->raceDate ?></h3>
        <a href="./predictions.php?id=<?php echo $_GET["id"]; ?>" style="text-decoration: none;">
            <button class="standerd-button" style=" margin:0 auto; margin-top: 20px; display:block;">Voorspel nu
            </button>
        </a>
    </div>
</div>
<?php require_once "./includes/footer.php"; ?>
</body>

</html>