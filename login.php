<?php
 $login= false;
 $showError= false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  include './partials/dbconnect.php';
  $name = $_POST['name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
 
  $sql = "SELECT * FROM `profiles` WHERE `username` LIKE '$username'";
  $result= mysqli_query($conn,$sql);

  $num = mysqli_num_rows($result);
  if ($num ==1){
    while($row=mysqli_fetch_array($result)){
        if (password_verify($password, $row['password'])){
        $login= true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $name;
      
        header("location: ./welcome.php");
        }else {
          $showError= true;
        }
    }
  }
}
?>

<?php include "./header.php"?>
<!-- ALERT -->
<?php  
  if($login) { ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success:</strong> You are logged in.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php }
  ?>

<?php  
  if($showError) { ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Alert:</strong> Username and Password are wrong.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php }
  ?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form id="login-form" class="form" method="post">
        <h2>Login</h2>
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username:</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
      <p class="mt-3">If you don't have an account, please <a href="./signup.php">register here</a>.</p>
    </div>
  </div>
</div>

<?php include "./footer.php"?>