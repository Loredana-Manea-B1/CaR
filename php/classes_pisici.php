<?php


class Pisica
{
    public $nume;
    public $descriere;
    public $poza;

    private $id;

    public function getId()
    {
        return $this->id;
    }
    public function setId($val)
    {
        $this->id = $val;
    }

    public function __construct($id, $nume, $descriere, $poza)
    {
        $this->id = $id;
        $this->nume = $nume;
        $this->descriere = $descriere;
        $this->poza = $poza;
    }
}



class Cursa
{
    public int $p1;
    public int $p2;
    public $data_cursa;
    public $data_limita;
    public $castigator;

    private $id;

    public function getId()
    {
        return $this->id;
    }
    public function setId($val)
    {
        $this->id = $val;
    }

    public function __construct($id, int $p1, int $p2, $data_cursa, $data_limita, $castigator)
    {
        $this->id = $id;
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->data_cursa = $data_cursa;
        $this->data_limita = $data_limita;
        $this->castigator = $castigator;
    }
}


class Pariu
{
    public $id_pisica;
    public $id_cursa;
    public $suma;

    private $id;

    public function getId()
    {
        return $this->id;
    }
    public function setId($val)
    {
        $this->id = $val;
    }

    public function __construct($id, $id_pisica, $id_cursa, $suma)
    {
        $this->id = $id;
        $this->id_pisica = $id_pisica;
        $this->id_cursa = $id_cursa;
        $this->$suma = $suma;
    }
}

class Connector
{
    private $connection;

