<?php
//gebruik managers
require_once "../private/config.php";


if ($_POST) {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];


    $country = $_POST["country"];

    if (empty($_POST["password"] || $_POST["username"])) {
        echo "<h1 style='color: red; font-weight: bold;'>Vul aub alle velden in!</h1>";
    } else {
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $signin = accountManager::signup($username, $email, $passwordhash, $country);

        header("location: index.php");
    }
}
?>

<html>
<head>
    <?php
    require_once "head.php";
    ?>

    <style>
        body {
            background-image: url('img/image_5.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
<?php require_once 'includes/menu.php' ?>

<!-- SignIn deel van de paagina -->
<div class="signup-container">

    <form method="POST" name="signin">
        <h1>Sign Up</h1>
        <h4>Gebruikersnaam</h4>
        <input class="input-text" type="text" name="username">
        <h4>Email</h4>
        <input class="input-text" type="email" name="email">
        <h4>Wachtwoord</h4>
        <input class="input-text" type="password" name="password">

        <!-- lijst aan landen die gebruiker kiest -->
        <h4>Kies een land</h4>
        <select name="country">
            <?php
            $countries = countryManager::getAll();

            foreach ($countries as $country) { ?>
                <option value="<?php echo $country->countryId; ?>"><?php echo $country->countryName; ?> </option>
                <?php
            } ?>

        </select>
        </h5>
        <input type="submit" class="submit" value="Signup">
    </form>
</div>

<!-- footer -->
<?php require_once "includes/footer.php"; ?>
</body>

</html>