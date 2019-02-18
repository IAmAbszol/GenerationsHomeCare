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
		window.onload = function(){
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
		}
	</script>
	<script type="text/javascript">
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
			 xmlhttp.open("GET","../utils/client/display_client.php?client="+i,true);
			 xmlhttp.send();

		}

		function setIdRemove(i) {
			// grab stored information

			// set the id, php will use this later to update accordingly
			document.getElementById('removeId').value=i;

		}

		function validateInput(myForm) {

			var noerrors = true;

			var clientName = document.forms[myForm]['clientsName'];
			if(!clientName.value.match(/^[A-Za-z- ]+$/)) {
				clientName.style.border = "2px solid #fc677d";
				$( document ).ready(function() {
					toastr.error('Clients name contains numbers or unrecognized characters.', 'Error!');
				});
				noerrors = false;
			} else {
				clientName.style.border = "0";
				clientName.style.borderBottom = "1px solid black";
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

			var address = document.forms[myForm]['address'];
			if(!address.value.match('')) {
				address.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Address must be filled out.', 'Error!');
					});
					noerrors = false;
			} else {
				address.style.border = "0";
				address.style.borderBottom = "1px solid black";
			}

			var clientnumber = document.forms[myForm]['clientsNumber'];
			if(!clientnumber.value.match(/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/)) {
				clientnumber.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Clients phone number has an invalid format/character.', 'Error!');
					});
					noerrors = false;
			} else {
				clientnumber.style.border = "0";
				clientnumber.style.borderBottom = "1px solid black";
			}

			var emergencycontact1name = document.forms[myForm]['emergencyContact1'];
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

			var phonecontact1number = document.forms[myForm]['emergencyNumber1'];
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

			var emergencycontact2name = document.forms[myForm]['emergencyContact2'];
			if(!emergencycontact2name.value == '' && !emergencycontact2name.value.match(/^[A-Za-z- ]+$/)) {
				emergencycontact2name.style.border = "2px solid #fc677d";
				$( document ).ready(function() {
					toastr.error('Emergency contact name contains numbers or unrecognized characters.', 'Error!');
				});
				noerrors = false;
			} else {
				emergencycontact2name.style.border = "0";
				emergencycontact2name.style.borderBottom = "1px solid black";
			}

			var phonecontact2number = document.forms[myForm]['emergencyNumber2'];
			if(!phonecontact2number.value == '' && !phonecontact2number.value.match(/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/)) {
				phonecontact2number.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Emergency contact phone number has an invalid format/character.', 'Error!');
					});
					noerrors = false;
			} else {
				phonecontact2number.style.border = "0";
				phonecontact2number.style.borderBottom = "1px solid black";
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
        <li class="breadcrumb-item active">My Clients</li>
      </ol>

      <div class="row">
    		<!-- Clients Panel table -->
  			<div class="card col-md-3 mb-2 ml-2">
          <div class="card-header">
            <i class="fa fa-address-book-o"></i> Client Panel</div>
          <div class="card-body">
						<table cellpadding="5" align="center">
							<tr><td style="text-align: center"><button type="button" class="btn btn-primary" id="addclient" data-toggle="modal" data-target="#clientAddModal">Add Client</button></td></tr>
						</table>
  				</div>
  			</div>
  			<!-- End of Client Panel table -->
        <!-- Clients table -->
  			<div class="card col-md-8 mb-3 ml-3">
          <div class="card-header">
            <i class="fa fa-table"></i> Clients Table</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  							<?php
  								$data = grab_clients_restricted();
  								echo "<thead><tr>";
  								if($data) {
  									while ($fieldinfo=mysqli_fetch_field($data)) {
  										echo "<th>{$fieldinfo->name}</th>";
  									}
  									echo "<th>Available Care Plan</th>
													<th>Edit Care Plan</th>
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
                    $redirect = urlencode($_SERVER['REQUEST_URI']);
										if(check_client_plan($id)) {
  									  echo "<td align='center'><a target='_blank' href='careplan/generationscareplanview.php?careplan=$id&redirect=$redirect' class='btn btn-primary'><i class='fa fa-binoculars'></i></a></td>";
                    } else {
                    	echo "<td></td>";
                    }
                    if(check_client_plan($id)) {
  									  echo "<td align='center'><a href='careplan/generationscareplan.php?careplan=$id&redirect=$redirect' class='btn btn-primary'><i class='fa fa-envelope-open-o'></i></a></td>";
                    } else {
                      echo "<td align='center'><a href='careplan/generationscareplan.php?evaluate=$id&redirect=$redirect' class='btn btn-primary'><i class='fa fa-plus-square'></li></a></td>";
                    }
										echo "<td align='center'><a onclick='setId($id);' data-toggle='modal' data-target='#clientUpdateModal' class='btn btn-primary'><i style='color:#fff;' class='fa fa-pencil-square-o'></li></a></td>";
										echo "<td align='center'><a onclick='setIdRemove($id);' data-toggle='modal' data-target='#clientRemoveModal' class='btn btn-primary'><i style='color:#fff;' class='fa fa-minus-square'></li></a></td>";
  									echo "</tr>";
  								}
  								echo "</tbody>";
  							 ?>
  						</table>
  					</div>
  				</div>
  			</div>
  			<!-- End of Clients table -->
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
		<div class="modal fade" id="clientAddModal" tabindex="-1" role="dialog" aria-labelledby="clientAddModalTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
					<form name="clientAddForm" action="../utils/client/addClient.php" method="post" onsubmit="return validateInput('clientAddForm');">
						<?php
							echo '<input type="hidden" name="redirect" id="redirect" value="';
								if(isset($_GET['redirect'])) {
									echo htmlspecialchars($_GET['redirect']);
								}
							echo '" />';
						 ?>
						<div class="modal-header">
			        <h5 class="modal-title" id="clientAddModalTitle">Add Client</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
									<table>
										<tr>
											<td>
												<label for="clientsName">Clients Full Name</label>
												<input class="form-control no-border" name="clientsName" id="clientsName" placeholder="Full Name" type="text">
											</td>
											<td>
												<label for="dob">Date of Birth</label>
												<input class="form-control no-border" name="dob" id="dob" placeholder="MM-DD-YYYY" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="address">Address</label>
												<input class="form-control no-border" name="address" id="address" placeholder="Address" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="clientsNumber">Clients Phone Number</label>
												<input class="form-control no-border" name="clientsNumber" id="clientsNumber" placeholder="123-456-7890" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="emergencyContact1">Emergency Contact 1</label>
												<input class="form-control no-border" name="emergencyContact1" id="emergencyContact1" placeholder="Contact Name" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="emergencyNumber1">Emergency Phone Number 1</label>
												<input class="form-control no-border" name="emergencyNumber1" id="emergencyNumber1" placeholder="123-456-7890" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="emergencyContact2">Emergency Contact 2</label>
												<input class="form-control no-border" name="emergencyContact2" id="emergencyContact2" placeholder="Contact Name" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="emergencyNumber2">Emergency Phone Number 2</label>
												<input class="form-control no-border" name="emergencyNumber2" id="emergencyNumber2" placeholder="123-456-7890" type="text">
											</td>
										</tr>
										<tr>
											<td>
												<label for="allergies">Allergies</lable>
												<textarea style="width: 100%; border: 1px;" class="form-control" cols="20" rows="5" name="allergies" id="allergies"></textarea>
											</td>
										</tr>
									</table>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  						<button type="submit" class="btn btn-primary">Add Client</button>
			      </div>
					</form>
		    </div>
		  </div>
		</div>
		<!-- End of Client Add Modal -->
		<!-- Client Update Modal -->
		<div class="modal fade" id="clientUpdateModal" tabindex="-1" role="dialog" aria-labelledby="clientUpdateModalTitle" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
					<form name="clientUpdate" action="../utils/client/updateClient.php" method="post" onsubmit="return validateInput('clientUpdate');">
						<?php
							echo '<input type="hidden" name="redirect" id="redirect" value="';
								if(isset($_GET['redirect'])) {
									echo htmlspecialchars($_GET['redirect']);
								}
							echo '" />';
						 ?>
						<input type="hidden" name="updateId" id="updateId" value=""/>
						<div class="modal-header">
			        <h5 class="modal-title" id="clientUpdateModalTitle">Update Client</h5>
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
  						<button type="submit" class="btn btn-primary">Update Client</button>
			      </div>
					</form>
		    </div>
		  </div>
		</div>
		<!-- End of Client Update Modal -->
		<!-- Remove Modal-->
		<div class="modal fade" id="clientRemoveModal" tabindex="-1" role="dialog" aria-labelledby="clientRemoveModalTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form name="clientRemove" action="../utils/client/remove_client.php" method="post">
				 	<input type="hidden" name="removeId" id="removeId" value=""/>
						<div class="modal-header">
							<h5 class="modal-title" id="clientRemoveModalTitle">Remove Client</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">Are you sure you wish to remove this client?</div>
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
