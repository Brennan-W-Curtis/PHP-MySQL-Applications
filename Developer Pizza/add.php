<?php 

    include('config/db_connect.php');

    $email = $title = $ingredients = '';

    $errors = ['email'=>'', 'title'=>'', 'ingredients'=>''];

    if (isset($_POST['submit'])) {

        if (empty($_POST['email'])) {
            $errors['email'] = 'Please enter an email.';
        } else {
            $email = $_POST['email'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Input must be a valid email address.';
            }

        }

        if (empty($_POST['title'])) {
            $errors['title'] = 'Please enter a title.';
        } else {
            $title = $_POST['title'];

            if (!preg_match('/^[a-zA-z\s]+$/', $title)) {
                $errors['title'] = 'Title must be letters and spaces only.';
            }
        }

        if (empty($_POST['ingredients'])) {
            $errors['ingredients'] = 'Please enter at least one ingredient.';
        } else {
            $ingredients = $_POST['ingredients'];

            if (!preg_match('/^([a-zA-z\s]+)(, \s*[a-zA-Z\s]*)*$/', $ingredients)) {
                $errors['ingredients'] = 'Ingredients must be a comma separated list.';
            }
        }

        if (array_filter($errors)) {
            echo 'There are errors in the form.';
        } else {
            
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
    
            // Create SQL
            $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";
    
            // Save to DB and check
            if (mysqli_query($conn, $sql)) {
                header('Location: index.php');
            } else {
                echo 'Query error: ' . mysqli_error($conn);
            }
    
        }

    }

?>

<!DOCTYPE html>

    <?php include('templates/header.php'); ?>

    <section class="container grey-text">
        <h4 class="center">Add a Pizza</h4>
        <form action="add.php" class="white" method="POST">
            <label for="">Your Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <div class="red-text">
                <?php echo $errors['email']; ?>
            </div>
            <label for="">Pizza Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
            <div class="red-text">
                <?php echo $errors['title']; ?>
            </div>
            <label for="">Ingredients (comma separated): </label>
            <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">
            <div class="red-text">
                <?php echo $errors['ingredients']; ?>
            </div>
            <div class="center">
                <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
            </div>
        </form>
    </section>

    <?php include('templates/footer.php'); ?>
</html>