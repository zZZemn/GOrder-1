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

    if(isset($_GET['del_id']))
    {
        $del_id = $_GET['del_id'];

        $tbldeliver = "SELECT * FROM tbldeliver WHERE del_ID = $del_id";
        $result = $conn->query($tbldeliver);
        $deliver = $result->fetch_assoc();
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
        <link href="../../css/product-deliver-per-deliver.css" rel="stylesheet">
    </head>
    <body class="container p-5 d-flex justify-content-center align-items-center">

        <a href="product-deliver.php" class="back">
         <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="d-flex row justify-content-center">
            <div class="d-flex justify-content-between">
                <?php  
                $del_id = $_GET['del_id'];

                $tbldeliver = "SELECT * FROM tbldeliver WHERE del_ID = $del_id";
                $result = $conn->query($tbldeliver);
                $deliver = $result->fetch_assoc();

                $supp = $deliver['supplier_id'];

                $tblsupplier = "SELECT * FROM tblsupplier WHERE supplier_id = $supp";
                $result = $conn->query($tblsupplier);
                $supplier = $result->fetch_assoc();

                $tblInventory = "SELECT * FROM tblinventory WHERE del_ID = $del_id";
                $tblInventoryResult = $conn->query($tblInventory);
                ?>

                <h3><?php echo $deliver['delivery_date'] ?></h3>
                <h3><?php echo $supplier['supplier_name'] ?></h3>
            </div>
            <table class="table table-striped text-center mt-5">
                <thead>
                    <tr>
                        <th>Inventory Code</th>
                        <th>Product Code</th>
                        <th>Quantity</th>
                        <th>Expriration Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    
                     if($tblInventoryResult->num_rows > 0)
                     {
                        while($row = $tblInventoryResult->fetch_assoc())
                        {
                    ?>

                            <tr>
                                <td><?php echo $row['inv_code'] ?></td>
                                <td><?php echo $row['product_code'] ?></td>
                                <td><?php echo $row['qty'] ?></td>
                                <td><?php echo $row['expiration_date'] ?></td>
                            </tr>

                    <?php
                        }
                     }

                    ?>
                </tbody>
            </table>
        </div>

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