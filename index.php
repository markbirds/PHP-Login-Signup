<?php
session_start();
require('config/define.php');
require('config/db.php');

$match = "";

if(isset($_POST['login'])){ 

  $username = mysqli_real_escape_string($conn,$_POST['username']);
  $password = mysqli_real_escape_string($conn,$_POST['password']);

  $username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
  $password = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);

  $query = "SELECT * FROM accounts";
  $result = mysqli_query($conn, $query);
  $accounts = mysqli_fetch_all($result, MYSQLI_ASSOC);

  foreach ($accounts as $account) {
    if($account['username']==$username && $account['password']==$password){
      $_SESSION['account_id'] = $account['account_id'];
      $_SESSION['date'] = $account['date'];
      header("Location: " . ROOT_URL . 'process/profile.php  ');
    }
  }

  $match = "Account not found";

  mysqli_free_result($result);
  mysqli_close($conn);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>PHP LOGIN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container w-25" style="padding-top: 120px;"> <!--container-->
<div class="shadow p-4 mb-4 bg-white"> <!--shadow-->
  <div class="text-center py-3">
    <h2>PHP Login</h2>    
  </div>
  <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" class="needs-validation" novalidate>
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value="<?php echo isset($_POST['username']) ? $username : ''; ?>" required>
      <?php if($match!=""): ?>
        <div class="text-center text-danger pt-2"><?php echo $match; ?></div>
      <?php endif; ?>  
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" value="<?php echo isset($_POST['password']) ? $password : ''; ?>" required>
    </div>
    <div class="text-center">
       <button type="submit" name="login" class="btn btn-dark">Login</button>   
    </div>
  </form>
</div> <!--shadow-->
<div class="text-center">
  <a href="<?php echo ROOT_URL . 'process/create.php'; ?>" class="text-dark">Create an account</a>
</div>
</div> <!--container-->

<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

</body>
</html>
