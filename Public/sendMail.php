<?php

require_once "../Private/config.php";
$userid = $_GET['userId'];
$result = accountManager::getUser($userid);
$email = $result["email"];

$mail = "
    <link rel='stylesheet' href=''../Public/css/style.css'>

    <body style='background-color: rgb(234, 234, 234);''>
        <div id='outer-container' style='
            width: 60%;
            background-color: rgb(255, 255, 255); 
            padding: 50px;
            padding-bottom: 0; 
            margin: auto; 
            margin-top: 70px;
            border-radius: 15px;'>
            <div id='header-container' style='
                width: 100%;
                text-align: center;'>
                <img id='logoImgMail' alt title src='http://portfolio.ictcampus.nl/566653/Zelf/f1.svg.png' role='img'
                width='200px;' style='margin: auto;'>
            </div>
            <div id='middle-container' style='
                text-align: center;
                margin-top: 130px;
                '>
    
                <h2 style='font-family: `Inter`, sans-serif;'>Welkom bij Formula 1 Predict.</h2>
                <h3 style='font-family: `Inter`, sans-serif;'>Bedankt voor het registreren bij ons platform!<br> We zijn
                    verheugd dat je deel wilt uitmaken van onze community.<br></h3>
                <span style='font-family: `Inter`, sans-serif;'><br>Om je account te activeren en ervoor te zorgen dat jij
                    het bent, vragen we je vriendelijk om je e-mailadres te verifiëren door op de onderstaande link te
                    klikken:</span><br>
                <br>
                <a style='font-family: `Inter`, sans-serif;'
                    href='http://f1.localhost/verify.php?link=verify_email&userid=$userid'>Verifieer je email</a> <br> <br>
                <span style='font-family: `Inter`, sans-serif;'>Door op de bovenstaande link te klikken, bevestig je dat het
                    opgegeven e-mailadres van jou is en dat je gemachtigd bent om dit account aan te maken. Hierdoor kunnen
                    we de veiligheid van onze gebruikers waarborgen en je een optimale ervaring bieden op ons
                    platform.</span> <br> <br>
                <span style='font-family: `Inter`, sans-serif;'>
                    Bedankt voor je medewerking en welkom bij onze community!<br>
                    
                    Met vriendelijke groet,<br> <br>
                    
                    Formula 1 Predict</span>
            </div>
            <div id='footer-container' style='
                margin-top: 20px;
                text-align: center;
                padding: 20px;
            '>
                <span style='font-family: `Inter`, sans-serif; font-size: 10px;'>Als je geen account hebt aangemaakt op ons platform, kun je
                    deze e-mail veilig negeren. Er worden geen verdere acties van je verwacht.</span><br>
                <span style='font-family: `Inter`, sans-serif; font-size: 10px;''>We willen je erop wijzen dat het belangrijk is om je account te beschermen en dat je de inloggegevens niet met anderen deelt. Als je verdachte activiteiten opmerkt of vermoedt dat iemand anders toegang heeft tot je account, neem dan onmiddellijk contact met ons op via: f1@predict.com </span>
            </div>
        </div>
    </body>
    ";
Emailmanager::sendEmail($email, "Verify Email Formula 1 Predict", $mail);
header("Location: account.php");
