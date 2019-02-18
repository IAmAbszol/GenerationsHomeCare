<?php
/*
  * File to grab form data from Generations
  * generationsadultcare/dashboard/admin/careplan/generationscareplan.php
  */
  include('../../../services/login_script.php');
  include('../../../services/server_connection.inc');
  $dbh = "";
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);


  // first to read in EVERYTHING
  $redirect = NULL;
  if($_POST['redirect'] != '') {
      $redirect = $_POST['redirect'];
  }
	if(isset($_POST['employeename']))
		$employeename = mysqli_real_escape_string($connection, $_POST['employeename']);
	if(isset($_POST['employee_id']))
		$id = mysqli_real_escape_string($connection, $_POST['employee_id']);
	$weekending = "";
	if(isset($_POST['weekmonth']))
		$weekendingmonth = mysqli_real_escape_string($connection, $_POST['weekmonth']);
	if(isset($_POST['weekday']))
		$weekendingday = mysqli_real_escape_string($connection, $_POST['weekday']);
	if(isset($_POST['weekyear']))
		$weekendingyear = mysqli_real_escape_string($connection, $_POST['weekyear']);
	$weekending = "$weekendingyear-$weekendingmonth-$weekendingday";
	if(isset($_POST['mondaydate']))
		$mondaydate = mysqli_real_escape_string($connection, $_POST['mondaydate']);
	if(isset($_POST['mondayclientsname']))
		$mondayclient = mysqli_real_escape_string($connection, $_POST['mondayclientsname']);
	if(isset($_POST['mondaytimestarted']))
		$mondaytimestarted = mysqli_real_escape_string($connection, $_POST['mondaytimestarted']);
	if(isset($_POST['mondaytimeending']))
		$mondaytimeended = mysqli_real_escape_string($connection, $_POST['mondaytimeending']);
	if(isset($_POST['mondayliveorhours']))
		$mondayliveorhours = mysqli_real_escape_string($connection, $_POST['mondayliveorhours']);
	if(isset($_POST['tuesdaydate']))
		$tuesdaydate = mysqli_real_escape_string($connection, $_POST['tuesdaydate']);
	if(isset($_POST['tuesdayclientsname']))
		$tuesdayclient = mysqli_real_escape_string($connection, $_POST['tuesdayclientsname']);
	if(isset($_POST['tuesdaytimestarted']))
		$tuesdaytimestarted = mysqli_real_escape_string($connection, $_POST['tuesdaytimestarted']);
	if(isset($_POST['tuesdaytimeending']))
		$tuesdaytimeended = mysqli_real_escape_string($connection, $_POST['tuesdaytimeending']);
	if(isset($_POST['tuesdayliveorhours']))
		$tuesdayliveorhours = mysqli_real_escape_string($connection, $_POST['tuesdayliveorhours']);
	if(isset($_POST['wednesdaydate']))
		$wednesdaydate = mysqli_real_escape_string($connection, $_POST['wednesdaydate']);
	if(isset($_POST['wednesdayclientsname']))
		$wednesdayclient = mysqli_real_escape_string($connection, $_POST['wednesdayclientsname']);
	if(isset($_POST['wednesdaytimestarted']))
		$wednesdaytimestarted = mysqli_real_escape_string($connection, $_POST['wednesdaytimestarted']);
	if(isset($_POST['wednesdaytimeending']))
		$wednesdaytimeended = mysqli_real_escape_string($connection, $_POST['wednesdaytimeending']);
	if(isset($_POST['wednesdayliveorhours']))
		$wednesdayliveorhours = mysqli_real_escape_string($connection, $_POST['wednesdayliveorhours']);
	if(isset($_POST['thursdaydate']))
		$thursdaydate = mysqli_real_escape_string($connection, $_POST['thursdaydate']);
	if(isset($_POST['thursdayclientsname']))
		$thursdayclient = mysqli_real_escape_string($connection, $_POST['thursdayclientsname']);
	if(isset($_POST['thursdaytimestarted']))
		$thursdaytimestarted = mysqli_real_escape_string($connection, $_POST['thursdaytimestarted']);
	if(isset($_POST['thursdaytimeending']))
		$thursdaytimeended = mysqli_real_escape_string($connection, $_POST['thursdaytimeending']);
	if(isset($_POST['thursdayliveorhours']))
		$thursdayliveorhours = mysqli_real_escape_string($connection, $_POST['thursdayliveorhours']);
	if(isset($_POST['fridaydate']))
		$fridaydate = mysqli_real_escape_string($connection, $_POST['fridaydate']);
	if(isset($_POST['fridayclientsname']))
		$fridayclient = mysqli_real_escape_string($connection, $_POST['fridayclientsname']);
	if(isset($_POST['fridaytimestarted']))
		$fridaytimestarted = mysqli_real_escape_string($connection, $_POST['fridaytimestarted']);
	if(isset($_POST['fridaytimeending']))
		$fridaytimeended = mysqli_real_escape_string($connection, $_POST['fridaytimeending']);
	if(isset($_POST['fridayliveorhours']))
		$fridayliveorhours = mysqli_real_escape_string($connection, $_POST['fridayliveorhours']);
	if(isset($_POST['saturdaydate']))
		$saturdaydate = mysqli_real_escape_string($connection, $_POST['saturdaydate']);
	if(isset($_POST['saturdayclientsname']))
		$saturdayclient = mysqli_real_escape_string($connection, $_POST['saturdayclient']);
	if(isset($_POST['saturdaytimestarted']))
		$saturdaytimestarted = mysqli_real_escape_string($connection, $_POST['saturdaytimestarted']);
	if(isset($_POST['saturdaytimeending']))
		$saturdaytimeended = mysqli_real_escape_string($connection, $_POST['saturdaytimeending']);
	if(isset($_POST['saturdayliveorhours']))
		$saturdayliveorhours = mysqli_real_escape_string($connection, $_POST['saturdayliveorhours']);
	if(isset($_POST['sundaydate']))
		$sundaydate = mysqli_real_escape_string($connection, $_POST['sundaydate']);
	if(isset($_POST['sundayclientsname']))
		$sundayclient = mysqli_real_escape_string($connection, $_POST['sundaysundayclientsn']);
	if(isset($_POST['sundaytimestarted']))
		$sundaytimestarted = mysqli_real_escape_string($connection, $_POST['sundaytimestarted']);
	if(isset($_POST['sundaytimeending']))
		$sundaytimeended = mysqli_real_escape_string($connection, $_POST['sundaytimeending']);
	if(isset($_POST['sundayliveorhours']))
		$sundayliveorhours = mysqli_real_escape_string($connection, $_POST['sundayliveorhours']);
	if(isset($_POST['totalhours']))
		$total = mysqli_real_escape_string($connection, $_POST['totalhours']);

	// our dates need to be either completely wrapped or have just NULL
	if($mondaydate == "") {
		$mondaydate = "NULL";
	} else {
		$tmp = explode("-", $mondaydate);
		$mondaydate = "'$tmp[2]-$tmp[0]-$tmp[1]'";
	}
	if($tuesdaydate == "") {
		$tuesdaydate = "NULL";
	} else {
		$tmp = explode("-", $tuesdaydate);
		$tuesdaydate = "'$tmp[2]-$tmp[0]-$tmp[1]'";
	}
	if($wednesdaydate == "") {
		$wednesdaydate = "NULL";
	} else {
		$tmp = explode("-", $wednesdaydate);
		$wednesdaydate = "'$tmp[2]-$tmp[0]-$tmp[1]'";
	}
	if($thursdaydate == "") {
		$thursdaydate = "NULL";
	} else {
		$tmp = explode("-", $thursdaydate);
		$thursdaydate = "'$tmp[2]-$tmp[0]-$tmp[1]'";
	}
	if($fridaydate == "") {
		$fridaydate = "NULL";
	} else {
		$tmp = explode("-", $fridaydate);
		$fridaydate = "'$tmp[2]-$tmp[0]-$tmp[1]'";
	}
	if($saturdaydate == "") {
		$saturdaydate = "NULL";
	} else {
		$tmp = explode("-", $saturdaydate);
		$saturdaydate = "'$tmp[2]-$tmp[0]-$tmp[1]'";
	}
	if($sundaydate == "") {
		$sundaydate = "NULL";
	} else {
		$tmp = explode("-", $sundaydate);
		$sundaydate = "'$tmp[2]-$tmp[0]-$tmp[1]'";
	}
	// first we need to see if were updating or inserting for the week.
	// employees can update any time during the given week.
	date_default_timezone_set('America/New_York');
	$the_date = date('Y-m-d');
  $statement = "select * from Timesheet where CURDATE() <= WeekEnding AND CURDATE() >= MondayDate AND EmployeeID='$id';";
  $result = $connection->query($statement);

  // grab employee $payrate
  $select_pay = "select PayRate from Employees where ID='$id';";
  $select_result = $connection->query($select_pay);

	// if already submitted, we'll just update
  if($result->num_rows == 1) {
		$update_timesheet = "update Timesheet set MondayDate=$mondaydate, MondayClient='$mondayclient', MondayTimeStart='$mondaytimestarted', MondayTimeEnd='$mondaytimeended', MondayTotal='$mondayliveorhours',TuesdayDate=$tuesdaydate, TuesdayClient='$tuesdayclient', TuesdayTimeStart='$tuesdaytimestarted', TuesdayTimeEnd='$tuesdaytimeended', TuesdayTotal='$tuesdayliveorhours',WednesdayDate=$wednesdaydate, WednesdayClient='$wednesdayclient', WednesdayTimeStart='$wednesdaytimestarted', WednesdayTimeEnd='$wednesdaytimeended', WednesdayTotal='$wednesdayliveorhours',ThursdayDate=$thursdaydate, ThursdayClient='$thursdayclient', ThursdayTimeStart='$thursdaytimestarted', ThursdayTimeEnd='$thursdaytimeended', ThursdayTotal='$thursdayliveorhours',FridayDate=$fridaydate, FridayClient='$fridayclient', FridayTimeStart='$fridaytimestarted', FridayTimeEnd='$fridaytimeended', FridayTotal='$fridayliveorhours',SaturdayDate=$saturdaydate, SaturdayClient='$saturdayclient', SaturdayTimeStart='$saturdaytimestarted', SaturdayTimeEnd='$saturdaytimeended', SaturdayTotal='$saturdayliveorhours',SundayDate=$sundaydate, SundayClient='$sundayclient', SundayTimeStart='$sundaytimestarted', SundayTimeEnd='$sundaytimeended', SundayTotal='$sundayliveorhours', TotalHours='$total' where EmployeeID='$id'";
		$result = $connection->query($update_timesheet);
    $the_row = mysqli_fetch_assoc($select_result);
    $grabbed_payrate = $the_row['PayRate'];
    $payment = calculatePayment($total, $grabbed_payrate);
    $update_invoice = "update EmployeeInvoices set TotalHours='$total', Payment='$payment' where EmployeesID='$id';";
    $update_result = $connection->query($update_invoice);

	} else {
		$insert_timesheet = "insert into Timesheet (EmployeeID, WeekEnding, MondayDate, MondayClient, MondayTimeStart, MondayTimeEnd, MondayTotal,TuesdayDate, TuesdayClient, TuesdayTimeStart, TuesdayTimeEnd, TuesdayTotal,WednesdayDate, WednesdayClient, WednesdayTimeStart, WednesdayTimeEnd, WednesdayTotal,ThursdayDate, ThursdayClient, ThursdayTimeStart, ThursdayTimeEnd, ThursdayTotal,FridayDate, FridayClient, FridayTimeStart, FridayTimeEnd, FridayTotal,SaturdayDate, SaturdayClient, SaturdayTimeStart, SaturdayTimeEnd, SaturdayTotal,SundayDate, SundayClient, SundayTimeStart, SundayTimeEnd, SundayTotal, TotalHours) values ('$id', '$weekending', $mondaydate, '$mondayclient', '$mondaytimestarted', '$mondaytimeended', '$mondayliveorhours',$tuesdaydate, '$tuesdayclient', '$tuesdaytimestarted', '$tuesdaytimeended', '$tuesdayliveorhours',$wednesdaydate, '$wednesdayclient', '$wednesdaytimestarted', '$wednesdaytimeended', '$wednesdayliveorhours',$thursdaydate, '$thursdayclient', '$thursdaytimestarted', '$thursdaytimeended', '$thursdayliveorhours',$fridaydate, '$fridayclient', '$fridaytimestarted', '$fridaytimeended', '$fridayliveorhours',$saturdaydate, '$saturdayclient', '$saturdaytimestarted', '$saturdaytimeended', '$saturdayliveorhours',$sundaydate, '$sundayclient', '$sundaytimestarted', '$sundaytimeended', '$sundayliveorhours', '$total')";
		$result = $connection->query($insert_timesheet);
    // now insert into EmployeeInvoices
    $the_row = mysqli_fetch_assoc($select_result);
    $grabbed_payrate = $the_row['PayRate'];
    $payment = calculatePayment($total, $grabbed_payrate);
    $insert_invoice = "insert into EmployeeInvoices (EmployeesID, TotalHours, Payment, Paid) values ('$id', '$total', '$payment', 'Not Paid');";
    $insert_result = $connection->query($insert_invoice);
	}

  mysqli_close($connection);
  if($result) {
    $_SESSION['message_success'] = "Timesheet has been updated.";
  } else {
    $_SESSION['message_error'] = "Timesheet has encountered an error.";
    $error = mysqli_error($connection);
    write_to_log("[$your_date] $statement. Result $error");
  }
  if($redirect) {
    header("Location: " . $redirect);
    exit();
  } else {
    header("Location: ../employees.php");
    exit();
  }

  function calculatePayment($total, $payrate) {
    // total is hh:mm
    $amount = 0;
    $tmp = explode(":", $total);
    $amount = $tmp[0] * $payrate; // apply hourly amount
    $base = (60 / $tmp[1]);
    $amount += round(($payrate / $base), 2);
    return $amount;
  }

 ?>
