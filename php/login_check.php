<?php
session_start();



if(isset($_SESSION["nume"])){
    $nume = $_SESSION["nume"];

}

else  {
    header("location:../pages-html/welcome.html");
    exit;
};

?>