<?php
session_start();
include './partials/dbconnect.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location: login.php");
  exit;
}
$username =$_SESSION['username'];

// //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($_SERVER["REQUEST_METHOD"] == "POST") {
$name = $_POST['name'];
$email = $_POST['email'];
$sql2 = "UPDATE `profiles` SET `name`='$name',`email`='$email' WHERE `username` = '$username'";
$result = mysqli_query($conn, $sql2);

$age = $_POST['age'];
$occupation = $_POST['occupation'];
$phone = $_POST['phone'];
$location = $_POST['location'];
$sql3 = "UPDATE `generalinfo` SET `age`='$age',`occupation`='$occupation',`phone`='$phone',`location`='$location' WHERE `username` = '$username'";
$result2 = mysqli_query($conn, $sql3);

}

// ////////////////////////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////////////////////////////////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

// Inserting New fields from the form ($_POST)
$additionalFieldsInPostNew = array();
foreach($_POST as $key => $value) {
    if(strpos($key, 'additionalDetails-Lable-New-') === 0) {
        $number = substr($key, strlen('additionalDetails-Lable-New-'));
        $additionalFieldsInPostNew[$value] = $_POST['additionalDetails-data-New-'.$number];
    }
}
if ($additionalFieldsInPostNew){
  foreach($additionalFieldsInPostNew as $key => $value) {
    $sql="INSERT INTO `addetionalfields` (`fieldtitle`, `fielddata`, `username`) VALUES ('$key', '$value', '$username')";
    if($key){
      $result= mysqli_query($conn,$sql);
    }
  }
}
// /////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Inserting New Eduction fields from the form ($_POST)
$educationFieldsInPostNew = array();
foreach($_POST as $key => $value) {
    if(strpos($key, 'educationDetails-status-New-') === 0) {
        $number = substr($key, strlen('educationDetails-status-New-'));
        $tempEduDetailes = array();
        $tempEduDetailes["status"] = $_POST['educationDetails-status-New-'.$number];
        $tempEduDetailes["uniname"] = $_POST['educationDetails-uniname-New-'.$number];
        $tempEduDetailes["degree"] = $_POST['educationDetails-degree-New-'.$number];
        $tempEduDetailes["startdate"] = $_POST['educationDetails-startdate-New-'.$number];
        $tempEduDetailes["enddate"] = $_POST['educationDetails-enddate-New-'.$number];
        array_push($educationFieldsInPostNew  , $tempEduDetailes);
    }
}
if ($educationFieldsInPostNew){
  foreach($educationFieldsInPostNew as $singleInfo) {

    $uniname = $singleInfo["uniname"];
    $degree = $singleInfo["degree"];
    $startdate = $singleInfo["startdate"];
    $enddate = $singleInfo["enddate"];
    $status = $singleInfo["status"];
    if($uniname){
    $sql="INSERT INTO `education` (`college`, `degree`, `start_year`, `end_year`, `status`, `username`) VALUES ('$uniname', '$degree', '$startdate', '$enddate', '$status', '$username')";
    $result= mysqli_query($conn,$sql);
    }
  }
}
// /////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inserting New JOBS fields from the form ($_POST)
$jobFieldsInPostNew = array();
foreach($_POST as $key => $value) {
    if(strpos($key, 'jobDetails-description-New-') === 0) {
        $number = substr($key, strlen('jobDetails-description-New-'));
        $tempJobDetailes = array();
        $tempJobDetailes["description"] = $_POST['jobDetails-description-New-'.$number];
        $tempJobDetailes["jobProfile"] = $_POST['jobDetails-jobProfile-New-'.$number];
        $tempJobDetailes["companyName"] = $_POST['jobDetails-companyName-New-'.$number];
        $tempJobDetailes["location"] = $_POST['jobDetails-location-New-'.$number];
        $tempJobDetailes["startDate"] = $_POST['jobDetails-startDate-New-'.$number];
        $tempJobDetailes["endDate"] = $_POST['jobDetails-endDate-New-'.$number];
        array_push($jobFieldsInPostNew  , $tempJobDetailes);
    }
}

