<?php

    function register() {

        $conn = openConn();

        if (isset($_POST['register_user'])) {

            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
            $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        
            // form validation: ensure that the form is correctly filled ...
            // by adding (array_push()) corresponding error unto $errors array
            if (empty($username)) { array_push($errors, "Username is required"); }
            if (empty($email)) { array_push($errors, "Email is required"); }
            if (empty($password_1)) { array_push($errors, "Password is required"); }
            if ($password_1 != $password_2) {
                array_push($errors, "The two passwords do not match");
            }
        
            // first check the database to make sure 
            // a user does not already exist with the same username and/or email
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);
            
            if ($user) { // if user exists
            if ($user['username'] === $username) {
                array_push($errors, "Username already exists");
            }
        
            if ($user['email'] === $email) {
                array_push($errors, "email already exists");
            }
            }
        
            // Finally, register user if there are no errors in the form
            if (count($errors) == 0) {
                $password = md5($password_1);//encrypt the password before saving in the database
        
                $query = "INSERT INTO users (username, email, password) 
                        VALUES('$username', '$email', '$password')";
                mysqli_query($conn, $query);
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                header('location: index.php');
            }
        }

        closeConn();
    }
?>


<div class="container register">
    <div class="row">

        <div class="col-md-3 register-left">
            <img src="" alt="">
        </div>

        <div class="col-md-9 register-right">

            <form method="POST" action="">

                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" value="">
                </div>
            
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="">
                </div>
            
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password_1">
                </div>

                <div class="input-group">
                    <label>Confirm password</label>
                    <input type="password" name="password_2">
                </div>

                <div class="input-group">
                    <button type="submit" class="btn" name="register_user">Register</button>
                </div>
                <p>
                    Already a member? <a href="login.php">Sign in</a>
                </p>
            </form>  
        </div>
    </div>
</div>