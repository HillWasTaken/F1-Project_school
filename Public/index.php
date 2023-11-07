<?php
require "../Private/config.php";
$results = raceresults::get_standen();
$aankomenderace = races::get_race_circuits();
// var_dump($aankomenderace->raceId);
$points = drivers::getDriverPoints();
//var_dump($points);
$date = apiManager::checkLastRace($aankomenderace->raceId);
$imgpath = "header.avif";
$imgpath2 = "imgnotfound.png";

$imgtypes = ['png', 'jpg', 'avif', 'jpeg', 'gif', 'raw'];
foreach ($imgtypes as $imgtype) {
    if (file_exists("./img/circuit/$aankomenderace->circuitName.$imgtype")) {
        $imgpath = $aankomenderace->circuitName . '.' . $imgtype;
    }

    if (file_exists("./includes/images/$aankomenderace->circuitName.$imgtype")) {
        $imgpath2 = $aankomenderace->circuitName . '.' . $imgtype;
    }
}

?>
<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<?php require_once 'includes/menu.php' ?>
<div id="cover">
    <a href="./race.php?id=<?php echo "$aankomenderace->raceId"; ?>">
        <img id="cover-image" src="./img/circuit/<?php echo $imgpath ?>" alt="">
        <h2 id="cover-text" class="rounded_corners">Coming race - <?php echo $aankomenderace->raceName ?></h2>
    </a>
</div>
<container class="flex-row d-flex justify-content-around flex-wrap container">
    <div class="coureur rounded_corner rounded_corners">
        <h1 class="text-center" style="padding: 0 50px 0 0;">Driver Standings</h1>
        <table style="width: 100%;">
            <thead>
            <tr>
                <th>Name:</th>
                <th>Point:</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($points as $p) {
                $name = substr($p->Driver->givenName, 0, 1) . ". " . $p->Driver->familyName;
                echo "
                    <tr>
                        <td>$name</td>
                        <td>$p->points</td>
                    </tr>
                ";
            } 
            ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4 mt-lg-0 right-container rounded_corners rounded_corners">
        <div class="right-div rounded_corner rounded_corners ">
            <h1 class="text-center">Information next race</h1>
            <div class="d-flex flex-row justify-content-between rounded_corners" style="margin-top: 20px">
                <div>
                    <?php
                    echo "<h3>$aankomenderace->circuitsLaps Laps</h3>
                    <h3>$aankomenderace->circuitsLengte</h3>
                    <h3>$aankomenderace->circuitsMin MINS</h3>"
                    ?>
                </div>
                <?php
                echo "<img class=\"img\" height='200px' width='300px' src=\"./includes/images/$imgpath2\">";
                ?>
            </div>
        </div>
        <div class="right-div rounded_corner rounded_corners">
            <h1 class="text-center">Information about predicting a race </h1>
            <h5>
            "F1 Predict" is an official prediction game of Formula 1 where you can participate for free. You can make predictions for various aspects of F1 races, such as the pole position, the winner, and the podium. Compare your performance with other participants and see your position in the standings. It's a fun way to test your prediction skills and enhance the excitement of Formula 1.
            </h5>
        </div>
    </div>
</container>
<?php require_once "includes/footer.php"; ?>
</body>