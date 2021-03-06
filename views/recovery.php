<?php
require_once __DIR__."/../utils/config.php";

$username = $domanda = $risposta = "";

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
                    $username = trim($_POST["username"]);
                } else{
                    $username_err = "This username does not exists";
                }
            } else
                echo "Oops! Something went wrong. Please try again later.";       
            
            
            //show answere
            $sqlget = "SELECT domanda FROM users WHERE username = ?";

            $sqldata = mysqli_query($link, $sqlget) or die('error:'.mysql_error());
           
            $row = mysqli_fetch_assoc($sqldata);

                       
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


/*            //write the answer for the question
            if(empty(trim($_POST["risposta"]))){
                $risposta_err = "Please enter the answere.";
            }else{
                $risposta = trim($_POST["risposta"]);
            }
*/           
            if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($risposta_err)){
                
                $sql = "SELECT user_id, username, domanda, risposta FROM users WHERE username = ?";
                
                $stmt = $link->prepare($sql);
                

                $stmt->bind_param("s", $param_username);

                $stmt->execute();

                $stmt->bind_result($user_id, $username, $domanda, $hash);

                if(password_verify($risposta, $hash)){

                    $sql2 = "INSERT INTO users(password) VALUES (?)";
                    
                    $stmt2->bind_param("s", $param_password);

                    $param_password = password_hash($password, PASSWORD_DEFAULT);

                    $exe = $stmt2->exeecute(); 
            
            
                }  


            }
        }
    }  
    //close connectionwad  
    mysqli_close($link);
    
}
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">

    <div class="row">
        <h2>Login</h2>
        <p>Se non sei ancora registrato allora <a href="./signup"><u>fallo ora!</u></a></p>
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
                    <div class="form-group" <?php echo $row?>>
                    </div>
                </form>
            </div>
        </div>
    </div>  
</body>
</html>