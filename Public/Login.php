<html lang="nl">

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
    <?php require_once 'includes/menu.php' ?>
</head>

<?php
require_once "../private/config.php";


if ($_POST) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($_POST["email"] && $_POST["password"])) {
        echo "<h1 style='color: red; font-weight: bold;'>Vul aub alle velden in!</h1>";
    } else {
        $login = accountManager::login($email, $password);

        if ($login) {
            header("location: index.php");
        } else {
            echo "<h1 style='color: red; font-weight: bold;'>Vul aub alle velden in!</h1>";
        }
    }
}
?>

<body>


<!-- login deel van de paagina -->
<div class="login-container">

    <form method="POST">
        <h1>Login</h1>
        <h4>Email</h4>
        <input class="input-text" type="email" name="email">
        <h4>Wachtwoord</h4>
        <input class="input-text" type="password" name="password">
        <input type="submit" class="submit" value="Login">
    </form>
</div>

<!-- footer -->
<?php require_once "includes/footer.php"; ?>
</body>

</html>