if ($jobFieldsInPostNew){
  foreach($jobFieldsInPostNew as $singleInfo) {

    $jobProfile = $singleInfo["jobProfile"];
    $companyName = $singleInfo["companyName"];
    $location = $singleInfo["location"];
    $startDate = $singleInfo["startDate"];
    $endDate = $singleInfo["endDate"];
    $description = $singleInfo["description"];
    if($jobProfile){
    $sql="INSERT INTO `jobs` (`job_profile`, `company_name`, `location`, `start_date`, `end_date`, `description`, `username`) VALUES ('$jobProfile', '$companyName', '$location', '$startDate', '$endDate', '$description', '$username')";
    $result= mysqli_query($conn,$sql);
    }
  }
}
// ///////////////////////////////////////////////////////////////////////////////////////////!SECTION
// Inserting SKILLS fields from the ($_POST)
$skillFieldsInPostNew = array();
foreach($_POST as $key => $value) {
    if(strpos($key, 'skillDetails-skillName-New-') === 0) {
        $number = substr($key, strlen('skillDetails-skillName-New-'));
        $tempSkillDetailes = array();
        $tempSkillDetailes["skillName"] = $_POST['skillDetails-skillName-New-'.$number];
        array_push($skillFieldsInPostNew  , $tempSkillDetailes);
    }
}

if ($skillFieldsInPostNew){
  foreach($skillFieldsInPostNew as $singleInfo) {
    $skillName = $singleInfo["skillName"];
    if($skillName){
    $sql="INSERT INTO `skills` (`skill_name`, `username`) VALUES ('$skillName', '$username')";
    $result= mysqli_query($conn,$sql);
    }
  }
}
// //////////////////////////////////////////////////////////////////////////////////////////////////////////
// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////////////////////

// Deleting delted ADD fields
foreach($_POST as $key => $value) {
    if(strpos($key, 'additionalDetails-deleted-') === 0)  {
      $id = substr($key, strlen('additionalDetails-deleted-'));
      $sql = "DELETE FROM `addetionalfields` WHERE `id` LIKE '$id' AND `username` LIKE '$username'";
      $result= mysqli_query($conn,$sql);
    }
}
// Deleting delted EDUCATION fields
foreach($_POST as $key => $value) {
    if(strpos($key, 'additionalDetails-deleted-') === 0)  {
      $id = substr($key, strlen('additionalDetails-deleted-'));
      $sql2 = "DELETE FROM `education` WHERE `id` LIKE '$id' AND `username` LIKE '$username'";
      $result2= mysqli_query($conn,$sql2);
    }
}
// Deleting delted JOBS fields
foreach($_POST as $key => $value) {
  if(strpos($key, 'additionalDetails-deleted-') === 0)  {
    $id = substr($key, strlen('additionalDetails-deleted-'));
    $sql2 = "DELETE FROM `jobs` WHERE `id` LIKE '$id' AND `username` LIKE '$username'";
    $result2= mysqli_query($conn,$sql2);
  }
}
// Deleting delted SKILL fields
foreach($_POST as $key => $value) {
  if(strpos($key, 'additionalDetails-deleted-') === 0)  {
    $id = substr($key, strlen('additionalDetails-deleted-'));
    $sql2 = "DELETE FROM `skills` WHERE `id` LIKE '$id' AND `username` LIKE '$username'";
    $result2= mysqli_query($conn,$sql2);
  }
}
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////
// //////////////////////////////////////////////////////////////////////////////////////////////////////////

// Updating old ADD fields //////////////////
$additionalFieldsInPostOld = array();
foreach($_POST as $key => $value) {
    if(strpos($key, 'additionalDetails-Lable-Old-') === 0) {
        $id = substr($key, strlen('additionalDetails-Lable-Old-'));
        $additionalFieldsInPostOld[$id] = $_POST['additionalDetails-data-Old-'.$id] . "||" . $value;
    }
}
if ($additionalFieldsInPostOld){
  foreach($additionalFieldsInPostOld as $key => $value) {
    list($fielddata, $fieldtitle) = explode("||", $value);
    if ($fieldtitle){
      $sql = "UPDATE addetionalfields SET fielddata = '$fielddata', fieldtitle = '$fieldtitle' WHERE id = '$key' AND username = '$username'";
    }else{
      $sql = "DELETE FROM `addetionalfields` WHERE `id` LIKE '$key' AND `username` LIKE '$username'";
    }
    $result= mysqli_query($conn,$sql);
  }
}

