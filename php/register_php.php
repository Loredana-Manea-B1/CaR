<?php
require_once 'db-conn.php';
define('DB_SERVER', 'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME', 'cat');
$link = mysqli_connect(DB_SERVER, DB_USERNAME,DB_PASSWORD,DB_NAME);
$nume =$pariu=$parola = $confirm_parola = "";
$nume_err = $parola_err = $confirm_parola_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["nume"]))){
        $nume_err = "Scrieti nume.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["nume"]))){
        $nume_err = "Numele poate contine numai litere, numere si _.";
    } else{
        
        $sql = "SELECT id FROM user WHERE nume = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "s", $param_nume);
            
            
            $param_nume = trim($_POST["nume"]);
            
           
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $nume_err = "Acest nume este deja luat.";
                } else{
                    $nume = trim($_POST["nume"]);
                }
            } else{
                echo "Oops!Ceva a mers gresit. Va rugam incercati mai tarziu.";
            }

          
            mysqli_stmt_close($stmt);
        }
    }
   
    if(empty(trim($_POST["parola"]))){
        $parola_err = "Introduceti parola.";     
    } elseif(strlen(trim($_POST["parola"])) < 6){
        $parola_err = "Parola trebuie sa contina cel putin 6 caractere.";
    } else{
        $parola = trim($_POST["parola"]);
    }
    
   
    if(empty(trim($_POST["confirm_parola"]))){
        $confirm_parola_err = "Confirmati parola.";     
    } else{
        $confirm_parola = trim($_POST["confirm_parola"]);
        if(empty($parola_err) && ($parola != $confirm_parola)){
            $confirm_parola_err = "Parola nu se potriveste.";
        }
    }
    
  
    if(empty($nume_err) && empty($parola_err) && empty($confirm_parola_err)  ){
        
       
        $sql = "INSERT INTO user (nume,parola) VALUES (?,?)";

        if($stmt = mysqli_prepare($link, $sql)){
          
            mysqli_stmt_bind_param($stmt, "ss", $param_nume,$param_parola);
            
         
            
            $param_nume = $nume;
            $param_parola =password_hash($parola, PASSWORD_DEFAULT);
         

            
            
            if(mysqli_stmt_execute($stmt)){
                
                header("location: login.php");
            } else{
                echo "Oops!Ceva a mers gresit. Va rugam incercati mai tarziu.";
            }

          
            mysqli_stmt_close($stmt);
        }
    }
    
   
    mysqli_close($link);
}
?>
 
