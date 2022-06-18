
<!DOCTYPE html>
<html lang="ro">

<head>
    <link rel="stylesheet" href="../styles/listare_pisici.css">
    <link rel="stylesheet" href="../styles/header.css">
    <?php include "../php/db-conn.php"; 
    ?>

    <title>Listare Pisici</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    

    <h1>Lista pisici</h1>
    <div class="optiuni">
        <div class="adaugare">
            <p>Adauga pisica</p>
            <a class="add" href="pisica_form.php"></a>
        </div>
    </div>
    <table id="lista_pisici">
        <tr>
            <th>
                Id
            </th>
            <th>
                Nume
            </th>
            <th>
                Descriere
            </th>
            <th>
                Rata
            </th>
            <th>
                Imagine
            </th>
            <th>
                Actiune
            </th>
        </tr>
        <?php
        foreach($test as $p){

        echo"
        <tr>
            <td class='text'>".$p->getId()."</td>
            <td class='text'>".$p->nume."</td>
            <td class='text'>".$p->descriere."</td>
            <td class='text'>".$connector->getRata($p->getId())."</td>
            <td class='text'>".$p->poza."</td>
            <td class='actiune'>
                <a class='modifica' href='pisica_form.php?id=".$p->getId()."'></a>
                <a class='sterge'></a>
            </td>
        </tr>";
    }
        ?>
    </table>
    <script src="../js/listare_pisici.js"></script>
    <div class="adaugare">
            <a class="back" href="admin.html"></a>
        </div>

</body>

</html>