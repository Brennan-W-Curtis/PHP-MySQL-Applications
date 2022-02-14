<?php 
    // Include constants files
    include('../config/constants.php');

    if (isset($_GET['id']) && isset($_GET['image_name'])) {

        // Get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Check whether the image is available 
        if ($image_name != "") {
            
            // Get the image path
            $path = "../images/food/" . $image_name;

            // Remove image file from folder 
            $remove = unlink($path);

            // Check whether the image is removed
            if (!$remove) {
                // Failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to remove image file.</div>";
                // Redirect to manage food page
                header('location:' . SITEURL . 'admin/manage-food.php');
                // Stop the process of deleting food
                die();
            }
        }
        
        // Delete food from database
        $sql = "DELETE FROM tbl_food where id = $id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether query successfully executed
        if ($res) {
            // Food deleted 
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            // Redirect to manage food page.
            header('location:' . SITEURL . 'admin/manage-food.php');
        } else {
            // Failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
            // Redirect to manage food page.
            header('location:' . SITEURL . 'admin/manage-food.php');
        }

    } else {

        // Redirect to manage food page
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized access.</div>";
        header('location:' . SITEURL . 'admin/manage-food.php');

    }

?>