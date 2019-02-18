<?php
  error_reporting(E_ALL); ini_set('display_errors', 1);
/*
  * File to grab form data from Generations
  * generationsadultcare/dashboard/admin/careplan/generationscareplan.php
  */
  include('../../../services/login_script.php');
  include('../../../services/server_connection.inc');
  $dbh = "";
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);


  // first to read in EVERYTHING
  //read_checkbox_array($_POST['activityplan']);
  $redirect = NULL;
  if($_POST['redirect'] != '') {
      $redirect = $_POST['redirect'];
  }
  $_client_id="";
  $_membername="";
  $_dobmonth="";
  $_dobday="";
  $_dobyear="";
  $_address="";
  $_clientsphonenumber="";
  $_emergencycontact1="";
  $_phonecontact1="";
  $_emergencycontact2="";
  $_phonecontact2="";
  $_allergies="";
  $_todaysdate="";
  $your_date = "";
  // down near bottom
  $_suppliesneeded="";
  $_specialrequest="";
  $_clientspecifiedcare="";
  $_concat_needs = "";
  // personal comments
  $_additionalcomments="";
  // checkboxes
  $_acitivityplan = "";
  $_checkifapplicableplan = "";
  $_clientenvironment = "";
  $_safetyprecautions = "";
  $_personalcare = "";
  $_typeofservice = "";
  $_elimination = "";
  $_treatments = "";
  if(isset($_POST['client_id']))
    $_client_id=mysqli_real_escape_string($connection, $_POST['client_id']);
  if(isset($_POST['membername']))
    $_membername=mysqli_real_escape_string($connection, $_POST['membername']);
  if(isset($_POST['dobmonth']))
    $_dobmonth=mysqli_real_escape_string($connection, $_POST['dobmonth']);
  if(isset($_POST['dobday']))
    $_dobday=mysqli_real_escape_string($connection, $_POST['dobday']);
  if(isset($_POST['dobyear']))
    $_dobyear=mysqli_real_escape_string($connection, $_POST['dobyear']);
  if(isset($_POST['address']))
    $_address=mysqli_real_escape_string($connection, $_POST['address']);
  if(isset($_POST['clientsphonenumber']))
    $_clientsphonenumber=mysqli_real_escape_string($connection, $_POST['clientsphonenumber']);
  if(isset($_POST['emergencycontact1']))
    $_emergencycontact1=mysqli_real_escape_string($connection, $_POST['emergencycontact1']);
  if(isset($_POST['phonecontact1']))
    $_phonecontact1=mysqli_real_escape_string($connection, $_POST['phonecontact1']);
  if(isset($_POST['emergencycontact2']))
    $_emergencycontact2=mysqli_real_escape_string($connection, $_POST['emergencycontact2']);
  if(isset($_POST['phonecontact2']))
    $_phonecontact2=mysqli_real_escape_string($connection, $_POST['phonecontact2']);
  if(isset($_POST['allergies']))
    $_allergies=mysqli_real_escape_string($connection, $_POST['allergies']);
  if(isset($_POST['todaysdate'])) {
    $_todaysdate=mysqli_real_escape_string($connection, $_POST['todaysdate']);
    $your_date = date("Y-m-d", strtotime($_todaysdate));
  }
    // down near bottom
  if(isset($_POST['suppliesneeded']))
    $_suppliesneeded=mysqli_real_escape_string($connection, $_POST['suppliesneeded']);
  if(isset($_POST['specialrequest']))
    $_specialrequest=mysqli_real_escape_string($connection, $_POST['specialrequest']);
  if(isset($_POST['clientspecifiedcare']))
    $_clientspecifiedcare=mysqli_real_escape_string($connection, $_POST['clientspecifiedcare']);
  $_concat_needs = "$_suppliesneeded#$_specialrequest#$_clientspecifiedcare";
  if(isset($_POST['additionalcomments']))
    $_additionalcomments=mysqli_real_escape_string($connection, $_POST['additionalcomments']);

  if(isset($_POST['activityplan']))
    $_acitivityplan = read_checkbox_array($_POST['activityplan']);
  if(isset($_POST['checkifapplicableplan']))
    $_checkifapplicableplan = read_checkbox_array($_POST['checkifapplicableplan']);
  if(isset($_POST['clientenvironment']))
    $_clientenvironment = read_checkbox_array($_POST['clientenvironment']);
  if(isset($_POST['safetyprecautions']))
    $_safetyprecautions = read_checkbox_array($_POST['safetyprecautions']);
  if(isset($_POST['personalcare']))
    $_personalcare = read_checkbox_array($_POST['personalcare']);
  if(isset($_POST['typeofservice']))
    $_typeofservice = read_checkbox_array($_POST['typeofservice']);
  if(isset($_POST['elimination']))
    $_elimination = read_checkbox_array($_POST['elimination']);
  if(isset($_POST['treatments']))
    $_treatments = read_checkbox_array($_POST['treatments']);

  // update clients
  $update_client = "update Clients set Name='$_membername', Address='$_address', ClientsNumber='$_clientsphonenumber', EmergencyContact1='$_emergencycontact1', EmergencyNumber1='$_phonecontact1', EmergencyNumber2='$_emergencycontact2', EmergencyNumber2='$_phonecontact2', Allergies='$_allergies', Status='Active' where ID='$_client_id';";
  $update_result = $connection->query($update_client);

  // does careplan exist for client?
  $search_statement = "select * from CarePlan where ClientID='$_client_id';";
  $search_result = $connection->query($search_statement);
  $insert_statement = "";
  $update_statement = "";
  if($search_result->num_rows == 0) {

    // success, continuing for new careplan insertion
    $statement = "insert into CarePlan (ClientID, DateCreated, Impairments, PersonalCare, Elimination, Treatments, Activity, SafetyPrecautions, TypeOfServices, ClientEnvironment, ImportantClientInformation, Notes) values
    ($_client_id, '$your_date', '$_checkifapplicableplan', '$_personalcare', '$_elimination', '$_treatments', '$_acitivityplan', '$_safetyprecautions', '$_typeofservice', '$_clientenvironment', '$_concat_needs', '$_additionalcomments');";
    $insert_statement = $connection->query($statement);
    mysqli_close($connection);
    if($insert_statement) {
      $_SESSION['message_success'] = "Careplan has been successfully inserted.";
    } else {
      $_SESSION['message_error'] = "Careplan encountered an error inserting.";
      $error = mysqli_error($connection);
      write_to_log("[$your_date] $statement. Result $error");
    }
    if($redirect) {
      header("Location: " . $redirect);
      exit();
    } else {
      header("Location: ../clients.php");
      exit();
    }
  } else {

    // we will simply update it
    $statement = "update CarePlan set ClientID='$_client_id', DateCreated='$your_date', Impairments='$_checkifapplicableplan', PersonalCare='$_personalcare', Elimination='$_elimination', Treatments='$_treatments', Activity='$_acitivityplan', SafetyPrecautions='$_safetyprecautions', TypeOfServices='$_typeofservice', ClientEnvironment='$_clientenvironment', ImportantClientInformation='$_concat_needs', Notes='$_additionalcomments' where ClientID='$_client_id';";
    $update_statement = $connection->query($statement);
    mysqli_close($connection);
    if($update_statement) {
      $_SESSION['message_success'] = "Careplan has been updated.";
    } else {
      $_SESSION['message_error'] = "Careplan updating encountered an error.";
      $error = mysqli_error($connection);
      write_to_log("[$your_date] $statement. Result $error");
    }
    if($redirect) {
      header("Location: " . $redirect);
      exit();
    } else {
      header("Location: ../clients.php");
      exit();
    }

  }

  // function returns a string of true, false, true, false statements. Each separated by... a comma
  function read_checkbox_array($the_array) {
    if(!empty($the_array)) {
      $sort = array();
      foreach($the_array as $check) {
        array_push($sort, $check);
      }
      for($x = 0; $x < sizeof($sort); $x++) {
        if($x != (sizeof($sort) - 1)) {
          $sort[$x] .= "#";
        }
      }
      return implode($sort);
    }
    return "";
  }

 ?>
