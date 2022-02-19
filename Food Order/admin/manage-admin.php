<!DOCTYPE html>
<html lang="en">
<?php include('partials/menu.php'); ?>
<!-- Main Content -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>

        <?php 
        
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add']; // Displaying session message
                unset($_SESSION['add']); // Removing session message
            }
        
            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete']; // Displaying session message
                unset($_SESSION['delete']); // Removing session message
            }

            if (isset($_SESSION['update'])) {
                echo $_SESSION['update']; // Displaying session message
                unset($_SESSION['update']); // Removing session message
            }

            if (isset($_SESSION['user-not-found'])) {
                echo $_SESSION['user-not-found']; // Displaying session message
                unset($_SESSION['user-not-found']); // Removing session message
            }

            if (isset($_SESSION['password-not-match'])) {
                echo $_SESSION['password-not-match']; // Displaying session message
                unset($_SESSION['password-not-match']); // Removing session message
            }

            if (isset($_SESSION['change-password'])) {
                echo $_SESSION['change-password']; // Displaying session message
                unset($_SESSION['change-password']); // Removing session message
            }

        ?>

        <br><br><br>
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br><br>
        <table class="tbl-full">
            <tr>
                <th>Serial Number</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php 
                // Query to get all admins
                $sql = "SELECT * FROM tbl_admin";
                // Execute the query
                $res = mysqli_query($conn, $sql);
                // Check whether the query is executed
                if ($res) {
                    // Count rows to check whether there is data
                    $count = mysqli_num_rows($res); // Get all the rows from the database
                    $serial_number = 1; // Create a variable to serve as id
                    // Check the number of rows
                    if ($count > 0) {
                        // Using while loop to get all data from database, it will run as long as we have data
                        while ($rows = mysqli_fetch_assoc($res)) {
                            // Get individual data
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $username = $rows['username'];
                            // Display the values in our table         
                            ?>
                                <tr>
                                    <td><?php echo $serial_number++; ?>.</td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                        <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                }  
            ?>
        </table>
    </div>
</div>
<?php include('partials/footer.php'); ?>
</html>