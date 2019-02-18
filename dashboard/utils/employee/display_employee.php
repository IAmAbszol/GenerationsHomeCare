<?php
  include('../../../services/server_connection.inc');
  include('../table_calls.php');
  $code = $_GET['employee'];
  $data = grab_employees($code);
  // should only have 1
  if(mysqli_num_rows($data) == 1) {
    $result = $data->fetch_array(MYSQLI_ASSOC);
    $position = $result['Position'];
    $name = $result['Name'];
    $dateTmp = $result['DOB'];
    $dob = date("m-d-Y", strtotime($dateTmp));
    $address1 = $result['Address'];
    $address2 = $result['Address2'];
    $email = $result['EmailAddress'];
    $phone = $result['PhoneNumber'];
    $emergencyContact = $result['EmergencyContact'];
    $emergencyNumber = $result['EmergencyNumber'];
    $allergies = $result['Allergies'];
    $payrate = $result['PayRate'];
    echo "<table>										<tr>											<td>												<label for='employeesPosition'>Employees Position</label>												<input class='form-control no-border' name='employeesPosition' id='employeesPosition' value='$position' type='text'>											</td>										</tr>										<tr>											<td>												<label for='employeesName'>Employee Full Name</label>												<input class='form-control no-border' name='employeesName' id='employeesName' value='$name' type='text'>											</td>											<td>												<label for='dob'>Date of Birth</label>												<input class='form-control no-border' name='dob' id='dob' value='$dob' type='text'>											</td>										</tr>										<tr>											<td>												<label for='address1'>Address 1</label>												<input class='form-control no-border' name='address1' id='address1' value='$address1' type='text'>											</td>											<td>												<label for='address2'>Address 2</label>												<input class='form-control no-border' name='address2' id='address2' value='$address2' type='text'>											</td>										</tr>										<tr>											<td>												<label for='phone'>Phone Number</label>												<input class='form-control no-border' name='phone' id='phone' value='$phone' type='text'>											</td>											<td>												<label for='email'>Email</label>												<input class='form-control no-border' name='email' id='email' value='$email' type='text'>											</td>										</tr>										<tr>											<td>												<label for='emergencyContact'>Emergency Contact</label>												<input class='form-control no-border' name='emergencyContact' id='emergencyContact' value='$emergencyContact' type='text'>											</td>										</tr>										<tr>											<td>												<label for='emergencyNumber'>Emergency Phone Number</label>												<input class='form-control no-border' name='emergencyNumber' id='emergencyNumber' value='$emergencyNumber' type='text'>											</td>										</tr>										<tr>											<td>												<label for='allergies'>Allergies</lable>												<textarea style='width: 100%; border: 1px;' class='form-control' cols='20' rows='5' name='allergies' id='allergies'>$allergies</textarea>											</td>										</tr>										<tr>											<td>												<label for='payrate'>Pay Rate</lable>												<input class='form-control no-border' name='payrate' id='payrate' value='$payrate' type='text'>											</td>										</tr>									</table>";
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
