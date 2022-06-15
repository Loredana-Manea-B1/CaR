<!DOCTYPE html>
<html lang="ro">

<head>
    <link rel="stylesheet" href="../styles/pisica_form.css">
    <title> Adaugare cursa </title>
    <?php
        require_once '../php/curse_insert.php';
    ?>
    <script src="../js/fetch_form_cursa.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
</head>

<body>

    
<?php if (isset($_GET['id'])) {
        $_editCursa = $connector->get_1_cursa($_GET['id']);
        $pisica1 = $connector->get_1_pisica($_editCursa->p1);
        $pisica2 = $connector->get_1_pisica($_editCursa->p2);
        if($_editCursa->castigator != NULL){
        $winner = $connector->get_1_pisica($_editCursa->castigator);
        }
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

    <form method="POST" enctype="multipart/form-data">
    <div class="form-data">
            <label for="pisica1">Alege prima pisica concurenta</label><br>
            <select name="pisica1" id="pisica1">
                <option value="">Alege</option>
                
                <?php  foreach($test as $p){
                    ?>
                    <option value="'<?= $p->getId() ?>'" <?php if (isset($_GET["id"])&& strcmp($p->getId(), $pisica1->getId()) == 0) {
                                                        echo " selected ";
                                                    } ?>> <?= $p->nume ?></option>
                <?php  }   ?>
                

            </select>
    </div>
    <div class="form-data">
            <label for="pisica2">Alege a doua pisica concurenta</label><br>
            <select name="pisica2" id="pisica2">
                <option value="">Alege</option>
                <?php  foreach($test as $p2){
                    ?>
                    <option value="'<?= $p2->getId() ?>'" <?php if (isset($_GET["id"])&& strcmp($p2->getId(), $pisica2->getId()) == 0) {
                                                        echo " selected ";
                                                    } ?>> <?= $p2->nume; ?></option>
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
                    <option value="'<?= $castig->getId() ?>'"<?php if (isset($_GET["id"]) && strcmp($castig->getId(), $winner->getId()) == 0) {
                                                        echo " selected ";
                                                    } ?>> <?= $castig->nume; ?></option>
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