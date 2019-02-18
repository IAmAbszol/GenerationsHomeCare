<!-- Admin Dashboard -->
<?php
	include('../../services/login_script.php');
	include("../utils/table_calls.php");
	if (!(isset($_SESSION['logon']))) {
		header('Location: ../../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
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
    function validate() {
      var pw = document.getElementById('newPassword').value;
      var pw2 = document.getElementById('newPassword2').value;
			if(pw == " ") {
				$( document ).ready(function() {
          toastr.error('Passwords cannot be blank.', 'Error!');
        });
        return false;
			}
      if(pw != pw2) {
        $( document ).ready(function() {
          toastr.error('Passwords don\'t match.', 'Error!');
        });
        return false;
      }
			if(pw.length < 5) {
				$( document ).ready(function() {
          toastr.error('Passwords must be greater than 5 characters long.', 'Error!');
        });
        return false;
			}
      return true;
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
        <li class="breadcrumb-item active">Change/Forgot Password</li>
      </ol>
      <form name="passwordchange" method="post" action="changePassword.php" onsubmit="return validate();">
        <label for="newPassword">Enter New Password</label>
        <input style="width: 25%;" class="form-control no-border" name="newPassword" id="newPassword" placeholder="Password" type="password">
        <label for="newPassword2">Confirm New Password</label>
        <input style="width: 25%;" class="form-control no-border" name="newPassword2" id="newPassword2" placeholder="Retype Password" type="password">
        <button style="margin-top: 20px;" type="submit" class="button">Submit</button>
        <button type="reset" class="button">Clear</button>
      </form>
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