// Updating old Education fields //////////////////
$additionalFieldsInPostOld = array();
foreach($_POST as $key => $value) {
    if(strpos($key, 'educationDetails-uniname-Old-') === 0) {
      $id = substr($key, strlen('educationDetails-uniname-Old-'));
      $tempEduDetailes = array();
      $tempEduDetailes["uniname"] = $_POST['educationDetails-uniname-Old-'.$id];
      $tempEduDetailes["status"] = $_POST['educationDetails-status-Old-'.$id];
      $tempEduDetailes["degree"] = $_POST['educationDetails-degree-Old-'.$id];
      $tempEduDetailes["startdate"] = $_POST['educationDetails-startdate-Old-'.$id];
      $tempEduDetailes["enddate"] = $_POST['educationDetails-enddate-Old-'.$id];
      $tempEduDetailes["id"] = $id;
      array_push($additionalFieldsInPostOld  , $tempEduDetailes);
    }
}
if ($additionalFieldsInPostOld){
  foreach($additionalFieldsInPostOld as $singleInfo) {
    $uniname = $singleInfo["uniname"];
    $degree = $singleInfo["degree"];
    $startdate = $singleInfo["startdate"];
    $enddate = $singleInfo["enddate"];
    $status = $singleInfo["status"];
    $id = $singleInfo["id"];   
    if ($uniname){
    $sql = "UPDATE education SET college = '$uniname', degree = '$degree', start_year = '$startdate', end_year = '$enddate', status = '$status' WHERE id = '$id' AND username = '$username'";
    }else{
    $sql = "DELETE FROM `education` WHERE `id` LIKE '$id' AND `username` LIKE '$username'";
    }
    $result= mysqli_query($conn,$sql);
  }
}

// Updating old JOBS fields //////////////////
$additionalFieldsInPostOld = array();
foreach($_POST as $key => $value) {
    if(strpos($key, 'jobDetails-jobProfile-Old-') === 0) {
      $id = substr($key, strlen('jobDetails-jobProfile-Old-'));
      $tempJobDetailes = array();
      $tempJobDetailes["jobProfile"] = $_POST['jobDetails-jobProfile-Old-'.$id];
      $tempJobDetailes["description"] = $_POST['jobDetails-description-Old-'.$id];
      $tempJobDetailes["companyName"] = $_POST['jobDetails-companyName-Old-'.$id];
      $tempJobDetailes["location"] = $_POST['jobDetails-location-Old-'.$id];
      $tempJobDetailes["startDate"] = $_POST['jobDetails-startDate-Old-'.$id];
      $tempJobDetailes["endDate"] = $_POST['jobDetails-endDate-Old-'.$id];
      $tempJobDetailes["id"] = $id;
      array_push($additionalFieldsInPostOld  , $tempJobDetailes);
    }
}
if ($additionalFieldsInPostOld){
  foreach($additionalFieldsInPostOld as $singleInfo) {
    $jobProfile = $singleInfo["jobProfile"];
    $companyName = $singleInfo["companyName"];
    $location = $singleInfo["location"];
    $startDate = $singleInfo["startDate"];
    $endDate = $singleInfo["endDate"];
    $description = $singleInfo["description"];
    $id = $singleInfo["id"];
    if ($jobProfile){
      $sql = "UPDATE jobs SET job_profile = '$jobProfile',company_name = '$companyName',location ='$location',start_date ='$startDate', end_date ='$endDate',description='$description' WHERE id = '$id'";
    }else{
      $sql = "DELETE FROM `jobs` WHERE `id` LIKE '$id' AND `username` LIKE '$username'";
    }
    $result= mysqli_query($conn,$sql);
  }
}

