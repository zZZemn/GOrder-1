<?php
include("../database/db.php");

$customerId = $_POST['customerId'];

if (!empty($customerId)) {
  $sql = "SELECT age FROM tblcustomer WHERE cust_ID = $customerId";
  $result = $conn->query($sql);

  if ($result) {
    $row = $result->fetch_assoc();
    $customerAge = $row['age'];

    // Return the customer age
    echo $customerAge;
  } 
  else {
    // Return an error message
    echo "Error: " . $conn->error;
  }
}

 else {
  // Return a default value or an error message
  echo "Customer ID is empty";
}


?>