<?php 
include ('../database/db.php');

if(isset($_POST['signin'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tblemployee WHERE email = '$email'";
    $result = $conn->query($sql);
    $employee = $result->fetch_assoc();

    if ($employee) {  
        if (password_verify($password, $employee["password"])) 
        {
            if ($employee["status"] == "active")
            {
                session_start();
                $_SESSION["user_ID"] = $employee["user_ID"];
                
                if($employee["role"] == "admin")
                    {
                        header("Location: ../php/admin.php");
                    }
    
                else if($employee["role"] === "assistant")
                    {
                        header("Location: ../php/pos.php");
                    }
    
                else if($employee["role"] === "rider")
                    {
                        header("Location: ../php/rider.php");
                    }
                exit;
            }
            else
            {
                echo 'Deactivated';
            }
        }
        else
        {
            $invalid = true;
            header("Location: ../index.php?invalid=$invalid");
            exit;
        }
    }
    else if(!$employee){
        $sql = "SELECT * FROM tblcustomer WHERE email = '$email'";
        $result = $conn->query($sql);
        $customer = $result->fetch_assoc();

        if($customer)
        {
            if (password_verify($password, $customer["password"])) 
            {
                if($customer['verified'] == true)
                {
                    echo "verified";
                }
                else
                {
                    echo "not verified";
                }
            }
            else
            {
                $invalid = true;
                header("Location: ../index.php?invalid=$invalid");
                exit;
            }
        }
    }
}
?>