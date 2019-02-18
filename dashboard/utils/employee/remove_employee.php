<?php
    include('../../../services/server_connection.inc');
    include('../../../services/login_script.php');
    $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
    $id = mysqli_real_escape_string($connection, $_POST['removeId']);
    date_default_timezone_set('America/New_York');
    $today = date('Y-m-d');
    $statement = "update Employees set DateOfTermination = '$today', Status='Inactive' where ID='$id'";
    $result = $connection->query($statement);
      mysqli_close($connection);
    if($result) {
      $_SESSION['message_success'] = "Employee was successfully removed.";
      header("location: ../../admin/employees.php");
      exit();
    } else {
      echo "Error, bad query result.\nContact your site administrator with the following message.\n$statement";
    }

 ?>
