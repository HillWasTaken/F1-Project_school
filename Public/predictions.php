<?php
require "../Private/config.php";
$aankomenderace = races::get_race_circuits();
if (!isset($_GET['id'])) {
    header("location: predictions.php?id=$aankomenderace->raceId");
}
$race = races::extra_race_info($_GET['id']);
// var_dump($race);

$currentDate = date('Y-m-d'); // Huidige datum
$raceDate = $race->raceDate; // Datum van de aankomende race
if (isset($raceDate)) {
    if ($raceDate < $currentDate) {

        echo '<script>
                    alert("Race is has already been raced");
                    window.location.href = \'races.php\';
                    </script>';
    }
}
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

$userchecks = Predictions::getuserhasprediction($_SESSION['userid']);
if ($userchecks) {
    foreach ($userchecks as $usercheck) {
        // var_dump($usercheck);
        $racechecks = Predictions::getPrediction($usercheck['prediction_predictionId']);
        if ($racechecks) {
            foreach ($racechecks as $racecheck) {
                if ($racecheck->predictionRaceId == $_GET['id']) {
                    echo '<script>
                    alert("You already have predicted this race");
                    window.location.href = \'races.php\';
                    </script>';
                }
            }
        }


    }
}

$drivers = drivers::getAll();

if (!isset($_GET['id'])) {
    header("location: predictions.php?id=$aankomenderace->raceId");
}
if ($_POST) {
    $elements = $_POST['positions'];
    $elements = explode(',', $elements);
    var_dump($elements);
}

if (!isset($_SESSION["userid"])) {
    header('location: login_signup.php');
}
?>


<head>
    <?php require_once 'head.php' ?>
</head>
<body>
<?php require_once 'includes/menu.php' ?>

<div id="cover">
    <a href="race.php?id=<?php echo $race->raceId ?>">
        <img id="cover-image" src="./img/circuit/<?php echo $imgpath ?>" alt="">
        <h2 id="cover-text" class="rounded_corners">Predicting race - <?php echo $race->raceName ?></h2>
    </a>
</div>

<div class="info">
    <h2 class="tekst-bold">How does it work</h2> <br/>
    <p>
        You can predict the F1 race by dragging the drivers to the right place you think they will finish in. If you
        guess correct you will get 10 points but if you are too far of the position the drivers finished you will get 0
        points.
    </p>
</div>

<div class="info row">
    <h3 style="font-size: medium; text-align: center; font-weight: bold;">Predicting the
        race: <?php echo $race->raceName ?></h3>
    <h2 class="tekst-bold">Positions</h2>
    <p class="paragraph" style="text-align: center; font-size: 20px;font-style:italic;">Drag the driver to the right
        position to earn points</p>
    <div class="col">
        <h6 style="text-align:center; font-weight:bold; font-size:25px;">Position</h6>
        <?php
        $getal = 1;
        while ($getal <= 20) {
            // Check if the position is already assigned to a driver

            echo "<div class='d-flex flex-row'>";
            echo "<h5 style='margin-right: 1px;'>$getal. </h5>";
            echo "<div id='pos$getal' ondrop='drop(event)'' ondragover='allowDrop(event)' style='width: 100%;height: 30px;border: 1px solid #aaaaaa;padding: 4px;padding-left: 5px; background-color:white; border-radius:10px;' class='inputprediction'></div>";
            echo "</div>";

            $getal++;
        }
        ?>
    </div>
    <div class="col">
        <h6 style="text-align:center; font-weight:bold; font-size:25px;">Drivers</h6>
        <?php
        foreach ($drivers as $d) {
            echo "<div id='$d->driverId' style='display: flex; margin-bottom:4px;' draggable='true' ondragstart='drag(event)'>";
            echo "<img id='$d->driverId' src='img/driversflag/$d->countryName.svg'  width='30' height='20'>";
            echo "<h6 style='margin-bottom: 0px;'>$d->driverName</h6>";
            echo "</div>";
        }
        ?>
    </div>
    <button id="myButton">Submit</button>
    <!--    MOET ONDERAAN STAAN!!!-->
    <script>
        var positions = []

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function findGetParameter(parameterName) {
            var result = null,
                tmp = [];
            location.search
                .substr(1)
                .split("&")
                .forEach(function (item) {
                    tmp = item.split("=");
                    if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                });
            return result;
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            var target = ev.target;

            // Check if the position already contains a driver
            if (target.childNodes.length > 0) {
                // Show an alert message that you can't put two drivers in the same position
                alert("You can't put two drivers in the same position.");
                return;
            }

            // Append the new driver to the position
            target.appendChild(document.getElementById(data));

            var droppedId = ev.target.id;
            console.log("Image ID:", data, "Dropped ID:", droppedId);
            var positionId = droppedId.replace("pos", "");
            var raceId = findGetParameter('id')
            positions.push({
                positionId: positionId,
                driverId: data,
                raceId: raceId
            });
        }

        document.getElementById("myButton").onclick = function () {
            if (positions.length < 20) {
                alert('Please fill everything!')
                return
            }

            var xhr = new XMLHttpRequest();

            var data = JSON.stringify(positions);


            xhr.open("POST", "jsondecode.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.send(data);

            window.location.href = "races.php";
        };


    </script>
</div>
<?php require_once 'includes/footer.php'; ?>
</body>

<!-- https://www.w3schools.com/html/tryit.asp?filename=tryhtml5_draganddrop -->