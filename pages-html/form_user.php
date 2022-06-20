<!DOCTYPE html>
<html lang="ro">

<head>
    <link rel="stylesheet" href="../styles/pisica_form.css">
    <link rel="stylesheet" href="../styles/general.css">
    <title> Edit user </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <?php
    require_once '../php/user_insert.php';
    require_once "../php/login_check.php";
    $uid = intval($connector->getUID($nume));
    $admin = $connector->isAdmin($uid);
    ?>
</head>

<body>

<?php
    if($admin!=1){
        header("location:../pages-html/index.php");
    }
    
    if (isset($_GET['id'])) {
        $_editUser = $connector->get_user($_GET['id']);
        echo '<h3> Modifica userul '.$_editUser->nume.'</h3>';

        if ($_editUser == NULL) {
            echo "<div class='alert danger'><strong>Danger! </strong> Pisica inexistenta! </div>";
            exit;
        }
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-data">
            <label for="admin">Admin</label><br>
            <select name="admin" id="admin">
                <option value="0">Nu</option>
                <option value="1">Da</option>
                
        </div>



        <input type="number" hidden name="id-user" value="<?= isset($_GET['id']) ? $_GET['id'] : '-1'; ?>">
        <div class="form-data">
            <input type="submit" id="submit" name="submit" value="Editeaza">
        </div>
    </form>

    <div class = "butoane">
    <a class="btn" onclick="location.href = 'lista_utilizatori.php';">Listare</a>
    <a class="btn" onclick="location.href = 'admin.php';">Home</a>
    </div>
</body>

</html>