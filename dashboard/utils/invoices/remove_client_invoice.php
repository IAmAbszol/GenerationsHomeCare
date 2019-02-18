<?php
    include('../../../services/server_connection.inc');
    include('../../../services/login_script.php');
    $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
    $id = mysqli_real_escape_string($connection, $_POST['clientInvoiceRemoveId']);
    $select = "select JobID from ClientInvoices where ID='$id'";
    $select_result = $connection->query($select);
    $row = mysqli_fetch_assoc($select_result);
    $jobid = $row['JobID'];
    $invoice_remove = "delete from ClientInvoices where ID='$id'";
    $invoice_result = $connection->query($invoice_remove);
    $job_remove = "delete from Jobs where ID='$jobid'";
    $job_result = $connection->query($job_remove);
    mysqli_close($connection);
    if($invoice_result) {
      $_SESSION['message_success'] = "Client Invoice was successfully removed.";
      header("location: ../../admin/clientinvoices.php");
      exit();
    } else {
      echo "Error, bad query result.\nContact your site administrator with the following message.\n$invoice_remove";
    }

 ?>
