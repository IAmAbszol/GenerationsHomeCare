<?php
    if(!session_id()) session_start();
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Organization striving to improve elder homecare by supporting aging persons/young disabled and their caregivers.">
    <meta name="author" content="Kyle Darling">
    <meta name="keywords" content="adult care, home care, care, services, transportation, socialization, therapeutic activities, health monitoring, assistance">

    <title>Generations Home Care</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ty    pe="text/javascript"></script>

  </head>

  <body>

    <!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Generations Adult Care</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="services.php">Services<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
							<?php
								if($_SESSION['logon']) {
									if($_SESSION['type'] == "admin") {
										echo "<a class='nav-link' href='dashboard/admin/dashboard.php'>My Dashboard</a>";
									} else if($_SESSION['type'] == "employee") {
										echo "<a class='nav-link' href='dashboard/employee/dashboard.php'>My Dashboard</a>";
									}
								}
							 ?>
						</li>
            <li class="nav-item">
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
