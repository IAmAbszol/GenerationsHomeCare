<?php
  include('../../../services/login_script.php');
  include('../../../services/server_connection.inc');
  $dbh = "";
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);

  $redirect = NULL;
  if($_POST['redirect'] != '') {
      $redirect = $_POST['redirect'];
  }

  $clientid = mysqli_real_escape_string($connection, $_POST['clientSelectionList']);
  $employeeid = mysqli_real_escape_string($connection, $_POST['employeeSelectionList']);
  $mondaydate = refactorDate(mysqli_real_escape_string($connection, $_POST['mondayDate']));
  $mondayarrival = mysqli_real_escape_string($connection, $_POST['mondayArrivalTime']);
  $mondaydeparture = mysqli_real_escape_string($connection, $_POST['mondayDepartureTime']);
  $tuesdaydate = refactorDate(mysqli_real_escape_string($connection, $_POST['tuesdayDate']));
  $tuesdayarrival = mysqli_real_escape_string($connection, $_POST['tuesdayArrivalTime']);
  $tuesdaydeparture = mysqli_real_escape_string($connection, $_POST['tuesdayDepartureTime']);
  $wednesdaydate = refactorDate(mysqli_real_escape_string($connection, $_POST['wednesdayDate']));
  $wednesdayarrival = mysqli_real_escape_string($connection, $_POST['wednesdayArrivalTime']);
  $wednesdaydeparture = mysqli_real_escape_string($connection, $_POST['wednesdayDepartureTime']);
  $thursdaydate = refactorDate(mysqli_real_escape_string($connection, $_POST['thursdayDate']));
  $thursdayarrival = mysqli_real_escape_string($connection, $_POST['thursdayArrivalTime']);
  $thursdaydeparture = mysqli_real_escape_string($connection, $_POST['thursdayDepartureTime']);
  $fridaydate = refactorDate(mysqli_real_escape_string($connection, $_POST['fridayDate']));
  $fridayarrival = mysqli_real_escape_string($connection, $_POST['fridayArrivalTime']);
  $fridaydeparture = mysqli_real_escape_string($connection, $_POST['fridayDepartureTime']);
  $saturdaydate = refactorDate(mysqli_real_escape_string($connection, $_POST['saturdayDate']));
  $saturdayarrival = mysqli_real_escape_string($connection, $_POST['saturdayArrivalTime']);
  $saturdaydeparture = mysqli_real_escape_string($connection, $_POST['saturdayDepartureTime']);
  $sundaydate = refactorDate(mysqli_real_escape_string($connection, $_POST['sundayDate']));
  $sundayarrival = mysqli_real_escape_string($connection, $_POST['sundayArrivalTime']);
  $sundaydeparture = mysqli_real_escape_string($connection, $_POST['sundayDepartureTime']);
  $notes = mysqli_real_escape_string($connection, $_POST['notes']);
  $amountdue = mysqli_real_escape_string($connection, $_POST['amountdue']);

  // insert job into database.
  // Insertion doesn't question overlap, merely interstion purposes only.
  $statement = "insert into Jobs (ClientID, AssignedEmployeeID, StartOfWeek, EndOfWeek, MondayDate, MondayArrival, MondayEnded, TuesdayDate, TuesdayArrival, TuesdayEnded, WednesdayDate, WednesdayArrival, WednesdayEnded, ThursdayDate, ThursdayArrival, ThursdayEnded, FridayDate, FridayArrival, FridayEnded, SaturdayDate, SaturdayArrival, SaturdayEnded, SundayDate, SundayArrival, SundayEnded, Notes, AmountDue)
  values ($clientid, $employeeid, '$mondaydate', '$sundaydate', '$mondaydate', '$mondayarrival', '$mondaydeparture', '$tuesdaydate', '$tuesdayarrival', '$tuesdaydeparture', '$wednesdaydate', '$wednesdayarrival', '$wednesdaydeparture', '$thursdaydate', '$thursdayarrival', '$thursdaydeparture', '$fridaydate', '$fridayarrival', '$fridaydeparture', '$saturdaydate', '$saturdayarrival', '$saturdaydeparture', '$sundaydate', '$sundayarrival', '$sundaydeparture', '$notes', '$amountdue');";
  $result = $connection->query($statement);

  $select_jobid = "select ID from Jobs where (ClientID='$clientid' AND AssignedEmployeeID='$employeeid' AND StartOfWeek='$mondaydate' AND EndOfWeek='$sundaydate' AND Amountdue='$amountdue');";
  $select_result = $connection->query($select_jobid);
  $job_id = -1;
  if($select_result->num_rows == 1) {
    $row = $row=mysqli_fetch_assoc($select_result);
    $job_id = $row['ID'];
  }
  // need to link clients invoice with the new amount charged
  $clientinvoice_statement = "insert into ClientInvoices (ClientID, JobID, InvoiceAmount, Notes, Paid) values ($clientid, $job_id, '$amountdue', '$notes', 'Not Paid');";
  $client_result = $connection->query($clientinvoice_statement);

  if($result && $client_result) {
    $_SESSION['message_success'] = "Job has been successfully created!";
  } else {
    $_SESSION['message_error'] = "Job has failed to be created.";
    $error = mysqli_error($connection);
    write_to_log("[$your_date] $statement. Result $error");
  }

  if($redirect) {
    echo "$statement";
    header("Location: " . $redirect);
    exit();
  } else {
    header("Location: ../employees.php");
    exit();
  }

  function refactorDate($date) {
    $tmp = explode("-", $date);
    return "$tmp[2]-$tmp[0]-$tmp[1]";
  }
 ?>
