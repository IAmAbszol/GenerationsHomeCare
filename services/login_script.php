<?php
	session_start();
	$message="";
	if(isset($_POST["login"])) {
		$redirect = NULL;
		if($_POST['redirect'] != '') {
		    $redirect = $_POST['redirect'];
		}
		if(empty($_POST['username']) || empty($_POST['password'])) {
			$message = "Both fields must be filled out.";
			$_SESSION['sysLogin'] = "$message";
			header("location: ../login.php?redirect=" . urlencode($redirect));
		} else {

			require('server_connection.inc');
			$connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);

			$user=mysqli_real_escape_string($connection, $_POST['username']);
			$pass=mysqli_real_escape_string($connection, $_POST['password']);
			$statement = "select * from Credentials where UserName='$user' AND Password='$pass';";
			$result = $connection->query($statement);

			if($result->num_rows == 1) {
				// lets determine the type of user that logged in
				// if not employee but CEO, Manager, ETC, its an Admin
				$employeeid = ($result->fetch_assoc())["EmployeeID"];
				$check = "select Employees.Position, Employees.Name, Employees.ID from Credentials, Employees where (Credentials.EmployeeID = Employees.ID) AND Employees.ID = '$employeeid' AND Employees.Status='Active';";
				$result_two = $connection->query($check);
				if($result_two->num_rows == 1) {
					$the_row = $result_two->fetch_assoc();
					if(!($the_row["Position"] == "CEO" || $the_row["Position"] == "Manager" || $the_row["Position"] == "Admin")) {
						$name = $the_row["Name"];
						$the_id = $the_row['ID'];
						$_SESSION['logon'] = true;
						$_SESSION['user'] = "$name";
						$_SESSION['type'] = "employee";
						$_SESSION['sysLogin'] = "success";
						$_SESSION['user_id'] = $the_id;
						mysqli_close($conection);
						if($redirect) {
							  header("Location:". $redirect);
						} else {
							header("location: ../index.php");
						}
						exit();
					} else if($the_row["Position"] == "CEO" || $the_row["Position"] == "Manager" || $the_row["Position"] == "Admin") {
						$name = $the_row["Name"];
						$the_id = $the_row['ID'];
						$_SESSION['logon'] = true;
						$_SESSION['user'] = "$name";
						$_SESSION['type'] = "admin";
						$_SESSION['sysLogin'] = "success";
						$_SESSION['user_id'] = $the_id;
						mysqli_close($conection);
						if($redirect) {
								header("Location:". $redirect);
						} else {
							header("location: ../index.php");
						}
						exit();
					} else {
						$message = "Employee has been removed from the system.";
						$_SESSION['sysLogin'] = "$message";
						mysqli_close($conection);
						header("location: ../login.php?redirect=" . urlencode($redirect));
					}
				} else {
					$message = "Employee has been removed from the system.";
					$_SESSION['sysLogin'] = "$message";
					mysqli_close($conection);
					header("location: ../login.php?redirect=" . urlencode($redirect));
				}
			} else if($result->num_rows == 0){
				$message = "Incorrect username or password";
				$_SESSION['sysLogin'] = "$message";
				mysqli_close($conection);
				header("location: ../login.php?redirect=" . urlencode($redirect));
			} else {
				$message = "Database Login Error. Too many retrieved accounts. Please contact your sites Administrator.";
				$_SESSION['sysLogin'] = "$message";
				mysqli_close($conection);
				header("location: ../login.php?redirect=" . urlencode($redirect));
			}
		}
	}

	function write_to_log($message) {
		$file = fopen("logfile.txt", "w") or die("Unable to open file!");
		fwrite($file, "$message\n");
		fclose($file);
	}

	function connect_to_db($server, $username, $pwd, $dbname) {
		$conn = mysqli_connect($server, $username, $pwd);
		if(!$conn) {
				echo "" . mysqli_error($conn);
				exit;
		}
		$dbh = mysqli_select_db($conn, $dbname);
		if(!$dbh) {
			echo "" . mysqli_error($conn);
			exit;
		}
		return $conn;
	}
?>
