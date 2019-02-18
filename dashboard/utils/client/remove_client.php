<?php
    include('../../../services/server_connection.inc');
    include('../../../services/login_script.php');
    $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
    $id = mysqli_real_escape_string($connection, $_POST['removeId']);
    $statement = "update Clients set Status='Inactive' where ID='$id'";
    $result = $connection->query($statement);
      mysqli_close($connection);
    if($result) {
      $_SESSION['message_success'] = "Client was successfully removed.";
      header("location: ../../admin/clients.php");
      exit();
    } else {
      echo "Error, bad query result.\nContact your site administrator with the following message.\n$statement";
    }

 ?>
