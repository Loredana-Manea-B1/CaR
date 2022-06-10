<?php
//require_once 'classes_pisici.php';
require_once 'db-conn.php';


$pisica = new Pisica(NULL, NULL, NULL, NULL, NULL);

if (!empty($_POST) && isset($_POST['submit'])){
    if (isset($_POST['nume_pisica']) && strlen($_POST['nume_pisica'])){
        $pisica->nume = $_POST['nume_pisica'];
        if (isset($_POST['descriere']) && strlen($_POST['descriere'])) {
            $pisica->descriere = $_POST['descriere'];
            if ($pisica->poza = $connector->checkPhoto()){
                    if (isset($_POST['id']) && $_POST['id'] > 0) { // daca primesc id ul pisicii inseamna ca trebuie sa o editez, altfel inseamna ca trebuie sa l inserez
                        $pisica->setId($_POST['id']);
                        $status = $connector->updatePisica($pisica); // functia ce editeaza pisica
                        alert($status[0], $status[1]);
                    } else if ($_POST['id'] == -1) { // daca id ul este -1 inseamna ca pisica trebuie inserata si nu editata
                        $connector->insereazaPisica($pisica); // functia ce insereaza pisica
                        alert("Pisica inserata cu succes!", "success");
                    } else {
                        alert("Pisica nu exista!", "danger");
                    }
            }
            else{
                //alert("Alege o imagine!", "danger");
            }
        }
        else{
            alert("Introdu o descriere!", "danger");
        }
    }
    else{
        alert("Introdu numele!", "danger");
    }
}

function alert($msg, $type)
{
    echo $msg . "|" . $type;
}