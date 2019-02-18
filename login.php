<?php
	include('services/login_script.php');
	if ((isset($_SESSION['logon']))) {
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Organization striving to improve elder homecare by supporting aging persons/young disabled and their caregivers.">
    <meta name="author" content="Kyle Darling">
    <meta name="keywords" content="adult care, home care, care, services, transportation, socialization, therapeutic activities, health monitoring, assistance">

    <title>Generations Adult Care</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
		<link href="css/sb-admin.css" rel="stylesheet">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ty    pe="text/javascript"></script>

		<!-- Notifications -->
		<link href="css/toastr.css" rel="stylesheet"/>
    <script src="js/toastr.js"></script>

  </head>

  <body>

    <!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Generations Home Care</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item active">
                <?php
                    if($_SESSION['logon']) {
                         echo "<a class='nav-link' href='logout.php'>Logout</a>";
                    } else
                         echo "<a class='nav-link' href='login.php'>Login</a>";
                ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <!-- Page Content -->
    <div class="container supportFooter">

			<div class="col-sm-6 col-sm-offset-3 addSpace">

					<?php
						if(!empty($_SESSION['sysLogin'])) {
							$message = $_SESSION['sysLogin'];
							echo "<script type='text/javascript'>
								    $( document ).ready(function() {
	                					toastr.error('$message', 'Error');
	           						 });
								  </script>";
							$_SESSION['sysLogin'] = "";
						}
					?>
				</div>

				<form action="services/login_script.php" method="POST" id="formLogin">
					<?php
						echo '<input type="hidden" name="redirect" id="redirect" value="';
							if(isset($_GET['redirect'])) {
								echo htmlspecialchars($_GET['redirect']);
							}
						echo '" />';
					 ?>
					<div class="field-group">
						<div><label for="login">Username</label></div>
						<div><input name="username" id="username" type="text" class="input-field"></div>
					</div>
					<div class="field-group">
						<div><label for="password">Password</label></div>
						<div><input name="password" id="password" type="password" class="input-field"> </div>
					</div>
					<div class="field-group">
						<div><input type="submit" name="login" id="login" value="Login" class="form-submit-button"></span>
							<input type="reset" name="clear" id="clear" value="Clear" class="form-reset-button"></span></div>
					</div>
				</form>

			</div>

		</div>
		<!-- /.container -->

		<!-- Footer -->
		<footer class="py-3">
		  <center>
			<table>
			  <tr>
				<td>
               <p class="text-white">Contact Us @ Email: <a href="mailto:nancy.generations@gmail.com">nancy.generations@gmail.com</a> | Phone Number: (516) 849-1226 | <a target="_blank" href="https://www.facebook.com/generationsadultcare/">Our Facebook</a></p>
            </td>
          </tr>
        </table>
      </center>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
