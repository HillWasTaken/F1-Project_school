<?php
//get driver
$dbdrivers = drivers::getAll();

//remove driver
if (isset($_GET["RemoveDriver"])) {
    drivers::removeDriver($_GET["RemoveDriver"]);
}

//add driver
if (isset($_POST['addDriver'])) {
    drivers::addDriver(
        $_POST["driverName"],
        $_POST["driverNumber"],
        $_POST["driverPoints"],
        $_POST["driverCountryId"],
        $_POST["driverTeamId"],
    );
}

//edit driver
if (isset($_POST['editdriver'])) {
    drivers::editDriver(
        $_POST["driverName"],
        $_POST["driverNumber"],
        $_POST["driverPoints"],
        $_POST["driverCountryId"],
        $_POST["driverTeamId"],
        $_GET["EditDriver"]
    );
}
?>

    <table class="table table-striped">
        <thead class="h2 table-dark">
        <tr>
            <th>Name</th>
            <th>Driver Number</th>
            <th>Points</th>
            <th>Country</th>
            <th>Team</th>
            <th>Delete</th>
            <th><a href="../adminoptions?AddDriver=$dbdriver->driverId" class="btn btn-info">+ Driver</a></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $dbdrivers = drivers::getAll();
        foreach ($dbdrivers as $dbdriver) :
            echo "<tr style='cursor: pointer' onclick=\"window.location='adminoptions.php?EditDriver={$dbdriver->driverId}'\">";
            echo "<td>$dbdriver->driverName</td>";
            echo "<td>$dbdriver->driverNumber</td>";
            echo "<td>$dbdriver->driverPoints</td>";
            echo "<td>$dbdriver->countryName</td>";
            echo "<td>$dbdriver->teamName</td>";
            echo "<td><a href='../adminoptions?RemoveDriver=$dbdriver->driverId' onclick='return confirm(\"weet je het zeker?\")'; class='btn btn-danger'>X</a></td>";
            echo "<td></td>";
            echo "</tr>";
        endforeach;
        ?>
        </tbody>
    </table>

    <!-- edit/add window -->
    <!-- als er op een rij van de tabel word geselecteerd opent het dit scherm -->

<?php
if (!empty($_GET["EditDriver"])) {
    echo '
    <div class="edit-user-bar" style="background-color: black;
    color: white;
    width: 100%;
    height: 20%;
    border-radius: 0%;
    padding: 1%;">
        <h1>Edit Driver: ' . $_GET["EditDriver"] . '</h1>
    </div>
    <!-- edit window -->
    <div class="edit-container" style="background-color: rgb(204, 204, 204);
    border-radius: 0%;
    padding: 1%;
    text-align: center;">';

    $editdriver = drivers::getDriverForEdit($_GET["EditDriver"]);

    echo '
        <form method="POST">
            <h4>
                naam <input class="input-text" type="text" name="driverName" value="' . $editdriver->driverName . '">
                </p>
                driver number <input class="input-text" type="text" name="driverNumber" value="' . $editdriver->driverNumber . '">
                </p>
                points <input class="input-text" type="text" name="driverPoints" value="' . $editdriver->driverPoints . '">
                </p>
                country
                <select>';
    $countries = countryManager::getAll();

    foreach ($countries as $country) {
        if ($country->countryId == $editdriver->driverCountryId) {
            ?>
            <option value="<?php echo $country->countryId; ?>" selected><?php echo $country->countryName; ?> </option>
            <?php
        } else {
            ?>
            <option value="<?php echo $country->countryId; ?>"><?php echo $country->countryName; ?> </option>
            <?php
        }
    }
    echo '
                </select>
                </p>
                Team
                <select>';
    $teams = teamManager::getAll();

    foreach ($teams as $team) {
        if ($team->teamId == $editdriver->driverTeamId) {
            ?>
            <option value="<?php echo $team->teamId; ?>" selected><?php echo $team->teamName; ?></option>
            <?php
        } else {
            ?>
            <option value="<?php echo $team->teamId; ?>"><?php echo $team->teamName; ?></option>
            <?php
        }
    }

    echo '
                </select>
            </h4>
            <input type="submit" class="submit" name="editdriver" value="Save">
        </form>
    </div>';
}


//add driver

if (!empty($_GET["AddDriver"])) {
    echo '
    <div class="edit-user-bar" style="background-color: black;
    color: white;
    width: 100%;
    height: 20%;
    border-radius: 0%;
    padding: 1%;">
        <h1>Add Driver</h1>
    </div>
    <!-- edit window -->
    <div class="edit-container" style="background-color: rgb(204, 204, 204);
    border-radius: 0%;
    padding: 1%;
    text-align: center;">';


    echo '
        <form method="POST">
            <h4>
                naam <input class="input-text" type="text" name="driverName"  >
                </p>
                driver number <input class="input-text" type="text" name="driverNumber"  >
                </p>
                points <input class="input-text" type="text" name="driverPoints"  >
                </p>
                country
                <select>';
    $countries = countryManager::getAll();

    foreach ($countries as $country) { ?>
        <option value="<?php echo $country->countryId; ?>"><?php echo $country->countryName; ?> </option>
        <?php
    }
    echo '
                </select>
                </p>
                Team
                <select>';
    $teams = teamManager::getAll();

    foreach ($teams as $team) { ?>
        <option value="<?php echo $team->teamId; ?>"><?php echo $team->teamName; ?> </option>
        <?php
    }
    echo '
                </select>
                
            </h4>
            <input type="submit" class="submit" name="addDriver" value="Add">
        </form>
    </div>';
}

?>