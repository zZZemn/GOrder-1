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

    if(isset($_POST['save']))
    {
        $product_code = $_POST['product_code'];
        $product_name = $_POST['product_name'];
        $product_category = $_POST['product_category'];
        $selling_price = $_POST['selling_price'];
        $product_measurement = $_POST['product_measurement'];
        $critical_level = $_POST['critical_level'];
        $product_desc = $_POST['product_desc'];

        $sql = "UPDATE `tblproducts` SET `product_name`='$product_name',`category`='$product_category',`selling_price`='$selling_price', `product_measurement`='$product_measurement',`critical_level`='$critical_level',`product_desc`='$product_desc' WHERE product_code = '$product_code'";
        
        if($conn->query($sql))
        {
            header("Location: product-all.php");
        }
        else
        {
            echo "Edit not success :<";
        }
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
        <form class="p-5" method="post">
        
            <a href="product-all.php" class="close"><i class="fa-solid fa-rectangle-xmark"></i></a>
            <a href="#" class="notice"><i class="fa-solid fa-triangle-exclamation"></i><span>You can't edit the product code.</span></a>
            
        <div class="container">   
            <div class="container d-flex">
                <div class="m-3">
                    <div class="form-group text-primary">
                        <label for="productCode">Product Code</label>
                        <input name="product_code" type="number" class="form-control" id="productCode" readonly value="<?php echo $product['product_code']; ?>">
                    </div>

                    <div class="form-group mt-3">
                        <label for="productame">Product Name</label>
                        <input name="product_name" type="text" class="form-control" id="productName" value="<?php echo $product['product_name']; ?>">
                    </div>

                    <div class="form-group mt-3">
                        <label for="cat">Category</label>
                        <select name="product_category" class="form-control" id="cat">
                            <?php 
                                echo "<option value='Branded'";
                                if($product['category'] == 'Branded')
                                {
                                    echo 'selected';
                                }
                                echo ">Branded</option>";

                                echo "<option value='Consumer Goods'";
                                if($product['category'] == 'Consumer Goods')
                                {
                                    echo 'selected';
                                }
                                echo ">Consumer Goods</option>";
                                
                                echo "<option value='Generic'";
                                if($product['category'] == 'Generic')
                                {
                                    echo 'selected';
                                }
                                echo ">Generic</option>";
                                
                                echo "<option value='Sari-Sari'";
                                if($product['category'] == 'Sari-Sari')
                                {
                                    echo 'selected';
                                }
                                echo ">Sari-Sari</option>";

                                echo "<option value='Med Supplies'";
                                if($product['category'] == 'Med Supplies')
                                {
                                    echo 'selected';
                                }
                                echo ">Med Supplies</option>";

                                echo "<option value='Milk'";
                                if($product['category'] == 'Milk')
                                {
                                    echo 'selected';
                                }
                                echo ">Milk</option>";
                            ?>
                        </select>
                    </div>
                </div>

                <div class="m-3">
                    <div class="form-group">
                        <label for="sellingPrice">Selling Price</label>
                        <input name="selling_price" type="number" class="form-control" id="sellingPrice" step="0.01" min="0" value="<?php echo $product['selling_price']; ?>">
                    </div>

                    <div class="form-group mt-3">
                        <label for="Measurement">Measurement</label>
                        <input name="product_measurement" type="text" class="form-control" id="Measurement" value="<?php echo $product['product_measurement'];?>">
                    </div>

                    <div class="form-group mt-3">
                        <label for="Measurement">Critical Level</label>
                        <input name="critical_level" type="number" class="form-control" id="Measurement" value="<?php echo $product['critical_level'];?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group m-auto p-4">
                <label for="desc">Product Description</label>
                <textarea name="product_desc" class="form-control" id="desc"><?php echo $product['product_desc']; ?></textarea>
            </div>
        </div>

        <div class="text-center">
            <input type="submit" name="save" id="save" class="btn btn-primary w-50 mt-3" value="Save">
        </div>
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