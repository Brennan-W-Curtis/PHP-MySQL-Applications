<?php ?>

<!DOCTYPE html>
<html lang="en">
    <?php include('partials/menu.php'); ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>
            <br><br>

            <?php 
            
                if (isset($_SESSION['upload'])) {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }

            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td><label for="">Title:</label></td>
                        <td><input type="text" name="title" placeholder="Title of the food"></td>
                    </tr>
                    <tr>
                        <td><label for="">Description</label></td>
                        <td><textarea name="description" id="" cols="30" rows="5" placeholder="Description of the food"></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="">Price:</label></td>
                        <td><input type="number" name="price"></td>
                    </tr>
                    <tr>
                        <td><label for="">Select Image:</label></td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td><label for="">Category:</label></td>
                        <td>
                            <select name="category" id="">
                                <?php 
                                
                                    // Create a SQL query to get all categories from database
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    
                                    // Execute the query
                                    $res = mysqli_query($conn, $sql);

                                    // Count rows to check whether we have categories
                                    $count = mysqli_num_rows($res);
                                    
                                    // If count is greater than zero we have categories 
                                    if ($count > 0) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            // Get the details of categories
                                            $id = $row['id'];
                                            $title =$row['title'];
                                            ?>
                                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                            <?php
                                        }

                                    } else {
                                        ?>
                                            <option value="0">No category Found</option>
                                        <?php
                                    }                               
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Featured:</label></td>
                        <td>
                            <input type="radio" name="featured" value="Yes">Yes</input>
                            <input type="radio" name="featured" value="No">No</input>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Active:</label></td>
                        <td>
                            <input type="radio" name="active" value="Yes">Yes</input>
                            <input type="radio" name="active" value="No">No</input>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="submit" value="Add Food" class="btn-secondary"></td>
                    </tr>
                </table>
            </form>
            <?php
                // Check whether the button is clicked 
                if (isset($_POST['submit'])) {

                    // Get the data from form
                    $title = mysqli_real_escape_string($conn, $_POST['title']);
                    $description = mysqli_real_escape_string($conn, $_POST['description']);
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                    
                    // Check whether radio button for feature or active is checked
                    if (isset($_POST['featured'])) {
                        $featured = $_POST['featured'];
                    } else {
                        $featured = "No";
                    }

                    if (isset($_POST['active'])) {
                        $active = $_POST['active'];
                    } else {
                        $active = "No";
                    }

                    if (isset($_FILES['image']['name'])) {
                        // Get details of the selected image
                        $image_name = $_FILES['image']['name'];
                        
                        // Check whether the image is selected and upload image
                        if ($image_name != "") {
                            // Get the extension of selected image
                            $ext = end(explode('.', $image_name));
                            
                            // Create a new name for image
                            $image_name = "Food-Name" . rand(0000, 9999) . "." . $ext;

                            // Get the source and destination paths
                            $src = $_FILES['image']['tmp_name'];
                            
                            $dst = "../images/food/" . $image_name;
                           
                            // Upload the food image
                            $upload = move_uploaded_file($src, $dst);
                            
                            // Check whether the image failed to upload
                            if (!$upload) {
                                // Redirect to food page with message
                                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                                header('location:' . SITEURL . 'admin/add-food.php');
                                // Stop the process
                                die();
                            }
                        }
                    } else {
                        $image_name = "";
                    }

                    // Insert it into the database
                    // Create a SQL Query
                    $sql2 = "INSERT INTO tbl_food SET 
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                    ";

                    // Execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    // Check whether data is inserted
                    if ($res2) {
                        // Data successfully inserted
                        $_SESSION['add'] = "<div class='success'>Food successfully added.</div>";
                        // Redirect to manage food page
                        header('location:' . SITEURL . 'admin/manage-food.php');
                    } else {
                        // Failed to insert data
                        $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
                        // Redirect to manage food page
                        header('location:' . SITEURL . 'admin/manage-food.php');
                    }  

                }                  
            ?>
        </div>
    </div>
    <?php include('partials/footer.php'); ?>
</html>