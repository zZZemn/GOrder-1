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

$process_id = $_GET['process_id'];

$tblProductSales = "SELECT * FROM tblproduct_sales WHERE process_id = $process_id";
$tblProductSalesResult = $conn->query($tblProductSales);

$tblinvoice = "SELECT * FROM tblinvoice WHERE process_id = $process_id";
$tblinvoiceRes = $conn->query($tblinvoice);
$invoice = $tblinvoiceRes->fetch_assoc();

?>

<?php if (isset($user) && $user["role"] == "admin" || $user['role'] == "assistant"): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice -
            <?php echo $process_id ?></title>
        <link rel="shortcut icon" href="" type="image/x-icon">
        <link rel="stylesheet" href="../../css/invoice.css">
    </head>
    <body>
        <table>
            <thead>
                <tr class="store-name"><th colspan="3"><p class="storename">GOLDEN GATE DRUGSTORE</p></th></tr>
                <tr class="address"><th colspan="3"><p class="address">Estrella Homes Subdivision, Ilang Ilang, Patubig, Marilao, Bulacan</p></th></tr>
                <tr class="pb" >
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Amount</th>
                </trcl>
            </thead>
            <tbody>

                <?php 
        
        if($tblProductSalesResult->num_rows > 0)
        {
            while($row = $tblProductSalesResult->fetch_assoc())
            {
                $product_code = $row['product_code'];
                $product = "SELECT * FROM tblproducts WHERE product_code = $product_code";
                $productRes = $conn->query($product);
                $productRow = $productRes->fetch_assoc();

                ?>

                <tr>
                    <td><?php echo $productRow['product_name']." ".$productRow['product_measurement'] ?></td>
                    <td><?php echo $row['qty'] ?></td>
                    <td><?php echo $row['amount'] ?></td>
                </tr>

                <?php
            }
        }
        
        ?>
                <tr>
                    <td colspan="3">---------------------------------------------------------------------------------</td>
                </tr>
                <tr>
                    <td colspan="2">Subtotal</td>
                    <td><?php echo $invoice['subtotal'] ?></td>
                </tr>
                <tr>
                    <td colspan="2">VAT</td>
                    <td><?php echo $invoice['vat'] ?></td>
                </tr>
                <tr>
                    <td colspan="2">Discount</td>
                    <td><?php echo $invoice['discount'] ?></td>
                </tr>
                <tr>
                    <td colspan="2">Total</td>
                    <td><?php echo $invoice['total'] ?></td>
                </tr>
                <tr>
                    <td colspan="3">---------------------------------------------------------------------------------</td>
                </tr>
                <tr>
                    <td colspan="2">Payment</td>
                    <td><?php echo $invoice['payment'] ?></td>
                </tr>
                <tr>
                    <td colspan="2">Change</td>
                    <td><?php echo $invoice['change'] ?></td>
                </tr>
                <tr>
                    <td colspan="3">---------------------------------------------------------------------------------</td>
                </tr>

                <tr>
                    <td>
                        <p class="date"><?php echo $invoice['time'] ?></p>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <p class="time"><?php echo $invoice['date'] ?></p>
                    </td>
                </tr>
            </tbody>
        </table>

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
    </body>
</html>