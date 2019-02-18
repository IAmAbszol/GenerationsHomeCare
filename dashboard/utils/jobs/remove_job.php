<?php
    include('../../../services/server_connection.inc');
    include('../../../services/login_script.php');
    $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
    $id = mysqli_real_escape_string($connection, $_POST['removeId']);
    $invoice_remove = "delete from ClientInvoices where JobID='$id'";
    $invoice_result = $connection->query($invoice_remove);
    $statement = "delete from Jobs where ID='$id';";
    $result = $connection->query($statement);
    mysqli_close($connection);
    if($result) {
      $_SESSION['message_success'] = "Job was successfully removed.";
      header("location: ../../admin/jobs.php");
      exit();
    } else {
      echo "Error, bad query result.\nContact your site administrator with the following message.\n$statement";
    }

 ?>
