<?php
include'../php/register_php.php';
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
            <a href="login.php" class="btn">Log in</a>
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