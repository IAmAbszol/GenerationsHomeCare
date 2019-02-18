<?php
  include('../../../services/server_connection.inc');
  include('../table_calls.php');
  $code = $_GET['employee'];
  $data = grab_employee_linked_jobs($code);
  $row;
  echo "<table class='table'>";
  echo "<th>Employee</th><th>Starting</th><th>Ending</th><th>Client</th>";
  while($row = mysqli_fetch_assoc($data)) {
    echo "<tr>";
    $client = $row['Client'];
    $employee = $row['Employee'];
    $start = $row['StartOfWeek'];
    $end = $row['EndOfWeek'];
    $id = $row['JobID'];
    echo "<td>$employee</td><td>$start</td><td>$end</td><td>$client</td>";
    echo "<td><input type='radio' id='jobs' name='jobs' value='$id'/></td>";
    echo "</tr>";
  }
  echo "</table>";
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
