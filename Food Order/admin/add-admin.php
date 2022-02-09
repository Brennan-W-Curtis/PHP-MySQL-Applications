<?php include('partials/menu.php'); ?>
<?php 

    // Process the value from the form and save it to database
    // Check whether the button is clicked or not
    if (isset($_POST['submit'])) {
        // Get the data from the form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password'])); // Password encryption with MD5

        // Create SQL query for data
        $sql = "INSERT INTO tbl_admin SET 
            full_name='$full_name', 
            username='$username', 
            password='$password'
        "; 

        // Execute query and save data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // Check whether the query is query is executed, the data is inserted, and display appropriate message
        if ($res) {
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin successfully added.</div>";
            // Redirect page to manage admin
            header('location:' . SITEURL . 'admin/manage-admin.php');
        } else {
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to add Admin.</div>";
            // Redirect page to add admin
            header('location:' . SITEURL . 'admin/add-admin.php');
        }
    } 

?>

<!DOCTYPE html>
<html lang="en">
        <div class="main-content">
            <div class="wrapper">
                <h1>Add Admin</h1>
                <br><br>
                <?php 
                    // Checking whether the session is set or not
                    if(isset($_SESSION['add'])) {
                        echo $_SESSION['add']; // Displaying session message
                        unset($_SESSION['add']); // Removing session message
                    }

                ?>
                <form action="" method="POST">
                    <table class="tbl-30">
                        <tr>
                            <td><label for="full_name">Full Name:</label></td>
                            <td><input type="text" id="full_name" name="full_name" placeholder="Enter Your Name"></td>
                        </tr>
                        <tr>
                            <td><label for="">Username:</label></td>
                            <td><input type="text" id="username" name="username" placeholder="Enter Your Username"></td>
                        </tr>
                        <tr>
                            <td><label for="">Password:</label></td>
                            <td><input type="password" id="password" name="password" placeholder="Enter Your Password"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    <?php include('partials/footer.php'); ?>
</html>