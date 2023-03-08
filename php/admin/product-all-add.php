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

    if(isset($_POST['add']))
    {
        $product_code = null;
        $random_number = sprintf("%05d", rand(0, 99999));
        $sqlP_code = "SELECT product_code FROM tblproducts WHERE product_code = '$random_number'";
        
        if($p_code_result = $conn->query($sqlP_code))
        {
            while($p_code_result->num_rows > 0)
            {
                $random_number = sprintf("%05d", rand(0, 99999));
            }
            $product_code = $random_number;
        }

        $product_name = $_POST['product_name'];
        $product_category = $_POST['product_category'];
        $selling_price = $_POST['selling_price'];
        $product_measurement = $_POST['product_measurement'];
        $critical_level = $_POST['critical_level'];
        $product_desc = $_POST['product_desc'];

        $sqlAdd = "INSERT INTO tblproducts(`product_code`, `product_name`, `category`, `selling_price`
        ,`product_measurement`, `critical_level`, `product_desc`) 
        VALUES ('$product_code','$product_name','$product_category','$selling_price','$product_measurement','$critical_level','$product_desc')";

        if($conn->query($sqlAdd))
        {
            header("Location: product-all.php");
        }
        else
        {
            echo "
            <script>
                alert('Failed to add this product.');
            </script>
            ";
        }
    }
?>

<?php if (isset($user) && $user["role"] == "admin"): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Product</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous">
        <link href="../../css/product-all-add.css" rel="stylesheet">
    </head>
    <body
        class="container p-5 d-flex justify-content-center align-items-center bg-primary">
        <form class="p-5" method="post">
            <a href="product-all.php" class="close">
                <i class="fa-solid fa-rectangle-xmark"></i>
            </a>
            <div class="container d-flex">
                <div class="m-3">
                    <div class="form-group mt-3">
                        <label for="productame">Product Name</label>
                        <input
                            name="product_name"
                            type="text"
                            class="form-control"
                            id="productName"
                            required="required">
                    </div>

                    <div class="form-group mt-3">
                        <label for="cat">Category</label>
                        <select
                            name="product_category"
                            class="form-control"
                            id="cat"
                            required="required">
                            <option>Branded</option>
                            <option>Consumer Goods</option>
                            <option>Generic</option>
                            <option>Sari-Sari</option>
                            <option>Med Supplies</option>
                            <option>Milk</option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="sellingPrice">Selling Price</label>
                        <input
                            name="selling_price"
                            type="number"
                            class="form-control"
                            id="sellingPrice"
                            step="0.01"
                            min="0"
                            required="required">
                    </div>
                    <div class="form-group mt-3">
                        <label for="Measurement">Measurement</label>
                        <input
                            name="product_measurement"
                            type="text"
                            class="form-control"
                            id="Measurement">
                    </div>
                </div>

                <div class="desc m-3">

                    <div class="form-group mt-3">
                        <label for="criticalLevel">Critical Level</label>
                        <input
                            name="critical_level"
                            type="number"
                            class="form-control"
                            id="criticalLevel"
                            required="required">
                    </div>
                    <div class="form-group m-auto p-3">
                        <label>Product Description</label>
                        <textarea name="product_desc" class="form-control" id="desc"></textarea>
                    </div>

                    <div class="text-center">
                        <input
                            type="submit"
                            name="add"
                            id="save"
                            class="btn btn-primary w-50 mt-3"
                            value="Add">
                    </div>
                </div>
            </div>

        </div>
    </form>

    <script src="https://kit.fontawesome.com/c6c8edc460.js" crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
        crossorigin="anonymous"></script>

<?php else: ?>
    <div
        class="no-account-selected"
        style="height: 90vh; display:flex; flex-direction:column; justify-content:center; align-items:center; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color:red">
        <h1 style="font-size: 40px;">You don't have permission to access this page</h1>
        <a
            href="../../index.php"
            style="background-color: #007bff; color: white; padding:10px 30px; border-radius:5px; text-decoration:none; font-weight:900;">Login</a>
    </div>
    <?php endif; ?>

    <script>
        if (window.history.replaceState) {
            window
                .history
                .replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>