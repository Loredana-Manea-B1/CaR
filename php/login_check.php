<?php
session_start();



if(isset($_SESSION["nume"])){
    $nume = $_SESSION["nume"];

}

else echo " ";

?>