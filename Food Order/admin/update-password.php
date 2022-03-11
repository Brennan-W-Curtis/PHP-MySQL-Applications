<!DOCTYPE html>
<html lang="en">
    <?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Change Password</h1>
            <br><br>

            <?php 
            
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                }
            
            ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>
                            <label for="">Current Password:</label>
                        </td>
                        <td>
                            <input type="password" name="current_password" placeholder="Current Password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">New Password:</label>
                        </td>
                        <td>
                            <input type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Confirm Password:</label>
                        </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <?php 
    
        // Check whether the submit button is clicked
        if (isset($_POST['submit'])) {
            // Get the data from the form
            $id = $_POST['id'];
            $current_password = mysqli_real_escape_string($conn, md5($_POST['current_password']));
            $new_password = mysqli_real_escape_string($conn, md5($_POST['new_password']));
            $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

            // Check whether the user with current id and current password exists
            $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            if ($res) {
                // Checke whether data is available
                $count = mysqli_num_rows($res);

                If ($count == 1) {
                    // User exists and password can be changed

                    // Check whether the new and confirm password match
                    if ($new_password == $confirm_password) {
                        // Update the password 
                        $sql2 = "UPDATE tbl_admin SET
                            password='$new_password'
                            WHERE id = $id
                        ";

                        // Execute query
                        $res2 = mysqli_query($conn, $sql2);

                        // Check whether query executed
                        if ($res2) {
                            // Display success message
                            $_SESSION['change-password'] = "<div class='success'>Password successfully changed.</div>";
                            // Redirect the user
                            header('location:' . SITEURL . 'admin/manage-admin.php');
                        } else {
                            // Display error message
                            $_SESSION['change-password'] = "<div class='error'>Failed to change password.</div>";
                            // Redirect the user
                            header('location:' . SITEURL . 'admin/manage-admin.php');
                        }

                    } else {
                        // Redirect user to manage admin page with error message
                        $_SESSION['password-not-match'] = "<div class='error'>Password does not match.</div>";
                        // Redirect the user
                        header('location:' . SITEURL . 'admin/manage-admin.php');
                    }
                    
                } else {
                    // User does not exist
                    $_SESSION['user-not-found'] = "<div class='error'>User not found.</div>";
                    // Redirect the user
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            }

            // Check whether the current and new password match

            // Change the password if all of the above are true
        }

    ?>

    <?php include('partials/footer.php'); ?>
</body>
</html>