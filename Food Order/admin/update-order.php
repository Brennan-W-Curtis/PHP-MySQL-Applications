<!DOCTYPE html>
<html lang="en">
    <?php include('partials/menu.php'); ?>
    
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Order</h1>
            <br><br>

            <?php 
            
                // Check whether id is set
                if (isset($_GET['id'])) {

                    // Get the order details based on this id
                    $id = $_GET['id'];
                    
                    // Create SQL query to get order details
                    $sql = "SELECT * FROM tbl_order WHERE id = $id";

                    // Execute the query
                    $res = mysqli_query($conn, $sql);

                    // Count the rows
                    $count = mysqli_num_rows($res);

                    // Check whether we have a value
                    if ($count == 1) {

                        // Details available
                        $row = mysqli_fetch_assoc($res);

                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['quantity'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                        
                    } else {

                        // Details not available and redirect to manage order 
                        header('location:' . SITEURL . 'admin/manage-order.php');
                    }

                } else {

                    // Redirect to manage order page
                    header('location:' . SITEURL . 'admin/manage-order.php');

                }
            
            ?>
            
            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td><label for="">Food Name:</label></td>
                        <td><p><strong><?php echo $food; ?></strong></p></td>
                    </tr>
                    <tr>
                        <td><label for="">Price:</label></td>
                        <td><p><strong>$<?php echo $price; ?></strong></p></td>
                    </tr>
                    <tr>
                        <td><label for="">Quantity</label></td>
                        <td><input type="number" name="qty" value="<?php echo $qty; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="">Status</label></td>
                        <td>
                            <select name="status" id="">
                                <option <?php if ($status == "Ordered") { echo "selected"; } ?> value="Ordered">Ordered</option>
                                <option <?php if ($status == "On Delivery") { echo "selected"; } ?> value="On Delivery">On Delivery</option>
                                <option <?php if ($status == "Delivered") { echo "selected"; } ?> value="Delivered">Delivered</option>
                                <option <?php if ($status == "Cancelled") { echo "selected"; } ?> value="Cancelled">Cancelled</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="">Customer Name:</label></td>
                        <td><input type="text" name="customer_name" value="<?php echo $customer_name; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="">Customer Contact:</label></td>
                        <td><input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="">Customer Email:</label></td>
                        <td><input type="text" name="customer_email" value="<?php echo $customer_email; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="">Customer Address:</label></td>
                        <td><textarea name="customer_address" id="" cols="30" rows="5"><?php echo $customer_address; ?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="price" value="<?php echo $price; ?>">
                            <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <?php 
            
                // Check whether update button is clicked
                if (isset($_POST['submit'])) {
                    
                    // Get all values from the form
                    $id = $_POST['id'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;
                    $status = $_POST['status'];
                    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
                    $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
                    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
                    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);

                    // Update the values
                    $sql2 = "UPDATE tbl_order SET
                        quantity = $qty,
                        total = $total,
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                        WHERE id = $id
                    ";

                    // Execute the query 
                    $res2 = mysqli_query($conn, $sql2);

                    // Check whether order details are updated
                    if ($res2) {

                        // Order details successfully updated
                        $_SESSION['update'] = "<div class='success'>Order updated successfully.</div>";
                        // Redirect to manage order with mesage
                        header('location:' . SITEURL . 'admin/manage-order.php');

                    } else {

                        // Order details failed to update
                        $_SESSION['update'] = "<div class='error'>Failed to update order.</div>";
                        // Redirect to manage order with mesage
                        header('location:' . SITEURL . 'admin/manage-order.php');

                    }

                }
            
            ?>

        </div>
    </div>

    <?php include('partials/footer.php'); ?>
</html>