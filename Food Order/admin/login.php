<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Login </title>
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php 
            
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if (isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }

            

        ?>
        <br><br>

        <!-- Login Form -->
        <form action="" method="POST" class="text-center">
            <label for="">Username:</label>
            <br>
            <input type="text" name="username" placeholder="Enter Username">
            <br><br>
            <label for="">Password:</label>
            <br>
            <input type="password" name="password" placeholder="Enter Password">
            <br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
        </form>
    </div>
</body>
</html>

<?php 

    // Check whether the submit button is clicked
    if (isset($_POST['submit'])) {
        // Get the data from login form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        
        // SQL to check whether the username and password exists
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

        // Execute the SQL Query
        $res = mysqli_query($conn, $sql);

        // Count rows to check whether the user exists
        $count = mysqli_num_rows($res);
        
        if ($count == 1) {
            // User available and successful login
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username; // To check whether the user is logged in

            // Redirect to homepage/dashboard
            header('location:' . SITEURL . 'admin/');

        } else {
            // User not available and unsuccessful login
            $_SESSION['login'] = "<div class='error text-center'>Login unsuccessful.</div>";

            // Redirect to homepage/dashboard
            header('location:' . SITEURL . 'admin/login.php');
        }
    }

?>