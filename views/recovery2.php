<?php

//include the config file
require_once __DIR__."/../utils/config.php";

//define variables with empty values
$username = "";
$username_err = "";

//Processing form data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "please enter ypur username.";
    }else{
        //prepare a select statement
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            //set parameters
            $param_username = trim($_POST["username"]);
            //bind variables
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //attemt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                //store result
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username = trim($_POST["username"]);
                
                }else{
                    $username_err = "this username does not exist";
                }
            }else{
                echo "ops something goes wrong. Please try again later";
            }
            //close statement
            mysqli_stmt_close($stmt);
        }
    }

    if(empty($username_err)){

        $sql = "SELECT domanda FROM users WHERE username = ?";

        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $param_username);
        $stmt->execute();

        $stmt->bind_result($domanda);
        $stmt->fetch();
        echo $domanda;
    }

    mysqli_close($link);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <title>recovery</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <h2>recovery</h2>
            <p>Se non sei ancora registrato allora <a href="./signup"><u>fallo ora!!</u></a></p>
        </div>

        <div class="container-fluid justify-content-around">
            <div class="row">
                <div class="row align-items-center align-self-center">
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 recovery-form-1">
                        <form action="/Bookique_animaniacs/views/recovery2.php" method="post" id="">

                            <div class="form-group <?php echo(!empty($username_err)) ? 'has-error' : ''; ?>">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                                <span class="helèpblock"><?php echo $username_err; ?></span>
                            </div>

                            <div></div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" values="recovery">
                            
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>