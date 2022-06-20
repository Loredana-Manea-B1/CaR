<?php
require_once 'db-conn.php';


$user = new User (NULL, NULL, NULL, NULL);
if(!empty($_POST) && isset($_POST['submit'])){
    if(isset($_POST['id-user']) && $_POST['id-user']>0){
        $user = $connector->get_user($_POST['id-user']);
        if(isset($_POST['admin'])){
        $user->admin = $connector->toint($_POST['admin']);
        $status = $connector->updateUser($user);
        echo "User editat cu succes!";
        }

    }
    else alert("Nu am primit id", "danger");
}


function alert($msg, $type)
{
    echo $msg . "|" . $type;
}