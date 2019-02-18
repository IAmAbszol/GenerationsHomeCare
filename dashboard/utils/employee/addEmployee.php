<?php
  include('../../../services/server_connection.inc');
  include('../../../services/login_script.php');
  $redirect = NULL;
  if($_GET['redirect'] != '') {
      $redirect = htmlspecialchars($_GET['redirect']);
  }
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
  $position = mysqli_real_escape_string($connection, $_POST['employeesPosition']);
  $name = mysqli_real_escape_string($connection, $_POST['employeesName']);
  $dob = mysqli_real_escape_string($connection, $_POST['dob']);
  $your_date = "";
  $res;
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
  date_default_timezone_set('America/New_York');
  $today = date('Y-m-d');
  $search_previous_employee = "select * from Employees where Name='$name' AND DOB='$your_date';";
  $search_employee_result = $connection->query($search_previous_employee);
  if($search_employee_result->num_rows > 0) {
    $update_statement = "update Employees set Status='Active', Position='$position', Address='$address1', Address2='$address2', EmailAddress='$email', PhoneNumber='$phone', EmergencyContact='$emergencyContact', EmergencyNumber='$emergencyPhone',
    Allergies='$allergies', DateOfTermination=NULL, PayRate='$pay' where Name='$name' AND DOB='$your_date';";
    $update_result = $connection->query($update_statement);
    // don't need to play with credentials, should still be in the database. Just wasn't able to be used due to status = inactive.
    $_SESSION['message_error'] = "Duplicate of $name. Updating settings for user.";
    header("location: ../../admin/employees.php");
    exit();
  } else {
    $statement = "insert into Employees (Position, Name, DOB, Address, Address2, EmailAddress, PhoneNumber, EmergencyContact, EmergencyNumber, Allergies, DateOfEmployment, DateOfTermination, PayRate, Status)
    values ('$position', '$name', '$your_date', '$address1', '$address2', '$email', '$phone', '$emergencyContact', '$emergencyPhone',
            '$allergies', '$today', NULL, '$pay', 'Active');";
    $result = $connection->query($statement);

    if($result) {
      // get array, may be first last or first middle last
      $credname = explode(" ", $name);
      $id = 0;
      $start = substr($credname[0], 0, 1);
      $end = $credname[sizeof($credname) - 1];
      $username = "$start$end" . $res[1];
      $username = strtolower($username);
      /*
      $search_credential = "select * from credentials where UserName LIKE '{$username}%';";
      $search_result = $connection->query($search_credential);
      if($search_credential->num_rows > 0) {
        // have to get the last digit and increment by 1
        $the_row = $search_result->fetch_assoc();
        $last_number = $the_row["UserName"];
        $int = intval(preg_replace('/[^0-9]+/', '', $last_number), 10);
        $int++;
        $username="$username$int";
      }
      */
      // now grab new employee id
      $search_employee = "select ID from Employees where Position='$position' AND Name='$name' AND DOB='$your_date';";
      $search_employee_result = $connection->query($search_employee);
      if($search_employee_result->num_rows == 1) {
        $the_row = $search_employee_result->fetch_assoc();
        $id=$the_row['ID'];
      } else if($search_employee_result->num_rows > 1){
        $_SESSION['message_error'] = "Duplicate of $name. Failed to be added to database.";
        header("location: ../../admin/employees.php");
        exit();
      }
      $credentials = "insert into Credentials (EmployeeID, UserName, Password) values ('$id', '$username', 'password')";
      $result_credentials=$connection->query($credentials);
      mysqli_close($connection);
      $_SESSION['message_success'] = "Employee $name has been successfully added!";
      header("location: ../../admin/employees.php");
      exit();
    } else {
      $_SESSION['message_error'] = "$name failed to be added to database.";
      header("location: ../../admin/employees.php");
      exit();
    }
    return $result;
  }
  return $search_employee_result;
 ?>
