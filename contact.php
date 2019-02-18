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

	<link href="css/toastr.css" rel="stylesheet"/>
    <script src="js/toastr.js"></script>

    <script type="text/javascript">

      function verify() {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var number = document.getElementById('phone').value;
        var comment = document.getElementById('comment').value;

        var errormessage = "";

        errormessage += checkName(name);
        errormessage += checkEmail(email);
        errormessage += checkPhone(number);
        if(comment == "") errormessage += "* Please fill out on how we may help you today.\n";

        if(errormessage != "") {
			  $( document ).ready(function() {
				var elm = errormessage.split('|');
				for(i = 0; i < elm.length; i++) {
					toastr.error(elm[i], 'Error');
				}
              });
			return false;
        }
        return true;
      }
      function checkPhone(phone) {
        if(phone != "") {
           if(phone.match(/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/)) {
             return "";
           } else
            return "* Please enter a valid phone number.|";
        } else
          return "* Please fill out a phone number.|";
      }
      function checkEmail(email) {
        if(email != "") {
          if(email.lastIndexOf("@") > 0) {
            return "";
          } else
            return "* Please enter a valid email address.|";
        } else
          return "* Please fill out an email address.|";
      }
		function checkName(name) {
        if(name != "") {
          if(name.match(/^[A-Za-z-]+[ ][A-Za-z-]+$/)) {
            if(name.lastIndexOf("-") == (name.length - 1)) {
              return "* Please check formatting on hyphens. Misplaced hyphen found at the end of the last name.|";
            }
            if(name.lastIndexOf("-") == 0) {
              return "* Please check formatting on hyphens. Misplaced hyphen found at the start of the first name.|";
            }
          } else
            return "* Only have alphabetical characters and a space separating your first and last name. Any additional spaces will require a hyphen instead.|";
        } else
          return "* Please fill out your name.|";
        return "";
      }
	</script>

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
            <li class="nav-item active">
              <a class="nav-link" href="contact.php">Contact<span class="sr-only">(current)</span></a>
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
      <!-- Form content -->
      <div class="col-md-5 addSpace">
        <h4>Get in touch</h4>
        <p>Any questions and/or business propositions may be found at the bottom of this page.</p>
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
