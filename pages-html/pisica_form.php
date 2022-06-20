<?php
require_once '../php/pisici_insert.php';
require_once "../php/login_check.php";
    $uid = intval($connector->getUID($nume));
    $admin = $connector->isAdmin($uid);
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <link rel="stylesheet" href="../styles/pisica_form.css">
    <link rel="stylesheet" href="../styles/general.css">
    <title> Admin </title>
    <script src="../js/fetch_form_pisica.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
</head>

<body>

<?php
    if($admin!=1){
        header("location:../pages-html/index.php");
    }
    ?>

<?php if (isset($_GET['id'])) {
        $_editPisica = $connector->get_1_pisica($_GET['id']);

        if ($_editPisica == NULL) {
            echo "<div class='alert danger'><strong>Danger! </strong> Pisica inexistenta! </div>";
            exit;
        }
    ?>
        <h3> Editează o pisica </h3>
    <?php
    } else {

    ?>
        <h3> Inserează o pisica </h3>
    <?php
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-data">
            <label for="nume_pisica">Inserează numele pisicii</label><br>
            <input type="text" name="nume_pisica" id="nume_pisica" placeholder="ex. Bella"<?php
                                                                                                if (isset($_GET["id"])) {
                                                                                                    echo 'value="' . $_editPisica->nume . '"';
                                                                                                } ?>>
        </div>


        <div class="form-data">
            <label for="descriere">Descriere</label> <br>
            <textarea id="descriere" name="descriere" placeholder="Descriere..." ><?php
                                                                                echo isset($_GET["id"]) ? $_editPisica->descriere : "";
                                                                                ?></textarea>
        </div>

        <div class="form-data">
            <label for="poza">Imagine</label><br>
            <input type="file" accept="image/*" name="poza" id="poza"><?php
                                                                                echo isset($_GET["id"]) ? $_editPisica->poza : "";
                                                                                ?>
        </div>
        <input type="number" hidden id="id-input" value="<?= isset($_GET['id']) ? $_GET['id'] : '-1'; ?>">
        <div class="form-data">
            <input type="submit" id="submit" name="submit" value="<?php echo isset($_GET['id']) ? 'Editează' : 'Adaugă' ?>">
        </div>
    </form>
    <div class="butoane">
    <button class="btn" onclick="location.href = 'listare_pisici.php';">Listare</button>
    <button class="btn" onclick="location.href = 'index.html';">Home</button>
                                                                                            </div>
</body>

</html>