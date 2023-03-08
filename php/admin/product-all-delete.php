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

<?php if (isset($user) && $user["role"] == "admin"): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete <?php echo $product['product_name'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../../css/product-all-delete.css" rel="stylesheet">
</head>

    <body class="container p-5 d-flex justify-content-center align-items-center bg-primary">

        <div class="del-container mt-5 row d-flex text-center" method="post">
            <p>Are you sure you want to delete <em><?php echo $product['product_name']; ?></em> in product list?</p>

            <div class="button mt-5">
                <a href="product-all.php" class="btn btn-primary m-2">Cancel</a>
                <a href="../../process/product-all-delete-process.php?product_code=<?php echo $product['product_code'] ?>" class="btn btn-danger m-2">Delete</a>
            </div>
        </div>

        <script src="https://kit.fontawesome.com/c6c8edc460.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>    
    
                            
<?php else: ?>  
    <div class="no-account-selected" style="height: 90vh; display:flex; flex-direction:column; justify-content:center; align-items:center; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color:red">
        <h1 style="font-size: 40px;">You don't have permission to access this page</h1>
        <a href="../../index.php" style="background-color: #007bff; color: white; padding:10px 30px; border-radius:5px; text-decoration:none; font-weight:900;">Login</a>
    </div>
<?php endif; ?>
    </body>
</html>