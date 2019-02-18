<?php
    include('../../../services/server_connection.inc');
    include('../../../services/login_script.php');
    $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
    $id = mysqli_real_escape_string($connection, $_POST['clientPaidId']);
    $invoice = "update ClientInvoices set Paid='Paid' where ID='$id'";
    $result = $connection->query($invoice);
    mysqli_close($connection);
    if($result) {
      $_SESSION['message_success'] = "Client Invoice was successfully marked as paid.";
      header("location: ../../admin/clientinvoices.php");
      exit();
    } else {
      echo "Error, bad query result.\nContact your site administrator with the following message.\n$invoice";
    }

 ?>
