<!-- Admin Dashboard -->
<?php
	include('../../../services/login_script.php');
	include("../../utils/table_calls.php");
	if (!(isset($_SESSION['logon']))) {
		header('Location: ../../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
	} else {
		if($_SESSION['type'] == "employee" || $_SESSION['type'] == "admin") {
			if(!isset($_GET['employee'])) {
				/*
				if($_SESSION['user_id'] != $_GET['employee']) {
					header('Location: ../../../index.php?error=' . urlencode(base64_encode("Unauthorized access to employees timesheet.")));
				}*/
			} else
				header('Location: ../../../index.php?error=' . urlencode(base64_encode("Insufficient Privileges.")));
		} else
			header('Location: ../../../index.php?error=' . urlencode(base64_encode("Insufficient Privileges.")));
	}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Employee Timesheet</title>
    <!-- Custom fonts for this template-->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <!-- Notifications -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ty    pe="text/javascript"></script>
  	<link href="../../../css/toastr.css" rel="stylesheet"/>
  	<script src="../../../js/toastr.js"></script>

    <script>

      <?php
        include('../../../services/server_connection.inc');
        $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
				$employeename = "";
				$id = "";
				$weekending = "";
				$weekendingmonth = "";
				$weekendingday = "";
				$weekendingyear = "";
				$mondaydate = "";
				$mondayclient = "";
				$mondaytimestarted = "";
				$mondaytimeended = "";
				$mondayliveorhours = "";
				$tuesdaydate = "";
				$tuesdayclient = "";
				$tuesdaytimestarted = "";
				$tuesdaytimeended = "";
				$tuesdayliveorhours = "";
				$wednesdaydate = "";
				$wednesdayclient = "";
				$wednesdaytimestarted = "";
				$wednesdaytimeended = "";
				$wednesdayliveorhours = "";
				$thursdaydate = "";
				$thursdayclient = "";
				$thursdaytimestarted = "";
				$thursdaytimeended = "";
				$thursdayliveorhours = "";
				$fridaydate = "";
				$fridayclient = "";
				$fridaytimestarted = "";
				$fridaytimeended = "";
				$fridayliveorhours = "";
				$saturdaydate = "";
				$saturdayclient = "";
				$saturdaytimestarted = "";
				$saturdaytimeended = "";
				$saturdayliveorhours = "";
				$sundaydate = "";
				$sundayclient = "";
				$sundaytimestarted = "";
				$sundaytimeended = "";
				$sundayliveorhours = "";
				$total = "";

        if(isset($_GET['employee'])) {
          $id = $_GET['employee'];
					// set the timezone, this is from issues that php has on the server
					date_default_timezone_set('America/New_York');
					$the_date = date('Y-m-d');
          $statement = "select * from Timesheet where CURDATE() <= WeekEnding AND CURDATE() >= MondayDate AND EmployeeID='$id';";
				  $result = $connection->query($statement);
					// if already submitted, load everything
          if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
						$weekending = $row['WeekEnding'];
						$tmp = explode("-", $weekending);
						$weekendingyear = $tmp[0];
						$weekendingmonth = $tmp[1];
						$weekendingday = $tmp[2];
						$mondaydate = $row['MondayDate'];
						if($mondaydate != "") {
							$tmp = explode("-", $mondaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$mondaydate = "$tmp2-$tmp3-$tmp1";
						}
						$mondayclient = $row['MondayClient'];
						$mondaytimestarted = $row['MondayTimeStart'];
						$mondaytimeended = $row['MondayTimeEnd'];
						$mondayliveorhours = $row['MondayTotal'];
						$tuesdaydate = $row['TuesdayDate'];
						if($tuesdaydate != "") {
							$tmp = explode("-", $tuesdaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$tuesdaydate = "$tmp2-$tmp3-$tmp1";
						}
						$tuesdayclient = $row['TuesdayClient'];
						$tuesdaytimestarted = $row['TuesdayTimeStart'];
						$tuesdaytimeended = $row['TuesdayTimeEnd'];
						$tuesdayliveorhours = $row['TuesdayTotal'];
						$wednesdaydate = $row['WednesdayDate'];
						if($wednesdaydate != "") {
							$tmp = explode("-", $wednesdaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$wednesdaydate = "$tmp2-$tmp3-$tmp1";
						}
						$wednesdayclient = $row['WednesdayClient'];
						$wednesdaytimestarted = $row['WednesdayTimeStart'];
						$wednesdaytimeended = $row['WednesdayTimeEnd'];
						$wednesdayliveorhours = $row['WednesdayTotal'];
						$thursdaydate = $row['ThursdayDate'];
						if($thursdaydate != "") {
							$tmp = explode("-", $thursdaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$thursdaydate = "$tmp2-$tmp3-$tmp1";
						}
						$thursdayclient = $row['ThursdayClient'];
						$thursdaytimestarted = $row['ThursdayTimeStart'];
						$thursdaytimeended = $row['ThursdayTimeEnd'];
						$thursdayliveorhours = $row['ThursdayTotal'];
						$fridaydate = $row['FridayDate'];
						if($fridaydate != "") {
							$tmp = explode("-", $fridaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$fridaydate = "$tmp2-$tmp3-$tmp1";
						}
						$fridayclient = $row['FridayClient'];
						$fridaytimestarted = $row['FridayTimeStart'];
						$fridaytimeended = $row['FridayTimeEnd'];
						$fridayliveorhours = $row['FridayTotal'];
						$saturdaydate = $row['SaturdayDate'];
						if($saturdaydate != "") {
							$tmp = explode("-", $saturdaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$saturdaydate = "$tmp2-$tmp3-$tmp1";
						}
						$saturdayclient = $row['SaturdayClient'];
						$saturdaytimestarted = $row['SaturdayTimeStart'];
						$saturdaytimeended = $row['SaturdayTimeEnd'];
						$saturdayliveorhours = $row['SaturdayTotal'];
						$sundaydate = $row['SundayDate'];
						if($sundaydate != "") {
							$tmp = explode("-", $sundaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$sundaydate = "$tmp2-$tmp3-$tmp1";
						}
						$sundayclient = $row['SundayClient'];
						$sundaytimestarted = $row['SundayTimeStart'];
						$sundaytimeended = $row['SundayTimeEnd'];
						$sundayliveorhours = $row['SundayTotal'];
						$total = $row['TotalHours'];

						$search_employee = "select Name, Position from Employees where ID='$id';";
						$search_result = $connection->query($search_employee);
						$rows = $search_result->fetch_assoc();
						$employeename = $rows['Name'];
          } else {
						// no timesheet found, lets fill out the basics
						$search_employee = "select Name, Position from Employees where ID='$id';";
						$search_result = $connection->query($search_employee);
						$row = $search_result->fetch_assoc();
						$employeename = $row['Name'];
						//$employeename = $row['Name'];

						$weekending = date('Y-m-d', strtotime('this sunday'));
						$tmp = explode("-", $weekending);
						$weekendingyear = $tmp[0];
						$weekendingmonth = $tmp[1];
						$weekendingday = $tmp[2];
/*
						$mondaydate = date('Y-m-d', strtotime('monday'));
						$tmp = explode("-", $mondaydate);
						$mondaydate = "$tmp[1]-$tmp[2]-$tmp[0]";
						$tuesdaydate = date('Y-m-d', strtotime('tuesday'));
						$tmp = explode("-", $tuesdaydate);
						$tuesdaydate = "$tmp[1]-$tmp[2]-$tmp[0]";
						$wednesdaydate = date('Y-m-d', strtotime('wednesday'));
						$tmp = explode("-", $wednesdaydate);
						$wednesdaydate = "$tmp[1]-$tmp[2]-$tmp[0]";
						$thursdaydate = date('Y-m-d', strtotime('thursday'));
						$tmp = explode("-", $thursdaydate);
						$thursdaydate = "$tmp[1]-$tmp[2]-$tmp[0]";
						$fridaydate = date('Y-m-d', strtotime('friday'));
						$tmp = explode("-", $fridaydate);
						$fridaydate = "$tmp[1]-$tmp[2]-$tmp[0]";
						$saturdaydate = date('Y-m-d', strtotime('saturday'));
						$tmp = explode("-", $saturdaydate);
						$saturdaydate = "$tmp[1]-$tmp[2]-$tmp[0]";
						$sundaydate = date('Y-m-d', strtotime('sunday'));
						$tmp = explode("-", $sundaydate);
						$sundaydate = "$tmp[1]-$tmp[2]-$tmp[0]";
*/
					}
        } else if(isset($_GET['timesheet'])) {
					$id = $_GET['timesheet'];
					// set the timezone, this is from issues that php has on the server
					date_default_timezone_set('America/New_York');
					$the_date = date('Y-m-d');
          $statement = "select * from Timesheet where ID='$id';";
				  $result = $connection->query($statement);
					// if already submitted, load everything
          if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
						$weekending = $row['WeekEnding'];
						$tmp = explode("-", $weekending);
						$weekendingyear = $tmp[0];
						$weekendingmonth = $tmp[1];
						$weekendingday = $tmp[2];
						$mondaydate = $row['MondayDate'];
						if($mondaydate != "") {
							$tmp = explode("-", $mondaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$mondaydate = "$tmp2-$tmp3-$tmp1";
						}
						$mondayclient = $row['MondayClient'];
						$mondaytimestarted = $row['MondayTimeStart'];
						$mondaytimeended = $row['MondayTimeEnd'];
						$mondayliveorhours = $row['MondayTotal'];
						$tuesdaydate = $row['TuesdayDate'];
						if($tuesdaydate != "") {
							$tmp = explode("-", $tuesdaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$tuesdaydate = "$tmp2-$tmp3-$tmp1";
						}
						$tuesdayclient = $row['TuesdayClient'];
						$tuesdaytimestarted = $row['TuesdayTimeStart'];
						$tuesdaytimeended = $row['TuesdayTimeEnd'];
						$tuesdayliveorhours = $row['TuesdayTotal'];
						$wednesdaydate = $row['WednesdayDate'];
						if($wednesdaydate != "") {
							$tmp = explode("-", $wednesdaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$wednesdaydate = "$tmp2-$tmp3-$tmp1";
						}
						$wednesdayclient = $row['WednesdayClient'];
						$wednesdaytimestarted = $row['WednesdayTimeStart'];
						$wednesdaytimeended = $row['WednesdayTimeEnd'];
						$wednesdayliveorhours = $row['WednesdayTotal'];
						$thursdaydate = $row['ThursdayDate'];
						if($thursdaydate != "") {
							$tmp = explode("-", $thursdaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$thursdaydate = "$tmp2-$tmp3-$tmp1";
						}
						$thursdayclient = $row['ThursdayClient'];
						$thursdaytimestarted = $row['ThursdayTimeStart'];
						$thursdaytimeended = $row['ThursdayTimeEnd'];
						$thursdayliveorhours = $row['ThursdayTotal'];
						$fridaydate = $row['FridayDate'];
						if($fridaydate != "") {
							$tmp = explode("-", $fridaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$fridaydate = "$tmp2-$tmp3-$tmp1";
						}
						$fridayclient = $row['FridayClient'];
						$fridaytimestarted = $row['FridayTimeStart'];
						$fridaytimeended = $row['FridayTimeEnd'];
						$fridayliveorhours = $row['FridayTotal'];
						$saturdaydate = $row['SaturdayDate'];
						if($saturdaydate != "") {
							$tmp = explode("-", $saturdaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$saturdaydate = "$tmp2-$tmp3-$tmp1";
						}
						$saturdayclient = $row['SaturdayClient'];
						$saturdaytimestarted = $row['SaturdayTimeStart'];
						$saturdaytimeended = $row['SaturdayTimeEnd'];
						$saturdayliveorhours = $row['SaturdayTotal'];
						$sundaydate = $row['SundayDate'];
						if($sundaydate != "") {
							$tmp = explode("-", $sundaydate);
							$tmp1 = $tmp[0];
							$tmp2 = $tmp[1];
							$tmp3 = $tmp[2];
							$sundaydate = "$tmp2-$tmp3-$tmp1";
						}
						$sundayclient = $row['SundayClient'];
						$sundaytimestarted = $row['SundayTimeStart'];
						$sundaytimeended = $row['SundayTimeEnd'];
						$sundayliveorhours = $row['SundayTotal'];
						$total = $row['TotalHours'];
						$employeeid = $row['EmployeeID'];
						$search_employee = "select Name, Position from Employees where ID='$employeeid';";
						$search_result = $connection->query($search_employee);
						$rows = $search_result->fetch_assoc();
						$employeename = $rows['Name'];
					}
				}
        mysqli_close($connection);
        ?>
				// Required if PHP -> Javascript is desired
        window.onload = function(){
					document.getElementById('employeename').innerHTML = "<?php echo "$employeename"; ?>";
					document.getElementById('weekday').innerHTML = "<?php echo "$weekendingday"; ?>";
					document.getElementById('weekmonth').innerHTML = "<?php echo "$weekendingmonth"; ?>";
					document.getElementById('weekyear').innerHTML = "<?php echo "$weekendingyear"; ?>";
					document.getElementById('mondaydate').innerHTML = "<?php echo "$mondaydate"; ?>";
					document.getElementById('mondayclientsname').innerHTML = "<?php echo "$mondayclient"; ?>";
					document.getElementById('mondaytimestarted').innerHTML = "<?php echo "$mondaytimestarted"; ?>";
					document.getElementById('mondaytimeending').innerHTML = "<?php echo "$mondaytimeended"; ?>";
					document.getElementById('mondayliveorhours').innerHTML = "<?php echo "$mondayliveorhours"; ?>";

					document.getElementById('tuesdaydate').innerHTML = "<?php echo "$tuesdaydate"; ?>";
					document.getElementById('tuesdayclientsname').innerHTML = "<?php echo "$tuesdayclient"; ?>";
					document.getElementById('tuesdaytimestarted').innerHTML = "<?php echo "$tuesdaytimestarted"; ?>";
					document.getElementById('tuesdaytimeending').innerHTML = "<?php echo "$tuesdaytimeended"; ?>";
					document.getElementById('tuesdayliveorhours').innerHTML = "<?php echo "$tuesdayliveorhours"; ?>";

					document.getElementById('wednesdaydate').innerHTML = "<?php echo "$wednesdaydate"; ?>";
					document.getElementById('wednesdayclientsname').innerHTML = "<?php echo "$wednesdayclient"; ?>";
					document.getElementById('wednesdaytimestarted').innerHTML = "<?php echo "$wednesdaytimestarted"; ?>";
					document.getElementById('wednesdaytimeending').innerHTML = "<?php echo "$wednesdaytimeended"; ?>";
					document.getElementById('wednesdayliveorhours').innerHTML = "<?php echo "$wednesdayliveorhours"; ?>";

					document.getElementById('thursdaydate').innerHTML = "<?php echo "$thursdaydate"; ?>";
					document.getElementById('thursdayclientsname').innerHTML = "<?php echo "$thursdayclient"; ?>";
					document.getElementById('thursdaytimestarted').innerHTML = "<?php echo "$thursdaytimestarted"; ?>";
					document.getElementById('thursdaytimeending').innerHTML = "<?php echo "$thursdaytimeended"; ?>";
					document.getElementById('thursdayliveorhours').innerHTML = "<?php echo "$thursdayliveorhours"; ?>";

					document.getElementById('fridaydate').innerHTML = "<?php echo "$fridaydate"; ?>";
					document.getElementById('fridayclientsname').innerHTML = "<?php echo "$fridayclient"; ?>";
					document.getElementById('fridaytimestarted').innerHTML = "<?php echo "$fridaytimestarted"; ?>";
					document.getElementById('fridaytimeending').innerHTML = "<?php echo "$fridaytimeended"; ?>";
					document.getElementById('fridayliveorhours').innerHTML = "<?php echo "$fridayliveorhours"; ?>";

					document.getElementById('saturdaydate').innerHTML = "<?php echo "$saturdaydate"; ?>";
					document.getElementById('saturdayclientsname').innerHTML = "<?php echo "$saturdayclient"; ?>";
					document.getElementById('saturdaytimestarted').innerHTML = "<?php echo "$saturdaytimestarted"; ?>";
					document.getElementById('saturdaytimeending').innerHTML = "<?php echo "$saturdaytimeended"; ?>";
					document.getElementById('saturdayliveorhours').innerHTML = "<?php echo "$saturdayliveorhours"; ?>";

					document.getElementById('sundaydate').innerHTML = "<?php echo "$sundaydate"; ?>";
					document.getElementById('sundayclientsname').innerHTML = "<?php echo "$sundayclient"; ?>";
					document.getElementById('sundaytimestarted').innerHTML = "<?php echo "$sundaytimestarted"; ?>";
					document.getElementById('sundaytimeending').innerHTML = "<?php echo "$sundaytimeended"; ?>";
					document.getElementById('sundayliveorhours').innerHTML = "<?php echo "$sundayliveorhours"; ?>";

					document.getElementById('totalhours').innerHTML = "<?php echo "$total"; ?>";
        }

    </script>
		<script type="text/javascript">
			function printDiv() {
				window.print();
			}
		</script>
    <style>
      body {
        font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
				width: 75%;
      }
      table {
        border: 0;
      }
			hr {
				color: #4f7dc1;
	      background-color: #c7dbf9;
				border: none;
				height: 5px;
			}
			.form-control {
				font-weight: bold;
				font-size: 14px;
			}
			td {
        color: #000000;
        font-weight: normal;
				text-align: center;
        font-size: 14px;
			}
			th {
				text-align: center;
			}
			label {
		    float: left;
				font-weight: bold;
				font-size: 16px;
			}
			span {
			    display: block;
			    overflow: hidden;
			    padding: 0 4px 0 6px;
					float: right;
			}
			input {
			    width: 100%
			}
			#border {
        border-top: 2px solid #5b80ba;
			}
      #customblueheader {
        background-color: #e8f1ff;
        color: #000000;
        font-weight: bold;
        border: 1px solid #5b80ba;
				text-align: center;
        font-size: 14px;
      }
			#stripedone {
				background-color: #92a9cc;
        color: #000000;
        font-weight: normal;
        border: 1px solid #5b80ba;
				text-align: center;
        font-size: 14px;
			}
			#stripedtwo {
				background-color: #e8f1ff;
        color: #000000;
        font-weight: normal;
        border: 1px solid #5b80ba;
				text-align: center;
        font-size: 14px;
			}
      #infoblockleft {
        width: 45%;
        float: left;
        margin-left: 15%;
      }
      #infoblockright {
        width: 45%;
        float: right;
        margin-right: 15%;
      }
			@media screen and (max-width: 1020px) {
				label {
					font-size: 12px;
				}
				th {
					font-size: 10px;
				}
			  .form-control {
					font-size: 10px;
					width: 100%;
				}
				#titletable {
					width: 100%;
				}
				body {
					width: 100%;
				}
			}
    </style>
  </head>

  <body>
		<div id="printableTable">
				<div class="content-wrapper">
			    <div class="container-fluid">
			      <!-- Header -->
							<div class="card-body">
					      <img src="../../../img/generations.png" alt="Generations Home Care Logo" width="300" height="100">
								<img src="../../../img/EmployeeTimeSheet.png" alt="Employee Time Sheet Logo" width="300" height="50">
								<div class="table-responsive">
					        <table class="table">
										<tr>
											<th>Employee Name</th>
											<td><div style="font-weight: bold; text-decoration: underline;" id="employeename"></div></td>
											<th>WEEK ENDING (Sundays Date)</th>
											<td>
												<div style="font-weight: bold;" id="weekmonth"></div>
											</td>
											<td>
												<div style="font-weight: bold;" id="weekday"></div>
											</td>
											<td>
												<div style="font-weight: bold;" id="weekyear"></div>
											</td>
										</tr>
									</table>
								</div>
								<hr/>
								<div class="table-responsive">
									<table class="table">
										<tr>
											<th>Day/Date</th>
											<th id="customblueheader">Clients Name</th>
											<th id="customblueheader">Time Started</th>
											<th id="customblueheader">Time Ending</th>
											<th id="customblueheader">Live In or Hours Worked</th>
										</tr>
										<tr>
											<td id="border"><label for="mondaydate">Monday</label> <span><div style="font-weight: bold;" id="mondaydate"></div></span></td>
											<td id="border"><div style="font-weight: bold;" id="mondayclientsname"></div></td>
											<td id="border"><div style="font-weight: bold;" id="mondaytimestarted"></div></td>
											<td id="border"><div style="font-weight: bold;" id="mondaytimeending"></div></td>
											<td id="border"><div style="font-weight: bold;" id="mondayliveorhours"></div></td>
										</tr>
										<tr>
											<td id="border"><label for="tuesdaydate">Tuesday</label> <span><div style="font-weight: bold;" id="tuesdaydate"></div></span></td>
											<td id="border"><div style="font-weight: bold;" id="tuesdayclientsname"></div></td>
											<td id="border"><div style="font-weight: bold;" id="tuesdaytimestarted"></div></td>
											<td id="border"><div style="font-weight: bold;" id="tuesdaytimeending"></div></td>
											<td id="border"><div style="font-weight: bold;" id="tuesdayliveorhours"></div></td>
										</tr>
										<tr>
											<td id="border"><label for="wednesdaydate">Wednesday</label> <span><div style="font-weight: bold;" id="wednesdaydate"></div></span></td>
											<td id="border"><div style="font-weight: bold;" id="wednesdayclientsname"></div></td>
											<td id="border"><div style="font-weight: bold;" id="wednesdaytimestarted"></div></td>
											<td id="border"><div style="font-weight: bold;" id="wednesdaytimeending"></div></td>
											<td id="border"><div style="font-weight: bold;" id="wednesdayliveorhours"></div></td>
										</tr>
										<tr>
											<td id="border"><label for="thursdaydate">Thursday</label> <span><div style="font-weight: bold;" id="thursdaydate"></div></span></td>
											<td id="border"><div style="font-weight: bold;" id="thursdayclientsname"></div></td>
											<td id="border"><div style="font-weight: bold;" id="thursdaytimestarted"></div></td>
											<td id="border"><div style="font-weight: bold;" id="thursdaytimeending"></div></td>
											<td id="border"><div style="font-weight: bold;" id="thursdayliveorhours"></div></td>
										</tr>
										<tr>
											<td id="border"><label for="fridaydate">Friday</label> <span><div style="font-weight: bold;" id="fridaydate"></div></span></td>
											<td id="border"><div style="font-weight: bold;" id="fridayclientsname"></div></td>
											<td id="border"><div style="font-weight: bold;" id="fridaytimestarted"></div></td>
											<td id="border"><div style="font-weight: bold;" id="fridaytimeending"></div></td>
											<td id="border"><div style="font-weight: bold;" id="fridayliveorhours"></div></td>
										</tr>
										<tr>
											<td id="border"><label for="saturdaydate">Saturday</label> <span><div style="font-weight: bold;" id="saturdaydate"></div></span></td>
											<td id="border"><div style="font-weight: bold;" id="saturdayclientsname"></div></td>
											<td id="border"><div style="font-weight: bold;" id="saturdaytimestarted"></div></td>
											<td id="border"><div style="font-weight: bold;" id="saturdaytimeending"></div></td>
											<td id="border"><div style="font-weight: bold;" id="saturdayliveorhours"></div></td>
										</tr>
										<tr>
											<td id="border"><label for="sundaydate">Sunday</label> <span><div style="font-weight: bold;" id="sundaydate"></div></span></td>
											<td id="border"><div style="font-weight: bold;" id="sundayclientsname"></div></td>
											<td id="border"><div style="font-weight: bold;" id="sundaytimestarted"></div></td>
											<td id="border"><div style="font-weight: bold;" id="sundaytimeending"></div></td>
											<td id="border"><div style="font-weight: bold;" id="sundayliveorhours"></div></td>
										</tr>
									</table>
								</div>
								<div style="margin-left:auto; margin-right:0;">
									<table class="table" style="width: 50%;">
										<th id="customblueheader"><label for="totalhours">TOTAL HOURS WORKED</labe><span><div style="font-weight: bold;" id="totalhours"></div></span></th>
									</table>
								</div>
									<button class="button" onclick="window.open('', '_self', ''); window.close();">Close</button>
							</div>
				 </div>
			 </div>
		</div>
 		<center><button onclick="printDiv()"><span class="glyphicon glyphicon-print"></span>Print Page</button></center>
  </body>
</html>
