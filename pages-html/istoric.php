<!DOCTYPE html>
<html>

<head>
    <title>Istoric</title>
    <link rel="stylesheet" href="../styles/istoric.css">
    <link rel="stylesheet" href="../styles/header.css">
    <?php 
    require_once "../php/login_check.php";
    require_once "../php/db-conn.php"
    ?>
    <meta charset="UTF-8">
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
            <a href="./istoric.php" target=”_blank”><img src="../poze_tw/account.svg" class="imag" alt="account"></a>

            <?php
            $uid = intval($connector->getUID($nume));
            $admin = $connector->isAdmin($uid);
            if($admin){
                echo '
            <a href="./admin.html" target=”_blank”><img src="../poze_tw/admin.svg" class="imag" alt="admin"></a>';
            }?>
            <a href="./help.php" target=”_blank”><img src="../poze_tw/help.svg" class="imag" alt="help"></a>
        </div>
        <div class=" button">
            <a href="../php/logout.php" class="btn">Log out</a>
            </div>
    </header>

    <h1 class="titlu_pagina"> Istoric </h1>
    <div class="desc">
        <p> Aici puteti vedea istoricul tuturor curselor pentru care ați pariat pana acum!
        </p>
    </div>

    
    <div class="pariuri">
    <?php
    $pariuri_user = $connector->getPariurifromUser($uid);
    if($pariuri_user==NULL) {
        echo "<p class = 'anunt'> Inca nu ati pariat pentru nicio cursa! </p>";
    }

    else{
    
    foreach($pariuri_user as $par){
        $curse[] = $connector->get_1_cursa($par->id_cursa);
        $sume[] = $connector->getSuma($par->getId());
        $pisica_pariu[] = $connector->get_1_pisica(($par->id_pisica));
        
    } 
    $i = 0;
    foreach($curse as $c){
        $pisica1 = $connector->get_1_pisica($c->p1);
        $pisica2 = $connector->get_1_pisica($c->p2);
        echo '
        <div class="info_cursa">
            <div class="text1">
                <p class="data_cursa">Data cursei: '.$c->data_cursa.'</p>
                <p class="castigator">Suma pariata: '.$sume[$i].'</p>
            </div>
            <div class="tichet">
                <div ';
                if($pisica_pariu[$i] == $pisica1){
                    echo " class = 'concurent1'";
                }
                else echo " class = 'concurent2'";
                
                echo '>
                    <div>
                        <img src="'.$pisica1->poza.'" alt="Poza pisica">
                    </div>
                    <div class="text">
                        <p class="nume">'.$pisica1->nume.'</p>
                    </div>
                </div>
                <div ';
                if($pisica_pariu[$i] == $pisica2){
                    echo " class = 'concurent1'";
                }
                else echo " class = 'concurent2'";
                
                echo
                
                '>
                    <div>
                        <img src="'.$pisica2->poza.'" alt="Poza pisica">
                    </div>
                    <div class="text">
                        <p class="nume">'.$pisica2->nume.'</p>
                    </div>
                </div>
            </div>
        </div>
        ';
        $i++;
    }
    }
    ?>

    
        
    </div>

</body>

</html>