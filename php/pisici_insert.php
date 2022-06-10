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
                    if (isset($_POST['id']) && $_POST['id'] > 0) { // daca primesc id ul pisicii o editez, altfel inseamna ca vreau sa adaug pisica noua
                        $pisica->setId($_POST['id']);
                        $status = $connector->updatePisica($pisica); // functia ce editeaza pisica
                        alert("Pisica editata cu succes!", "success");
                    } else if ($_POST['id'] == -1) { // daca id ul este -1 inseamna ca pisica trebuie adaugata si nu editata
                        $connector->insereazaPisica($pisica); // functia ce insereaza pisica
                        alert("Pisica inserata cu succes!", "success");
                    } else {
                        alert("Pisica nu exista!", "danger");
                    }
            }
            else{
                alert("Alege o imagine!", "danger");
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