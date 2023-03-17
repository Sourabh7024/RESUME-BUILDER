<?php
 include './partials/dbconnect.php';
$showAlert= false;
$showError= false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  // check weather this username exists or not 
  $existSql = "SELECT * FROM `profiles` WHERE `username` LIKE '$username'";
  $result= mysqli_query($conn,$existSql);
  $numRowsExist = mysqli_num_rows($result);
  if($numRowsExist > 0){
    $exists = true;
    $showError= true;
  }else {
          $hash = password_hash($password, PASSWORD_DEFAULT);
          $sql3="INSERT INTO `profiles` (`name`, `email`, `username`, `password`, `dt`) VALUES ('$name', '$email','$username', '$hash', current_timestamp())";
          $result3= mysqli_query($conn,$sql3);
          if ($result3){
            $showAlert= true;
          }else{
            echo "Connection failed";
            }
      }
    }
?>



<?php include "./header.php"?>

<!-- ALERT -->
<?php  
  if($showAlert) { ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Successfully:</strong> Your account is created.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php }
  ?>
<?php  
  if($showError) { ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Alert:</strong> Username Already exists.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php }
  ?>

<div class="form-container">
  <form action="./signup.php" class="form" method="post" enctype="multipart/form-data">
    <h2>Signup</h2>
    <div class="mb-3">
      <label for="name" class="form-label">Full Name:</label>
      <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email:</label>
      <input type="email" id="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="new-username" class="form-label">Username:</label>
      <input type="text" id="username" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="new-password" class="form-label">Password:</label>
      <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Signup</button>
  </form>
  <p class="link">If you have an account, please <a href="./login.php">Login here</a></p>
</div>

<?php include "./footer.php"?>