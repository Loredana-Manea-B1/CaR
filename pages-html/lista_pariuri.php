<!DOCTYPE html>
<html lang="ro">

<head>
    <link rel="stylesheet" href="../styles/listare_pisici.css">
    <?php include "../php/db-conn.php"; 
    ?>
    <title>Lista pariuri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <h1>Lista Pariuri</h1>
    
    <table id="lista_pariuri">
        <tr>
            <th>
                Id
            </th>
            <th>
                Pisica
            </th>
            <th>
                Cursa
            </th>
            <th>
                User
            </th>
            <th>
                Suma
            </th>
        </tr>

        <?php 

        foreach($test_pariuri as $p){
            $sum = $connector->getSuma($p->getId());
            $pisic = $connector->get_1_pisica($p->id_pisica);
            $uid = $connector->getUserPariu($p->getId());
            echo '
        <tr>
            <td class="text"> '.$p->getId().' </td>
            <td class="text">'.$pisic->nume.'</td>
            <td class="text">'.$p->id_cursa.'</td>
            <td class="text">'.$uid.'</td>
            <td class="text">'.$sum.'</td>
        </tr>';
            }
        

        ?>
    </table>
    <div class="adaugare">
            <a class="back" href="admin.php"></a>
        </div>

</body>

</html>