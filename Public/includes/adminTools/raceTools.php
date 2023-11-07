<?php

//remove driver
if (isset($_GET["RemoveRace"])) {
    races::removeRace($_GET["RemoveRace"]);
}


// Edit race
if (isset($_POST['editrace'])) {
    races::editRace(
        $_POST["raceName"],
        $_POST["raceCircuit"],
        $_POST["Season_seasonId"],
        $_POST["raceDate"],
        $_GET["RaceId"]
    );
}

//Add race
if (isset($_POST['addRace'])) {

    races::addRace(
        $_POST["raceName"],
        $_POST["raceCircuit"],
        $_POST["Season_seasonId"],
        $_POST["raceDate"],
    );
}


?>

<table class="table table-striped">
    <thead class="h2 table-dark">
    <tr>
        <th>Race Name</th>
        <th>Circuit</th>
        <th>Season</th>
        <th>Date</th>
        <th>Delete</th>
        <th><a href="../adminoptions?addRace=$dbrace->raceId" class="btn btn-info">+ Race</a></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $dbraces = races::getAllRaces();
    foreach ($dbraces as $dbrace) :
        echo "<tr style='cursor: pointer' onclick=\"window.location='adminoptions.php?RaceId={$dbrace->raceId}'\">";
        echo "<td>$dbrace->raceName</td>";
        echo "<td>$dbrace->raceCircuit</td>";
        echo "<td>$dbrace->Season_seasonId</td>";
        $datetime = date_create($dbrace->raceDate);
        $date = date_format($datetime, 'G:i d-m-Y');
        echo "<td>$date</td>";
        echo "<td><a href='../adminoptions?RemoveRace=$dbrace->raceId' onclick='return confirm(\"Are you sure?\")' class='btn btn-danger'>X</a></td>";
        echo "<td></td>";
        echo "</tr>";
    endforeach;
    ?>
    </tbody>
</table>

<!-- edit window -->

<!-- als er op een rij van de tabel word geselecteerd opent het dit scherm -->
<?php
if (!empty($_GET["RaceId"])) {
    echo '
    <div class="edit-user-bar" style="background-color: black;
    color: white;
    width: 100%;
    height: 20%;
    border-radius: 0%;
    padding: 1%;">
        <h1>Edit Race: ' . $_GET["RaceId"] . '</h1>
    </div>
    <!-- edit window -->
    <div class="edit-container" style="background-color: rgb(204, 204, 204);
    border-radius: 0%;
    padding: 1%;
    text-align: center;">';

    $dbrace = races::getRaceForEdit($_GET["RaceId"]);


    echo '
        <form method="POST">
            <h4>
                Name: <input class="input-text" type="text" name="raceName" value="' . $dbrace->raceName . '">
                </p>
                Circuit: 
                <select name="raceCircuit">';

                $circuits = circuits::getAll();
                foreach($circuits as $circuit){
                    if ($circuit->circuitId == $dbrace->raceCircuit ) {
                        ?>
                        <option value="<?php echo $circuit->circuitId; ?>" selected><?php echo $circuit->circuitName; ?></option>
                        <?php
                    } else {
                        ?>
                        <option value="<?php echo $circuit->circuitId; ?>"><?php echo $circuit->circuitName; ?></option>
                        <?php
                    }
                }
    echo
                '</select>
                </p>
                Season: 
                <select name="Season_seasonId">';

    $seasons = seasonManager::getAll();
    foreach ($seasons as $season) {
        if ($season->seasonId == $dbrace->Season_seasonId) {
            ?>
            <option value="<?php echo $season->seasonId; ?>" selected><?php echo $season->seasonId; ?></option>
            <?php
        } else {
            ?>
            <option value="<?php echo $season->seasonId; ?>"><?php echo $season->seasonId; ?></option>
            <?php
        }
    }
    echo
        '</select>
                </p>
                Date: <input class="input-text" type="datetime-local" name="raceDate" value="' . $dbrace->raceDate . '">
            </h4>
            <input type="submit" class="submit" name="editrace" value="Save">
        </form>
    </div>';
}

//add race
if (!empty($_GET["addRace"])) {
    echo '
    <div class="edit-user-bar" style="background-color: black;
    color: white;
    width: 100%;
    height: 20%;
    border-radius: 0%;
    padding: 1%;">
        <h1>Add Race</h1>
    </div>
    <!-- edit window -->
    <div class="edit-container" style="background-color: rgb(204, 204, 204);
    border-radius: 0%;
    padding: 1%;
    text-align: center;">';


    echo '
        <form method="POST">
        <h4>
            Name: <input class="input-text" type="text" name="raceName" >
            </p>
            Circuit: 
            <select name="raceCircuit">';

            $circuits = circuits::getAll();
            foreach($circuits as $circuit){?>
                    <option value="<?php echo $circuit->circuitId; ?>"><?php echo $circuit->circuitName;?></option><?php
                }

echo
            '</select>
            </p>
            Season: 
            <select name="Season_seasonId">';
    $seasons = seasonManager::getAll();
    foreach ($seasons as $season) {
        ?>
        <option value="<?php echo $season->seasonId; ?>" selected><?php echo $season->seasonId; ?>  </option><?php
    }


    echo
    '</select>
            </p>
            Date: <input class="input-text" type="datetime-local" name="raceDate" >
        </h4>
        <input type="submit" class="submit" name="addRace" value="Save">
    </form>
    </div>';
}


?>
