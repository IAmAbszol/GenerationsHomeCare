<?php
  include('../../../services/server_connection.inc');
  include('../table_calls.php');
  $code = $_GET['client'];
  $data = grab_clients($code);
  // should only have 1
  if(mysqli_num_rows($data) == 1) {
    $result = $data->fetch_array(MYSQLI_ASSOC);
    $name = $result['Name'];
    $dateTmp = $result['DOB'];
    $date = date("m-d-Y", strtotime($dateTmp));
    $address = $result['Address'];
    $clientNumber = $result['ClientsNumber'];
    $emergencyContact1 = $result['EmergencyContact1'];
    $emergencyNumber1 = $result['EmergencyNumber1'];
    $emergencyContact2 = $result['EmergencyContact2'];
    $emergencyNumber2 = $result['EmergencyNumber2'];
    $allergies = $result['Allergies'];
    echo "<table><tr><td><label for='clientsName'>Clients Full Name</label><input class='form-control no-border' name='clientsName' id='clientsName' value='$name' type='text'></td><td><label for='dob'>Date of Birth</label><input class='form-control no-border' name='dob' id='dob' placeholder='MM-DD-YYYY' value='$date' type='text'></td></tr><tr><td><label for='address'>Address</label><input class='form-control no-border' name='address' id='address' placeholder='Address' value='$address' type='text'></td></tr><tr><td><label for='clientsNumber'>Clients Phone Number</label><input class='form-control no-border' name='clientsNumber' id='clientsNumber' value='$clientNumber' placeholder='123-456-7890' type='text'></td></tr><tr><td><label for='emergencyContact1'>Emergency Contact 1</label><input class='form-control no-border' name='emergencyContact1' id='emergencyContact1' value='$emergencyContact1' placeholder='Contact Name' type='text'></td></tr><tr><td><label for='emergencyNumber1'>Emergency Phone Number 1</label><input class='form-control no-border' name='emergencyNumber1' id='emergencyNumber1' value='$emergencyNumber1' placeholder='123-456-7890' type='text'></td></tr><tr><td><label for='emergencyContact2'>Emergency Contact 2</label><input class='form-control no-border' name='emergencyContact2' id='emergencyContact2' value='$emergencyContact2' placeholder='Contact Name' type='text'></td></tr><tr><td><label for='emergencyNumber2'>Emergency Phone Number 2</label><input class='form-control no-border' name='emergencyNumber2' id='emergencyNumber2' value='$emergencyNumber2' placeholder='123-456-7890' type='text'></td></tr><tr><td><label for='allergies'>Allergies</lable><textarea style='width: 100%; border: 1px;' class='form-control' cols='20' rows='5' name='allergies' id='allergies'>$allergies</textarea></td></tr></table>";
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
