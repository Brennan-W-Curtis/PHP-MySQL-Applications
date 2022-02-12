<?php 
    include('../config/constants.php');

    // Get the id of the admin to be deleted
    $id = $_GET['id'];

    // Create an SQL query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully
    if ($res) {
        // Create a session variable to display message 
        $_SESSION['delete'] = "<div class='success'>Admin successfully deleted.</div>";
        // Redirect to manage admin page
        header('location:' . SITEURL . 'admin/manage-admin.php');
    } else {
        // Create a session variable to display message 
        $_SESSION['delete'] = "<div class='error'>Failed to delete admin.</div>";
        // Redirect to manage admin page
        header('location:' . SITEURL . 'admin/manage-admin.php');
    }

    // Redirect to the manage admin page with a message

?>