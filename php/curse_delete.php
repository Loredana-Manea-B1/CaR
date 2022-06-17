<?php
require_once 'db-conn.php';

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    if ($connector->deleteCursa($_GET["id"])) {
        echo "Cursa ștearsa cu succes|success";
    } else {
        echo "A apărut o eroare la ștergerea cursei|danger";
    }
} else {
    echo "Cursa nu a fost găsita|danger";
}
