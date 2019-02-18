<!-- Admin Dashboard -->
<?php
	include('../../services/login_script.php');
	include("../utils/table_calls.php");
	if (!(isset($_SESSION['logon']))) {
		header('Location: ../../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
	} else if($_SESSION['type'] == "employee") {
		header('Location: ../../index.php?error=' . urlencode(base64_encode("Insufficient Administrator Privileges.")));
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Kyle Darling">
  <title><?php $user = $_SESSION['user']; echo "$user's Dashboard - Generations Home Care";?></title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

	<!-- Notifications -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ty    pe="text/javascript"></script>
	<link href="../../css/toastr.css" rel="stylesheet"/>
	<script src="../../js/toastr.js"></script>
	<script type="text/javascript">
			$( document ).ready(function() {
					<?php
						if($_SESSION['sysLogin'] == "success") {
							$_SESSION['sysLogin'] = "";
							$user = $_SESSION['user'];
							echo "toastr.success('Welcome $user', 'User has logged in');";
						}
						if($_SESSION['message_success'] != "") {
							$msg = $_SESSION['message_success'];
							$_SESSION['message_success'] = "";
							echo "toastr.success('$msg', 'Success!');";
						}
						if($_SESSION['message_error'] != "") {
							$msg = $_SESSION['message_error'];
							$_SESSION['message_error'] = "";
							echo "toastr.error('$msg', 'Error!');";
						}
						if($_SESSION['message_warning'] != "") {
							$msg = $_SESSION['message_warning'];
							$_SESSION['message_warning'] = "";
							echo "toastr.warning('$msg', 'Warning!');";
						}
					 ?>
			});
	</script>
	<script type="text/javascript">
		<?php
			$redirect = urlencode($_SERVER['REQUEST_URI']);
			$my_id = $_SESSION['user_id'];
		?>

		// script that appends the URL to coorindate with php/modal
		function evaluateURL(type, i) {
			if(type == "careplan") {
				if (history.pushState) {
	          var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?careplan='+i;
	          window.history.pushState({path:newurl},'',newurl);
	      }
			}
		}

// gotta use javscript to php to pass desired variable
		function setId(i) {
			// grab stored information

			// set the id, php will use this later to update accordingly
			document.getElementById('updateId').value=i;
			$('#updateInsert').empty();
			if (window.XMLHttpRequest) {
					 // code for IE7+, Firefox, Chrome, Opera, Safari
					 xmlhttp = new XMLHttpRequest();
			 } else {
					 // code for IE6, IE5
					 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			 }
			 xmlhttp.onreadystatechange = function() {
					 if (this.readyState == 4 && this.status == 200) {
							 document.getElementById("updateInsert").innerHTML = this.responseText;
					 }
			 };
			 xmlhttp.open("GET","../utils/employee/display_employee.php?employee="+i,true);
			 xmlhttp.send();

		}

		function setIdJob(i) {
			document.getElementById('jobViewId').value=i;
			$('#employeeJobsInsert').empty();
			if (window.XMLHttpRequest) {
					 // code for IE7+, Firefox, Chrome, Opera, Safari
					 xmlhttp = new XMLHttpRequest();
			 } else {
					 // code for IE6, IE5
					 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			 }
			 xmlhttp.onreadystatechange = function() {
					 if (this.readyState == 4 && this.status == 200) {
							 document.getElementById("employeeJobsInsert").innerHTML = this.responseText;
					 }
			 };
			 xmlhttp.open("GET","../utils/jobs/display_jobs.php?employee="+i,true);
			 xmlhttp.send();
		}

		function setIdRemove(i) {
			// grab stored information

			// set the id, php will use this later to update accordingly
			document.getElementById('removeId').value=i;

		}

		function didTheySelect() {
			var noerrors = false;
			var check = document.getElementsByName('jobs');
			for (var i=0; i<check.length; i++) {
		    // If you have more than one radio group, also check the name attribute
		    // for the one you want as in && chx[i].name == 'choose'
		    // Return true from the function on first match of a checked item
		    if (check[i].type == 'radio' && check[i].checked) {
		      noerrors = true;
		    }
		  }
			if(!noerrors) {
				$( document ).ready(function() {
					toastr.error('Please select a specific job.', 'Error!');
				});
			}
			return noerrors;
		}

		function validateInput(myForm) {

			var noerrors = true;

			var employeeName = document.forms[myForm]['employeesName'];
			if(!employeeName.value.match(/^[A-Za-z- ]+$/)) {
				employeeName.style.border = "2px solid #fc677d";
				$( document ).ready(function() {
					toastr.error('Employees name contains numbers or unrecognized characters.', 'Error!');
				});
				noerrors = false;
			} else {
				employeeName.style.border = "0";
				employeeName.style.borderBottom = "1px solid black";
			}

			var dob = document.forms[myForm]['dob'];
			if(!dob.value.match(/^[0-9]{2}[-/][0-9]{2}[-/][0-9]{4}$/)) {
				dob.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Invalid Date (Format MM-DD-YYYY).', 'Error!');
					});
					noerrors = false;
			} else {
				dob.style.border = "0";
				dob.style.borderBottom = "1px solid black";
			}

			var address1 = document.forms[myForm]['address1'];
			if(!address1.value.match('')) {
				address1.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Address 1 must be filled out.', 'Error!');
					});
					noerrors = false;
			} else {
				address1.style.border = "0";
				address1.style.borderBottom = "1px solid black";
			}

			var address2 = document.forms[myForm]['address2'];
			if(!address2.value.match('')) {
				address2.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Address 2 must be filled out.', 'Error!');
					});
					noerrors = false;
			} else {
				address2.style.border = "0";
				address2.style.borderBottom = "1px solid black";
			}

			var employeenumber = document.forms[myForm]['phone'];
			if(!employeenumber.value.match(/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/)) {
				employeenumber.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Employees phone number has an invalid format/character.', 'Error!');
					});
					noerrors = false;
			} else {
				employeenumber.style.border = "0";
				employeenumber.style.borderBottom = "1px solid black";
			}

			var emergencycontact1name = document.forms[myForm]['emergencyContact'];
			if(!emergencycontact1name.value == '' && !emergencycontact1name.value.match(/^[A-Za-z- ]+$/)) {
				emergencycontact1name.style.border = "2px solid #fc677d";
				$( document ).ready(function() {
					toastr.error('Emergency contact name contains numbers or unrecognized characters.', 'Error!');
				});
				noerrors = false;
			} else {
				emergencycontact1name.style.border = "0";
				emergencycontact1name.style.borderBottom = "1px solid black";
			}

			var phonecontact1number = document.forms[myForm]['emergencyNumber'];
			if(!phonecontact1number.value == '' && !phonecontact1number.value.match(/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/)) {
				phonecontact1number.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Emergency contact phone number has an invalid format/character.', 'Error!');
					});
					noerrors = false;
			} else {
				phonecontact1number.style.border = "0";
				phonecontact1number.style.borderBottom = "1px solid black";
			}

			var payrate = document.forms[myForm]['payrate'];
			if(payrate.value == '' || !payrate.value.match(/^[$]?[0-9]+[.][0-9]{2}$/)) {
				payrate.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Employees payrate must include decimal followed by two digits (More of clarification).', 'Error!');
					});
					noerrors = false;
			} else {
				payrate.style.border = "0";
				payrate.style.borderBottom = "1px solid black";
			}

			if (history.pushState) {
					var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?redirect=<?php  urlencode($_SERVER['REQUEST_URI']); ?>';
					window.history.pushState({path:newurl},'',newurl);
			}
			return noerrors;
		}
	</script>

