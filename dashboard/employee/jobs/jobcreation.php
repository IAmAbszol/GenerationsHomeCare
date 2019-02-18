<!-- Admin Dashboard -->
<?php
	include('../../../services/login_script.php');
	include("../../utils/table_calls.php");
	if (!(isset($_SESSION['logon']))) {
		header('Location: ../../../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
	} else if($_SESSION['type'] == "employee") {
		header('Location: ../../../index.php?error=' . urlencode(base64_encode("Insufficient Administrator Privileges.")));
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
    <title>Generations Job Creation</title>
    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <!-- Notifications -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ty    pe="text/javascript"></script>
  	<link href="../../../css/toastr.css" rel="stylesheet"/>
  	<script src="../../../js/toastr.js"></script>

		<script type="text/javascript">
			function validateInput() {
				var noerrors = true;

				return noerrors;
			}

			function buildTimes(element, suffix) {
				var x = document.getElementById(element);
		    var option = document.createElement("option");

		    option.text = "Not Scheduled";
				option.value = "Not Scheduled";
		    x.add(option);

				var quarter = ["00", "15", "30", "45"];
				for(i = 1; i <= 12; i++) {
					for(j = 0; j < quarter.length; j++) {
						option = document.createElement("option");
						var time = "" + i + ":" + quarter[j];
						option.text = time;
						option.value = time;
				    x.add(option);
					}
				}

				var y = document.getElementById(suffix);
		    var optionsuffix = document.createElement("option");

		    optionsuffix.text = "am";
				optionsuffix.value = "am";
		    y.add(optionsuffix);

				optionsuffix = document.createElement("option");
				optionsuffix.text = "pm";
				optionsuffix.value = "pm";
		    y.add(optionsuffix);
			}

			window.onload = function(){

				<?php
					date_default_timezone_set('America/New_York');

					$monday = date('Y-m-d', strtotime("monday this week"));

					$sunday =  date('Y-m-d', strtotime("sunday this week"));

					$period = new DatePeriod(
							 new DateTime($monday),
							 new DateInterval('P1D'),
							 (new DateTime($sunday))->modify('+1 day')
					);

					$days = array();
					foreach ($period as $date) {
						array_push($days, ($date->format('m-d-Y')));
					}
				?>
				document.getElementById('startOfWeek').innerHTML = "<?php echo "$days[0]"; ?>";
				document.getElementById('mondayDate').value = "<?php echo "$days[0]"; ?>";
				document.getElementById('tuesdayDate').value = "<?php echo "$days[1]"; ?>";
				document.getElementById('wednesdayDate').value = "<?php echo "$days[2]"; ?>";
				document.getElementById('thursdayDate').value = "<?php echo "$days[3]"; ?>";
				document.getElementById('fridayDate').value = "<?php echo "$days[4]"; ?>";
				document.getElementById('saturdayDate').value = "<?php echo "$days[5]"; ?>";
				document.getElementById('sundayDate').value = "<?php echo "$days[6]"; ?>";
				document.getElementById('endOfWeek').innerHTML = "<?php echo "$days[6]"; ?>";
				buildTimes("mondayArrivalTime", "mondayArrivalAmPm");
				buildTimes("mondayDepartureTime", "mondayDepartureAmPm");
				buildTimes("tuesdayArrivalTime", "tuesdayArrivalAmPm");
				buildTimes("tuesdayDepartureTime", "tuesdayDepartureAmPm");
				buildTimes("wednesdayArrivalTime", "wednesdayArrivalAmPm");
				buildTimes("wednesdayDepartureTime", "wednesdayDepartureAmPm");
				buildTimes("thursdayArrivalTime", "thursdayArrivalAmPm");
				buildTimes("thursdayDepartureTime", "thursdayDepartureAmPm");
				buildTimes("fridayArrivalTime", "fridayArrivalAmPm");
				buildTimes("fridayDepartureTime", "fridayDepartureAmPm");
				buildTimes("saturdayArrivalTime", "saturdayArrivalAmPm");
				buildTimes("saturdayDepartureTime", "saturdayDepartureAmPm");
				buildTimes("sundayArrivalTime", "sundayArrivalAmPm");
				buildTimes("sundayDepartureTime", "sundayDepartureAmPm");
			}
		</script>
    <style>
      body {
        font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
				width: 50%;
      }
      table {
        border: 0;
				border-collapse: separate;
  			border-spacing: 10px;
      }
      td {
        text-align: left;
        padding-left: 25px;
        padding-right: 25px;
        font-size: 14px;
				border: 0;
      }
			.form-control {
				font-weight: bold;
				font-size: 14px;
			}
			#titletable {
				width: 100%;
			}
      #customblueheader {
        background-color: #c7dbf9;
        color: #4f7dc1;
        font-weight: bold;
        border-top: 1px solid black;
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
			label {
				font-weight: bold;
			}
			@media screen and (max-width: 1020px) {
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
		    <form name="jobform" action="job_handler.php" method="post" onsubmit="return validateInput();">
		      <?php
		        echo '<input type="hidden" name="redirect" id="redirect" value="';
		          if(isset($_GET['redirect'])) {
		            echo htmlspecialchars($_GET['redirect']);
		          }
		        echo '" />';
		       ?>
		      <!-- Header -->
						<div class="card-body">
				        <img src="../../../img/generations.png" alt="Generations Home Care Logo" width="300" height="100">
				        <p style="font-size: 20px; font-weight: bold;">Job Creation</p>
			          <div class="table-responsive">
			            <table class="table borderless" id="dataTable" width="100%" cellspacing="0">
					          <tbody>
											<tr>
												<th>
													Start Of Week <div id="startOfWeek"></div>
												</th>
												<th>
													End Of Week <div id="endOfWeek"></div>
												</th>
											</tr>
											<tr>
												<th>
													Clients Name
												</th>
												<th>
													Assigned Employee Name
												</th>
											</tr>
											<tr>
												<td>
													<select id="clientSelectionList" name="clientSelectionList" class="form-control">
															<?php
												        include('../../../services/server_connection.inc');
																$data = grab_client_names();
																while($row=mysqli_fetch_assoc($data)) {
							  									$i = 0;
							  									$id = "";
							  									foreach($row as $_column) {
							  										if($i == 0) $id = $_column;
																		else
							  											echo "<option value='$id'>{$_column}</option>";
							  										$i++;
							  									}
							  								}
															 ?>
													</select>
												</td>
												<td>
													<select id="employeeSelectionList" name="employeeSelectionList" class="form-control">
															<?php
												        include('../../../services/server_connection.inc');
																$data = grab_employee_names();
																while($row=mysqli_fetch_assoc($data)) {
							  									$i = 0;
							  									$id = "";
							  									foreach($row as $_column) {
							  										if($i == 0) $id = $_column;
																		else
							  											echo "<option value='$id'>{$_column}</option>";
							  										$i++;
							  									}
							  								}
															 ?>
													</select>
												</td>
					          	</tr>
											<tr>
												<th>
													Monday
												</th>
											</tr>
											<tr>
												<input type="hidden" id="mondayDate" name="mondayDate" value = ""/>
												<td>Arrival Time <select id="mondayArrivalTime" name="mondayArrivalTime"></select> <select id="mondayArrivalAmPm" name="mondayArrivalAmPm"></select></td>
												<td>Departure Time <select id="mondayDepartureTime" name="mondayDepartureTime"></select> <select id="mondayDepartureAmPm" name="mondayDepartureAmPm"></select></td>
											</tr>
											<tr>
												<th>
													Tuesday
												</th>
											</tr>
											<tr>
												<input type="hidden" id="tuesdayDate" name="tuesdayDate" value = ""/>
												<td>Arrival Time <select id="tuesdayArrivalTime" name="tuesdayArrivalTime"></select> <select id="tuesdayArrivalAmPm" name="tuesdayArrivalAmPm"></select></td>
												<td>Departure Time <select id="tuesdayDepartureTime" name="tuesdayDepartureTime"></select> <select id="tuesdayDepartureAmPm" name="tuesdayDepartureAmPm"></select></td>
											</tr>
											<tr>
												<th>
													Wednesday
												</th>
											</tr>
											<tr>
												<input type="hidden" id="wednesdayDate" name="wednesdayDate" value = ""/>
												<td>Arrival Time <select id="wednesdayArrivalTime" name="wednesdayArrivalTime"></select> <select id="wednesdayArrivalAmPm" name="wednesdayArrivalAmPm"></select></td>
												<td>Departure Time <select id="wednesdayDepartureTime" name="wednesdayDepartureTime"></select> <select id="wednesdayDepartureAmPm" name="wednesdayDepartureAmPm"></select></td>
											</tr>
											<tr>
												<th>
													Thursday
												</th>
											</tr>
											<tr>
												<input type="hidden" id="thursdayDate" name="thursdayDate" value = ""/>
												<td>Arrival Time <select id="thursdayArrivalTime" name="thursdayArrivalTime"></select> <select id="thursdayArrivalAmPm" name="thursdayArrivalAmPm"></select></td>
												<td>Departure Time <select id="thursdayDepartureTime" name="thursdayDepartureTime"></select> <select id="thursdayDepartureAmPm" name="thursdayDepartureAmPm"></select></td>
											</tr>
											<tr>
												<th>
													Friday
												</th>
											</tr>
											<tr>
												<input type="hidden" id="fridayDate" name="fridayDate" value = ""/>
												<td>Arrival Time <select id="fridayArrivalTime" name="fridayArrivalTime"></select> <select id="fridayArrivalAmPm" name="fridayArrivalAmPm"></select></td>
												<td>Departure Time <select id="fridayDepartureTime" name="fridayDepartureTime"></select> <select id="fridayDepartureAmPm" name="fridayDepartureAmPm"></select></td>
											</tr>
											<tr>
												<th>
													Saturday
												</th>
											</tr>
											<tr>
												<input type="hidden" id="saturdayDate" name="saturdayDate" value = ""/>
												<td>Arrival Time <select id="saturdayArrivalTime" name="saturdayArrivalTime"></select> <select id="saturdayArrivalAmPm" name="saturdayArrivalAmPm"></select></td>
												<td>Departure Time <select id="saturdayDepartureTime" name="saturdayDepartureTime"></select> <select id="saturdayDepartureAmPm" name="saturdayDepartureAmPm"></select></td>
											</tr>
											<tr>
												<th>
													Sunday
												</th>
											</tr>
											<tr>
												<input type="hidden" id="sundayDate" name="sundayDate" value = ""/>
												<td>Arrival Time <select id="sundayArrivalTime" name="sundayArrivalTime"></select> <select id="sundayArrivalAmPm" name="sundayArrivalAmPm"></select></td>
												<td>Departure Time <select id="sundayDepartureTime" name="sundayDepartureTime"></select> <select id="sundayDepartureAmPm" name="sundayDepartureAmPm"></select></td>
											</tr>
											<tr>
						            <td>
						              Notes
						            </td>
						            <td>
						              <textarea style="width: 100%; " class="form-control" cols="20" rows="5" id="notes" name="notes"></textarea>
						            </td>
						          </tr>
											<tr>
												<td>
													Amount Due
												</td>
												<td>
													<input class="form-control no-border" id="amountdue" name="amountdue" placeholder="Amount" type="text"/>
												</td>
											</tr>
											<tr>
						            <td>
						              <button type="submit" class="button">Submit</button>
						              <button type="reset" class="button" onclick="<?php  if(isset($_GET['redirect'])) {
						 		            echo "location.href='" . htmlspecialchars($_GET['redirect']) . "'";
						 		          }?>">Close</button>
						            </td>
					          	</tr>
					        </tbody>
							</table>
						</div>
					</div>
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
