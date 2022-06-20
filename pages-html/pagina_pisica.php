<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Istoricul pisicii</title>
    <link rel="stylesheet" href="../styles/pisica.css">
    <link rel="stylesheet" href="../styles/header.css">
    <?php include "../php/db-conn.php";
    require_once "../php/login_check.php";

    ?>
    <meta name="description" content="Choose your own style!">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>



<?php if (isset($_GET['id'])) {
        $pisica = $connector->get_1_pisica($_GET['id']);

        if ($pisica == NULL) {
            echo "<div class='alert danger'><strong>Danger! </strong> Pisica inexistenta! </div>";
            exit;
        }
    }
    ?>

<header>
            <div class="logo">
                <a href="./index.php"><img src="../poze_tw/logo.png" class="img-fluid" alt="logo"></a>
            </div>
            <div class = "meniu">   
            <a href="./istoric.html" target=”_blank”><img src="../poze_tw/account.svg" class="imag" alt="account"></a>
            <a href="./admin.html" target=”_blank”><img src="../poze_tw/admin.svg" class="imag" alt="admin"></a>
            <a href="./help.php" target=”_blank”><img src="../poze_tw/help.svg" class="imag" alt="help"></a>
            </div>
            <div class=" button">
            <a href="../php/logout.php" class="btn">Log out</a>
            </div>
        </header>


    <div class="continut">
        <div class="pisi">
            <div class="info_pisica">
                <p class="nume"> <?=$pisica->nume?> </p>
                <div class="img_pisica">
                    <img src="<?=$pisica->poza ?>" alt="Poza pisica">
                </div>

            </div>
            <div class="descriere">
                <p class="desc"><?= $pisica->descriere?></p>
            </div>
        </div>

        <div class="istoric">
            <div class="titlu">
                <p>Istoricul curselor lui <?=$pisica->nume?></p>
            </div>

            <?php 
                if($connector->getCursePisica($_GET['id'])==NULL) {
                    $curse = NULL;
                    echo "<p class = 'anunt'> Aceasta pisica nu a participat la nicio cursa inca! </p>";
                }
                
                else{
                $curse = $connector->getCursePisica($_GET['id']);
                foreach($curse as $c)
                {


                    $pisica1 = $connector->get_1_pisica($c->p1);
                    $pisica2 = $connector->get_1_pisica($c->p2);
                    $castigator = $connector->get_1_pisica($c->castigator);
                    

                    echo '
                    <div class="info_cursa">
                    <div class="text1">
                        <p class="data_cursa">Data cursei:  '.$c->data_cursa.'</p>
                        <p class="castigator"> Castigator: '.$castigator->nume.'</p>
                    </div>
    
                    <div class="tichet">
                        <div ';
                        
                        if($castigator == $pisica1){
                            echo " class = 'concurent1'";
                        }
                        else echo " class = 'concurent2'";


                        
                        
                        echo '>
                            <div  ';
                        
                            if($castigator == $pisica1){
                                echo " class = 'poza1'";
                            }
                            else echo " class = 'poza2'";
    
    
                            
                            
                            echo '>
                                <img src="'.$pisica1->poza.'" alt="Poza pisica">
                            </div>
                            <div class="text">
                                <p class="nume">'.$pisica1->nume.'</p>
                            </div>
                        </div>
                        <div  ';
                        
                        if($castigator == $pisica2){
                            echo " class = 'concurent1'";
                        }
                        else echo " class = 'concurent2'";


                        
                        
                        echo '>
                            <div  ';
                        
                            if($castigator == $pisica1){
                                echo " class = 'poza1'";
                            }
                            else echo " class = 'poza2'";
    
    
                            
                            
                            echo '>
                                <img src="'.$pisica2->poza.'" alt="Poza pisica">
                            </div>
                            <div class="text">
                                <p class="nume">'.$pisica2->nume.'</p>
                            </div>
                        </div>
                    </div>
                </div>
    
                    
                    
                    ';
                }
            }

               

                ?>
           
        </div>
    </div>
</body>

</html>