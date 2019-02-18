<?php
  include('../../../services/server_connection.inc');
  include('../../../services/login_script.php');
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
  $id = mysqli_real_escape_string($connection, $_POST['updateId']);
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
  $position = mysqli_real_escape_string($connection, $_POST['employeesPosition']);
  $name = mysqli_real_escape_string($connection, $_POST['employeesName']);
  $dob = mysqli_real_escape_string($connection, $_POST['dob']);
  $your_date = "";
  if (strpos($dob, '-') !== false) {
    $res = explode("-", $dob);
    $your_date = "$res[2]-$res[0]-$res[1]";
  } else {
    $res = explode("/", $dob);
    $your_date = "$res[2]-$res[0]-$res[1]";
  }
  $address1 = mysqli_real_escape_string($connection, $_POST['address1']);
  $address2 = mysqli_real_escape_string($connection, $_POST['address2']);
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $phone = mysqli_real_escape_string($connection, $_POST['phone']);
  $emergencyContact = mysqli_real_escape_string($connection, $_POST['emergencyContact']);
  $emergencyPhone = mysqli_real_escape_string($connection, $_POST['emergencyNumber']);
  $allergies = mysqli_real_escape_string($connection, $_POST['allergers']);
  $pay = mysqli_real_escape_string($connection, $_POST['payrate']);
  $statement = "update Employees set Position='$position', Name='$name', DOB='$your_date', Address='$address1', Address2='$address2', EmailAddress='$email', PhoneNumber='$phone', EmergencyContact='$emergencyContact',
  EmergencyNumber='$emergencyPhone', Allergies='$allergies', PayRate='$pay' where ID='$id'";
  $result = $connection->query($statement);
  mysqli_close($connection);
  if($result) {
    $_SESSION['message_success'] = "Employee $name has been successfully updated!";
    header("location: ../../admin/employees.php");
    exit();
  } else {
    $_SESSION['message_error'] = "$name failed to update!";
    echo "$statement";
    header("location: ../../admin/employees.php");
    exit();
  }
  return $result;

 ?>
