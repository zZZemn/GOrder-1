<?php
include "../database/db.php";

  if (isset($_POST['query'])) {
    $query = $_POST['query'];

    // Query the database or perform any other search operation
    $sql = "SELECT * FROM tblproducts WHERE product_name LIKE '%$query%'";
    $search = $conn->query($sql);

    if($search->num_rows > 0)
    {
        while($row = $search->fetch_assoc())
        {
            $result = 
            "<tr>
                <td>".$row['product_code']."</td>
                <td>".$row['product_name']."</td>
                <td>".$row['category']."</td>
                <td>".$row['selling_price']."</td>
                <td>".$row['product_measurement']."</td>
                <td>".$row['critical_level']."</td>
                <td>".$row['product_qty']."</td>
                <td>".$row['product_desc']."</td>
            </tr>";
            
            echo $result;
        }
    }
    else
    {
        echo 
        "<tr>
            <td colspan='8' style = 'text-align: center; padding: 50px;'>
                <em>Product not found</em>
            </td>
        </tr>";
    }

  }
?>