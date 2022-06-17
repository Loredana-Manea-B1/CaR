<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME', 'cat');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME,DB_PASSWORD,DB_NAME);
 
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:../pages-html/pagina_pisica.html");
    exit;
}
// Define variables and initialize with empty values
$nume = $parola = "";
$nume_err = $parola_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["nume"]))){
        $nume_err = "Introduceti nume.";
    } else{
        $nume = trim($_POST["nume"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["parola"]))){
        $parola_err = "Introduceti parola.";
    } else{
        $parola = trim($_POST["parola"]);
    }
    
    // Validate credentials
    if(empty($nume_err) && empty($parola_err)){
        // Prepare a select statement
        $sql = "SELECT id,nume,parola FROM user_base WHERE nume = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_nume);
            
            // Set parameters
            
            $param_nume = $nume;
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $nume, $parola);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($parola, $parola)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["nume"] = $nume;                            
                            
                            // Redirect user to welcome page
                            header("location:./pages-html/pagina_pisica.html");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid nume sau parola.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid nume sau parola.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Login</title>
    <link rel="stylesheet" href="../styles/LoginStyle.css">

</head>

<body>

    <header>
        <div class="logo">
            <a href="#"><img src="../poze_tw/logo.png" class="img-fluid" alt="logo"></a>
        </div>
        <div class=" button">
            <a href="Login.html" class="btn">Log in</a>
        </div>
    </header>

    <div class="container">
        <div class="screen">
        
            <div class="screen__content">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login" >
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="text" class="login__input" placeholder="User name" name="nume"
                        <?php echo (!empty($nume_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nume; ?>">
                        <span class="invalid-feedback"><?php echo $nume_err; ?></span>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" class="login__input" placeholder="Password" name="parola" 
                           <?php echo (!empty($parola_err)) ? 'is-invalid' : ''; ?>">
                       <span class="invalid-feedback"><?php echo $parola_err; ?></span>
                    </div>

                    <button type="submit"  class="button login__submit ">Login</button>
                    <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

                    <div class="button login__submit ">
                        <a href="register.php" class="button__text">Register</a>

                    </div>



                </form>

            </div>

        </div>
    </div>



</body>

</html>