<?php
  include('../../../services/server_connection.inc');
  include('../../../services/login_script.php');
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
  $id = mysqli_real_escape_string($connection, $_POST['updateId']);
  $name = mysqli_real_escape_string($connection, $_POST['clientsName']);
  $dob = mysqli_real_escape_string($connection, $_POST['dob']);
  $your_date = "";
  if (strpos($dob, '-') !== false) {
    $res = explode("-", $dob);
    $your_date = "$res[2]-$res[0]-$res[1]";
  } else {
    $res = explode("/", $dob);
    $your_date = "$res[2]-$res[0]-$res[1]";
  }
  $address = mysqli_real_escape_string($connection, $_POST['address']);
  $clientsnumber = mysqli_real_escape_string($connection, $_POST['clientsNumber']);
  $emergencyContact1 = mysqli_real_escape_string($connection, $_POST['emergencyContact1']);
  $emergencyPhone1 = mysqli_real_escape_string($connection, $_POST['emergencyNumber1']);
  $emergencyContact2 = mysqli_real_escape_string($connection, $_POST['emergencyContact2']);
  $emergencyPhone2 = mysqli_real_escape_string($connection, $_POST['emergencyNumber2']);
  $allergies = mysqli_real_escape_string($connection, $_POST['allergies']);
  $statement = "update Clients set Name='$name', DOB='$your_date', Address='$address', ClientsNumber='$clientsnumber', EmergencyContact1='$emergencyContact1',
  EmergencyNumber1='$emergencyPhone1', EmergencyContact2='$emergencyContact2', EmergencyNumber2='$emergencyPhone2', Allergies='$allergies' where ID='$id'";
  $result = $connection->query($statement);
  mysqli_close($connection);
  if($result) {
    $_SESSION['message_success'] = "Client $name has been successfully updated!";
    header("location: ../../admin/clients.php");
    exit();
  } else {
    $_SESSION['message_error'] = "$name failed to update!";
    header("location: ../../admin/clients.php");
    exit();
  }
  return $result;

 ?>
