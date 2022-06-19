<?php

class User {
    public $nume;


    private $id;
    private $parola;
    private $admin;

    public function getId()
    {
        return $this->id;
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

class Connector {
    private $connection;

    //conectare la baza de date
    public function __construct($host, $dbName, $user,  $password)
    {
        $this->connection = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $user, $password);
    }
    public function getConnection()
    {
        return $this->connection;
    }
    public function getUser(){
        try {
            $user = [];
            $sql = "select user.id as id, user.nume as nume, user.parola as parola, user.admin as admin from user";
            // folosim prepared statements pentru a preveni sql injections
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
            $sql = "select nume from user where id=?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $sql = "delete from user where id = ?";
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