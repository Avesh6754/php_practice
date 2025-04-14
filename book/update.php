<?php
session_start();
include 'config.php';
$config = new Config();

$id = $_SESSION['id'];
$title = $_SESSION['title'];
$author = $_SESSION['author'];
$publishyear = $_SESSION['publishyear'];
$price = $_SESSION['price'];
$quantity = $_SESSION['quantity'];
$general = $_SESSION['general'];

// Update logic for the book record
if (isset($_REQUEST['updateBook'])) {
    $updatedTitle = $_POST['title'];
    $updatedAuthor = $_POST['author'];
    $updatedPublishyear = $_POST['publishyear'];
    $updatedPrice = $_POST['price'];
    $updatedQuantity = $_POST['quantity'];
    $updatedGeneral = $_POST['general'];
 
    $result = $config->updateBook($id, $updatedTitle, $updatedAuthor, $updatedPublishyear, $updatedPrice, $updatedQuantity, $updatedGeneral);

    if (isset($result)) {
        echo "<div class='alert alert-success text-center'>Book Updated Successfully</div>";
        header("Refresh:1; url=index.php"); // Redirect back to main page
        exit;
    } else {
        echo "<div class='alert alert-danger text-center'>Update Failed</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Book</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f4f8; /* Light background */
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h3 {
            color: #4a4a4a;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center mb-4">Update Book Details</h3>
    <div class="card">
        <div class="card-body">
            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="title">Title</label>
                        <input name="title" type="text" class="form-control" value="<?php echo $title ?>" required>
                        <div class="invalid-feedback">Please enter the title.</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="author">Author</label>
                        <input name="author" type="text" class="form-control" value="<?php echo $author ?>" required>
                        <div class="invalid-feedback">Please enter the author.</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="publishyear">Publish Year</label>
                        <input name="publishyear" type="number" class="form-control" value="<?php echo $publishyear ?>" required>
                        <div class="invalid-feedback">Please enter the publish year.</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="price">Price</label>
                        <input name="price" type="text" class="form-control" value="<?php echo $price ?>" required>
                        <div class="invalid-feedback">Please enter the price.</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="quantity">Quantity</label>
                        <input name="quantity" type="number" class="form-control" value="<?php echo $quantity ?>" required>
                        <div class="invalid-feedback">Please enter the quantity.</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="general">Genre</label>
                        <input name="general" type="text" class="form-control" value="<?php echo $general ?>" required>
                        <div class="invalid-feedback">Please enter the genre.</div>
                    </div>
                </div>
                <button name="updateBook" type="submit" class="btn btn-primary">Update</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

</body>
</html>
