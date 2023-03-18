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


<div class="container mt-5">
  <button class="btn btn-primary"><a href="./editProfile.php" class="badge badge-primary">EDIT PROFILE</a></button>
  <button class="btn btn-primary"><a href="./template1.php" class="badge badge-primary">TEMPLATE 1</a></button>
  <button class="btn btn-primary"><a href="./template2.php" class="badge badge-primary">TEMPLATE 2</a></button>

  <div class="row">

    <div class="row">

      <div class="col-md-9">
        <h1><?php echo $currentUser['name'];?></h1>
        <p>Age: <?php echo $generalinfo['age'];?></p>
        <p>Occupation: <?php echo $generalinfo['occupation'];?></p>
        <p>Email: <?php echo $currentUser['email'];?></p>
        <p>Phone: <?php echo $generalinfo['phone'];?></p>
        <p>Location: <?php echo $generalinfo['location'];?></p>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-12">
        <h2>About Me</h2>
        <p><?php echo $generalinfo['about'];?></p>
      </div>
    </div>
    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
    <div class="row mt-5">
      <div class="col-md-12">
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
      </div>
    </div>
    <!-- //////////////////////////////////////////////////////////////////////////////////////////////// -->
    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Jobs</h2>
        <?php
    $sql3 = "SELECT `job_profile`, `company_name`, `location`, `start_date`, `end_date`, `description` FROM `jobs` WHERE `username` = '$username'";
    $result3 = mysqli_query($conn, $sql3);
    foreach ($result3 as $currentUsersjobs) {
?>
        <ul>
          <li><?php echo $currentUsersjobs['job_profile']; ?></li>
          <li><?php echo $currentUsersjobs['company_name']; ?></li>
          <li><?php echo $currentUsersjobs['location']; ?></li>
          <li><?php echo $currentUsersjobs['start_date']; ?></li>
          <li><?php echo $currentUsersjobs['end_date']; ?></li>
          <p><?php echo $currentUsersjobs['description']; ?></p>
        </ul>
        <?php
    }
?>
      </div>
    </div>

    <!-- ////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Education</h2>
        <?php
    $sql4 = "SELECT `college`, `degree`, `start_year`, `end_year`, `status` FROM `education` WHERE `username` = '$username'";
    $result4 = mysqli_query($conn, $sql4);
    foreach ($result4 as $currentUsersEducation) {
?>
        <ul>
          <li><?php echo $currentUsersEducation['college']; ?></li>
          <li><?php echo $currentUsersEducation['degree']; ?></li>
          <li><?php echo $currentUsersEducation['start_year']; ?></li>
          <li><?php echo $currentUsersEducation['end_year']; ?></li>
          <li><?php echo $currentUsersEducation['status']; ?></li>
        </ul>
        <?php
    }
?>
      </div>
    </div>
    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
    <div class="row mt-5">
      <div class="col-md-12">
        <h2>Social Media links and Other Fields</h2>
        <?php
        $sql5 = "SELECT `fieldtitle`, `fielddata` FROM `addetionalfields` WHERE `username` = '$username'";
        $result5 = mysqli_query($conn, $sql5);
        foreach ($result5 as $currentUsersField) {
      ?>
        <p><?php echo $currentUsersField['fieldtitle']; ?> ==&gt <?php echo $currentUsersField['fielddata']; ?></p>
        <?php
        }
      ?>
      </div>
    </div>
    <?php include "./footer.php"?>