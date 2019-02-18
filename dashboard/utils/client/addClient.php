<?php
  include('../../../services/server_connection.inc');
  include('../../../services/login_script.php');
  $redirect = NULL;
  if($_GET['redirect'] != '') {
      $redirect = htmlspecialchars($_GET['redirect']);
  }
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
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
  $statement = "insert into Clients (Name, DOB, Address, ClientsNumber, EmergencyContact1, EmergencyNumber1, EmergencyContact2, EmergencyNumber2, Allergies, Status) values
                ('$name', '$your_date', '$address', '$clientsnumber', '$emergencyContact1', '$emergencyPhone1', '$emergencycontact2', '$emergencyPhone2', '$allergies', 'Active')";
  $result = $connection->query($statement);
  mysqli_close($connection);
  if($result) {
    $_SESSION['message_success'] = "Client $name has been successfully added!";
    header("location: ../../admin/clients.php");
    exit();
  } else {
    $_SESSION['message_error'] = "$name failed to be added to database.";
    header("location: ../../admin/clients.php");
    exit();
  }
  return $result;
 ?>
