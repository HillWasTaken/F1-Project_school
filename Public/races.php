<?php

require_once "../Private/config.php";

$year = 2023;
$race = 7;
$result = apiManager::getRaces($year, $race);
// var_dump($result);
$results = raceresults::get_standen();
$aankomenderace = races::get_race_circuits();
$allRaces = races::getAllRaces();
$imgpath = "header.avif";
$imgtypes = ['jpg', 'png', 'avif', 'jpeg', 'gif', 'raw'];
foreach ($imgtypes as $imgtype) {
    if (file_exists("./img/circuit/$aankomenderace->circuitName.$imgtype")) {
        $imgpath = $aankomenderace->circuitName . '.' . $imgtype;
    }
}
// var_dump($allRaces);
?>

<head>
    <?php require_once 'head.php' ?>
</head>

<body>
<?php require_once './includes/menu.php' ?>
<div id="cover">
    <a href="race.php?id=<?php echo $aankomenderace->raceId ?>">
        <img id="cover-image" src="./img/circuit/<?php echo $imgpath ?>" alt="">
        <h2 id="cover-text" class="rounded_corners">Coming race - <?php echo $aankomenderace->raceName ?></h2>
    </a>
</div>
<div class="container rounded_corners rounded_corners" style=" width: 50%; display: flex; justify-content: center;">
    <div id="coming-races">
        <?php
        foreach ($allRaces as $race) {
            // var_dump($race);
            foreach ($imgtypes as $imgtype) {
                if (file_exists("./includes/Images/$race->circuitName.$imgtype")) {
                    $circuitLayout = $race->circuitName . '.' . $imgtype;
                    break;
                } else {
                    $circuitLayout = "imgnotfound.png";
                }
            }
            ?>

            <div class="right-div rounded_corner rounded_corners coming-race">
                <h3 class="text-center"><?php echo $race->raceName ?></h3>

                <h5>Race start: <?php $datetime = date_create($race->raceDate);
                    $date = date_format($datetime, 'G:i d F Y');
                    echo $date; ?>
                </h5><br/>

                <?php if ($race->raceDate <= Date("Y-m-d H:i:s")) { ?>
                    <h1 style="color: red;">Race over</h1>
                <?php } ?>

                <a href="race.php?id=<?php echo $race->raceId; ?>">
                    <button class="submit" style=" width:150px; margin-right:10px;">Info Race</button>
                </a>

                <?php if ($race->raceDate <= Date("Y-m-d H:i:s")) { ?>
                    <a href="results.php?raceId=<?php echo $race->raceId; ?>">
                        <button style="width: 150px;" class="submit">Results</button>
                    </a>
                <?php } else { ?>
                    <a href="predictions.php?id=<?php echo $race->raceId; ?>">
                        <button style="width: 150px;" class="submit">Predict</button>
                    </a>
                <?php } ?>

                <div id="foto_div" style="display: flex;justify-content: flex-end;">
                    <?php echo "<img class='img' height='200px' width='300px' src=\"./includes/images/$circuitLayout\">"; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php require_once './includes/footer.php'; ?>
</body>