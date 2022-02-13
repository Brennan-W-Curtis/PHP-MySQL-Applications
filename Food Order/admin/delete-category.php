<?php 
    include('../config/constants.php');

    // Check whether the id and image_name values are set
    if (isset($_GET['id']) && isset($_GET['image_name'])) {
        // Get the value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the image file 
        if ($image_name != "") {
            // Store source path
            $path = "../images/category/" . $image_name;
            // Remove the image
            $remove = unlink($path);
            // If removing the image results in failure display error and stop process
            if (!$remove) {
                // Set the session message
                $_SESSION['remove'] = "<div class='error'>Failed to remove category image.</div>";
                // Redirect to manage category page
                header('location:' . SITEURL . 'admin/manage-category.php');
                // Stope the process
                die();
            }
        }

        // SQL Query to delete data from database
        $sql = "DELETE FROM tbl_category WHERE id = $id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the data is deleted from the database
        if ($res) {
            // Set success message
            $_SESSION['delete'] = "<div class='success'>Category deleted successfully.</div>";
            // Redirect to manage category page
            header('location:' . SITEURL . 'admin/manage-category.php');
        } else {
            // Set error message
            $_SESSION['delete'] = "<div class='error'>Failed to delete category.</div>";
            // Redirect to manage category page
            header('location:' . SITEURL . 'admin/manage-category.php');
        }

        // Redirect to manage category page with message
    } else {
        // Redirect to manage category page
        header('location:' . SITEURL . 'admin/manage-category.php');
    }

?>

