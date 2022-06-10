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
            if (strcmp($row["poza"], $pis->poza)) {
                unlink($row["poza"]);
            }

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

}
?>