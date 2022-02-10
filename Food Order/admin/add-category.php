<!DOCTYPE html>
<html lang="en">
    <?php include('partials/menu.php'); ?>
        <div class="main-content">
            <div class="wrapper">
                <h1>Add Category</h1>
                <br><br>

                <?php 
                
                    if (isset($_SESSION['add'])) {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if (isset($_SESSION['upload'])) {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }
                
                ?>
                <br><br>
                <!-- Category Form -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                        <tr>
                            <td>
                                <label for="">Title:</label>
                            </td>
                            <td>
                                <input type="text" name="title" placeholder="Category Title">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Select Image:</label>
                            </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Featured:</label>
                            </td>
                            <td>
                                <input type="radio" name="featured" value="Yes">Yes</input>
                                <input type="radio" name="featured" value="No">No</input>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="">Active:</label>
                            </td>
                            <td>
                                <input type="radio" name="active" value="Yes">Yes</input>
                                <input type="radio" name="active" value="No">No</input>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>
                <?php 
                
                    // Check whether the submit button is clicked
                    if (isset($_POST['submit'])) {
                        // Get value from the category form
                        $title = $mysqli_real_escape_string($conn, $_POST['title']);

                        // For radio input we need to check if button is selected
                        if (isset($_POST['featured'])) {
                            // Get value from form
                            $featured = $_POST['featured'];
                        } else {
                            $featured = "No";
                        }

                        if (isset($_POST['active'])) {
                            // Get value from form
                            $active = $_POST['active'];
                        } else {
                            $active = "No";
                        }

                        // Check whether an image is selected and set a value for image name
                        // print_r($_FILES['image']);
                        // die();

                        if (isset($_FILES['image']['name'])) {
                            // To upload image we need an image name, source path, and destination path
                            $image_name = $_FILES['image']['name'];

                            // Upload the image only if an image is selected
                            if ($image_name != "") {

                                // Get extension for our image
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
                                    header('location:' . SITEURL . 'admin/add-category.php');
                                    // Stop the process
                                    die();
                                }
                                
                            }

                        } else {
                            // Dont upload image and set image value as empty string
                            $image_name = "";
                        }

                        // Create SQL Query to insert category into database
                        $sql = "INSERT INTO tbl_category SET
                            title = '$title',
                            image_name = '$image_name',
                            featured = '$featured',
                            active = '$active'
                        ";

                        // Execute the query and save in database
                        $res = mysqli_query($conn, $sql);

                        // Check whether the query executed and the data is added
                        if ($res) {
                            // Query executed and category added
                            $_SESSION['add'] = "<div class='success'>Category successfully added.</div>";
                            // Redirect to manage category page
                            header('location:' . SITEURL . 'admin/manage-category.php');
                        } else {
                            // Query not executed and failed to add category
                            $_SESSION['add'] = "<div class='error'>Failed to add category.</div>";
                            // Redirect to manage category page
                            header('location:' . SITEURL . 'admin/add-category.php'); 
                        }
                    }
                
                ?>
            </div>
        </div>
    <?php include('partials/footer.php'); ?>
</html>