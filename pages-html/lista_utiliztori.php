<!DOCTYPE html>
<html lang="ro">

<head>
    <link rel="stylesheet" href="../styles/listare_pisici.css">
    <?php 
    require_once "../php/db-conn.php";
    ?>
    <title>Listare Utilizatori</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

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
                <a class="modifica" href="form_user.html"></a>
                <a class="sterge"></a>
            </td>
        </tr>';
        }
        ?>
    </table>
    <div class="adaugare">
            <a class="back" href="admin.html"></a>
        </div>

   

</body>

</html>