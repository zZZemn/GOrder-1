<?php 
    session_start();
    if (isset($_SESSION["user_ID"])) 
    {
        include("../database/db.php");
    
        $sql = "SELECT * FROM tblemployee
                WHERE user_ID = {$_SESSION["user_ID"]}";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();

        if (isset($user) && $user["role"] == "admin")
        {
            if(isset($_GET['product_code']))
            {
                $product_code = $_GET['product_code'];
                $delete = "DELETE FROM `tblproducts` WHERE product_code = $product_code";
                if($conn->query($delete))
                {
                    header("Location: ../php/admin/product-all.php");
                }
                else
                {
                    echo "Delet not success :<";
                }
            }
            else
            {
                echo "<div class='no-account-selected' style='height: 90vh; display:flex; flex-direction:column; justify-content:center; align-items:center; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color:red'>
                <h1 style='font-size: 40px;'>You don't have permission to access this page</h1>
                <a href='../index.php' style='background-color: #007bff; color: white; padding:10px 30px; border-radius:5px; text-decoration:none; font-weight:900;'>Login</a>
                </div>";
            }
        }
        else 
        {
            echo "<div class='no-account-selected' style='height: 90vh; display:flex; flex-direction:column; justify-content:center; align-items:center; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color:red'>
                <h1 style='font-size: 40px;'>You don't have permission to access this page</h1>
                <a href='../index.php' style='background-color: #007bff; color: white; padding:10px 30px; border-radius:5px; text-decoration:none; font-weight:900;'>Login</a>
                </div>";
        }
    }
    else
    {
        echo "<div class='no-account-selected' style='height: 90vh; display:flex; flex-direction:column; justify-content:center; align-items:center; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; color:red'>
                <h1 style='font-size: 40px;'>You don't have permission to access this page</h1>
                <a href='../index.php' style='background-color: #007bff; color: white; padding:10px 30px; border-radius:5px; text-decoration:none; font-weight:900;'>Login</a>
                </div>";
    }
?>

<head></head>