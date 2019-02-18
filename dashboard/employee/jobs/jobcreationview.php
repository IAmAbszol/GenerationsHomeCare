<!-- Admin Dashboard -->
<?php
	include('../../../services/login_script.php');
	include("../../utils/table_calls.php");
	if (!(isset($_SESSION['logon']))) {
		header('Location: ../../../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
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

			window.onload = function(){

				<?php
					$job_id = 0;
					if(isset($_GET['job'])) {
						$job_id = $_GET['job'];
					}

					include('../../../services/server_connection.inc');
					$connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
					$statement = "select * from Jobs where ID='$job_id'";
					$result = $connection->query($statement);
					if($result->num_rows == 1) {
						// update
						$name_statement = "select Clients.Name as 'Client', Employees.Name as 'Employee' from Clients, Employees, Jobs where (Jobs.ClientID=Clients.ID) AND (Jobs.AssignedEmployeeID=Employees.ID) AND Jobs.ID='$job_id';";
						$name_result = $connection->query($name_statement);
						$row = mysqli_fetch_assoc($result);
						$start = $row['StartOfWeek'];
						$tmp = explode("-", $start);
						$start = "$tmp[1]-$tmp[2]-$tmp[0]";
						$end = $row['EndOfWeek'];
						$tmp = explode("-", $end);
						$end = "$tmp[1]-$tmp[2]-$tmp[0]";
						echo "document.getElementById('startOfWeek').innerHTML = '$start';";
						echo "document.getElementById('endOfWeek').innerHTML = '$end';";
						$name_row = mysqli_fetch_assoc($name_result);
						$client = $name_row['Client'];
						$employee = $name_row['Employee'];
						echo "document.getElementById('selectedClient').innerHTML = '$client';";
						echo "document.getElementById('selectedEmployee').innerHTML = '$employee';";

						// setting the days
						$mondayarrival = $row['MondayArrival'];
						$mondaydeparture = $row['MondayEnded'];
						echo "document.getElementById('mondayTimeArrival').innerHTML = '$mondayarrival';";
						echo "document.getElementById('mondayTimeDeparture').innerHTML = '$mondaydeparture';";
						$tuesdayarrival = $row['TuesdayArrival'];
						$tuesdaydeparture = $row['TuesdayEnded'];
						echo "document.getElementById('tuesdayTimeArrival').innerHTML = '$tuesdayarrival';";
						echo "document.getElementById('tuesdayTimeDeparture').innerHTML = '$tuesdaydeparture';";
						$wednesdayarrival = $row['WednesdayArrival'];
						$wednesdaydeparture = $row['WednesdayEnded'];
						echo "document.getElementById('wednesdayTimeArrival').innerHTML = '$wednesdayarrival';";
						echo "document.getElementById('wednesdayTimeDeparture').innerHTML = '$wednesdaydeparture';";
						$thursdayarrival = $row['ThursdayArrival'];
						$thursdaydeparture = $row['ThursdayEnded'];
						echo "document.getElementById('thursdayTimeArrival').innerHTML = '$thursdayarrival';";
						echo "document.getElementById('thursdayTimeDeparture').innerHTML = '$thursdaydeparture';";
						$fridayarrival = $row['FridayArrival'];
						$fridaydeparture = $row['FridayEnded'];
						echo "document.getElementById('fridayTimeArrival').innerHTML = '$fridayarrival';";
						echo "document.getElementById('fridayTimeDeparture').innerHTML = '$fridaydeparture';";
						$saturdayarrival = $row['SaturdayArrival'];
						$saturdaydeparture = $row['SaturdayEnded'];
						echo "document.getElementById('saturdayTimeArrival').innerHTML = '$saturdayarrival';";
						echo "document.getElementById('saturdayTimeDeparture').innerHTML = '$saturdaydeparture';";
						$sundayarrival = $row['SundayArrival'];
						$sundaydeparture = $row['SundayEnded'];
						echo "document.getElementById('sundayTimeArrival').innerHTML = '$sundayarrival';";
						echo "document.getElementById('sundayTimeDeparture').innerHTML = '$sundaydeparture';";

						$notes = $row['Notes'];
						$amountdue = $row['AmountDue'];
						echo "document.getElementById('notes').innerHTML = '$notes';";
						echo "document.getElementById('amountdue').innerHTML = '$amountdue';";

					}
					?>
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
		<div id="printableTable">
			<div class="content-wrapper">
		    <div class="container-fluid">
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
														<div id="selectedClient"></div>
													</td>
													<td>
														<div id="selectedEmployee"></div>
													</td>
						          	</tr>
												<tr>
													<th>
														Monday
													</th>
												</tr>
												<tr>
													<td>Arrival Time <div id="mondayTimeArrival"></div></td>
													<td>Departure Time <div id="mondayTimeDeparture"></div></td>
												</tr>
												<tr>
													<th>
														Tuesday
													</th>
												</tr>
												<tr>
													<td>Arrival Time <div id="tuesdayTimeArrival"></div></td>
													<td>Departure Time <div id="tuesdayTimeDeparture"></div></td>
												</tr>
												<tr>
													<th>
														Wednesday
													</th>
												</tr>
												<tr>
													<td>Arrival Time <div id="wednesdayTimeArrival"></div></td>
													<td>Departure Time <div id="wednesdayTimeDeparture"></div></td>
												</tr>
												<tr>
													<th>
														Thursday
													</th>
												</tr>
												<tr>
													<td>Arrival Time <div id="thursdayTimeArrival"></div></td>
													<td>Departure Time <div id="thursdayTimeDeparture"></div></td>
												</tr>
												<tr>
													<th>
														Friday
													</th>
												</tr>
												<tr>
													<td>Arrival Time <div id="fridayTimeArrival"></div></td>
													<td>Departure Time <div id="fridayTimeDeparture"></div></td>
												</tr>
												<tr>
													<th>
														Saturday
													</th>
												</tr>
												<tr>
													<td>Arrival Time <div id="saturdayTimeArrival"></div></td>
													<td>Departure Time <div id="saturdayTimeDeparture"></div></td>
												</tr>
												<tr>
													<th>
														Sunday
													</th>
												</tr>
												<tr>
													<td>Arrival Time <div id="sundayTimeArrival"></div></td>
													<td>Departure Time <div id="sundayTimeDeparture"></div></td>
												</tr>
												<tr>
							            <td>
							              Notes
							            </td>
							            <td>
														<div id="notes"></div>
							            </td>
							          </tr>
												<tr>
													<td>
														Amount Due
													</td>
													<td>
														<div id="amountdue"></div>
													</td>
												</tr>
												<tr>
							            <td>
							              <button type="button" class="button" onclick="<?php  if(isset($_GET['redirect'])) {
							 		            echo "location.href='" . htmlspecialchars($_GET['redirect']) . "'";
							 		          }?>">Close</button>
							            </td>
						          	</tr>
						        </tbody>
								</table>
							</div>
						</div>
			    </div>
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
	 </div>
	 <center><button onclick="printDiv()"><span class="glyphicon glyphicon-print"></span>Print Page</button></center>
  </body>
</html>
