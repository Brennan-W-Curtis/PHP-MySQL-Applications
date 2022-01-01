<?php 

// Connect to database.
$conn = mysqli_connect('localhost', 'brennan', 'bwc1993', 'dev_pizza');
    
// Check the connection.
if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}

?>