<?php
require_once 'db-conn.php';


$pariu = new Pariu (NULL, NULL, NULL, NULL);
if(!empty($_POST) && isset($_POST['submit'])){
    if(isset($_POST['id-pisica']) && $_POST['id-pisica']>0){
        $pariu->id_pisica = $_POST['id-pisica'];
        if(isset($_POST['id-cursa']) && $_POST['id-cursa']>0){
            $pariu->id_cursa = $_POST['id-cursa'];
            if(isset($_POST['suma']) && $_POST['suma']>0){
                $pariu->suma = $_POST['suma'];
                $connector->insereazaPariu($pariu);
                alert("Pariu finalizat cu succes!", "success");
            }
            else alert("Selectati suma", "danger");
        }
        else alert("Cursa selectata gresit", "danger");
    }
    else alert("Pisica selectata gresit", "danger");
}


function alert($msg, $type)
{
    echo $msg . "|" . $type;
}