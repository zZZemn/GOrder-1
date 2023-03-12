<?php 
  session_start();

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
            </div>
            <div class="right">asd</div>

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