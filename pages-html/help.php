<!DOCTYPE html>
<html>

<head>
    <title>Help</title>
    <link rel="stylesheet" href="../styles/pag1.css">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/help.css">
    <link rel="stylesheet" href="../styles/header.css">
    <meta charset="UTF-8">
    <?php 
    require_once "../php/login_check.php";
    ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Choose your own style!">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <header>
        <div class="logo">
            <a href="./index.php"><img src="../poze_tw/logo.png" class="img-fluid" alt="logo"></a>
        </div>
        <div class="meniu">
        <?php
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true) 
            { 
             ?>
             <a href="./istoric.php" target=”_blank”><img src="../poze_tw/account.svg" class="imag" alt="account"></a>
             <?php
            }
              ?>
         
             <a href="./admin.php" target=”_blank”><img src="../poze_tw/admin.svg" class="imag" alt="admin"></a>
                
           
            <a href="./help.php" target=”_blank”><img src="../poze_tw/help.svg" class="imag" alt="help"></a>
        </div>
         
        <?php
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true) 
            { 
             ?>
               <div class=" button">
            <a href="../php/logout.php" class="btn">Log out</a>
            </div>
             <?php
            }
            else 
            {?>

           <div class=" button">
            <a href="login.php" class="btn">Log in</a>
            </div>
            <?php
            }
              ?>
         



    </header>

    <h1 class="titlu_pagina"> Help </h1>



    <div class="container">
        <div class="text_intr">
            <p>Daca aveti intrebari sau sugestii, contactati-ne la urmatoarele adrese de e-mail:</p>
            <p>@1</p>
            <p>@2</p>
            <p>@3</p>
        </div>

        <div class="bttn">
            <a class="butoane btn" href="documentatie.html">Catre documentatie</a>
        </div>

    </div>
</body>

</html>