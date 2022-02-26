<!DOCTYPE html>
<html lang="en">
    <?php include('partials/menu.php'); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Update Category</h1>
                <br><br>
                <?php 
                
                    // Check whether the id is set
                    if (isset($_GET['id'])) {
                        // Get the id and all other details
                        $id = $_GET['id'];

                        // Create SQL query to get all the other details
                        $sql = "SELECT * FROM tbl_category WHERE id = $id";
                        
                        // Execute the query
                        $res = mysqli_query($conn, $sql);

                        // Count the rows to check whether the id is valid
                        $count = mysqli_num_rows($res);

                        if ($count == 1) {
                            // Get the data
                            $row = mysqli_fetch_assoc($res);

                            $title = $row['title'];
                            $current_image = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                        } else {
                            // Redirect to manage category page with message
                            $_SESSION['no-category-found'] = "<div class='error'>No category was found.</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                        }

                    } else {
                        // Redirect to manage category page
                        header('location:' . SITEURL . 'admin/manage-category.php');
                    }

                ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                        <tr>
                            <td><label for="">Title</label></td>
                            <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="">Current Image:</label></td>
                            <td>
                                <?php 
                                
                                    if ($current_image != "") {

                                        // Display the image
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                        <?php
                                    } else {
                                        // Display the message 
                                        echo "<div class='error'>Image not available.</div>";
                                    }
 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">New Image:</label></td>
                            <td><input type="file" name="image"></td>
                        </tr>
                        <tr>
                            <td><label for="">Featured:</label></td>
                            <td>
                                <input <?php if ($featured == "Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes">Yes</input>
                                <input <?php if ($featured == "No") { echo "checked"; } ?> type="radio" name="featured" value="No">No</input>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">Active:</label></td>
                            <td>
                                <input <?php if ($active == "Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes">Yes</input> 
                                <input <?php if ($active == "No") { echo "checked"; } ?> type="radio" name="active" value="No">No</input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>

                <?php 
                
                    if (isset($_POST['submit'])) {
                        // Get all the values from the form
                        $id = $_POST['id'];
                        $title = mysqli_real_escape_string($conn, $_POST['title']);
                        $current_image = $_POST['current_image'];
                        $featured = $_POST['featured'];
                        $active = $_POST['active'];

                        // Check whether an image is selected 
                        if (isset($_FILES['image']['name'])) {

                            // Get the image details
                            $image_name = $_FILES['image']['name'];

                            // Check whether the image is available
                            if ($image_name != "") { 
                                
                                // Upload the image but first get extension for our image
                                $ext = end(explode('.', $image_name));
    
                                // Rename the image 
                                $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;
                                $source_path = $_FILES['image']['tmp_name'];
                                $destination_path = "../images/category/" . $image_name;
    
                                // Upload image 
                                $upload = move_uploaded_file($source_path, $destination_path);

                                // Check whether the image is uploaded 
                                if (!$upload) {
                                    // Set message
                                    $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                                    // Redirect to add category page
                                    header('location:' . SITEURL . 'admin/manage-category.php');
                                    // Stop the process
                                    die();
                                }
                                // Remove the current image if available
                                if ($current_image != "") {

                                    $remove_path = '../images/category/' . $current_image;
                                    $remove = unlink($remove_path);
    
                                    // Check whether the image is removed
                                    if (!$remove) {
                                        // Failed to remove image
                                        $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                                        header('location:' . SITEURL . 'admin/manage-category.php');
                                        die();
                                    }
                                    
                                }

                            } else {
                                $image_name = $current_image;
                            }

                        } else {
                            $image_name = $current_image;
                        }

                        // Update the database by creating a SQL query
                        $sql2 = "UPDATE tbl_category SET
                            title = '$title',
                            image_name = '$image_name',
                            featured = '$featured',
                            active = '$active'
                            WHERE id = $id
                        ";

                        // Execute the query
                        $res2 = mysqli_query($conn, $sql2);

                        // Check whether the query executed
                        if ($res2) {
                            // Category updated successfully
                            $_SESSION['update'] = "<div class='success'>Category updated successfully.</div>";
                            // Redirect to manage category with message
                            header('location:' . SITEURL . 'admin/manage-category.php');
                        } else {
                            // Failed to update category
                            $_SESSION['update'] = "<div class='error'>Failed to update category.</div>";
                            // Redirect to manage category with message
                            header('location:' . SITEURL . 'admin/manage-category.php');
                        }
                    }
                
                ?>

            </div>
        </div>
    <?php include('partials/footer.php'); ?>
</html>