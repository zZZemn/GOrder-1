<?php
include "../database/db.php";

  if (isset($_POST['query'])) 
  {
    $query = $_POST['query'];

    $sql = "SELECT * FROM tblproducts WHERE product_name LIKE '%$query%' OR product_code LIKE '%$query%' OR category LIKE '%$query%' ORDER BY product_name ASC";
    $search = $conn->query($sql);

    if($search->num_rows > 0)
    {
        while($row = $search->fetch_assoc())
        {
            $result = 
            "<tr>
                <th scope='row'>".$row['product_code']."</th>
                <td>".$row['product_name']."</td>
                <td>".$row['category']."</td>
                <td>".$row['selling_price']."</td>
                <td>".$row['product_measurement']."</td>
                <td>".$row['critical_level']."</td>
                <td>".$row['product_qty']."</td>
                <td class='action-btn'>
                    <a href='#' class='desc'><i class='fa-solid fa-bookmark'></i><span>".$row['product_desc']."</span></a>
                    <a href='product-all-edit.php?product_code=".$row['product_code']."'><i class='fa-solid fa-pen-to-square'></i></a>
                    <a href='product-all-delete.php?product_code=".$row['product_code']."'><i class='fa-solid fa-trash-can'></i></a>
                </td>
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
  else 
  {
    echo "all data";
  }
?>