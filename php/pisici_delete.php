<?php
require_once 'db-conn.php';

// stergem din baza de date itemul primit prin get cu id ul respectiv
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    if ($connector->deletePisica($_GET["id"])) {
        echo "Pisica ștearsa cu succes|success";
    } else {
        echo "A apărut o eroare la ștergerea elementului|danger";
    }
} else {
    echo "Pisica nu a fost găsita|danger";
}
