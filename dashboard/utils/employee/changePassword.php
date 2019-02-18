<?php
	include('../../../services/login_script.php');
	include('../../../services/server_connection.inc');
	$dbh = "";
	$connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);

	$password = mysqli_real_escape_string($connection, $_POST['newPassword']);
	$id = $_SESSION['user_id'];
	$update = "update Credentials set Password='$password' where EmployeeID='$id';";
	$result = $connection->query($update);

	if($result) {
		$_SESSION['message_success'] = "Password successfully updated.";
	} else {
		$_SESSION['message_error'] = "Password failed to update.";
    $error = mysqli_error($connection);
    write_to_log("[$your_date] $statement. Result $error");
	}
	header("Location: ../../admin/dashboard.php");
	exit();
?>
