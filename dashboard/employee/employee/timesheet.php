<!-- Admin Dashboard -->
<?php
	include('../../../services/login_script.php');
	include("../../utils/table_calls.php");
	if (!(isset($_SESSION['logon']))) {
		header('Location: ../../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
	} else {
		if($_SESSION['type'] == "employee" || $_SESSION['type'] == "admin") {
			if(isset($_GET['employee'])) {
				if($_SESSION['user_id'] != $_GET['employee']) {
					header('Location: ../../../index.php?error=' . urlencode(base64_encode("Unauthorized access to employees timesheet.")));
				}
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
    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
        }

        mysqli_close($connection);
        ?>
				// Required if PHP -> Javascript is desired
        window.onload = function(){
					document.getElementById('employeename').value = "<?php echo "$employeename"; ?>";
					document.getElementById('weekday').value = "<?php echo "$weekendingday"; ?>";
					document.getElementById('weekmonth').value = "<?php echo "$weekendingmonth"; ?>";
					document.getElementById('weekyear').value = "<?php echo "$weekendingyear"; ?>";
					document.getElementById('mondaydate').value = "<?php echo "$mondaydate"; ?>";
					document.getElementById('mondayclientsname').value = "<?php echo "$mondayclient"; ?>";
					document.getElementById('mondaytimestarted').value = "<?php echo "$mondaytimestarted"; ?>";
					document.getElementById('mondaytimeending').value = "<?php echo "$mondaytimeended"; ?>";
					document.getElementById('mondayliveorhours').value = "<?php echo "$mondayliveorhours"; ?>";

					document.getElementById('tuesdaydate').value = "<?php echo "$tuesdaydate"; ?>";
					document.getElementById('tuesdayclientsname').value = "<?php echo "$tuesdayclient"; ?>";
					document.getElementById('tuesdaytimestarted').value = "<?php echo "$tuesdaytimestarted"; ?>";
					document.getElementById('tuesdaytimeending').value = "<?php echo "$tuesdaytimeended"; ?>";
					document.getElementById('tuesdayliveorhours').value = "<?php echo "$tuesdayliveorhours"; ?>";

					document.getElementById('wednesdaydate').value = "<?php echo "$wednesdaydate"; ?>";
					document.getElementById('wednesdayclientsname').value = "<?php echo "$wednesdayclient"; ?>";
					document.getElementById('wednesdaytimestarted').value = "<?php echo "$wednesdaytimestarted"; ?>";
					document.getElementById('wednesdaytimeending').value = "<?php echo "$wednesdaytimeended"; ?>";
					document.getElementById('wednesdayliveorhours').value = "<?php echo "$wednesdayliveorhours"; ?>";

					document.getElementById('thursdaydate').value = "<?php echo "$thursdaydate"; ?>";
					document.getElementById('thursdayclientsname').value = "<?php echo "$thursdayclient"; ?>";
					document.getElementById('thursdaytimestarted').value = "<?php echo "$thursdaytimestarted"; ?>";
					document.getElementById('thursdaytimeending').value = "<?php echo "$thursdaytimeended"; ?>";
					document.getElementById('thursdayliveorhours').value = "<?php echo "$thursdayliveorhours"; ?>";

					document.getElementById('fridaydate').value = "<?php echo "$fridaydate"; ?>";
					document.getElementById('fridayclientsname').value = "<?php echo "$fridayclient"; ?>";
					document.getElementById('fridaytimestarted').value = "<?php echo "$fridaytimestarted"; ?>";
					document.getElementById('fridaytimeending').value = "<?php echo "$fridaytimeended"; ?>";
					document.getElementById('fridayliveorhours').value = "<?php echo "$fridayliveorhours"; ?>";

					document.getElementById('saturdaydate').value = "<?php echo "$saturdaydate"; ?>";
					document.getElementById('saturdayclientsname').value = "<?php echo "$saturdayclient"; ?>";
					document.getElementById('saturdaytimestarted').value = "<?php echo "$saturdaytimestarted"; ?>";
					document.getElementById('saturdaytimeending').value = "<?php echo "$saturdaytimeended"; ?>";
					document.getElementById('saturdayliveorhours').value = "<?php echo "$saturdayliveorhours"; ?>";

					document.getElementById('sundaydate').value = "<?php echo "$sundaydate"; ?>";
					document.getElementById('sundayclientsname').value = "<?php echo "$sundayclient"; ?>";
					document.getElementById('sundaytimestarted').value = "<?php echo "$sundaytimestarted"; ?>";
					document.getElementById('sundaytimeending').value = "<?php echo "$sundaytimeended"; ?>";
					document.getElementById('sundayliveorhours').value = "<?php echo "$sundayliveorhours"; ?>";

					document.getElementById('totalhours').value = "<?php echo "$total"; ?>";
        }

    </script>
		<script type="text/javascript">
			var warned = false;
			var warning = false;
			var print_warning = true;
			function validateInput() {
				// validate
				var noerrors = false;

				// set current Date
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!

				var yyyy = today.getFullYear();
				if(dd<10){
						dd='0'+dd;
				}
				if(mm<10){
						mm='0'+mm;
				}
				var today = mm+'/'+dd+'/'+yyyy;
				document.getElementById('todaysdate').value = today;

				var message = "";
				// check Header
				var myname = document.getElementById('employeename');
				if(myname.value.match(/^[A-Za-z- ]+$/)) {
						myname.style.border = "1px solid #000";
				} else {
					myname.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Invalid employee name.', 'Error!');
					});
					message = "error";
				}

				var weekending = "" + document.getElementById('weekmonth').value + "-" + document.getElementById('weekday').value + "-" + document.getElementById('weekyear').value;
				if(isValidDate(weekending, "-")) {
						document.getElementById('weekmonth').style.border = "1px solid #000";
						document.getElementById('weekday').style.border = "1px solid #000";
						document.getElementById('weekyear').style.border = "1px solid #000";
				} else {
					document.getElementById('weekmonth').style.border = "2px solid #fc677d";
					document.getElementById('weekday').style.border = "2px solid #fc677d";
					document.getElementById('weekyear').style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Invalid week ending date.', 'Error!');
					});
					message = "error";
				}

				// check main rows
				if(!checkday(weekending, "Monday", "mondaydate", "mondayclientsname", "mondaytimestarted", "mondaytimeending", "mondayliveorhours")) { message = "error"; }
				if(!checkday(weekending, "Tuesday", "tuesdaydate", "tuesdayclientsname", "tuesdaytimestarted", "tuesdaytimeending", "tuesdayliveorhours")) { message = "error"; }
				if(!checkday(weekending, "Wednesday", "wednesdaydate", "wednesdayclientsname", "wednesdaytimestarted", "wednesdaytimeending", "wednesdayliveorhours")) { message = "error"; }
				if(!checkday(weekending, "Thursday", "thursdaydate", "thursdayclientsname", "thursdaytimestarted", "thursdaytimeending", "thursdayliveorhours")) { message = "error"; }
				if(!checkday(weekending, "Friday", "fridaydate", "fridayclientsname", "fridaytimestarted", "fridaytimeending", "fridayliveorhours")) { message = "error"; }
				if(!checkday(weekending, "Saturday", "saturdaydate", "saturdayclientsname", "saturdaytimestarted", "saturdaytimeending", "saturdayliveorhours")) { message = "error"; }
				if(!checkday(weekending, "Sunday", "sundaydate", "sundayclientsname", "sundaytimestarted", "sundaytimeending", "sundayliveorhours")) { message = "error"; }
				// validate total
				var totalhours = document.getElementById("totalhours");
				if(totalhours.value != "") {
					var split = totalhours.value.split(":");
					if(split.length == 2) {
						if(totalhours.value.match(/^[0-9]{1,2}:[0-9]{2}[am]?[pm]?/)) {
								totalhours.style.border = "1px solid #000";
						} else {
							totalhours.style.border = "2px solid #fc677d";
							$( document ).ready(function() {
								toastr.error('Total time has an invalid format (Please use HH:MM format).', 'Error!');
							});
							noerrors = false;
							message = "error";
						}
					}
				} else {
					totalhours.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Total Time must be at least 00:00.', 'Error!');
					});
					noerrors = false;
					message = "error";
				}

				//alert("js still works");
				if(warning && !warned) {
					warned = true;
					print_warning = false;
					return false;
				}
				if(message == "") return true;
				else {
					return false;
				}
			}

			function checkday(weekending, literalDay, day, client, started, ended, total) {
				var noerrors = true;

				// validate date
				var dayobj = document.getElementById(day);
				if(dayobj.value != "") {
					dayobj.style.border = "1px solid #000";
					if(isValidDate(dayobj.value, "-")) {
						dayobj.style.border = "1px solid #000";
					} else {
						dayobj.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error(literalDay + 's date fails date validator Month, Day, Year.', 'Error!');
						});
						noerrors = false;
					}
				} else if(print_warning) {
					$( document ).ready(function() {
						toastr.warning(literalDay + 's date missing.', 'Warning!');
					});
					warning = true;
				}

				// weekending is somehow less than day, thus user error
				if(!compareDate(weekending, dayobj.value) && day != "") {
					dayobj.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error(literalDay + 's date is greater than week ending, please fix.', 'Error!');
					});
					noerrors = false;
				} else {
					dayobj.style.border = "1px solid #000";
				}

				// validate client
				var clientobj = document.getElementById(client);
				if(clientobj.value != "") {
					if(clientobj.value.match(/^[A-Za-z- ]+$/)) {
							clientobj.style.border = "1px solid #000";
					} else {
						clientobj.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error(literalDay + 's clients name has unrecognized characters (Only use spaces, hyphens, or dashes).', 'Error!');
						});
						noerrors = false;
					}
				} else if(print_warning) {
					$( document ).ready(function() {
						toastr.warning(literalDay + 's client name missing.', 'Warning!');
					});
					warning = true;
				}

				// validate timestarted
				var startedobj = document.getElementById(started);
				if(startedobj.value != "") {
					if(startedobj.value.match(/^[0-9]{1,2}:[0-9]{1,2}([AaPp][Mm])?$/)) {
							startedobj.style.border = "1px solid #000";
					} else {
						startedobj.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error(literalDay + 's time started has an invalid format (Please use HH:MM format).', 'Error!');
						});
						noerrors = false;
					}
				}

				// validate timeending
				var endedobj = document.getElementById(ended);
				if(endedobj.value != "") {
					if(endedobj.value.match(/^[0-9]{1,2}:[0-9]{1,2}([AaPp][Mm])?$/)) {
							endedobj.style.border = "1px solid #000";
					} else {
						endedobj.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error(literalDay + 's time ended has an invalid format (Please use HH:MM format).', 'Error!');
						});
						noerrors = false;
					}
				}

				// validate total
				var totalobj = document.getElementById(total);
				if(totalobj.value != "") {
					var split = totalobj.value.split(":");
					if(split.length == 2) {
						if(totalobj.value.match(/^[0-9]{1,2}:[0-9]{1,2}[am]?[pm]?/)) {
								totalobj.style.border = "1px solid #000";
						} else {
							totalobj.style.border = "2px solid #fc677d";
							$( document ).ready(function() {
								toastr.error(literalDay + 's total time has an invalid format (Please use HH:MM format).', 'Error!');
							});
							noerrors = false;
						}
					} else
							totalobj.style.border = "1px solid #000"; // else we accept what the user has placed
				}

				return noerrors;
			}
			// d1 should be week ending, d2 is the date comparing
			// return true if d1 is greater than or equal to d2
			// return false if d1 is less than d2
			function compareDate(d1, d2, token) {
				var t1 = d1.split(token);
				var t2 = d2.split(token);
				if(t1[2] == t2[2]) {

					if(t1[0] == t2[0]) {

						if(t1[1] == t2[1]) {
							return true;
						} else {
							if(t1[1] > t2[1]) {
								return true;
							} else
								return false;
						}

					} else {
						if(t1[0] > t2[0]) return true;
						else {
							// same conclusion as below.
							return false;
						}
					}

				} else {
					// years don't match
					if(t1[2] > t2[2]) return true;
					else {
						// they weren't equal nor greater, thus t1 is less and is not accepted by validation
						return false;
					}
				}
			}
			// Validates that the input string is a valid date formatted as "mm/dd/yyyy"
			function isValidDate(dateString, token)
			{
			  // First check for the pattern
				if(!(dateString.match(/^[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}$/))) {
					return false;
				}

			  // Parse the date parts to integers
			  var parts = dateString.split(token);
			  var day = parseInt(parts[1], 10);
			  var month = parseInt(parts[0], 10);
			  var year = parseInt(parts[2], 10);

			  // Check the ranges of month and year
			  if(year < 1000 || year > 3000 || month == 0 || month > 12)
			      return false;

			  var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

			  // Adjust for leap years
			  if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
			      monthLength[1] = 29;

			  // Check the range of the day
			  return day > 0 && day <= monthLength[month - 1];
			};
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
		<div class="content-wrapper">
	    <div class="container-fluid">
		    <form name="timesheetform" action="timesheet_handler.php" method="post" onsubmit="return validateInput();">
		      <?php
		        echo '<input type="hidden" name="redirect" id="redirect" value="';
		          if(isset($_GET['redirect'])) {
		            echo htmlspecialchars($_GET['redirect']);
		          }
		        echo '" />';
		        echo '<input type="hidden" name="employee_id" id="employee_id" value="';
		          if(isset($_GET['employee'])) {
		            echo htmlspecialchars($_GET['employee']);
		          }
		        echo '" />';
		       ?>
					 <input type="hidden" name="todaysdate" id="todaysdate" value=""/>
		      <!-- Header -->
						<div class="card-body">
				      <img src="../../../img/generations.png" alt="Generations Home Care Logo" width="300" height="100">
							<img src="../../../img/EmployeeTimeSheet.png" alt="Employee Time Sheet Logo" width="300" height="50">
							<div class="table-responsive">
				        <table class="table">
									<tr>
										<th>Employee Name</th>
										<td><input class="form-control no-border" id="employeename" name="employeename" placeholder="Employee Name" type="text"></td>
										<th>WEEK ENDING (Sundays Date)</th>
										<td>
											<input class="form-control no-border" id="weekmonth" name="weekmonth" size="2" maxlength="2" placeholder="MM" type="text"/>
										</td>
										<td>
											<input class="form-control no-border" id="weekday" name="weekday" size="2" maxlength="2" placeholder="DD" type="text"/>
										</td>
										<td>
											<input class="form-control no-border" id="weekyear" name="weekyear" size="4" maxlength="4" placeholder="YYYY" type="text"/>
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
										<td id="border"><label for="mondaydate">Monday</label> <span><input class="form-control no-border" id="mondaydate" name="mondaydate" placeholder="MM-DD-YYYY" type="text"/></span></td>
										<td id="border"><input class="form-control no-border" id="mondayclientsname" name="mondayclientsname" placeholder="Clients Name" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="mondaytimestarted" name="mondaytimestarted" placeholder="Time Started HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="mondaytimeending" name="mondaytimeending" placeholder="Time Ending HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="mondayliveorhours" name="mondayliveorhours" placeholder="Live In or Hours Worked" type="text"/></td>
									</tr>
									<tr>
										<td id="border"><label for="tuesdaydate">Tuesday</label> <span><input class="form-control no-border" id="tuesdaydate" name="tuesdaydate" placeholder="MM-DD-YYYY" type="text"/></span></td>
										<td id="border"><input class="form-control no-border" id="tuesdayclientsname" name="tuesdayclientsname" placeholder="Clients Name" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="tuesdaytimestarted" name="tuesdaytimestarted" placeholder="Time Started HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="tuesdaytimeending" name="tuesdaytimeending" placeholder="Time Ending HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="tuesdayliveorhours" name="tuesdayliveorhours" placeholder="Live In or Hours Worked" type="text"/></td>
									</tr>
									<tr>
										<td id="border"><label for="wednesdaydate">Wednesday</label> <span><input class="form-control no-border" id="wednesdaydate" name="wednesdaydate" placeholder="MM-DD-YYYY" type="text"/></span></td>
										<td id="border"><input class="form-control no-border" id="wednesdayclientsname" name="wednesdayclientsname" placeholder="Clients Name" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="wednesdaytimestarted" name="wednesdaytimestarted" placeholder="Time Started HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="wednesdaytimeending" name="wednesdaytimeending" placeholder="Time Ending HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="wednesdayliveorhours" name="wednesdayliveorhours" placeholder="Live In or Hours Worked" type="text"/></td>
									</tr>
									<tr>
										<td id="border"><label for="thursdaydate">Thursday</label> <span><input class="form-control no-border" id="thursdaydate" name="thursdaydate" placeholder="MM-DD-YYYY" type="text"/></span></td>
										<td id="border"><input class="form-control no-border" id="thursdayclientsname" name="thursdayclientsname" placeholder="Clients Name" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="thursdaytimestarted" name="thursdaytimestarted" placeholder="Time Started HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="thursdaytimeending" name="thursdaytimeending" placeholder="Time Ending HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="thursdayliveorhours" name="thursdayliveorhours" placeholder="Live In or Hours Worked" type="text"/></td>
									</tr>
									<tr>
										<td id="border"><label for="fridaydate">Friday</label> <span><input class="form-control no-border" id="fridaydate" name="fridaydate" placeholder="MM-DD-YYYY" type="text"/></span></td>
										<td id="border"><input class="form-control no-border" id="fridayclientsname" name="fridayclientsname" placeholder="Clients Name" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="fridaytimestarted" name="fridaytimestarted" placeholder="Time Started HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="fridaytimeending" name="fridaytimeending" placeholder="Time Ending HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="fridayliveorhours" name="fridayliveorhours" placeholder="Live In or Hours Worked" type="text"/></td>
									</tr>
									<tr>
										<td id="border"><label for="saturdaydate">Saturday</label> <span><input class="form-control no-border" id="saturdaydate" name="saturdaydate" placeholder="MM-DD-YYYY" type="text"/></span></td>
										<td id="border"><input class="form-control no-border" id="saturdayclientsname" name="saturdayclientsname" placeholder="Clients Name" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="saturdaytimestarted" name="saturdaytimestarted" placeholder="Time Started HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="saturdaytimeending" name="saturdaytimeending" placeholder="Time Ending HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="saturdayliveorhours" name="saturdayliveorhours" placeholder="Live In or Hours Worked" type="text"/></td>
									</tr>
									<tr>
										<td id="border"><label for="sundaydate">Sunday</label> <span><input class="form-control no-border" id="sundaydate" name="sundaydate" placeholder="MM-DD-YYYY" type="text"/></span></td>
										<td id="border"><input class="form-control no-border" id="sundayclientsname" name="sundayclientsname" placeholder="Clients Name" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="sundaytimestarted" name="sundaytimestarted" placeholder="Time Started HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="sundaytimeending" name="sundaytimeending" placeholder="Time Ending HH:MM" type="text"/></td>
										<td id="border"><input class="form-control no-border" id="sundayliveorhours" name="sundayliveorhours" placeholder="Live In or Hours Worked" type="text"/></td>
									</tr>
								</table>
							</div>
							<div style="margin-left:auto; margin-right:0;">
								<table class="table" style="width: 50%;">
									<th id="customblueheader"><label for="totalhours">TOTAL HOURS WORKED</labe><span><input class="form-control no-border" id="totalhours" name="totalhours" placeholder="Total HH:MM" type="text"/></span></th>
								</table>
							</div>
									<button type="submit" class="button">Submit</button>
									<button class="button" onclick="<?php  if(isset($_GET['redirect'])) {
										echo "location.href='" . htmlspecialchars($_GET['redirect']) . "'";
									}?>">Close</button>
						</div>
		   </form>
		 </div>
		 <!-- End of Logout Modal -->
     <!-- Bootstrap core JavaScript-->
     <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
     <!-- Core plugin JavaScript-->
     <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
     <!-- Page level plugin JavaScript-->
     <script src="vendor/chart.js/Chart.min.js"></script>
     <script src="vendor/datatables/jquery.dataTables.js"></script>
     <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
     <!-- Custom scripts for all pages-->
     <script src="js/sb-admin.min.js"></script>
     <!-- Custom scripts for this page-->
     <script src="js/sb-admin-datatables.min.js"></script>
     <script src="js/sb-admin-charts.min.js"></script>
	 </div>
  </body>
</html>
