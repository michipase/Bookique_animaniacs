
<?php
// Include config file
require_once __DIR__."/../utils/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $nome = $cognome = $sede = $azienda = $domanda = $risposta = "";
$username_err = $password_err = $confirm_password_err = $email_err = $nome_err = $cognome_err = $sede_err = $azienda_err = $domanda_err = $risposta_err = "";
 


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";
        
        
        if($stmt = mysqli_prepare($link, $sql)){
              // Set parameters
            $param_username = trim($_POST["username"]);
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
            
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                    
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
     /// Validate email
      if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email= trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /*store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                    
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    //validate nome
    if(empty(trim($_POST["nome"]))){
        $nome_err = "Please enter a name.";     
    } else{
        $nome = trim($_POST["nome"]);
    }

    //validate cognome
    if(empty(trim($_POST["cognome"]))){
        $cognome_err = "Please enter a surname.";     
    } else{
        $cognome = trim($_POST["cognome"]);
    }

    //validate sede
    if(empty(trim($_POST["sede"]))){
        $sede_err = "Please enter a hearthquarter.";     
    } else{
        $sede = trim($_POST["sede"]);
    }

    //validate azienda
    if(empty(trim($_POST["nome"]))){
        $azienda_err = "Please enter a buisness name.";     
    } else{
        $azienda = trim($_POST["nome"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 1){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if((empty($password_err)) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //create a domanda for password recovery
    if(empty(trim($_POST["domanda"]))){
        $domanda_err = "Please enter a domanda recovery.";
    }else{
        $domanda = trim($_POST["domanda"]);
    }

    //create a answer for the domanda
    if(empty(trim($_POST["risposta"]))){
        $risposta_err = "Please enter a domanda recovery.";
    }else{
        $risposta = trim($_POST["risposta"]);
    }
// Check input errors before inserting in database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($nome_err) && empty($cognome_err) && empty($domanda_err) && empty($risposta_err))
{
    // Prepare an insert statement
    $sql = "INSERT INTO users (username, email, password, nome, cognome, domanda, risposta, ut_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $sql2 = "INSERT INTO casa_editrice (nome, sede) VALUES (?, ?)";
    

    $stmt = $link->prepare($sql);
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("sssssssi", $param_username, $param_email, $param_password, $param_nome, $param_cognome, $param_domanda, $param_risposta, $param_role );
   
    $stmt2 = $link2->prepare($sql2);

    $stmt2->bind_param("ss", $param_azienda, $param_sede);
    // Set parameters
    $param_username = $_POST['username'];
    $param_email = $email;
    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
    $param_nome = $nome;
    $param_cognome = $cognome;
    $param_role = 1;
    $param_azienda = $azienda;
    $param_sede = $sede;
    $param_domanda = password_hash($domanda, PASSWORD_DEFAULT);
    $param_risposta = password_hash($risposta, PASSWORD_DEFAULT);
    
    mysqli_multi_query($link, $sql);
    mysqli_multi_query($link2, $sql2);
    
    // Attempt to execute the prepared statement
    $exe = $stmt->execute();
    $exe2 = $stmt2->execute();
    if(($exe) && ($exe2)){
        // Redirect to login page
        header("location: /Bookique_animaniacs/login");
    } else {
        echo "Something went wrong. Please try again later.";
    }
    // Close statement
    mysqli_stmt_close($stmt);

}

// Close connection
mysqli_close($link);
}

$isEditor=true;


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="container">

        <div class="row">
            <h2>Sign Up</h2>
            <p>Please fill this form to create an account.</p>
        </div>


        <div class="container-fluid justify-content-around">
            <div class="row">
            <div class="row align-items-center align-self-center">
                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 login-form-1">
                    <form action="/Bookique_animaniacs/views/casa_editrice.php" method="post" id="">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>    
                        <div class="form-group <?php echo (!empty($nome_err)) ? 'has-error' : ''; ?>">
                            <label>nome</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>">
                            <span class="help-block"><?php echo $nome_err; ?></span>
                        </div> 
                        <div class="form-group <?php echo (!empty($cognome_err)) ? 'has-error' : ''; ?>">
                            <label>cognome</label>
                            <input type="text" name="cognome" class="form-control" value="<?php echo $cognome; ?>">
                            <span class="help-block"><?php echo $cognome_err; ?></span>
                        </div> 
                        <div class="form-group <?php echo (!empty($sede_err)) ? 'has-error' : ''; ?>">
                            <label>sede</label>
                            <input type="text" name="sede" class="form-control" value="<?php echo $sede; ?>">
                            <span class="help-block"><?php echo $sede_err; ?></span>
                        </div>   
                        <div class="form-group <?php echo (!empty($azienda_err)) ? 'has-error' : ''; ?>">
                            <label>azienda</label>
                            <input type="text" name="azienda" class="form-control" value="<?php echo $azienda; ?>">
                            <span class="help-block"><?php echo $azienda_err; ?></span>
                        </div> 
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err; ?></span>
                        </div>   
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                            <span class="help-block"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($domanda_err)) ? 'has-error' : ''; ?>">
                            <label>domanda</label>
                            <input type="text" name="domanda" class="form-control" value="<?php echo $domanda; ?>">
                            <span class="help-block"><?php echo $domanda_err; ?></span>
                        </div> 
                        <div class="form-group <?php echo (!empty($risposta_err)) ? 'has-error' : ''; ?>">
                            <label>risposta</label>
                            <input type="text" name="risposta" class="form-control" value="<?php echo $risposta; ?>">
                            <span class="help-block"><?php echo $risposta_err; ?></span>
                        </div> 

                        <div class="form-group">
                            
                            <div class="container-checkbox">
                                <input class="input" type="radio" id="test1" name="role-radio" value="2" checked hidden>
                                <label class="btn" for="test1"><a href="/Bookique_animaniacs/views/lettore.php">Lettore</a></label>
                                <span class="span"></span>
                            </div>

                            <div class="container-checkbox">
                                <input class="input" type="radio" id="test2" name="role-radio" value="1" hidden>
                                <label class="btn" for="test2"><a href="/Bookique_animaniacs/views/casa_editrice.php">Casa Editrice</a></label>
                                <span class="span"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-default" value="Reset">
                        </div>
                        
                    </form>
                </div>
            </div>  
        </div>

        <div class="row">
            <p>Hai già un account? <a href="Bookique_animaniacs/login">Login</a>.</p>
        </div>
    </div>
</body>
</html>