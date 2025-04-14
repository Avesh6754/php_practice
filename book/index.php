<?php
ob_start();                   // Start output buffering
session_start();              // Start the session at the very top
include 'config.php';
$config = new Config();
$config->Dbconncet();
$response = $config->fetchData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Database</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f4f8; /* Light bluish-gray background */
            color: #333;       /* Dark text for contrast */
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #4a90e2; /* A pleasing blue */
            color: #fff;
            font-weight: bold;
        }
        h3, h4 {
            color: #4a4a4a;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-outline-info {
            color: #4a90e2;
            border-color: #4a90e2;
        }
        .btn-outline-info:hover {
            background-color: #4a90e2;
            color: #fff;
        }
        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }
        table {
            background-color: #fff;
        }
        thead.thead-dark th {
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center mb-4">Book Registration</h3>
    <div class="card mb-4">
        <div class="card-header">
            Add New Book
        </div>
        <div class="card-body">
            <form class="row g-3 needs-validation" method="POST" novalidate>
                <div class="form-row">
                    <!-- Removed ID field if not required by the insertBook() method -->
                    <div class="form-group col-md-2">
                        <label for="title">Title</label>
                        <input name="title" type="text" class="form-control" id="title" placeholder="Enter Title" required>
                        <div class="invalid-feedback">Please enter title.</div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="author">Author</label>
                        <input name="author" type="text" class="form-control" id="author" placeholder="Enter Author" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="publishyear">Publish Year</label>
                        <input name="publishyear" type="number" class="form-control" id="publishyear" placeholder="Enter Year" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="price">Price</label>
                        <input name="price" type="number" class="form-control" id="price" placeholder="Enter Price" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="quantity">Quantity</label>
                        <input name="quantity" type="number" class="form-control" id="quantity" placeholder="Enter Quantity" required>
                    </div>
                    <div class="form-group col-md-4 mt-3">
                        <label for="general">General</label>
                        <input name="general" type="text" class="form-control" id="general" placeholder="Enter General" required>
                        <div class="invalid-feedback">Please enter genre.</div>
                    </div>
                </div>
                <button name="button" type="submit" class="btn btn-success mt-3">Submit</button>
            </form>
        </div>
    </div>

    <h4 class="text-center mb-4">Book Details</h4>
    <table class="table table-bordered border-primary table-striped table-hover">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Year</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Genre</th>
            <th>Update</th>
            <th>Delete</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_POST['button'])) {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $publishyear = $_POST['publishyear'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $general = $_POST['general'];

            // Note: Adjust the parameters based on your insertBook() method requirements.
            $result = $config->insertBook($title, $author, $publishyear, $price, $quantity, $general);
            if ($result) {
                echo "<div class='alert alert-info' role='alert'>Data is Added</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Data not added</div>";
            }
            header('Refresh:0');
        }

        if (isset($_POST['edit'])) {
            $id = $_POST['deleteId'];
            $config->deleteBook($id);
            $response = $config->fetchData();
        }

        if (isset($_POST['update'])) {
            $_SESSION['id'] = $_POST['deleteId'];
            $_SESSION['title'] = $_POST['titleId'];
            $_SESSION['author'] = $_POST['authorId'];
            $_SESSION['publishyear'] = $_POST['yearId'];
            $_SESSION['price'] = $_POST['priceId'];
            $_SESSION['quantity'] = $_POST['quantityId'];
            $_SESSION['general'] = $_POST['generalId'];
            header('Location:update.php');
        }

        for ($i = 0; $i < count($response); $i++) { ?>
            <tr>
                <td><?php echo $response[$i]['id'] ?></td>
                <td><?php echo $response[$i]['title'] ?></td>
                <td><?php echo $response[$i]['author'] ?></td>
                <td><?php echo $response[$i]['publishyear'] ?></td>
                <td><?php echo $response[$i]['price'] ?></td>
                <td><?php echo $response[$i]['quantity'] ?></td>
                <td><?php echo $response[$i]['general'] ?></td>
                <form method="POST">
                    <input type="hidden" name="deleteId" value="<?php echo $response[$i]['id'] ?>">
                    <input type="hidden" name="titleId" value="<?php echo $response[$i]['title'] ?>">
                    <input type="hidden" name="authorId" value="<?php echo $response[$i]['author'] ?>">
                    <input type="hidden" name="yearId" value="<?php echo $response[$i]['publishyear'] ?>">
                    <input type="hidden" name="priceId" value="<?php echo $response[$i]['price'] ?>">
                    <input type="hidden" name="quantityId" value="<?php echo $response[$i]['quantity'] ?>">
                    <input type="hidden" name="generalId" value="<?php echo $response[$i]['general'] ?>">
                    <td><button name="update" type="submit" class="btn btn-outline-info">Edit</button></td>
                    <td><button name="edit" type="submit" class="btn btn-outline-danger">Delete</button></td>
                </form>
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('form').reset();
});
</script>
</body>
</html>
<?php
ob_end_flush(); // Flush the output buffer if needed
?>
