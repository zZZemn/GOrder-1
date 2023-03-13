<?php 
  session_start();

  include("../process/date-time.php");

  if (isset($_SESSION["user_ID"])) 
  {
      include("../database/db.php");
  
      $sql = "SELECT * FROM tblemployee
              WHERE user_ID = {$_SESSION["user_ID"]}";
      $result = $conn->query($sql);
      $user = $result->fetch_assoc();
  }

  if(isset($_POST['submit-procode']))
  {
    $product_code = $_POST['product_code'];

    $checkProQty = "SELECT * FROM tblinventory WHERE product_code = $product_code";
    $checkProQtyRes = $conn->query($checkProQty);
    $pro_qty = 0;

    if($checkProQtyRes->num_rows > 0)
    {
        while($qty_row = $checkProQtyRes->fetch_assoc())
        {
            $pro_qty += $qty_row['qty'];
        }
    }
    
    if($pro_qty > 0)
    {
        $pro_price = "SELECT * FROM tblproducts WHERE product_code = $product_code";
        $pro_price_res = $conn->query($pro_price);
        $price = $pro_price_res->fetch_assoc();
    
        $poscheck = "SELECT * FROM tblpos_cur_process WHERE product_code = $product_code";
        $poscheckres = $conn->query($poscheck);
    
        if($poscheckres->num_rows > 0)
        {
            $pos_check_row = $poscheckres->fetch_assoc();
            $amt = $pos_check_row['amount'];
            $new_amt = $amt + $price['selling_price'];
            $new_qty = $pos_check_row['qty'] + 1;
    
            $posqtyupdate = "UPDATE `tblpos_cur_process` SET `qty`='$new_qty',`amount`='$new_amt' WHERE product_code = $product_code";
    
            $conn->query($posqtyupdate);
        }
        
        else
        {
        $count = 1;
        $qty = 1;
        $amount = 0;
    
        $amount = $price['selling_price'] * $qty;
        
        $tblpos = "SELECT COUNT(*) as count FROM tblpos_cur_process";
        $result = $conn->query($tblpos);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row["count"] + 1;
        }
    
        $pos_insert = "INSERT INTO `tblpos_cur_process`(`row`, `product_code`, `qty`, `amount`) 
        VALUES ('$count','$product_code','$qty','$amount')";
    
        $conn->query($pos_insert);
    
        }
    }

    else
    {
        $tblproduct = "SELECT * FROM tblproducts WHERE product_code = $product_code";
        $tblproductRes = $conn->query($tblproduct);
        $product = $tblproductRes->fetch_assoc();

        echo "<script type='text/javascript'>
                window.onload = function () { alert('".$product['product_name']." is out of stock!'); }
            </script>";
    }
   
  }


  if(isset($_POST['save']))
  {
    $payment = $_POST['payment'];
    $change = $_POST['change'];
    $total = $_POST['total'];
    $vat = $_POST['vat'];
    $subtotal = $_POST['subtotal'];
    $discount = $_POST['discount'];
    $custID = $_POST['customer'];
    $custID_insert = null;

    if($custID > 0)
    {
        $custID_insert = $custID;
    }

    include("../process/date-time.php");

    $process_id = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);

    $process_id_query = "SELECT COUNT(*) AS count FROM tblinvoice WHERE process_id = $process_id";
    $process_id_result = $conn->query($process_id_query);
    $invoice = $process_id_result->fetch_assoc();

    while($invoice['count'] > 0)
    {
        $process_id = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);

        $process_id_query = "SELECT COUNT(*) AS count FROM tblinvoice WHERE process_id = $process_id";
        $process_id_result = $conn->query($process_id_query);
        $invoice = $process_id_result->fetch_assoc();
    } 

    $process_by = $user['first_name']." ".$user['last_name'];

    if($payment >= $total)
    {
        $insert_invoice = "INSERT INTO `tblinvoice`(`process_id`, `subtotal`, `vat`, `discount`, `total`, `payment`, `change`, `cust_ID`, `date`, `time`, `processed_by`) 
                            VALUES ('$process_id','$subtotal','$vat','$discount','$total','$payment','$change','$custID_insert','$date','$time', '$process_by')";

        if($conn->query($insert_invoice))
        {
            $curr_pos = "SELECT * FROM tblpos_cur_process";
            $curr_pos_res = $conn->query($curr_pos);

            if($curr_pos_res->num_rows > 0){
                while($row = $curr_pos_res->fetch_assoc())
                {
                    $product_code = $row['product_code'];
                    $qty = $row['qty'];
                    $amt = $row['amount'];

                    $insert_prod_sales = "INSERT INTO `tblproduct_sales`(`process_id`, `product_code`, `qty`, `amount`) 
                    VALUES ('$process_id','$product_code','$qty','$amt')";

                    if($conn->query($insert_prod_sales))
                    {
                        $prosalesrow = $row['row'];
                        $curposdel = "DELETE FROM `tblpos_cur_process` WHERE row = $prosalesrow";
                        $conn->query($curposdel);
                    }
                }
            }
        }
    }

    else 
    {
        echo "<script>alert('The payment must be greater than or equal to ".$total." pesos.');</script>";
    }
  }



