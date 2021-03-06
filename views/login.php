<?php
// Include config file
$titolo = 'Bookique - Login';
require_once UTILS_DIR . 'config.php';
include ASSETS_DIR . 'asset.php';
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $nome = $cognome ="";
$username_err = $password_err = $confirm_password_err = $email_err = $nome_err = $cognome_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_COOKIE['user'])){
 

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
            } elseif(strlen(trim($_POST["password"])) < 8){
                $password_err = "Password must have atleast 8 characters.";
            } else{
                $password = trim($_POST["password"]);
            }

            if(empty($username_err) && empty($password_err)) {
                $sql = "SELECT user_id, username, email, password, nome, cognome, ut_type, status FROM users WHERE username = ?";
                $stmt = $link->prepare($sql);
                $stmt->bind_param("s", $param_username);
                $stmt->execute();
                $stmt->bind_result($user_id, $username, $email, $hash, $nome, $cognome, $ut_type, $status);
                $stmt->fetch();

                if(password_verify($password,$hash)){

                    $time = new DateTime();
                    $time->getTimestamp();


                    $expire = empty($_POST['remember']) ? (time() + (60 * 60 * 24)) : (time() + (60 * 60 * 24 * 14));

                    echo $expire;

                    if ($ut_type == 0 || $ut_type == 1) $enable_upload = 1;
                    else $enable_upload = 0;


                    $data = [
                        'logged_in' => true,
                        'enable_upload' => $enable_upload,
                        'data' => [
                            'user_id' => $user_id,
                            'username' => $username,
                            'email' => $email,
                            'nome' => $nome,
                            'cognome' => $cognome,
                            'ut_type' => $ut_type,
                            'status' => $ut_type
                        ],
                        'login_timestamp' => $time
                    ];

                    setcookie('user',base64_encode(serialize($data)), $expire, '', '', '', true);
                    $_SESSION['user'] = $data;

                    header("location: home");

                } else {
                    $password_err = "password errata";
                }
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
} else {
    if(isset($_COOKIE['user'])) {
        header('location: home');
    }
}
?>
 
<section class="banner" role="banner">
    <h1>Login</h1>
    <div class="container">
        <div class="row">

            <p>Se non sei ancora registrato allora <a href="./signup"><u>fallo ora!</u></a></p>
        </div>
        <div class="container-fluid justify-content-around">
            <div class="row">
            <div class="row align-items-center align-self-center">
                <div class="login-form-1">
                    <form action="login" method="post">
                        
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>    
                        
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div> 

                        <div class="form-group">
                            <input type="checkbox" name="remember" class="" value="true"><label>Remember me</label>
                        </div>

                        <div>
                            password dimenticata? <a href="./recovery">recuperala!</a>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>
                        
                    </form>
                </div>
            </div>  
        </div>
    </div>
    </div>
</section>