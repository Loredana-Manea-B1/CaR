<!DOCTYPE html>
<html>

<head>
    <title>Pariuri</title>
    <link rel="stylesheet" href="../styles/pag1.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/general.css">
    <?php 
    require_once "../php/pariu_insert.php";
    ?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Choose your own style!">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>

<body>
    
    
<?php
        foreach($test_curse as $c)
        {   
            
            $pisica1 = $connector->get_1_pisica($c->p1);
            $pisici[] = $pisica1;
            $idc[] = $c->getId();
            $pisica2 = $connector->get_1_pisica($c->p2);
            $pisici[]=$pisica2;
            $idc[] = $c->getId();
        }
        $i = 0;
        foreach($pisici as $pis1){
            echo'
            <div class="modal-plata" name='.$pis1->nume.'>
            <div class="continut">
            <a class="buton_inchidere close">&times;</a>
            <div class="info_pisica">
                <p class="nume_modal"> '.$pis1->nume.' </p>
                <p class="rata_modal">Rata de castig: '.$connector->getRata($pis1->getId()).'%</p>
                <a href="pagina_pisica.php?id='.$pis1->getId().'" target="_blank">
                    <div class="img_modal">
                        <img src="'.$pis1->poza.'" alt="Poza pisica">
                    </div>
                </a>

            </div>
            <div class="suma_plata">
                <div class="formular">
                    <form method="POST" enctype="multipart/form-data">
                    
                    <input type="number" name="id-pisica" hidden class="id-pisica" id="id-pisica'.$i.'" value="'.$pis1->getId().'">
                    <input type="number" name="id-cursa" hidden class="id-cursa" id = "id-cursa'.$i.'"value="'.$idc[$i].'">
                    <div class= "form-data">
                        <label for="suma">Introduceti suma pe care doriti sa o pariati:</label><br>
                        <input type="number" id="suma" name="suma" value="100"><br>
                        </div>

                        <div class = "form-data">
                        <input type="submit" id="submit'.$i.'" name="submit" class="butoane" value="Pariati">
                        </div>
                    </form>
                </div>
                
                
            </div>
        </div>
    </div>';
    $i++;
        }
        ?>




    <main>
        


        <header>
            <div class="logo">
                <a href="#"><img src="../poze_tw/logo.png" class="img-fluid" alt="logo"></a>
            </div>
            <div class = "meniu">   
            <a href="./istoric.html" target=”_blank”><img src="../poze_tw/account.svg" class="imag" alt="account"></a>
            <a href="./admin.html" target=”_blank”><img src="../poze_tw/admin.svg" class="imag" alt="admin"></a>
            <a href="./help.html" target=”_blank”><img src="../poze_tw/help.svg" class="imag" alt="help"></a>
            </div>
            <div class=" button">
                <a href="./index.php" class="btn">Log in</a>
            </div>
        </header>

        <h1 class="titlu_pagina"> Pariati pentru cursele viitoare! </h1>
        <div class="desc">
            <p> Alegeti pentru ce pisica doriti sa pariati dintre cele ce vor participa la cursele viitoare!
            </p>
        </div>
        

        <div class="pariuri">


        <?php
        foreach($test_curse as $c)
        {
        
            $pisica1 = $connector->get_1_pisica($c->p1);
            $pisica2 = $connector->get_1_pisica($c->p2);
            echo"
            <div class='info_cursa'>
                <div class='text1'>
                
                    <p class='data_cursa'>Data cursei: ".$c->data_cursa."</p>
                    <p class='data_limita'>Data limita pentru pariere: ".$c->data_limita."</p>
                </div>
                <div class='tichet'>
                    <div class='concurent concurent1'>
                        <div class='img1'>
                            <img src='".$pisica1->poza."' alt='Poza pisica'>
                        </div>
                        <div class='text'>
                            <p class='nume' name=".$pisica1->nume.">".$pisica1->nume."</p>
                            <p class='rata'>Rata de castig: ".$connector->getRata($pisica1->getId())."%</p>
                        </div>
                    </div>
                    <div class='concurent concurent2'>
                        <div class='img2'>
                            <img src='".$pisica2->poza."' alt='Poza pisica'>
                        </div>
                        <div class='text'>
                            <p class='nume' name=".$pisica2->nume.">".$pisica2->nume."</p>
                            <p class='rata'>Rata de castig: ".$connector->getRata($pisica2->getId())."%</p>
                        </div>
                    </div>
                </div>
            </div>
            
            ";
        };
        
        ?>
        </div>
        <script src="../js/modal.js"></script>


    </main>
</body>

</html>