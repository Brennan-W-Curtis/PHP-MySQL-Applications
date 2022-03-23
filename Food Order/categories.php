<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <!-- Display all the categories that are active -->
            <?php 
                // Create SQL Query
                $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count the rows
                $count = mysqli_num_rows($res);

                // Check whether the categories are available
                if ($count > 0) {

                    while ($row = mysqli_fetch_assoc($res)) {
                        // Get category data from database
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php 
                                    
                                        if ($image_name == "") {
                                            // Image not available 
                                            echo "<div class='error'>Image not available.</div>";
                                        } else {
                                            // Image is available
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                            <?php
                                        }
                                    
                                    ?>
                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                        <?php
                    }

                } else {
                    // Display error message
                    echo "<div class='error'>Categories not found.</div>";
                }
            
            ?>     
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>