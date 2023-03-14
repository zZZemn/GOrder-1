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

$customer_id = $_GET['customer_id'];

$customerSQL = "SELECT * FROM tblcustomer WHERE cust_ID = $customer_id";
$customerSQLResult = $conn->query($customerSQL);
$customer = $customerSQLResult->fetch_assoc();


?>

<?php if (isset($user) && $user["role"] == "admin" || $user['role'] == "assistant"): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $customer['first_name']." ".$customer['last_name'] ?></title>
        <link rel="shortcut icon" href="" type="image/x-icon">
        <link rel="stylesheet" href="../../css/customer.css">
    </head>
    <body>

        <table>
            <tr>
                <td rowspan="7"><img src="../../img/<?php echo $customer['sample_picture'] ?>"></td>
                <td colspan="2" class="bl"><?php echo $customer['first_name']." ".$customer['last_name'] ?></td>
            </tr>
            <tr>
                <td colspan="2" class="bl"><?php echo $customer['email'] ?></td>
            </tr>
            <tr>
                <td colspan="2" class="bl"><?php echo $customer['contact_num'] ?></td>
            </tr>
            <tr class="title">
                <td colspan="2" class="bl">Address</td>
            </tr>
            <tr>
                <td colspan="2" class="bl"><?php echo $customer['address'] ?></td>
            </tr>

            <tr class="title">
                <td>Age</td>
                <td>Sex</td>
            </tr>
            <tr class="ct">
                <td class="bl"><?php echo $customer['age'] ?></td>
                <td><?php echo $customer['sex'] ?></td>
            </tr>
        </tr>
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