<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME', 'cat');
 

$link = mysqli_connect(DB_SERVER, DB_USERNAME,DB_PASSWORD,DB_NAME);
 

session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:../pages-html/index.php");
    exit;
}

$nume = $parola = "";
$nume_err = $parola_err = $login_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["nume"]))){
        $nume_err = "Introduceti nume.";
    } else{
        $nume = trim($_POST["nume"]);
    }
    
   
    if(empty(trim($_POST["parola"]))){
        $parola_err = "Introduceti parola.";
    } else{
        $parola = trim($_POST["parola"]);
    }
    
  
    if(empty($nume_err) && empty($parola_err)){
       
        $sql = "SELECT id,nume,parola FROM user WHERE nume = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "s", $param_nume);
            
        
            
            $param_nume = $nume;
           
            
           
            if(mysqli_stmt_execute($stmt)){
              
                mysqli_stmt_store_result($stmt);
                
               
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                   
                    mysqli_stmt_bind_result($stmt, $id, $nume, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($parola,$hashed_password)){
                           
                            session_start();
                            
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["nume"] = $nume;                            
                            
                           
                            header("location:../pages-html/index.php");
                        } else{
                            
                            $login_err = "Invalid nume sau parola.";
                        }
                    }
                } else{
                    
                    $login_err = "Invalid nume sau parola.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

           
            mysqli_stmt_close($stmt);
        }
    }
    
  
    mysqli_close($link);
}
?>

