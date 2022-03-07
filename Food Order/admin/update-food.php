<!DOCTYPE html>
<html lang="en">
    <?php include('partials/menu.php'); ?>
    <?php 
        // Check whether id is set
        if (isset($_GET['id'])) {
            // Get the details
            $id = $_GET['id'];
            
            // Create SQL query to get the selected food
            $sql2 = "SELECT * FROM tbl_food WHERE id = $id";
            
            // Execute SQL query
            $res2 = mysqli_query($conn, $sql2);
            
            // Get the values based on query executed
            $row2 = mysqli_fetch_assoc($res2);
            
            // Get the individual values of selected food
            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $current_image = $row2['image_name'];
            $current_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];

        } else {
            // Redirect to manage food
            header('location:' . SITEURL . 'admin/manage-food.php');
        }
    ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1>
            <br><br>
            <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

        <tr>
            <td><label for="">Title:</label></td>
            <td>
                <input type="text" name="title" value="<?php echo $title; ?>">
            </td>
        </tr>
        <tr>
            <td><label for="">Description:</label></td>
            <td>
                <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
            </td>
        </tr>
        <tr>
            <td><label for="">Price:</label></td>
            <td>
                <input type="number" name="price" value="<?php echo $price; ?>">
            </td>
        </tr>
        <tr>
            <td><label for="">Current Image:</label></td>
            <td>
                <?php 
                    if($current_image == "")
                    {
                        //Image not Available 
                        echo "<div class='error'>Image not Available.</div>";
                    }
                    else
                    {
                        //Image Available
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                        <?php
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td><label for="">Select New Image:</label></td>
            <td>
                <input type="file" name="image">
            </td>
        </tr>
        <tr>
            <td><label for="">Category:</label></td>
            <td>
                <select name="category">
                    <?php 
                        // Create SQL Query to get active categories
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                        //Execute the Query
                        $res = mysqli_query($conn, $sql);
                        
                        // Count rows
                        $count = mysqli_num_rows($res);

                        //Check whether category available or not
                        if($count>0)
                        {
                            //CAtegory Available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $category_title = $row['title'];
                                $category_id = $row['id'];
                                
                                //echo "<option value='$category_id'>$category_title</option>";
                                ?>
                                    <option <?php if ($current_category == $category_id) { echo "selected"; } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                            }
                        }
                        else
                        {
                            //CAtegory Not Available
                            echo "<option value='0'>Category Not Available.</option>";
                        }
                    ?>
                </select>
            </td>
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
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
            <?php 
                // Check whether button is checked 
                if (isset($_POST['submit'])) {

                    // Get all the details from the form
                    $id = $_POST['id'];
                    $title = mysqli_real_escape_string($conn, $_POST['title']);
                    $description = mysqli_real_escape_string($conn, $_POST['description']);
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];
                    
                    // Check whether upload image is clicked
                    if(isset($_FILES['image']['name'])) {
                    
                        // Upload the image if selected
                        $image_name = $_FILES['image']['name'];
                        
                        // Check whether file is available 
                        if ($image_name != "") {
                            // Get extension of the image
                            $ext = end(explode('.', $image_name));

                            // Rename the image
                            $image_name = "Food_Name_" . rand(0000, 9999) . '.' . $ext; 

                            // Get the source path and destination path
                            $src_path = $_FILES['image']['tmp_name'];
                            $dest_path = "../images/food/" . $image_name;

                            // Upload the image
                            $upload = move_uploaded_file($src_path, $dest_path);

                            // Check whether image is uploaded
                            if (!$upload) {
                                // Failed to upload
                                $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                                // Redirect to manage food
                                header('location:' . SITEURL . 'admin/manage-food.php');
                                // Stop the process
                                die();
                            }

                            // Remove the image if new image is uploaded and current image exists
                            if ($current_image != "") {
                                 
                                // Remove the current image
                                $remove_path = "../images/food/" . $current_image;
                                $remove = unlink($remove_path);

                                // Check whether the current image is removed
                                if (!$remove) {

                                    // Failed to remove current image
                                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                                    
                                    // Redirect to manage food
                                    header('location:' . SITEURL . 'admin/manage-food.php');
                                    
                                    // Stop the process
                                    die();
                                }

                            }

                        } else {
                            $image_name = $current_image; // Default image when image is not selected
                        }

                    } else {
                        $image_name = $current_image; // Default image when button is not clicked
                    }

                    // Create SQL Query
                    $sql3 = "UPDATE tbl_food SET 
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id = $id
                    ";

                    // Execute the SQL Query
                    $res3 = mysqli_query($conn, $sql3);

                    // Check whether the query is executed
                    if ($res3) {
                        // Query executed and food in database updated
                        $_SESSION['update'] = "<div class='success'>Food successfully updated.</div>";
                        // Redirect to manage food page
                        header('location:' . SITEURL . 'admin/manage-food.php');
                    } else {
                        // Failed to update food
                        $_SESSION['update'] = "<div class='error'>Food failed to update.</div>";
                        // Redirect to manage food page
                        header('location:' . SITEURL . 'admin/manage-food.php');
                    }

                }
            ?>
        </div>
    </div>
    <?php include('partials/footer.php'); ?>
</html>