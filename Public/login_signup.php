<html>

<head>
    <?php require_once 'head.php' ?>

    <style>
        body {
            background-image: url('img/image_8.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .Login_Signup-container {
            height: 22%;
            width: 40%;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.896796218487395) 72%, rgba(255, 255, 255, 0) 98%);
            position: absolute;
            margin-top: 15%;
            margin-left: 30%;
            padding: 1%;
            text-align: center;
            color: white;
        }

        .red-button {
            padding: 5px 100px;
            background-color: #E10600;
            color: #fff;
            border-radius: 25px;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 25px;
            display: inline-block;
        }

        /* Media query for mobile devices */
        @media only screen and (max-width: 600px) {
            .red-button {
                font-size: 20px;
                padding: 5px 25px;
            }
            .Login_Signup-container {
                margin-top: 35%;
            }
        }
    </style>
</head>

<body>
    <?php require_once 'includes/menu.php' ?>

    <div class="Login_Signup-container rounded_corners">
        <h1>Log in/Sign up om account te beheeren</h1>
        <a href="SignUp.php" class="col red-button">Sign up</a>
        <a href="Login.php" class="col red-button">Log in</a>
    </div>
    <?php require_once "includes/footer.php"; ?>
</body>

</html>
