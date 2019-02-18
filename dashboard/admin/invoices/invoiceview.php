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
    <title>Generations Invoice</title>
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
					$id = 0;
					if(isset($_GET['invoice'])) {
						$id = $_GET['invoice'];
					}

					include('../../../services/server_connection.inc');
					$connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
					$statement = "select * from ClientInvoices where ID='$id'";
					$result = $connection->query($statement);
					if($result->num_rows == 1) {
            $row = mysqli_fetch_assoc($result);
            $clientid = $row['ClientID'];
            $jobid = $row['JobID'];
            $amount = $row['InvoiceAmount'];
            $notes = $row['Notes'];
            echo "document.getElementById('jobID').innerHTML = '$jobid';";
            echo "document.getElementById('amountdue').value = '$amount';";
            echo "document.getElementById('notes').value = '$notes';";

            $select_statement = "select Clients.Name as 'Client', Clients.Address as 'Address', Clients.ClientsNumber as 'ClientsNumber', Employees.Name as 'Employee', Employees.PhoneNumber as 'EmployeeNumber', Jobs.StartOfWeek as 'Start', Jobs.EndOfWeek as 'End' from Clients, Employees, ClientInvoices, Jobs where (ClientInvoices.ClientID = Clients.ID) AND (ClientInvoices.JobID = Jobs.ID) AND (Jobs.AssignedEmployeeID=Employees.ID) AND (Jobs.ClientID=Clients.ID) AND ClientInvoices.ID='$id';";
            $new_result = $connection->query($select_statement);
            if($new_result->num_rows == 1) {
              $new_row = mysqli_fetch_assoc($new_result);
              $clientname = $new_row['Client'];
              $clientaddress = $new_row['Address'];
              $clientnumber = $new_row['ClientsNumber'];
              $employeename = $new_row['Employee'];
              $employeenumber = $new_row['EmployeeNumber'];
              $start = $new_row['Start'];
              $end = $new_row['End'];
              echo "document.getElementById('employeeName').innerHTML = '$employeename';";
              echo "document.getElementById('employeeNumber').innerHTML = '$employeenumber';";
              echo "document.getElementById('clientName').innerHTML = '$clientname';";
              echo "document.getElementById('clientAddress').innerHTML = '$clientaddress';";
              echo "document.getElementById('clientNumber').innerHTML = '$clientnumber';";
              echo "document.getElementById('startOfWeek').innerHTML = '$start';";
              echo "document.getElementById('endOfWeek').innerHTML = '$end';";
            }
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
					        <p style="font-size: 20px; font-weight: bold;">Client Invoice Memo</p>
				          <div class="table-responsive">
				            <table class="table borderless" id="dataTable" width="100%" cellspacing="0">
						          <tbody>
                        <tr>
                          <th>Employee Name: <div id="employeeName"></th>
                          <th>Employee Phone Number: <div id="employeeNumber"></div></th>
                        </tr>
                        <tr>
                          <th>Client Name: <div id="clientName"></div></th>
                        </tr>
                        <tr>
                          <th>Client Address: <div id="clientAddress"></div></th>
                        </tr>
                        <tr>
                          <th>Client Phone Number: <div id="clientNumber"></div></th>
                        </tr>
                        <tr></tr>
                        <tr>
                          <td>Billing in regards to Job ID: <div id="jobID"></div></td>
                        </tr>
                        <tr>
                          <td>Start of Week: <div id="startOfWeek"></div></td>
                          <td>End of Week: <div id="endOfWeek"></div></td>
                        </tr>
                        <tr>
                          <td>Notes regarding job <textarea style="width: 100%; " class="form-control" cols="20" rows="5" id="notes" name="notes"></textarea></td>
                        </tr>
                        <tr>
                          <td>Amount Due <input type="text" id="amountdue" name="amountdue" placeholder="Amount Due"/></td>
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
