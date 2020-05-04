<?php

require('../config/define.php');
require('../config/db.php');

$match = "";
$unique = "";
$valid = true;

if(isset($_POST['create'])){

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $confirm = mysqli_real_escape_string($conn,$_POST['confirm']);

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $yearlevel = mysqli_real_escape_string($conn,$_POST['yearlevel']);

    $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm = filter_var($confirm, FILTER_SANITIZE_SPECIAL_CHARS);

    $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
    $age = filter_var($age, FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_var($address, FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($email, FILTER_SANITIZE_SPECIAL_CHARS);
    $yearlevel = filter_var($yearlevel, FILTER_SANITIZE_SPECIAL_CHARS);

    if($password != $confirm){
      $match = "Passwords doesn't match";
      $valid = false;
    }

    $query = "SELECT username,password FROM accounts";
    $result = mysqli_query($conn, $query);
    $accounts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($accounts as $account) {
      if ($account['username']==$username && $account['password']==$password ) {
        $unique = "Invalid Username";
        $valid = false;
      }
    }

    if ($valid) {
      $query = "INSERT INTO accounts (username,password)
              VALUES ('$username','$password');
          ";
      if(mysqli_query($conn, $query)){
      }else{
        echo 'Error' . mysqli_query($conn, $query);
      }

      $query = "SELECT account_id FROM accounts WHERE username = '{$username}' AND password = '{$password}'"; 
      $result = mysqli_query($conn, $query);
      $account = mysqli_fetch_assoc($result); 

      $account_id = mysqli_real_escape_string($conn,$account['account_id']);
      $account_id = filter_var($account_id, FILTER_SANITIZE_SPECIAL_CHARS);

      $query = "INSERT INTO profiles (name,age,address,email,yearlevel,account_id)
              VALUES ('$name','$age','$address','$email','$yearlevel','$account_id');
          ";
          
      if(mysqli_query($conn, $query)){
        header("Location: " . ROOT_URL . ' ');
      }else{
        echo 'Error' . mysqli_query($conn, $query);
      }

    }


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>PHP SIGN UP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container w-50" style="padding: 0px 100px;">
  <div class="shadow p-4 mb-4 bg-white mt-5"> <!--shadow-->
    <div class="text-center">
     <h2>Create account</h2>   
    </div>
    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" class="was-validated">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?php echo isset($_POST['username']) ? $username : ''; ?>" required>
        <?php if($unique!=""): ?>
        <div class="text-center text-danger pt-2"><?php echo $unique; ?></div>
        <?php endif; ?>  
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="text" class="form-control" id="password" placeholder="Enter password" name="password" value="<?php echo isset($_POST['password']) ? $password : ''; ?>" required>
        <?php if($match!=""): ?>
        <div class="text-center text-danger pt-2"><?php echo $match; ?></div>
        <?php endif; ?>  
      </div>
      <div class="form-group">
        <label for="confirm">Confirm Password:</label>
        <input type="text" class="form-control" id="confirm" placeholder="Enter password" name="confirm" value="<?php echo isset($_POST['confirm']) ? $confirm : ''; ?>" required>
      </div>
      <div class="text-center pt-4">
        <button type="button" class="btn btn-dark" data-toggle="collapse" data-target="#continue" onclick="this.style.display = 'none';">
        Continue
        </button>        
      </div>
    <div id="continue" class="collapse">
      <div class="text-center p-2">
       <h2>User Details</h2>   
      </div>
        <div class="row"> <!--row-->
          <div class="col-sm-7">  <!--col-sm-7-->
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
          </div>
          <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" value="<?php echo isset($_POST['address']) ? $address : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" required>
          </div>
          </div>  <!--col-sm-7-->
          <div class="col-sm-5">
          <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control" id="age" placeholder="Enter age" name="age" min="1" max="150" value="<?php echo isset($_POST['age']) ? $age : ''; ?>" required>
          </div>
          <div class="form-group">
            <label for="yearlevel">Year Level:</label>
            <input type="text" class="form-control" id="yearlevel" placeholder="Enter year level" name="yearlevel" value="<?php echo isset($_POST['yearlevel']) ? $yearlevel : ''; ?>" required>
          </div>
          </div>
        </div> <!--row-->
      <div class="text-right py-3">
        <button type="submit" name="create" class="btn btn-dark">Create</button>
      </div>
    </div>
    </form>
  </div> <!--shadow-->
</div>

</body>
</html>
