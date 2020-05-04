<?php
session_start();
require('../config/define.php');
require('../config/db.php');

$query = "SELECT * FROM profiles WHERE account_id = " . $_SESSION['account_id'];
$result = mysqli_query($conn, $query);
$profile = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>PHP PROFILE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <style>
    *{
      font-size: 18px;
    }
  </style>
</head>
<body>
<div class="p-3">
  <a href="<?php echo ROOT_URL; ?>">
    <button type="button" class="btn btn-dark">Log out</button>
  </a>
</div>

  
<div class="container w-50"> <!--container-->
<div class="shadow p-4 mb-4 bg-white mt-4"> <!--shadow-->
<div class="card">
  <div class="card-header text-center">
    <h2>Hello, <?php echo $profile['name']; ?></h2>
  </div>
  <div class="card-body">
    <p>Age: <?php echo $profile['age']; ?></p>
    <p>Address: <?php echo $profile['address']; ?></p>
    <p>Email: <?php echo $profile['email']; ?></p>
    <p>Year Level: <?php echo $profile['yearlevel']; ?></p>
    <p>Date Created: <?php echo $_SESSION['date']; ?></p>
  </div>
</div>
</div> <!--shadow-->
</div> <!--container-->
</body>
</html>