<?php
include('../../../services/server_connection.inc');
include('../../../services/login_script.php');
$connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
$id = mysqli_real_escape_string($connection, $_POST['jobs']);
$redirect = mysqli_real_escape_string($connection, $_POST['redirect']);
mysqli_close($connection);
header("Location: " . "../../admin/jobs/jobcreationview.php?job=$id&redirect=$redirect");
exit();
 ?>
