<?php

use function PHPSTORM_META\type;

require_once 'db-conn.php';


$cursa = new Cursa(NULL, 0, 0, NULL, NULL, NULL);
if (!empty($_POST) && isset($_POST['submit'])){
    if (isset($_POST['pisica1']) && strlen($_POST['pisica1'])>0){
        $cursa->p1 = $connector->toint(($_POST['pisica1']));
        if (isset($_POST['pisica2'])&& strlen($_POST['pisica2'])>0) {
            if($_POST['pisica2'] == $_POST['pisica1']){
                alert("Alege doua pisici diferite!","danger");
            }
            else{$cursa->p2 = $connector->toint(($_POST['pisica2']));}
            if(isset($_POST['dcursa'])&&strlen($_POST['dcursa'])>0){
                $cursa->data_cursa = $_POST['dcursa'];
                if(isset($_POST['dlimita']) && strlen($_POST['dlimita'])>0){
                    if($_POST['dlimita']>$_POST['dcursa']){
                        alert("data limita trb sa fie inainte de cursa", "danger");
                    }
                    else{
                        $cursa->data_limita = $_POST['dlimita'];
                    }
                    if(isset($_POST['castigator']) && strlen($_POST['castigator'])>0){
                        if($_POST['castigator'] != $cursa->p1 || $_POST['castigator'] != $cursa->p1) alert("castigatorul trebuie sa fie concurent", "danger");
                        else{
                        $cursa->castigator = $_POST['castigator'];
                    }

                    }
                    else{
                        $cursa->castigator = NULL;
                    }
                    if (isset($_POST['id']) && $_POST['id'] > 0) { 
                            $cursa->setId($_POST['id']);
                            //$status = $connector->updateCursa($cursa);
                            alert("Cursa editata cu succes!", "success");
                        } else if ($_POST['id'] == -1) { 
                            
                            $connector->insereazaCursa($cursa); 
                            alert("Cursa inserata cu succes!", "success");
                        } else {
                            alert("Cursa nu exista!", "danger");
                        }
                    }
                
                else alert("data limita", "danger");
            }
            else alert("data cursa!", "danger");
            
        }
        else{
            
            alert("pisica2!", "danger");
        }
    }
    else{
        alert("pisica1!", "danger");
    }
}

function alert($msg, $type)
{
    echo $msg . "|" . $type;
}