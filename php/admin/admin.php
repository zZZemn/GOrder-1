<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,900;1,200;1,500&family=Roboto+Condensed:wght@300;400&display=swap');
    </style>
    <link rel="stylesheet" href="../../css/admin-nav.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>GOrder | Admin</title>
</head>
<body>
      <nav class="top-nav">

        <img class="logo" src="../../img/ggd-text-logo.png" alt="Golden Gate Drugstore">

        <ul>
          <li><a><i class="fa-solid fa-message"></i></a></li>
          <li>
            <i class="fa-solid fa-bell"></i>
            <!-- <span class="badge rounded-pill badge-notification bg-danger">1</span> -->
          </li>
          
          <li class="avatar-dropdown" id="avatar-dropdown"><img src="https://avatars.githubusercontent.com/u/89580716?v=4" alt="avatar"></li>
            <div class="avatar-dropdown-container">
              <a href="#"><i class="fa-solid fa-user"></i>Profile</a>
              <hr>
              <a href="#"><i class="fa-solid fa-gear"></i>Settings</a>
              <hr>
              <a href="#"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
            </div>
        </ul>

      </nav>

      <div class="sidenav">
        <a href="#" class="nav-active"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
        
        <hr>

        <button class="dropdown-btn"><i class="fa-solid fa-chart-column"></i></i>Sales
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="#"><i class="fa-solid fa-chart-line"></i>Daily</a>
          <a href="#"><i class="fa-solid fa-chart-line"></i>Weekly</a>
          <a href="#"><i class="fa-solid fa-chart-line"></i>Monthly</a>
          <a href="#"><i class="fa-solid fa-chart-line"></i>Yearly</a>
        </div>

        <hr>

        <button class="dropdown-btn"><i class="fa-solid fa-folder"></i>Reports
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="#"><i class="fa-solid fa-chart-line"></i>Sales</a>
          <a href="#"><i class="fa-solid fa-chart-line"></i>Inventory</a>
          <a href="#"><i class="fa-solid fa-chart-line"></i>Products</a>
          <a href="#"><i class="fa-solid fa-chart-line"></i>Attendance</a>
        </div>

        <hr>

        <button class="dropdown-btn"><i class="fa-solid fa-users"></i>Users
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
          <a href="#"><i class="fa-solid fa-user-tie"></i>Employee</a>
          <a href="#"><i class="fa-solid fa-people-group"></i>Customer</a>
        </div>

        <hr>

      </div>

      <div class="main">
        hello
      </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>    
    <script src="https://kit.fontawesome.com/c6c8edc460.js" crossorigin="anonymous"></script>
    <script src="../../javascript/side-nav-dropdown.js"></script>
    <script src="../../javascript/nav-avatar-dropdown.js"></script>
</body>
</html>