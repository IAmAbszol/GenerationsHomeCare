<?php
	function show_nav($page) {
		echo " <!-- Navigation -->
		<nav class='navbar navbar-expand-lg navbar-dark fixed-top'>
		  <div class='container'>
			<a class='navbar-brand' href='index.php'>Generations Adult Care</a>
			<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarResponsive' aria-controls='navbarResponsive' aria-expanded='false' aria-label='Toggle navigation'>
			  <span class='navbar-toggler-icon'></span>
			</button>
			<div class='collapse navbar-collapse' id='navbarResponsive'>
			  <ul class='navbar-nav ml-auto'>
				<li class='nav-item"; if($page == "home") echo " active"; echo"'>
				  <a class='nav-link' href='index.php'>Home"; if($page == "home") echo "<span class='sr-only'>(current)</span>"; echo"</a>
				</li>
				 <li class='nav-item"; if($page == "services") echo " active"; echo"'>
				  <a class='nav-link' href='services.php'>Services"; if($page == "services") echo "<span class='sr-only'>(current)</span>"; echo"</a>
				</li>
				<li class='nav-item"; if($page == "contact") echo " active"; echo"'>
				  <a class='nav-link' href='contact.php'>Contact"; if($page == "contact") echo "<span class='sr-only'>(current)</span>"; echo"</a>
				</li>
				  <li class='nav-item"; if($page == "login") echo " active"; echo"'>";
						if($_SESSION['logon']) {
							echo "<a class='nav-link' href='logout.php'>Logout</a>";
						} else
							echo "<a class='nav-link' href='login.php'>Login</a>
				</li>
    	      </ul>
      	  </div>
     	 </div>
   	 </nav>
	";	
	}
?>
