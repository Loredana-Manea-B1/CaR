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

//clasa madalinei
class User {
    public $nume;
    public $admin;

    private $id;
    private $parola;
    

    public function getId()
    {
        return $this->id;
    }

    public function getParola()
    {
        return $this->parola;
    }
    public function setId($val)
    {
        $this->id = $val;
    }
    public function __construct($id, $nume, $parola, $admin)
    {
        $this->id = $id;
        $this->nume = $nume;
        $this->parola = $parola;
        $this->admin = $admin;
       

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


    public function insereazaPariu(Pariu $pariu, $uid){
        $sql = "INSERT INTO pariuri(id_pisica, id_cursa, suma) VALUES (?, ?, ?); insert into asociere(id_pariu, id_user) values (LAST_INSERT_ID(), ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$pariu->id_pisica, $pariu->id_cursa, $pariu->suma, $uid]);
    }

    public function getCurse(){
        try {
            $curse = [];
            $sql = "SELECT c.id AS id, id_pisica1 AS p1, id_pisica2 AS p2, c.data_cursa as data_cursa, c.data_limita as data_limita, c.castigator as castigator  FROM curse c";
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
        $sql = "SELECT COUNT(*) as number FROM curse WHERE id_pisica1 = ? OR id_pisica2 = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id, $id]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $total = $row['number'];
        }
        if($total!=0){
        $rata = $castiguri*100/$total;
        }
        else $rata =0;
        return floor($rata);
    }

    public function getCurseViitoare(){
        try {
            $viit = [];
            $sql = "SELECT id, id_pisica1, id_pisica2, data_cursa, data_limita, castigator FROM curse WHERE data_limita>CURRENT_DATE";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $viit[] = new Cursa($row['id'], $row['id_pisica1'], $row['id_pisica2'], $row['data_cursa'], $row['data_limita'], $row['castigator']);
            }
            return $viit;
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
        $sql = "insert into curse (id_pisica1, id_pisica2, data_cursa, data_limita, castigator) values(?,?,?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$cursa->p1, $cursa->p2, $cursa->data_cursa, $cursa->data_limita, $cursa->castigator]);
    }


    public function deleteCursa($id){
        try {
            $sql = "delete from curse where id = ?";
            $stmt = $this->connection->prepare($sql);
            if ($stmt->execute([$id])) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
        }
    }


    public function get_1_cursa($id)
    {
        try {
            $sql = "SELECT id, id_pisica1 as p1, id_pisica2 as p2, data_cursa, data_limita, castigator from curse WHERE id= ?";
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


    public function updateCursa(&$cursa)
    {
        try {

            $sql = "update curse set id_pisica1 = ?, id_pisica2 = ?, data_cursa = ?, data_limita = ?, castigator = ? where id = ?";
            $st = $this->connection->prepare($sql);
            $st->execute([$cursa->p1, $cursa->p2, $cursa->data_cursa, $cursa->data_limita, $cursa->castigator, $cursa->getId()]);
            return ["Produs editat cu succes!", "success"];
        } catch (Exception $e) {
            echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
        }
        return ["A aparut o eroare sau produsul nu exista in baza de date!", "danger"];
    }



    public function getPisici(){
        try {
            $pisici = [];
            $sql = "select pisici.id as id, pisici.nume as nume, pisici.descriere as descriere, pisici.poza as poza from pisici";
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
            echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
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


    public function getPariuri(){
        try {
            $pariuri = [];
            $sql = "select id, id_pisica, id_cursa, suma as s from pariuri";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pariuri[] = new Pariu($row['id'], $row['id_pisica'], $row['id_cursa'], $row['s']);
            }
            return $pariuri;
        } catch (Exception $e) {
            echo "error";
        }
    }



    public function getUserPariu($id){
        $sql = "select u.id as id from user u JOIN asociere a on u.id = a.id_user JOIN pariuri p on a.id_pariu = p.id WHERE p.id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $user = $row['id'];
        }
        if($user == NULL){
            return;
        }
        else return $user;
    }

    public function getPariuUser($id){}


    public function getSuma($id){
        $sql = "select suma from pariuri where id = ?";
        $stmt=$this->connection->prepare($sql);
        $stmt->execute([$id]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $sum = $row['suma'];
        }
        return $sum;
    }

    public function getPariurifromUser($id){
        try {
            $pariuri = [];
            $sql = "select p.id as id, p.id_pisica as id_pisica, p.id_cursa as id_cursa, p.suma as suma FROM pariuri p JOIN asociere a ON p.id = a.id_pariu JOIN user u ON u.id = a.id_user WHERE u.id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pariuri[] = new Pariu($row['id'], $row['id_pisica'], $row['id_cursa'], $row['suma']);
            }
            if($pariuri == NULL){
                return;
            }
            else return $pariuri;
        } catch (Exception $e) {
            echo "error";
        }
    }

    public function getUID($nume){
        $sql = "select id from user WHERE nume = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$nume]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $uid = $row['id'];
        }
        if($uid == NULL){
            return;
        }
        else return $uid;
    }


    public function isAdmin($id){
        $sql = "select admin from user WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$id]);
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $admin = $row['admin'];
        }
        if($admin == NULL){
            return;
        }
        else return $admin;
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


    //functiile madalinei

    public function getUser(){
        try {
            $user = [];
            $sql = "select user.id as id, user.nume as nume, user.parola as parola, user.admin as admin from user";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user[] = new User($row['id'], $row['nume'], $row['parola'], $row['admin']);
            }
            return $user;
        } catch (Exception $e) {
            echo "error";
        }
    }
    // functie user dupa id
    public function get_user($id)
    {
        try {
            $sql = "select user.id as id, user.nume as nume, user.parola as parola, user.admin as admin from user WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            if ($stmt->execute([$id])) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return new User($row['id'], $row['nume'], $row['parola'],  $row['admin']);
            } else {
                return NULL;
            }
        } catch (Exception $e) {
            echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
        }
    }
    public function insereazaUser(User &$user)
    {
        $sql = "insert into user(nume, parola, admin) values(?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$user->nume, $user->parola, $user->admin]);
    }
    public function deleteUser($id)
    {

        try {
            $sql = "delete from asociere where id_user = ?;  delete from user where id = ?;";
            $stmt = $this->connection->prepare($sql);
            if ($stmt->execute([$id, $id, $id])) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            echo "<div class='alert danger'><strong>Danger! </strong> " . $e->getMessage() . "</div>";
        }
    }

    public function updateUser(User &$user){
        $sql = "update user set admin = ? where id = ?";
        $st = $this->connection->prepare($sql);
        $st->execute([$user->admin, $user->getId()]);
        return ["Produs editat cu succes!", "success"];
    }

}






?>