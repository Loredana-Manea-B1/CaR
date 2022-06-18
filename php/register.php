<?php
require_once 'db-conn.php';
define('DB_SERVER', 'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME', 'cat');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME,DB_PASSWORD,DB_NAME);
 
// Define variables and initialize with empty values
$nume =$pariu=$parola = $confirm_parola = "";
$nume_err = $parola_err = $confirm_parola_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate nume
    if(empty(trim($_POST["nume"]))){
        $nume_err = "Scrieti nume.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["nume"]))){
        $nume_err = "Numele poate contine numai litere, numere si _.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM user WHERE nume = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_nume);
            
            // Set parameters
            $param_nume = trim($_POST["nume"]);
            
            // Attempt to execute the prepared statement
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

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate parola
    if(empty(trim($_POST["parola"]))){
        $parola_err = "Introduceti parola.";     
    } elseif(strlen(trim($_POST["parola"])) < 6){
        $parola_err = "Parola trebuie sa contina cel putin 6 caractere.";
    } else{
        $parola = trim($_POST["parola"]);
    }
    
    // Validate confirm parola
    if(empty(trim($_POST["confirm_parola"]))){
        $confirm_parola_err = "Confirmati parola.";     
    } else{
        $confirm_parola = trim($_POST["confirm_parola"]);
        if(empty($parola_err) && ($parola != $confirm_parola)){
            $confirm_parola_err = "Parola nu se potriveste.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($nume_err) && empty($parola_err) && empty($confirm_parola_err)  ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (nume,parola) VALUES (?,?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_nume,$param_parola);
            
            // Set parameters
            
            $param_nume = $nume;
            $param_parola =password_hash($parola, PASSWORD_DEFAULT);
         

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login_php.php");
            } else{
                echo "Oops!Ceva a mers gresit. Va rugam incercati mai tarziu.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 



<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../styles/header.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>
    <link rel="stylesheet" href="../styles/LoginStyle.css">


</head>

<body>

    <header>
        <div class="logo">
            <a href="#"><img src="../poze_tw/logo.png" class="img-fluid" alt="logo"></a>
        </div>
        <div class=" button">
            <a href="login_php.php" class="btn">Log in</a>
        </div>
    </header>


    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="login__field">
                        <i class="login__icon fas fa-nume"></i>
                        <input type="text" class="login__input" placeholder="Nume" name="nume"<?php echo (!empty($nume_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nume; ?>">
                     <span class="invalid-feedback"><?php echo $nume_err; ?></span>
                    </div>

                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="parola" class="login__input" placeholder="Parola"  name="parola"<?php echo (!empty($parola_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $parola; ?>">
                <span class="invalid-feedback"><?php echo $parola_err; ?></span>
                    </div>

                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="parola" class="login__input" placeholder="Confirmati parola"  name="confirm_parola"
                        <?php echo (!empty($confirm_parola_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_parola; ?>">
                          <span class="invalid-feedback"><?php echo $confirm_parola_err; ?></span>
                    </div>


                    <button type="submit" class="button login__submit" >Create account</button>
                   



                </form>

            </div>
         
        </div>
    </div>



</body>

</html>