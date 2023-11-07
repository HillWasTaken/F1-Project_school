<?php

$con = new PDO("mysql:host=portfolio.ictcampus.nl;dbname=f1ctrl; charset=utf8", "gdb_f1ctrl", "@3$8MmzB+");
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

global $con;