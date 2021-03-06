<?php
//include config file
require_once __DIR__."/../utils/config.php";

//define variables and initialize with empty values
$username = "";
$username_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //validate username
    if(empty(trim($POST["username"]))){
        $username_err = "Please enter a username.";
    }else{
        //prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if($stmt  =mysqli_prepare($link, $sql)){
            $param_username = trim($_POST["username"]);

            //bind variables to the prepared statement as parameters
            mysqli_stmt_stmt_bind_param($stmt, "s", $param_username);

            //attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $username = trim($_POST["username"]);
            }else{
               echo "this username does not exists"; 
            }
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>recovery</title>
</head>
<body>
    <div class="container">

        <div class="row">
            <h2>recovery</h2>
        </div>

        <div class="container-fluid justify-content-around">
            <div class="row">
            <div class="row align-items-center align-self-center">
                <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 login-form-1">
                    <form action="recovery" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        
                        </div>
                    </form>
                </div>
                
            </div>
            </div>
        </div>
    </div>
    
</body>
</html>