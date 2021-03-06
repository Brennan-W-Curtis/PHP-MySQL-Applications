<?php 

  

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('partials/menu.php'); ?>
    <!-- Main Content -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Dashboard</h1>
            <br><br>
            <?php 
        
                if (isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

            ?>
            <br><br>
            <div class="col-4 text-center">

                <?php 
                    // Create the SQL Query
                    $sql = "SELECT * FROM tbl_category";

                    // Execute the query
                    $res = mysqli_query($conn, $sql);
                
                    // Count the rows
                    $count = mysqli_num_rows($res);
                ?>

                <h2><?php echo $count; ?></h2>
                <br>
                Categories
            </div>
            <div class="col-4 text-center">
                <?php   
                    // Create the SQL Query
                    $sql2 = "SELECT * FROM tbl_food";

                    // Execute the query
                    $res2 = mysqli_query($conn, $sql2);
                
                    // Count the rows
                    $count2 = mysqli_num_rows($res2); 
                ?>

                <h2><?php echo $count2; ?></h2>
                <br>
                Foods
            </div>
            <div class="col-4 text-center">
                <?php 
                    
                    // Create the SQL Query
                    $sql3 = "SELECT * FROM tbl_order";

                    // Execute the query
                    $res3 = mysqli_query($conn, $sql3);
                
                    // Count the rows
                    $count3 = mysqli_num_rows($res3);
                    
                ?>
                <h2><?php echo $count3; ?></h2>
                <br>
                Total Orders
            </div>
            <div class="col-4 text-center">
                <?php 
                    // Create SQL Query to get total revenue generated
                    $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status = 'Delivered'";

                    // Execute the query
                    $res4 = mysqli_query($conn, $sql4);

                    // Get the value
                    $row4 = mysqli_fetch_assoc($res4);

                    // Get the total revenue
                    $total_revenue = $row4['Total'];
                ?>
                <h2>$<?php echo $total_revenue; ?></h2>
                <br>
                Revenue Generated
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php include('partials/footer.php'); ?>
</html>