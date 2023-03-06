<?php 
if (isset($_GET['invalid'])) {
    $invalid = (bool) $_GET['invalid'];
} 

else {
    $invalid = false;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>GOrder</title>
</head>
<body class="bg-primary">
    <form action="process/login-process.php" method="post" class="container w-50 h-75 bg-light rounded">
        <img src="img/ggd-logo.png" alt="Logo" class="login-logo-height mt-3">

        <?php if ($invalid): ?>
            <em class="invalid">Wrong email or password</em>
        <?php endif; ?>
        <hr class="line w-75 bg-secondary mb-3">

        <div class="form-outline mb-4 w-50">
            <input type="email" id="email" name="email" placeholder="Email" class="form-control">
        </div>
        
        <div class="form-outline mb-4 w-50">
            <input type="password" id="password" name="password" placeholder="Password" class="form-control">
        </div>  

        <div class="row mb-4 w-50">
            <div class="col d-flex justify-content-center">
              <!-- Checkbox -->
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="remember" checked />
                <label class="form-check-label" for="remember">Remember me</label>
              </div>
            </div>
        
            <div class="col">
              <a href="#!">Forgot password?</a>
            </div>
        </div>

        <button type="submit" name="signin" class="btn btn-primary btn-block mb-4 w-50">Sign in</button>

        <div class="text-center">
            <p>Don't have an account? <a href="#!">Register</a></p>
        </div>
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>    
</body>
</html>