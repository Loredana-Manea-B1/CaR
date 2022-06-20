<?php
require_once 'db-conn.php';

// stergem din baza de date itemul primit prin get cu id ul respectiv
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $user = $connector->toint($_GET["id"]);
    if ($connector->deleteUser($user)) {
        echo "User șters cu succes|success";
    } else {
        echo "A apărut o eroare la ștergerea elementului|danger";
    }
} else {
    echo "Userul nu a fost găsit|danger";
}
