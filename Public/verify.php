<?php
$juisteLink = "verify_email";
require_once "../Private/config.php";

if (isset($_GET['link']) && $_GET['link'] === $juisteLink) {
    // Toon de inhoud van de beveiligde pagina
    Emailmanager::verify($_GET['userid']);
} else {
    // Gebruiker heeft geen toegang, doorsturen naar een andere pagina
    header("Location: ongeautoriseerd.php");
    exit();
}
header("Location: account.php");
?>