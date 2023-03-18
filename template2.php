<?php
session_start();
include './partials/dbconnect.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location: login.php");
  exit;
}

$username = $_SESSION['username'];
$sql = "SELECT id,email,name FROM `profiles` WHERE `username` LIKE '$username'";
$result = mysqli_query($conn, $sql);
$currentUser = mysqli_fetch_array($result);


$sql2 = "SELECT `age`, `occupation`, `phone`, `location` FROM `generalinfo` WHERE `username` LIKE '$username'";
$result2 = mysqli_query($conn, $sql2);
$generalinfo = mysqli_fetch_assoc($result2);
    
?>


<?php include "./header.php"?>

<div class="container mt-5">
  <center>
    <h2>Resume</h2>
  </center>
  <div class="row">
    <div class="col-lg-4 col-md-5 col-sm-12">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center"><?php echo $currentUser['name'];?></h3>
          <h5 class="card-subtitle mb-2 text-muted text-center"><?php echo $generalinfo['occupation'];?></h5>
          <hr>
          <h5 class="card-subtitle mb-2 text-muted">Contact Information</h5>
          <p class="card-text">Phone: <?php echo $generalinfo['phone'];?></p>
          <p class="card-text">Email: <?php echo $currentUser['email'];?></p>
          <p class="card-text">Location: <?php echo $generalinfo['location'];?></p>
          <hr>
          <h5 class="card-subtitle mb-2 text-muted">Skills</h5>
          <?php
          $sql2 = "SELECT `skill_name` FROM `skills` WHERE `username` = '$username'";
          $result2 = mysqli_query($conn, $sql2);
          foreach ($result2 as $currentUserskill) {
          ?>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><?php echo $currentUserskill['skill_name']; ?></li>
          </ul>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
    <div class="col-lg-8 col-md-7 col-sm-12">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center">Experience</h3>
          <?php
            $sql3 = "SELECT `job_profile`, `company_name`, `location`, `start_date`, `end_date`, `description` FROM `jobs` WHERE `username` = '$username'";
            $result3 = mysqli_query($conn, $sql3);
            foreach ($result3 as $currentUsersjobs) {
            ?>
          <hr>
          <h5 class="card-subtitle mb-2 text-muted"><?php echo $currentUsersjobs['job_profile']; ?> at
            <?php echo $currentUsersjobs['company_name'];?></h5>
          <h5 class="card-subtitle mb-2 text-muted">Start date : <?php echo $currentUsersjobs['start_date']; ?></h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><?php echo $currentUsersjobs['description']; ?>
            </li>
          </ul>
          <br>
          <?php
            }
            ?>

          <h3 class="card-title text-center">Education</h3>
          <?php
              $sql4 = "SELECT `college`, `degree`, `start_year`, `end_year`, `status` FROM `education` WHERE `username` = '$username'";
              $result4 = mysqli_query($conn, $sql4);
              foreach ($result4 as $currentUsersEducation) {
              ?>
          <hr>
          <h5 class="card-subtitle mb-2 text-muted"><?php echo $currentUsersEducation['degree'];?>,
            <?php echo $currentUsersEducation['college']; ?></h5>
          <h5 class="card-subtitle mb-2 text-muted">Status : <?php echo $currentUsersEducation['status']; ?></h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Started in : <?php echo $currentUsersEducation['start_year']; ?> </li>
            <li class="list-group-item">Completed in : <?php echo $currentUsersEducation['end_year']; ?></li>
          </ul>
          <br>
          <?php
              }
              ?>
          <h3 class="card-title text-center">Projects</h3>
          <?php
        $sql5 = "SELECT `fieldtitle`, `fielddata` FROM `addetionalfields` WHERE `username` = '$username'";
        $result5 = mysqli_query($conn, $sql5);
        foreach ($result5 as $currentUsersField) {
      ?>
          <hr>
          <h5 class="card-subtitle mb-2 text-muted"><?php echo $currentUsersField['fieldtitle']; ?></h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><?php echo $currentUsersField['fielddata']; ?></li>
          </ul>
          <br>
          <?php
        }
      ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "./footer.php"?>

<style>
.list-group-flush .list-group-item {
  margin-bottom: -1px;
  padding: 10px 0 10px 0;
}
</style>