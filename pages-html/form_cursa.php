<!DOCTYPE html>
<html lang="ro">

<head>
    <link rel="stylesheet" href="../styles/pisica_form.css">
    <title> Adaugare cursa </title>
    <?php
require_once '../php/db-conn.php';


$cursa = new Cursa(NULL, NULL, NULL, NULL, NULL, NULL);
if (!empty($_POST) && isset($_POST['submit'])){
    if (isset($_POST['pisica1']) && strlen($_POST['pisica1'])>0){
        $cursa->p1 = $_POST['pisica1'];
        if (isset($_POST['pisica2'])&& strlen($_POST['pisica2'])>0) {
            if($_POST['pisica2'] == $_POST['pisica1']){
                alert("Alege doua pisici diferite!","danger");
            }
            else{$cursa->p2 = $_POST['pisica2'];}
            if(isset($_POST['dcursa'])){
                $cursa->data_cursa = $_POST['dcursa'];
                if(isset($_POST['dlimita'])){
                    if($_POST['dlimita']>$_POST['dcursa']){
                        alert("data limita trb sa fie inainte de cursa", "danger");
                    }
                    else{
                        $cursa->data_limita = $_POST['dlimita'];
                    }
                    if(isset($_POST['castigator']) && strlen($_POST['castigator'])>0){
                        $cursa->castigator = $_POST['castigator'];
                        if (isset($_POST['id']) && $_POST['id'] > 0) { 
                            $cursa->setId($_POST['id']);
                            //$status = $connector->updateCursa($cursa); 
                            alert("Pisica editata cu succes!", "success");
                        } else if ($_POST['id'] == -1) { 
                            $connector->insereazaCursa($cursa); 
                            alert("Pisica inserata cu succes!", "success");
                        } else {
                            alert("Pisica nu exista!", "danger");
                        }
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
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
</head>

<body>

    
<?php if (isset($_GET['id'])) {
        $_editCursa = $connector->get_1_cursa($_GET['id']);

        if ($_editCursa == NULL) {
            echo "<div class='alert danger'><strong>Danger! </strong> Pisica inexistenta! </div>";
            exit;
        }
    ?>
        <h3> Editează o cursa </h3>
    <?php
    } else {

    ?>
        <h3> Inserează o cursa </h3>
    <?php
    }
    ?>

    <form method="POST" enctype="multipart/form-data" action="" name="formular">
    <div class="form-data">
            <label for="pisica1">Alege prima pisica concurenta</label><br>
            <select name="pisica1" id="pisica1">
                <!--<option value="alege">Alege</option>-->
                
                <?php  foreach($test as $p){
                    ?>
                    <option value="<?php $p->getId()?>"> <?= $p->nume ?></option>
                <?php  }   ?>
                

            </select>
    </div>
    <div class="form-data">
            <label for="pisica2">Alege a doua pisica concurenta</label><br>
            <select name="pisica2" id="pisica2">
                <option value="">Alege</option>
                <?php  foreach($test as $p2){
                    ?>
                    <option value='<?php $p2->getId()?>'> <?= $p2->nume; ?></option>
                <?php  }   ?>
                

            </select>
    </div>
        <div class="form-data">
            <label for="dcursa">Data Cursei</label><br>
            <input type="date" name="dcursa" id="dcursa">
        </div>
        <div class="form-data">
            <label for="dlimita">Data Limită</label><br>
            <input type="date" name="dlimita" id="dlimita">
        </div>
        
        <div class="form-data">
            <label for="castigator">Alege castigatorul</label><br>
            <select name="castigator" id="castigator">
                <option value="">Alege</option>
                <?php  foreach($test as $castig){
                    ?>
                    <option value="<?php $castig->getId()?>"> <?= $castig->nume; ?></option>
                <?php  }   ?>
                

            </select>
    </div>
        
        <input type="number" hidden id="id-input" value="<?= isset($_GET['id']) ? $_GET['id'] : '-1'; ?>">
        <div class="form-data">
            <input type="submit" id="submit" name="submit" value="<?php echo isset($_GET['id']) ? 'Editează' : 'Adaugă' ?>">
        </div>
    </form>
    <button onclick="location.href = 'lista_curse.php';">Listare</button>
    <button onclick="location.href = 'admin.html';">Home</button>
</body>

</html>