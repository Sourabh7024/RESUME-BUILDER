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


$sql2 = "SELECT `about`,`age`, `occupation`, `phone`, `location` FROM `generalinfo` WHERE `username` LIKE '$username'";
$result2 = mysqli_query($conn, $sql2);
$generalinfo = mysqli_fetch_assoc($result2);
    
?>

<?php include "./header.php"?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h1><?php echo $currentUser['name'];?></h1>
          <h4><?php echo $generalinfo['occupation'];?></h4>
        </div>
        <div class="card-body">
          <h2>About Me</h2>
          <p><?php echo $generalinfo['about'];?>.</p>

          <h2>Skills</h2>
          <?php
          $sql2 = "SELECT `skill_name` FROM `skills` WHERE `username` = '$username'";
          $result2 = mysqli_query($conn, $sql2);
          foreach ($result2 as $currentUserskill) {
          ?>
          <ul>
            <li><?php echo $currentUserskill['skill_name']; ?></li>
          </ul>
          <?php
          }
          ?>
          <h2>Experience</h2>
          <?php
            $sql3 = "SELECT `job_profile`, `company_name`, `location`, `start_date`, `end_date`, `description` FROM `jobs` WHERE `username` = '$username'";
            $result3 = mysqli_query($conn, $sql3);
            foreach ($result3 as $currentUsersjobs) {
            ?>
          <h3><?php echo $currentUsersjobs['job_profile']; ?> at <?php echo $currentUsersjobs['company_name']; ?></h3>
          <p>Location : <?php echo $currentUsersjobs['location']; ?></p>
          <p>Start date : <?php echo $currentUsersjobs['start_date']; ?></p>
          <p>Description : <?php echo $currentUsersjobs['description']; ?></p>

          <?php
            }
            ?>

          <h2>Education</h2>
          <?php
              $sql4 = "SELECT `college`, `degree`, `start_year`, `end_year`, `status` FROM `education` WHERE `username` = '$username'";
              $result4 = mysqli_query($conn, $sql4);
              foreach ($result4 as $currentUsersEducation) {
              ?>
          <h3><?php echo $currentUsersEducation['degree'];?></h3>
          <p><?php echo $currentUsersEducation['college']; ?></p>
          <p>Started in : <?php echo $currentUsersEducation['start_year']; ?> </p>
          <p>Completed in : <?php echo $currentUsersEducation['end_year']; ?> </p>
          <p>Status : <?php echo $currentUsersEducation['status']; ?></p>
          <?php
              }
              ?>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include "./footer.php"?>