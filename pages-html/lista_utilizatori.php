<!DOCTYPE html>
<html lang="ro">

<head>
    <link rel="stylesheet" href="../styles/listare_pisici.css">
    <?php 
    require_once "../php/db-conn.php";
    require_once "../php/login_check.php";
    $uid = intval($connector->getUID($nume));
    $admin = $connector->isAdmin($uid);
    ?>
    <title>Listare Utilizatori</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<?php
    if($admin!=1){
        header("location:../pages-html/index.php");
    }
    ?>

    <h1>Lista Utilizatori</h1>
    </div>
    <table id="lista_utilizatori">
        <tr>
            <th>
                Id
            </th>
            <th>
                Nume
            </th>
            <th>
                Parola
            </th>
            <th>
                Admin
            </th>
            <th>
                Actiune
            </th>
        </tr>

        <?php 
        foreach($test_useri as $u){
            echo '
        <tr>
            <td class="text"> '.$u->getId().' </td>
            <td class="text"> '.$u->nume.'</td>
            <td class="text">'.$u->getParola().'</td>
            <td class="text">'.$u->admin.'</td>
            <td class="actiune">
            <a class="modifica" href="form_user.php?id='.$u->getId().'"></a>
            <a class="sterge"></a>
            </td>
        </tr>';
        }
        ?>
    </table>
    <div class="adaugare">
            <a class="back" href="admin.php"></a>
        </div>
        <script src="../js/listare_useri.js"></script>
   

</body>

</html>