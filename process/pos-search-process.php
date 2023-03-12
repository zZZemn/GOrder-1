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
            $pro_code = $row['product_code'];
            $invQty = 0;
            $tblInventory = "SELECT * FROM tblinventory WHERE product_code = $pro_code";
                          $tblInventoryResult = $conn->query($tblInventory);
                          if($tblInventoryResult->num_rows > 0)
                          {
                            while($tblInventoryRow = $tblInventoryResult->fetch_assoc())
                            {
                              $invQty += $tblInventoryRow["qty"];
                            }
                          }
            $result = "<form class='product-select' method='post'>
            <input
                type='hidden'
                name='product_code'
                value=".$row['product_code'].">
            <button class='btn' type='submit' name='submit-procode'>

                ".$row['product_name']." ". $row['product_measurement']."
                <div class='details-container'>
                    <div class='detail'>".$row['selling_price']." - ".$invQty."pc/s</div>
                </div>
            </button>
        </form>";

        echo $result;
        }
    }

    else
    {
        echo 
        "<tr>
            <td colspan='8' style = 'text-align: center; padding: 50px;'>
                <em style='color: red;'>Product not found</em>
            </td>
        </tr>";
    }

  }
  else 
  {
    echo "all data";
  }
?>