?>

<?php if (isset($user) && $user["role"] == "admin" || $user['role'] == "assistant"): ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,900;1,200;1,500&family=Roboto+Condensed:wght@300;400&display=swap');
        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous">
        <link rel="shortcut icon" href="../../img/ggd-logo.png" type="image/x-icon">
        <link rel="stylesheet" href="../css/pos.css">
        <title>GOrder | POS</title>
    </head>
    <body>
        <nav class="top-nav bg-dark">
            <img class="logo" src="../img/ggd-text-logo.png" alt="Golden Gate Drugstore">

            <ul>

                <li class="message-dropdown">
                    <a>
                        <i class="fa-solid fa-message"></i>
                    </a>
                </li>
                <div class="message-dropdown-container">

                    <a href="#">
                        <div class="from">
                            <img src="https://avatars.githubusercontent.com/u/89580716?v=4" alt="avatar">
                            <h3>Emmanuel Ugaban</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis, veritatis
                            iusto suscipit eos voluptate, quae totam nisi nihil facilis accusantium a
                            nesciunt labore, sit accusamus provident architecto delectus ipsa quas.</p>
                        <article>03/07/25</article>
                    </a>
                    <hr>

                    <a href="#">
                        <div class="from">
                            <img src="https://avatars.githubusercontent.com/u/89580716?v=4" alt="avatar">
                            <h3>Emmanuel Ugaban</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis, veritatis
                            iusto suscipit eos voluptate, quae totam nisi nihil facilis accusantium a
                            nesciunt labore, sit accusamus provident architecto delectus ipsa quas.</p>
                        <article>03/07/25</article>
                    </a>
                    <hr>

                    <a href="#">
                        <div class="from">
                            <img src="https://avatars.githubusercontent.com/u/89580716?v=4" alt="avatar">
                            <h3>Emmanuel Ugaban</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis, veritatis
                            iusto suscipit eos voluptate, quae totam nisi nihil facilis accusantium a
                            nesciunt labore, sit accusamus provident architecto delectus ipsa quas.</p>
                        <article>03/07/25</article>
                    </a>
                    <hr>

                    <a href="#">
                        <div class="from">
                            <img src="https://avatars.githubusercontent.com/u/89580716?v=4" alt="avatar">
                            <h3>Emmanuel Ugaban</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis, veritatis
                            iusto suscipit eos voluptate, quae totam nisi nihil facilis accusantium a
                            nesciunt labore, sit accusamus provident architecto delectus ipsa quas.</p>
                        <article>03/07/25</article>
                    </a>
                    <hr>

                    <a href="#">
                        <div class="from">
                            <img src="https://avatars.githubusercontent.com/u/89580716?v=4" alt="avatar">
                            <h3>Emmanuel Ugaban</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis, veritatis
                            iusto suscipit eos voluptate, quae totam nisi nihil facilis accusantium a
                            nesciunt labore, sit accusamus provident architecto delectus ipsa quas.</p>
                        <article>03/07/25</article>
                    </a>
                    <hr>

                </div>

                <li class="notification-dropdown">
                    <i class="fa-solid fa-bell"></i>
                    <?php
              $sql = "SELECT * FROM tblproducts
              WHERE product_qty < critical_level";
              $result = $conn->query($sql);
              
              if($result->num_rows >0)
              {
            ?>
                    <span class="badge rounded-pill badge-notification bg-danger"><?php echo $result->num_rows?></span>
                    <?php
              }
            ?>
                </li>
                <div class="notification-dropdown-container">
                    <?php 
              if($result->num_rows > 0)
              {
                while($row = $result->fetch_assoc())
                {
            ?>
                    <a href="#">
                    <?php
                      if($row['product_qty'] > 0)
                      {
                        echo "Product ".$row['product_name']." Low Quantity";
                      }
                      else 
                      {
                        echo "<span style='color: red;'>".$row['product_name']."</span> is out of stock";
                      }
                    ?>
                    </a>
                    <hr>
                    <?php
                }
              }
            ?>
                </div>

                <li class="avatar-dropdown"><img src="https://avatars.githubusercontent.com/u/89580716?v=4" alt="avatar"></li>
                <div class="avatar-dropdown-container">
                    <a href="avatar-profile.php">
                        <i class="fa-solid fa-user"></i>Profile</a>
                    <hr>
                    <a href="avatar-setting.php">
                        <i class="fa-solid fa-gear"></i>Settings</a>
                    <hr>
                    <a href="../process/logout-process.php">
                        <i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                    <?php 
                     if($user['role'] == "admin")
                     {
                        echo '<hr><a href="admin/admin.php"><i class="fa-solid fa-desktop"></i>Admin</a>';
                     }
                    ?>
                </div>
            </ul>

        </nav>

        <div class="pos-parent">

            <div class="left">
                <div class="item-pick-container">
                    <form class="search-bar mt-3">
                        <input type="text" id="search" placeholder="Scan Barcode / Search... " value="">
                        <button type="submit" disabled="disabled">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    <div class="result" id="results">

                        <?php
                    $sql = "SELECT * FROM tblproducts ORDER BY product_name ASC";
                    $result = $conn->query($sql);
                    $number_of_pro = 0;
                    
                    if($result->num_rows > 0)
                    {
                        while($row = $result->fetch_assoc())
                        {
                          $invQty = 0;

                          $number_of_pro += 1;

                          $product_code = $row['product_code'];
                          $tblInventory = "SELECT * FROM tblinventory WHERE product_code = $product_code";
                          $tblInventoryResult = $conn->query($tblInventory);
                          if($tblInventoryResult->num_rows > 0)
                          {
                            while($tblInventoryRow = $tblInventoryResult->fetch_assoc())
                            {
                              $invQty += $tblInventoryRow['qty'];
                            }
                          }
                          ?>

                        <form class="product-select" method="post">
                            <input
                                type="hidden"
                                name="product_code"
                                value="<?php echo $row['product_code'] ?> ">
                            <button class="btn" type="submit" name="submit-procode">

                                <?php echo $row['product_name']." ". $row['product_measurement']  ?>
                                <div class="details-container">
                                    <div class="detail"><?php echo "PHP ".$row['selling_price']." - ".$invQty." pc/s" ?></div>
                                </div>
                            </button>
                        </form>

                        <?php
                        }
                    }
                ?>
                    </div>

                    <div class="sales">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="11">
                                        Sales 
                                        <?php echo $date ?> 
                                    </th>
                                </tr>
                                <tr>
                                    <th>Process&nbsp;ID</th>
                                    <th>Customer&nbsp;ID</th>
                                    <th>Subtotal</th>
                                    <th>VAT</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Change</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    <th>Processed&nbsp;by</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php  
                                $invoice = "SELECT * FROM tblinvoice";
                                $invoice_res = $conn->query($invoice);

                                if($invoice_res->num_rows > 0)
                                {
                                    while($inv_row = $invoice_res->fetch_assoc())
                                    {
                                        $cust_id = $inv_row['cust_ID'];
                                        
                                        ?>

                                        <tr>
                                            <td><a href="admin/invoice.php?process_id=<?php echo $inv_row['process_id'] ?>"><?php echo $inv_row['process_id'] ?></a></td>
                                            <td><a href="admin/customer.php?customer_id=<?php echo $cust_id?>"><?php echo $cust_id ?></a></td>
                                            <td><?php echo $inv_row['subtotal'] ?></td>
                                            <td><?php echo $inv_row['vat'] ?></td>
                                            <td><?php echo $inv_row['discount']?></td>
                                            <td><?php echo $inv_row['total'] ?></td>
                                            <td><?php echo $inv_row['payment'] ?></td>
                                            <td><?php echo $inv_row['change'] ?></td>
                                            <td><?php echo $inv_row['time'] ?></td>
                                            <td><?php echo $inv_row['date'] ?></td>
                                            <td><?php echo $inv_row['processed_by'] ?></td>
                                        </tr>

                                        <?php
                                    }
                                }
                                
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="right">

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Measurement</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            
                            $pos_items_query = "SELECT * FROM tblpos_cur_process";
                            $pos_items = $conn->query($pos_items_query);
                            
                            if($pos_items->num_rows > 0)
                            {
                                while($item = $pos_items->fetch_assoc())
                                {
                                    $product_code = $item['product_code'];

                                    $product_query = "SELECT * FROM tblproducts WHERE product_code = $product_code"; 
                                    $product_query_res = $conn->query($product_query);
                                    $product = $product_query_res->fetch_assoc();
                            ?>

                            <tr>
                                <td class="product-name"><?php echo $product['product_name']?></td>
                                <td><?php echo $product['product_measurement']?></td>
                                <td><?php echo $product['selling_price'] ?></td>
                                <td><input
                                    type="number"
                                    min="1"
                                    class="quantity-input"
                                    data-product-id="<?php echo $item['product_code'] ?>"
                                    name="qty"
                                    id="qty"
                                    value="<?php echo $item['qty'] ?>"></td>
                                <td>
                                    <span
                                        class="price-display"
                                        data-product-id="<?php echo $item['product_code'] ?>"><?php echo $item['amount'] ?></span></td>
                                <td></tr>

                                <?php
                                }
                            }
                            
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <form method="post">
                        <div class="compute">
                            <div class="r">
                                <div class="txt-container">
                                    <div>
                                        <label for="customer">Customer</label>
                                        <input type="number" id="customer" name="customer" list="cust">

                                        <datalist id="cust">
                                            <?php 
                                        $sql = "SELECT * FROM tblcustomer";
                                        $result = $conn->query($sql);

                                        if($result->num_rows > 0)
                                        {
                                            while($customer = $result->fetch_assoc())
                                            {
                                                ?>
                                            <option value="<?php echo $customer['cust_ID'] ?>"><?php echo $customer['first_name']." ".$customer['last_name']." - ".$customer['age']  ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                        </datalist>

                                    </div>

                                    <div>
                                        <label for="payment">Payment</label>
                                        <input type="number" id="payment" name="payment" required="required">
                                    </div>

                                    <div>
                                        <label for="change">Change</label>
                                        <input type="number" id="change" name="change" value="0.00" readonly="readonly">
                                    </div>
                                </div>

                                <div class="pos-btn">
                                    <input type="submit" name="save" value="Save" class="btn btn-primary">
                                    <input type="submit" name="reset" value="Reset" class="btn btn-dark">
                                </div>
                            </div>

                            <?php 
                            $subtotal = 0;
                            $sql = "SELECT * FROM tblpos_cur_process";
                            $result = $conn->query($sql);
                            if($result->num_rows > 0)
                            {
                                while($row = $result->fetch_assoc())
                                {
                                    $subtotal += $row['amount'];
                                }
                            }

                            $maintenance_query = "SELECT * FROM `tblmaintenance` WHERE 1";
                            $maintenance_query_res = $conn->query($maintenance_query);
                            $maintenance = $maintenance_query_res->fetch_assoc();

                                          
                            $taxPercentage = $maintenance['tax_percentage'];                        
                            $discountpercentage = $maintenance['discount'];
                            
                            $vat = $subtotal * $taxPercentage;

                            $total = $subtotal + $vat;
                            // $discount = $subtotal2 * $discountpercentage;
                            // $total = $subtotal2 + $vat;

                            $rounded_subtotal = number_format($subtotal, 2, '.', '');
                            $rounded_vat = number_format($vat, 2, '.', '');
                            // $rounded_discount = number_format($discount, 2, '.', '');
                            $rounded_total = number_format($total, 2, '.', '');
                    ?>

                            <input
                                type="hidden"
                                id="tax-percentage"
                                value="<?php echo $maintenance['tax_percentage'] ?>">
                            <input
                                type="hidden"
                                id="discount-percentage"
                                value="<?php echo $maintenance['discount'] ?>">

                            <div class="l">
                                <div class="child">
                                    <div>
                                        <label for="vat">VAT</label>
                                        <input
                                            type="number"
                                            id="vat"
                                            name="vat"
                                            readonly="readonly"
                                            value="<?php echo $rounded_vat ?>">
                                    </div>

                                    <div>
                                        <label for="dicount">Discount</label>
                                        <input
                                            type="number"
                                            id="discount"
                                            name="discount"
                                            readonly="readonly"
                                            value="0.00">
                                    </div>
                                </div>

                                <div class="child">
                                    <div>
                                        <label for="subtotal">Subtotal</label>
                                        <input
                                            type="number"
                                            id="subtotal"
                                            name="subtotal"
                                            readonly="readonly"
                                            value="<?php echo $rounded_subtotal ?>">
                                    </div>
                                    <div>
                                        <label for="total">Total</label>
                                        <input
                                            type="number"
                                            id="total"
                                            name="total"
                                            readonly="readonly"
                                            value="<?php echo $rounded_total ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

            <script
                src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
                integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
                crossorigin="anonymous"></script>
            <script
                src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
                integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
                crossorigin="anonymous"></script>
            <script src="https://kit.fontawesome.com/c6c8edc460.js" crossorigin="anonymous"></script>
            <script src="../../javascript/side-nav-dropdown.js"></script>
            <script src="../javascript/nav-avatar-dropdown.js"></script>
            <script src="../javascript/nav-notif-dropdown.js"></script>
            <script src="../javascript/nav-message-dropdown.js"></script>
            <script src="../javascript/pos-product-search.js"></script>
            <script src="../javascript/pos-quantity.js"></script>
            <script src="../javascript/pos-vat.js"></script>
            <script src="../javascript/pos-calculate.js"></script>

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