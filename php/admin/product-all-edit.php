<?php 
    session_start();
    if (isset($_SESSION["user_ID"])) 
    {
        include("../../database/db.php");
    
        $sql = "SELECT * FROM tblemployee
                WHERE user_ID = {$_SESSION["user_ID"]}";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
    }

    if(isset($_GET['product_code']))
    {
        include("../../database/db.php");

        $product_code = $_GET['product_code'];

        $sql = "SELECT * FROM tblproducts WHERE product_code = $product_code";
        $result = $conn->query($sql);
        $product = $result->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product <?php echo $product['product_name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../../css/product-all-edit.css" rel="stylesheet">
</head>
<?php if (isset($user) && $user["role"] == "admin"): ?>
    <body class="container p-5 d-flex justify-content-center align-items-center bg-primary">
        <form class="p-5 mt-5">
        
            <a href="product-all.php" class="close"><i class="fa-solid fa-rectangle-xmark"></i></a>
            
        <div class="row">
            <div class="form-group">
                <label for="productCode">Product Code</label>
                <input type="number" class="form-control" id="productCode">
            </div>

            <div class="form-group mt-3">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName">
            </div>

            <div class="form-group mt-3">
                <label for="sel1">Category</label>
                <select class="form-control" id="sel1">
                    <option>Branded</option>
                    <option>Consumer Goods</option>
                    <option>Generic</option>
                    <option>Sari Sari</option>
                    <option>Med Supplies</option>
                    <option>Milk</option>
                </select>
            </div>
        </div

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <script src="https://kit.fontawesome.com/c6c8edc460.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>    
    
    <?php else: ?>  
    <div class="no-account-selected"">
        <h1>You don't have permission to access this page</h1>
    </div>
    <?php endif; ?>
    </body>
</html>