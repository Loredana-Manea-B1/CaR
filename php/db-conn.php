<?php

include "classes_pisici.php";
$host = "localhost";
$user = "root";
$dbName = "cat";

// cream o conexiune la baza de date
$connector = new Connector($host, $dbName, $user, "");
$test = $connector->getPisici();
$test_curse = $connector->getCurse();