    // conectarea la baza de date
    public function __construct($host, $dbName, $user,  $password)
    {
        $this->connection = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $user, $password);
    }
    public function getConnection()
    {
        return $this->connection;
    }


    public function insereazaPariu(Pariu $pariu){
        $sql = "INSERT INTO pariuri(id_pisica, id_cursa, suma) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$pariu->id_pisica, $pariu->id_cursa, $pariu->suma]);
    }

    public function getCurse(){
        try {
            $curse = [];
            $sql = "SELECT c.id AS id, id_pisica1 AS p1, id_pisica2 AS p2, c.data_cursa as data_cursa, c.data_limita as data_limita, c.castigator as castigator  FROM curse c JOIN pisici as pis1 ON c.id_pisica1=pis1.id JOIN pisici as pis2 on c.id_pisica2=pis2.id";
            // folosim prepared statements pentru a preveni sql injections
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $curse[] = new Cursa($row['id'], $row['p1'], $row['p2'], $row['data_cursa'], $row['data_limita'], $row['castigator']);
            }
            return $curse;
        } catch (Exception $e) {
            echo "error";
        }
    }

    public function getRata($id){
        $sql = "SELECT COUNT(*) as win FROM curse WHERE castigator=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $castiguri = $row['win'];
        }
        $sql = "SELECT COUNT(*) as number FROM curse";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $total = $row['number'];
        }
        $rata = $castiguri*100/$total;
        return floor($rata);
    }

    public function getCurseViitoare(){
        try {
            $curse = [];
            $sql = "select c.id AS id, id_pisica1 AS p1, id_pisica2 AS p2, c.data_cursa as data_cursa, c.data_limita as data_limita, c.castigator as castigator  FROM curse c JOIN pisici as pis1 ON c.id_pisica1=pis1.id JOIN pisici as pis2 on c.id_pisica2=pis2.id WHERE c.data_limita>CURRENT_DATE";
            // folosim prepared statements pentru a preveni sql injections
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $curse[] = new Cursa($row['id'], $row['p1'], $row['p2'], $row['data_cursa'], $row['data_limita'], $row['castigator']);
            }
            return $curse;
        } catch (Exception $e) {
            echo "error";
        }
    }


    public function getCursePisica($id){
        try{
        $curse = NULL;
        $sql = "SELECT id, id_pisica1 as p1, id_pisica2 as p2, data_cursa, data_limita, castigator FROM curse WHERE (id_pisica1 = ? OR id_pisica2= ?) AND castigator IS NOT NULL";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id, $id]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $curse[] = new Cursa($row['id'], $row['p1'], $row['p2'], $row['data_cursa'], $row['data_limita'], $row['castigator']);
        }


        if($curse == NULL){
            return;
        }
        else return $curse;
    }
    catch (Exception $e){
        echo "error";
    }
    }



        
    

    public function insereazaCursa(Cursa &$cursa)
    {   
        $aux = $cursa->p1;
        settype($aux, "int");
        echo $aux." ";
        echo $cursa->p1;
        echo (int)($cursa->p2);
        $sql = "insert into curse (id_pisica1, id_pisica2, data_cursa, data_limita, castigator) values(?,?,?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$cursa->p1, $cursa->p2, $cursa->data_cursa, $cursa->data_limita, $cursa->castigator]);
    }


    public function get_1_cursa($id)
    {
        try {
            $sql = "SELECT c.id AS id, id_pisica1 AS p1, id_pisica2 AS p2, c.data_cursa as data_cursa, c.data_limita as data_limita, c.castigator as castigator FROM curse WHERE id= ?";
            $stmt = $this->connection->prepare($sql);
            if ($stmt->execute([$id])) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return new Cursa($row['id'], $row['p1'], $row['p2'], $row['data_cursa'], $row['data_limita'], $row['castigator']);
            } else {
                return NULL;
            }
        } catch (Exception $e) {
            echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
        }
    }



    public function getPisici(){
        try {
            $pisici = [];
            $sql = "select pisici.id as id, pisici.nume as nume, pisici.descriere as descriere, pisici.poza as poza from pisici";
            // folosim prepared statements pentru a preveni sql injections
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pisici[] = new Pisica($row['id'], $row['nume'], $row['descriere'], $row['poza']);
            }
            return $pisici;
        } catch (Exception $e) {
            echo "error";
        }
    }


    // functie ce ia o pisica dupa id
    public function get_1_pisica($id)
    {
        try {
            $sql = "select pisici.id as id, pisici.nume as nume, pisici.descriere as descriere, pisici.poza as poza from pisici WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            if ($stmt->execute([$id])) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return new Pisica($row['id'], $row['nume'], $row['descriere'], $row['poza']);
            } else {
                return NULL;
            }
        } catch (Exception $e) {
            echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
        }
    }

    public function insereazaPisica(Pisica &$pis)
    {
        $sql = "insert into pisici(nume, descriere, poza) values(?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$pis->nume, $pis->descriere, $pis->poza]);
    }


    public function checkPhoto()
    {
        if (isset($_FILES['poza']) && $_FILES['poza']['name'] != "") {
            $targetDir = "../poze_tw/";
            $file = $_FILES['poza']['name'];
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $tempName = $_FILES['poza']['tmp_name'];
            $pathFilenameExt = $targetDir . $filename . "." . $ext;
            if (file_exists($pathFilenameExt)) {
               // echo "<div class='alert danger'><strong>Danger! </strong> " . "Fisierul deja Exista!" . "</div>";
            } else {
                move_uploaded_file($tempName, $pathFilenameExt);
            }
            return $pathFilenameExt;
        }
        if (isset($_POST["id"]) && $_POST["id"] > 0) {
            $sql = "select poza from pisici where id=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$_POST["id"]]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["poza"];
        }
        return NULL;
    }

    public function updatePisica(&$pis)
    {
        try {
            // daca nu s o pus nicio alta imagine noua la editare se pastreaza cea de dinainte
            $sql = "select poza from pisici where id=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$pis->getId()]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            /*if (strcmp($row["poza"], $pis->poza)) {
                unlink($row["poza"]);
            }*/

            $sql = "update pisici set nume = ?, descriere = ?, poza = ? where id = ?";
            $st = $this->connection->prepare($sql);
            $st->execute([$pis->nume,  $pis->descriere, $pis->poza, $pis->getId()]);
            return ["Produs editat cu succes!", "success"];
        } catch (Exception $e) {
            //echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
        }
        return ["A aparut o eroare sau produsul nu exista in baza de date!", "danger"];
    }


    public function deletePisica($id)
    {

        try {
            $sql = "select poza from pisici where id=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //unlink($row["poza"]);
            $sql = "delete from pisici where id = ?";
            $stmt = $this->connection->prepare($sql);
            if ($stmt->execute([$id])) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
        }
    }

    public function toint(&$s){
         $rez = 0;

         foreach(str_split($s) as $l){
            if($l>='0' && $l<='9'){
                $rez*=10;
                $rez+=$l-'0';
            }
         }

         return $rez;

    }

}






?>