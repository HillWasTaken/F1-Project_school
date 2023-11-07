<?php
//remove user
if (isset($_GET["RemoveUser"])) {
    accountManager::removeUser($_GET["RemoveUser"]);
}

//edit user
if (isset($_POST['edituser'])) {
    if (isset($_POST["isadmin"])) {
        $isadmin = 1;
    } else {
        $isadmin = 0;
    }

    if (isset($_POST["isverified"])) {
        $isverified = 1;
    } else {
        $isverified = 0;
    }

    if($_POST["password"] !== ""){
        $passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        accountManager::editUser(
            $_POST["username"],
            $_POST["email"],
            $isadmin,
            $isverified,
            $_GET["UserId"]
        );

        accountManager::editPassword(
            $passwordhash, 
            $_GET["UserId"]
        );

    } else {
        accountManager::editUser(
            $_POST["username"],
            $_POST["email"],
            $isadmin,
            $isverified,
            $_GET["UserId"]
        );
    }

    
}
?>

    <table class="table table-striped">
        <thead class="h2 table-dark">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Verified</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $dbusers = accountManager::getAll();
        foreach ($dbusers as $dbuser) :
            echo "<tr style='cursor: pointer' onclick=\"window.location='adminoptions.php?UserId={$dbuser->UserId}'\">";
            echo "<td>$dbuser->username</td>";
            echo "<td>$dbuser->email</td>";
            if ($dbuser->isAdmin == 1) {
                $dbuser->isAdmin = "Ja";
            } else {
                $dbuser->isAdmin = "Nee";
            }
            echo "<td>$dbuser->isAdmin</td>";
            if ($dbuser->isVerified == 1) {
                $dbuser->isVerified = "Ja";
            } else {
                $dbuser->isVerified = "Nee";
            }
            echo "<td>$dbuser->isVerified</td>";
            echo "<td><a href='../adminoptions.php?RemoveUser=$dbuser->UserId' onclick='return confirm(\"weet je het zeker?\")'; class='btn btn-danger'>X</a></td>";
            echo "</tr>";
        endforeach;
        ?>
        </tbody>
    </table>

    <!-- edit window -->


    <!-- als er op een rij van de tabel word geselecteerd opent het dit scherm -->

<?php
if (!empty($_GET["UserId"])) {
    echo '
    <div class="edit-user-bar" style="background-color: black;
    color: white;
    width: 100%;
    height: 20%;
    border-radius: 0%;
    padding: 1%;">
        <h1>Edit User: ' . $_GET["UserId"] . '</h1>
    </div>
    <!-- edit window -->
    <div class="edit-container" style="background-color: rgb(204, 204, 204);
    border-radius: 0%;
    padding: 1%;
    text-align: center;">';

    $editdbuser = accountManager::getUserForEdit($_GET["UserId"]);

    echo '
        <form method="POST">
            <h4>
                naam <input class="input-text" type="text" name="username" value="' . $editdbuser->username . '">
                admin? <input type="checkbox" name="isadmin" ' . ($editdbuser->isAdmin == '1' ? 'checked' : '') . '>
                
            </h4>
            <h4>email <input class="input-text" type="text" name="email" value="' . $editdbuser->email . '">
                verified? <input type="checkbox" name="isverified" ' . ($editdbuser->isVerified == '1' ? 'checked' : '') . '>
            </h4>
            <h4>
            vul nieuw wachtwoord in <input type="password" name="password">
            </h4>
            </p>
            <input type="submit" class="submit" name="edituser" value="Save">
        </form>
    </div>';
}