// Updating old SKILL fields
$additionalFieldsInPostOld = array();
foreach($_POST as $key => $value) {
    if(strpos($key, 'skillDetails-skillName-Old-') === 0) {
      $id = substr($key, strlen('skillDetails-skillName-Old-'));
      $tempSkillDetailes = array();
      $tempSkillDetailes["skillName"] = $_POST['skillDetails-skillName-Old-'.$id];
      $tempSkillDetailes["id"] = $id;
      array_push($additionalFieldsInPostOld  , $tempSkillDetailes);
    }
}
if ($additionalFieldsInPostOld){
  foreach($additionalFieldsInPostOld as $singleInfo) {
    $skillName = $singleInfo["skillName"];
    $id = $singleInfo["id"];
    if ($skillName){
      $sql = "UPDATE skills SET skill_name = '$skillName' WHERE id = '$id'";
    }else{
      $sql = "DELETE FROM `skills` WHERE `id` LIKE '$id' AND `username` LIKE '$username'";
    }
    $result= mysqli_query($conn,$sql);
  }
}
?>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<?php include "./header.php"?>
<div class="form-container p-5">
  <h1>
    Welcome <?php echo $_SESSION['username']; ?>
  </h1>

  <form id="signup-form" class="form updateForm" method="post">
    <?php
      $sql = "SELECT id,email,name FROM `profiles` WHERE `username` LIKE '$username'";
      $result = mysqli_query($conn, $sql);
      $currentUser = mysqli_fetch_assoc($result);
    ?>
    <input type="text" name="name" placeholder="ENTER NAME" class="form-control"
      value="<?php echo $currentUser['name'];?>">
    <br>
    <input type="email" name="email" placeholder="ENTER EMAIL" class="form-control"
      value="<?php echo $currentUser['email'];?>">
    <br>
    <input type="text" value="<?php echo $_SESSION['username'];?>" class="form-control" disabled>
    <br>
    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

    <?php
      $sql = "SELECT `age`, `occupation`, `phone`, `location` FROM `generalinfo` WHERE `username` LIKE '$username'";
      $result = mysqli_query($conn, $sql);
      $generalinfo = mysqli_fetch_assoc($result);
    ?>
    <input type="number" value="<?php echo $generalinfo['age'];?>" class="form-control" name="age">
    <br>
    <br>
    <input type="text" value="<?php echo $generalinfo['occupation'];?>" class="form-control" name="occupation">
    <br>
    <br>
    <input type="number" value="<?php echo $generalinfo['phone'];?>" class="form-control" name="phone">
    <br>
    <br>
    <input type="text" value="<?php echo $generalinfo['location'];?>" class="form-control" name="location">
    <br>


    <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <br>
    <H3>Add your educational fields</H3>
    <?php
      $sql = "SELECT * FROM `education` WHERE `username` LIKE '$username'";
      $result3 = mysqli_query($conn, $sql);
      if($result3){
        $educationFieldsCounter = 1;
        while($row = mysqli_fetch_assoc($result3)){
    ?>
    <div class="field-group">
      <a href="" onClick="deleteFieldFunction(event)" class="FieldDeleteButton">x</a>
      <input type="text" name="educationDetails-uniname-Old-<?php echo $row['id'];?>" placeholder=""
        class="customLable form-control" value="<?php echo $row['college'];?>">

      <input type="text" name="educationDetails-degree-Old-<?php echo $row['id'];?>" placeholder="" class="form-control"
        value="<?php echo $row['degree'];?>">

      <input type="year" name="educationDetails-startdate-Old-<?php echo $row['id'];?>" placeholder=""
        class="form-control" value="<?php echo $row['start_year'];?>">

      <input type="year" name="educationDetails-enddate-Old-<?php echo $row['id'];?>" placeholder=""
        class="form-control" value="<?php echo $row['end_year'];?>">

      <input type="text" name="educationDetails-status-Old-<?php echo $row['id'];?>" placeholder="" class="form-control"
        value="<?php echo $row['status'];?>">

    </div>
    <?php
        $educationFieldsCounter ++;
        }
      }
    ?>
    <br>
    <button class="button btn btn-primary" id="addEdubutton">Add edu Field</button><br>
    <br>
    <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <H3>Add your JOBS fields</H3>
    <?php
  $sql = "SELECT * FROM `jobs` WHERE `username` LIKE '$username'";
    $result3 = mysqli_query($conn, $sql);
    if($result3){
      $jobFieldsCounter = 1;
      while($row = mysqli_fetch_assoc($result3)){
      ?>
    <div class="field-group">

      <a href="" onClick="deleteFieldFunction(event)" class="FieldDeleteButton">x</a>

      <input type="text" name="jobDetails-jobProfile-Old-<?php echo $row['id'];?>" class="customLable form-control"
        value="<?php echo $row['job_profile'];?>">

      <input type="text" name="jobDetails-companyName-Old-<?php echo $row['id'];?>" class="form-control"
        value="<?php echo $row['company_name'];?>">

      <input type="text" name="jobDetails-location-Old-<?php echo $row['id'];?>" class="form-control"
        value="<?php echo $row['location'];?>">

      <input type="date" name="jobDetails-startDate-Old-<?php echo $row['id'];?>" class="form-control"
        value="<?php echo $row['start_date'];?>">

      <input type="date" name="jobDetails-endDate-Old-<?php echo $row['id'];?>" class="form-control"
        value="<?php echo $row['end_date'];?>">

      <input type="text" name="jobDetails-description-Old-<?php echo $row['id'];?>" class="form-control"
        value="<?php echo $row['description'];?>">

    </div>
    <?php
      $jobFieldsCounter ++;
      }
    }
    ?>
    <br>
    <button class="button btn btn-primary" id="addJobButton">Add job Field</button><br>
    <br>
    <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <br>
    <H3> Add your SKILLS fields </H3>
    <?php
  $sql = "SELECT * FROM `skills` WHERE `username` LIKE '$username'";
    $result3 = mysqli_query($conn, $sql);
    if($result3){
      $skillFieldsCounter = 1;
      while($row = mysqli_fetch_assoc($result3)){
      ?>
    <div class="field-group">
      <a href="" onClick="deleteFieldFunction(event)" class="FieldDeleteButton">x</a>

      <input type="text" name="skillDetails-skillName-Old-<?php echo $row['id'];?>" class="customLable form-control"
        value="<?php echo $row['skill_name'];?>">
    </div>
    <?php
      $skillFieldsCounter ++;
      }
    }
    ?>
    <br>
    <button class="button btn btn-primary" id="addSkillButton">Add SKILL Field</button><br>
    <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
    <br> <br> <br>
    <H3>Add your Social Media links and other field links</H3>
    <?php 
    // Reading and displaying data from database and displaying in form
    $sql = "SELECT * FROM `addetionalfields` WHERE `username` LIKE '$username'";
    $result = mysqli_query($conn, $sql);
    if($result){
      $addetionalDetailesCounter = 1;
      while($row = mysqli_fetch_assoc($result)){
      ?>
    <div class="field-group">
      <a href="" onClick="deleteFieldFunction(event)" class="FieldDeleteButton">x</a>
      <input type="text" name="additionalDetails-Lable-Old-<?php echo $row['id'];?>" placeholder="Enter field title"
        class="customLable form-control" value="<?php echo $row['fieldtitle'];?>">

      <input type="text" name="additionalDetails-data-Old-<?php echo $row['id'];?>" class="form-control"
        value="<?php echo $row['fielddata'];?>">
    </div>

    <?php
      $addetionalDetailesCounter ++;
      }
    }
    ?>
    <br>
    <button class="button btn btn-primary" id="addfieldbutton">Add Field</button>
    <br> <br> <br>
    <button type="submit" class="button btn btn-primary">Update</button>
  </form>
</div>
<script src="script.js"></script>

<?php include "./footer.php"?>