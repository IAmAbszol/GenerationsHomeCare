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
		 <link rel="shortcut icon" type="image/x-icon" href="img/Icon.png" />

		<!-- Bootstrap core CSS -->
		<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">

		<!-- Notifications -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>

		<link href="css/toastr.css" rel="stylesheet"/>
		<script src="js/toastr.js"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
					<?php
						if($_SESSION['sysLogin'] == "success") {
							$_SESSION['sysLogin'] = "";
							$user = $_SESSION['user'];
							echo "toastr.success('Welcome $user', 'User has logged in');";
						}
						if ($_GET['logout'])
						{
							$message = urldecode(base64_decode($_GET['logout']));
							echo "toastr.error('Goodbye', '$message');";
						}
						if ($_GET['error'])
						{
							$message = urldecode(base64_decode($_GET['error']));
							echo "toastr.error('$message', 'Error!');";
						}
					?>
				});
    </script>

	</head>

  <body>

    <!-- Navigation, sourced to different file to manage mass changes pending later on -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Generations Home Care</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
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
      <!-- Portfolio Item Heading -->
      <h1 class="my-4">Home</h1>

      <!-- Portfolio Item Row -->
      <div class="row">

        <div class="col-md-8">
          <div id="carouselPictures" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active keepHeight">
                <img class="d-block img-fluid" src="img/img0.jpg" alt="First Slide">
              </div>
              <div class="carousel-item keepHeight">
                <img class="d-block img-fluid" src="img/img1.jpg" alt="Second Slide">
              </div>
              <div class="carousel-item keepHeight">
                <img class="d-block img-fluid" src="img/img2.jpg" alt="Third Slide">
              </div>
              <div class="carousel-item keepHeight">
                <img class="d-block img-fluid" src="img/img3.jpg" alt="Fourth Slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselPictures" role="button" data-slide="prev">
             <span class="carousel-control-prev-icon" aria-hidden="true"></span>
             <span class="sr-only">Previous</span>
           </a>
           <a class="carousel-control-next" href="#carouselPictures" role="button" data-slide="next">
             <span class="carousel-control-next-icon" aria-hidden="true"></span>
             <span class="sr-only">Next</span>
           </a>
          </div>
        </div>

        <div class="col-md-4">
          <h3 class="my-3">Our Mission</h3>
          <p>Generations strives to assist the caregiver and help seniors remain independent longer. Services offered include:
            <ul style="margin-left:15px;" class="dashed">
              <li>Breakfast, Hot Catered Lunch &amp; Snack</li>
              <li>Assistance with Mobility &amp; Toileting</li>
              <li>Transportation</li>
              <li>Socialization</li>
              <li>Therapeutic Activities</li>
              <li>Health Monitoring</li>
            </ul>
          </p>
        </div>

      </div>
      <!-- /.row -->

      <!-- Related Projects Row -->
      <h3 class="my-4">Find Us</h3>

      <div class="row">

        <div class="col-md-3 col-sm-6 mb-4">
          <a target="_blank" href="https://wego.here.com/directions/mix//Generations-Adult-Care,-Po-Box-254-Oceanside,-11572-Long-Beach:e-eyJuYW1lIjoiR2VuZXJhdGlvbnMgQWR1bHQgQ2FyZSIsImFkZHJlc3MiOiJQbyBCb3ggMjU0IE9jZWFuc2lkZSwgTG9uZyBCZWFjaCwgTmV3IFlvcmsgMTE1NzIiLCJsYXRpdHVkZSI6NDAuNjQ0NDM2LCJsb25naXR1ZGUiOi03My42Mzk0ODAzLCJwcm92aWRlck5hbWUiOiJmYWNlYm9vayIsInByb3ZpZGVySWQiOjUyNjYzMjg0MDc2ODkwOX0=?map=40.64444,-73.63948,15,normal&fb_locale=en_US">
            <div id="map"></div>
            <script>
              function initMap() {
                var uluru = {lat: 40.64444, lng: -73.63948};
                var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 15,
                  center: uluru
                });
                var marker = new google.maps.Marker({
                  position: uluru,
                  map: map
                });
              }
            </script>
            <script async defer
             src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDepoyotX9c6L-6Ietupyc-gqz8nvxYJuY&callback=initMap">
            </script>
          </a>
        </div>

      </div>
      <!-- /.row -->

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
