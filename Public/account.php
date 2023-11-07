<?php
    require_once "../Private/config.php";

    $dbuser = accountManager::getUser($_SESSION["userid"]);
    $userid = $_SESSION['userid'];
    $password = $dbuser["passwordHash"];
    if (isset($_POST["editUser"])) {
        if($_POST["password"] == "" ) {
            $passwordhash = $password;
        } else {
            $password = $_POST["password"];

            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        }
        accountManager::editNameEmail($_POST["username"], $_POST["email"], $_SESSION["userid"], $passwordhash);
        header("Refresh:0");
    }
    if (isset($_POST["uploadFile"])) {
        accountManager::uploadPP();
        header("Refresh:0");
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <?php require_once 'head.php' ?>
</head>

<body>
<?php require_once 'includes/menu.php' ?>

    <div class="container">

        <div class="row">

            <!-- Profile Photo -->
            <div class="col-md-4">
                <div style="display: flex; justify-content: center;">
                    <?php
                    if (isset($dbuser["profilePicturePath"])) {
                        echo "<img class='profile-picture img-fluid rounded-circle' src='" . $dbuser["profilePicturePath"] . "'>";
                    } else {
                        echo "<img class='profile-picture img-fluid rounded-circle' src='includes/Images/acc_image.png'>";
                    }
                    ?>
                </div>
                <!-- Add Profile Photo -->
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image">+ New Image</label>
                        <input type="file" class="form-control-file" name="image">
                    </div>
                    <button type="submit" name="uploadFile" class="btn btn-primary">Upload</button>
                </form>
            </div>

            <!-- Profile Information -->
            <div class="col-md-4" style="margin-top: 20px;">
                <form method="POST" style="margin-top: 5%;">
                    <div class="form-group">
                        Name:
                        <input type="text" name="username" value="<?php echo $dbuser["username"]; ?>"
                            class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        Email:
                        <input type="email" name="email" value="<?php echo $dbuser["email"]; ?>"
                            class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        Password:
                        <input type="text" name="password"
                            class="form-control" placeholder="Password">
                    </div>
                    <button type="submit" name="editUser" class="btn btn-primary">Save changes</button>
                    <?php
                    if ($dbuser['isVerified'] == 0) {
                        echo "<a href='./sendMail.php?userId=$userid' class='profile-verify'>Verify account</a>";
                    }
                    ?>
                </form>
            </div>

            <!-- Profile Stats -->
            <div class="col-md-4" style="margin-top: 20px;">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Stats:</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <tr>
                            <td>
                                <h2>Points: -</h2>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h2>Position: -</h2>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <?php require_once 'includes/footer.php' ?>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
