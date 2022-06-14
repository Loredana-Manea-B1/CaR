<!DOCTYPE html>
<html>

<head>
    <title>Pariuri</title>
    <link rel="stylesheet" href="../styles/pag1.css">
    <link rel="stylesheet" href="../styles/header.css">
    <?php include "../php/db-conn.php"; 
    ?>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Choose your own style!">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>

<body>
    
    <div class="modal-plata">
        <div class="continut">
        <a class="buton_inchidere close">&times;</a>
            <div class="info_pisica">
                <p class="nume_modal"> Tomi </p>
                <p class="rata_modal">Rata de castig: 100%</p>
                <a href="pagina_pisica.html" target="_blank">
                    <div class="img_modal">
                        <img src="../poze_tw/1.png" alt="Poza pisica">
                    </div>
                </a>

            </div>
            <div class="suma_plata">
                <div class="formular">
                    <form action="/pagina_plata.html" target="_blank">
                        <label for="suma">Introduceti suma pe care doriti sa o pariati:</label><br>
                        <input type="number" id="suma" name="suma" value="100"><br>
                    </form>
                </div>
                <a class="butoane" href="payPage.html" target=”_blank”> Pariati </a>
                
            </div>
        </div>
    </div>


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
                <a href="#" class="btn">Log in</a>
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
                            <p class='nume'>".$pisica1->nume."</p>
                            <p class='rata'>Rata de castig: 100%</p>
                        </div>
                    </div>
                    <div class='concurent concurent2'>
                        <div class='img2'>
                            <img src='".$pisica2->poza."' alt='Poza pisica'>
                        </div>
                        <div class='text'>
                            <p class='nume'>".$pisica2->nume."</p>
                            <p class='rata'>Rata de castig:</p>
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