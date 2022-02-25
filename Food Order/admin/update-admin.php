<?php ?>

<!DOCTYPE html>
<html lang="en">
    <?php include('partials/menu.php'); ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Admin</h1>
            <br><br>

            <?php 
                // Get the id of the selected admin
                $id = $_GET['id'];
                // Create SQL query to get the details 
                $sql = "SELECT * FROM tbl_admin WHERE id = $id";
                // Execute the query
                $res = mysqli_query($conn, $sql);
                // Check whether the query is executed 
                if ($res) {
                    // Check whether the data is available
                    $count = mysqli_num_rows($res);
                    // Check whether we have admin data
                    if ($count == 1) {
                        // Get the details
                        $row = mysqli_fetch_assoc($res);
                        $full_name = $row['full_name'];
                        $username = $row['username'];
                    } else {
                        // Redirect to manage admin page
                        header('location:' . SITEURL . 'admin/manage-admin.php');
                    }
                }
            ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>
                            <label for="">Full Name:</label>
                        </td>
                        <td>
                            <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Username: </label>
                        </td>
                        <td>
                            <input type="text" name="username" value="<?php echo $username; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>    
    
    <?php 
    
        // Check whether the submit button is clicked 
        if (isset($_POST['submit'])) {
            // Get all the values from the form to update
            $id = $_POST['id'];
            $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);

            // Create a SQL Query to update admin
            $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username'
            WHERE id = '$id'
            ";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is successful
            if ($res) {
                // Successfuly updated admin
                $_SESSION['update'] = "<div class='success'>Admin successfully updated.</div>";
                // Redirect to manage admin page
                header('location:' . SITEURL . 'admin/manage-admin.php');
            } else {
                // Failed to update admin
                $_SESSION['update'] = "<div class='error'>Failed to update Admin.</div>";
                // Redirect to manage admin page
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        }

    ?>

    <?php include('partials/footer.php'); ?>
</html>