</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="dashboard.php">Generations Home Care Dashboard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="dashboard.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Clients">
          <a class="nav-link" href="clients.php">
            <i class="fa fa-address-book"></i>
            <span class="nav-link-text">Clients</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Employees">
          <a class="nav-link" href="employees.php">
            <i class="fa fa-user-circle"></i>
            <span class="nav-link-text">Employees</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Jobs">
          <a class="nav-link" href="jobs.php">
            <i class="fa fa-car"></i>
            <span class="nav-link-text">Jobs</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Client Invoices">
          <a class="nav-link" href="clientinvoices.php">
            <i class="fa fa-money"></i>
            <span class="nav-link-text">Client Invoices</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Employee Invoices">
          <a class="nav-link" href="employeeinvoices.php">
            <i class="fa fa-money"></i>
            <span class="nav-link-text">Employee Invoices</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Change/Forgot Password">
          <a class="nav-link" href="passwordchange.php">
            <i class="fa fa-key"></i>
            <span class="nav-link-text">Change/Forgot Password</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Employees</li>
      </ol>

      <div class="row">
    		<!-- Employees Panel table -->
  			<div class="card col-md-3 mb-2 ml-2">
          <div class="card-header">
            <i class="fa fa-address-book-o"></i> Employee Panel</div>
          <div class="card-body">
						<table cellpadding="5" align="center">
							<tr><td style="text-align: center"><button type="button" class="btn btn-primary" id="addemployee" data-toggle="modal" data-target="#employeeAddModal">Add Employee</button></td></tr>
							<tr><td style="text-align: center"><a href="employee/timesheet.php?employee=<?php echo "$my_id"; ?>&redirect=<?php echo "$redirect"; ?>" class="btn btn-primary" role="button">My Time Sheet</a></td></tr>
						</table>
  				</div>
  			</div>
  			<!-- End of Employees Panel table -->
        <!-- Employees table -->
  			<div class="card col-md-8 mb-3 ml-3">
          <div class="card-header">
            <i class="fa fa-table"></i> Employees Table</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  							<?php
  								$data = grab_employees_restricted();
  								echo "<thead><tr>";
  								if($data) {
  									while ($fieldinfo=mysqli_fetch_field($data)) {
  										echo "<th>{$fieldinfo->name}</th>";
  									}
  									echo "<th>View Time Sheet</th>
                          <th>View Job Logs</th>
													<th>Update</th>
													<th>Remove</th>";
  								}
  								echo "</tr></thead><tbody>";
  								while($row=mysqli_fetch_assoc($data)) {
  									echo "<tr>";
  									$i = 0;
  									$id = "";
  									foreach($row as $_column) {
  										if($i == 0) $id = $_column;
  										echo "<td>{$_column}</td>";
  										$i++;
  									}
                    // view time Sheet
                    echo "<td align='center'><a target='_blank' href='employee/timesheetview.php?employee=$id' class='btn btn-primary'><i class='fa fa-calendar'></i></a></td>";
                    // view job logs
										echo "<td align='center'><a onclick='setIdJob($id);' data-toggle='modal' data-target='#employeeJobModal' class='btn btn-primary'><i style='color:#fff;' class='fa fa-file-text-o'></li></a></td>";
										echo "<td align='center'><a onclick='setId($id);' data-toggle='modal' data-target='#employeeUpdateModal' class='btn btn-primary'><i style='color:#fff;' class='fa fa-pencil-square-o'></li></a></td>";
										echo "<td align='center'><a onclick='setIdRemove($id);' data-toggle='modal' data-target='#employeeRemoveModal' class='btn btn-primary'><i style='color:#fff;' class='fa fa-minus-square'></li></a></td>";
  									echo "</tr>";
  								}
  								echo "</tbody>";
  							 ?>
  						</table>
  					</div>
  				</div>
  			</div>
  			<!-- End of Employees table -->
      </div>
			<div class="row">
        <!-- Employees table -->
  			<div class="card col-md-8 mb-3 ml-3">
          <div class="card-header">
            <i class="fa fa-table"></i> Employee Username Table</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  							<?php
  								$data = grab_employees_and_usernames();
  								echo "<thead><tr>";
  								if($data) {
  									while ($fieldinfo=mysqli_fetch_field($data)) {
  										echo "<th>{$fieldinfo->name}</th>";
  									}
  								}
  								echo "</tr></thead><tbody>";
  								while($row=mysqli_fetch_assoc($data)) {
  									echo "<tr>";
  									$i = 0;
  									$id = "";
  									foreach($row as $_column) {
  										if($i == 0) $id = $_column;
  										echo "<td>{$_column}</td>";
  										$i++;
  									}
  									echo "</tr>";
  								}
  								echo "</tbody>";
  							 ?>
  						</table>
  					</div>
  				</div>
  			</div>
  			<!-- End of Employees table -->
      </div>

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small><p class="text-black">Contact Us @ Email: <a href="mailto:nancy.generations@gmail.com">nancy.generations@gmail.com</a> | Phone Number: (516) 849-1226 | <a target="_blank" href="https://www.facebook.com/generationsadultcare/">Our Facebook</a></p></small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

		<!-- Logout Modal-->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
						<a class="btn btn-primary" href="../../logout.php">Logout</a>
					</div>
				</div>
			</div>
		</div>
		<!-- End of Logout Modal -->
		<!-- Client Add Modal -->
		<div class="modal fade" id="employeeAddModal" tabindex="-1" role="dialog" aria-labelledby="employeeAddModalTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
					<form name="employeeAddForm" action="../utils/employee/addEmployee.php" method="post" onsubmit="return validateInput('employeeAddForm');">
						<?php
							echo '<input type="hidden" name="redirect" id="redirect" value="';
								if(isset($_GET['redirect'])) {
									echo htmlspecialchars($_GET['redirect']);
								}
							echo '" />';
						 ?>
						<div class="modal-header">
			        <h5 class="modal-title" id="employeeAddModalTitle">Add Employee</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
		      	<div class="modal-body">
									<table>
										<tr>
											<td>
												<label for="employeesPosition">Employees Position</label>
												<input class="form-control no-border" name="employeesPosition" id="employeesPosition" placeholder="Employees Position" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="employeesName">Employee Full Name</label>
												<input class="form-control no-border" name="employeesName" id="employeesName" placeholder="Full Name" type="text">
											</td>
											<td>
												<label for="dob">Date of Birth</label>
												<input class="form-control no-border" name="dob" id="dob" placeholder="MM-DD-YYYY" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="address1">Address 1</label>
												<input class="form-control no-border" name="address1" id="address1" placeholder="Address" type="text">
											</td>
											<td>
												<label for="address2">Address 2</label>
												<input class="form-control no-border" name="address2" id="address2" placeholder="Address" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="phone">Phone Number</label>
												<input class="form-control no-border" name="phone" id="phone" placeholder="123-456-7890" type="text">
											</td>
											<td>
												<label for="email">Email</label>
												<input class="form-control no-border" name="email" id="email" placeholder="my@email.com" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="emergencyContact">Emergency Contact</label>
												<input class="form-control no-border" name="emergencyContact" id="emergencyContact" placeholder="Contact Name" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="emergencyNumber">Emergency Phone Number</label>
												<input class="form-control no-border" name="emergencyNumber" id="emergencyNumber" placeholder="123-456-7890" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="allergies">Allergies</lable>
												<textarea style="width: 100%; border: 1px;" class="form-control" cols="20" rows="5" name="allergies" id="allergies"></textarea>
											</td>
										</tr>
										<tr>
											<td>
												<label for="payrate">Pay Rate</lable>
												<input class="form-control no-border" name="payrate" id="payrate" placeholder="12.50" type="text">
											</td>
										</tr>
									</table>
			      	</div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  						<button type="submit" class="btn btn-primary">Add Employee</button>
			      </div>
					</form>
		    </div>
		  </div>
		</div>
		<!-- End of Client Add Modal -->
		<!-- Employee Update Modal -->
		<div class="modal fade" id="employeeUpdateModal" tabindex="-1" role="dialog" aria-labelledby="employeeUpdateModalTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
					<form name="employeeUpdateUpdate" action="../utils/employee/updateEmployee.php" method="post" onsubmit="return validateInput('employeeUpdate');">
						<?php
							echo '<input type="hidden" name="redirect" id="redirect" value="';
								if(isset($_GET['redirect'])) {
									echo htmlspecialchars($_GET['redirect']);
								}
							echo '" />';
						 ?>
						<input type="hidden" name="updateId" id="updateId" value=""/>
						<div class="modal-header">
			        <h5 class="modal-title" id="employeeUpdateModalTitle">Update Employee</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
							<div id="updateInsert">
								<!-- Table data with PHP is inserted here -->
							</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  						<button type="submit" class="btn btn-primary">Update Employee</button>
			      </div>
					</form>
		    </div>
		  </div>
		</div>
		<!-- End of Employee Update Modal -->
		<!-- Employee Jobs Modal -->
		<div class="modal fade" id="employeeJobModal" tabindex="-1" role="dialog" aria-labelledby="employeeJobModalTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
					<form name="employeeJobsForm" action="../utils/jobs/loadJobView.php" method="post" onsubmit="return didTheySelect();">
						<?php
							echo '<input type="hidden" name="redirect" id="redirect" value="' . $redirect . '" />';
						 ?>
						<input type="hidden" name="jobViewId" id="jobViewId" value=""/>
						<div class="modal-header">
			        <h5 class="modal-title" id="employeeJobModalTitle">View Jobs</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      	<div class="modal-body">
								<div id="employeeJobsInsert">
								</div>
				      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  						<button type="submit" class="btn btn-primary">Select Job</button>
			      </div>
					</form>
		    </div>
		  </div>
		</div>
		<!-- End of Employee Jobs Modal -->
		<!-- Remove Modal-->
		<div class="modal fade" id="employeeRemoveModal" tabindex="-1" role="dialog" aria-labelledby="employeeRemoveModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form name="employeeRemove" action="../utils/employee/remove_employee.php" method="post">
				 	<input type="hidden" name="removeId" id="removeId" value=""/>
						<div class="modal-header">
							<h5 class="modal-title" id="employeeRemoveModalTitle">Remove Employee</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">Are you sure you wish to remove the employee?</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
							<input class="btn btn-primary" type="submit" value="Yes"/>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End of Remove Modal -->
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
