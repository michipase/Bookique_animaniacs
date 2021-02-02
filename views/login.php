<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $nome = $cognome ="";
$username_err = $password_err = $confirm_password_err = $email_err = $nome_err = $cognome_err = "";
 


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $password = $_POST['password'];

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
                    $username = trim($_POST["username"]);
                } else{
                    $username_err = "This username does not exists";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Validate password
            if(empty(trim($_POST["password"]))){
                $password_err = "Please enter a password.";     
            } elseif(strlen(trim($_POST["password"])) < 1){
                $password_err = "Password must have atleast 8 characters.";
            } else{
                $password = trim($_POST["password"]);
            }

            if(empty($username_err) && empty($password_err)) {
                $sql = "SELECT password FROM users WHERE username = ?";

                $stmt = $link->prepare($sql);
                
                $stmt->bind_param("s", $param_username);

                $exe = $stmt->execute();

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
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <div class="container">

        <div class="row">
            <h2>Login</h2>
            <p>Se non sei ancora registrato allora <a href="/signup"><u>fallo ora!</u></a></p>
        </div>


        <div class="container-fluid justify-content-around">
            <div class="row">
            <div class="row align-items-center align-self-center">
                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 login-form-1">
                    <form action="login" method="post">
                        
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>    
                        
                        <div class="form-group <?php echo (!empty($nome_err)) ? 'has-error' : ''; ?>">
                            <label>password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $nome_err; ?></span>
                        </div> 

                        <div>
                            <p>password dimenticata?</p><a href="/recovery">recuperala!</a>
                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>
                        
                    </form>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>