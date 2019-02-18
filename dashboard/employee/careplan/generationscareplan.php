<!-- Admin Dashboard -->
<?php
	include('../../../services/login_script.php');
	include("../../utils/table_calls.php");
	if (!(isset($_SESSION['logon']))) {
		header('Location: ../../../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
	} else if($_SESSION['type'] == "employee") {
		header('Location: ../../../index.php?error=' . urlencode(base64_encode("Insufficient Administrator Privileges.")));
	}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Generations Care Plan</title>
    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <!-- Notifications -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ty    pe="text/javascript"></script>
  	<link href="../../../css/toastr.css" rel="stylesheet"/>
  	<script src="../../../js/toastr.js"></script>

    <script>

      <?php
        include('../../../services/server_connection.inc');
        $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
        $membername = "";
        $dob = "";
        $address = "";
        $clientphone = "";
        $clientemergencycontactone = "";
        $clientemergencyphoneone = "";
        $clientemergencycontacttwo = "";
        $clientemergencyphonetwo = "";
        $allergies = "";
        $status = "";
				$datecreated = "";
				$impairments = "";
				$personalcare = "";
				$elimination = "";
				$treatments = "";
				$activity = "";
				$safetyprecautions = "";
				$typeofservices = "";
				$clientenvironment = "";
				$importantsclientinformation = "";
				$notes = "";

        if(isset($_GET['evaluate']) || isset($_GET['careplan'])) {
          $id = "";
          if(isset($_GET['evaluate'])) {
            $id = $_GET['evaluate'];
          } else {
            $id = $_GET['careplan'];
          }
          $statement = "select * from Clients where ID='$id';";
          $result = $connection->query($statement);

          if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $membername = $row['Name'];
            $address = $row['Address'];
            $dob = $row['DOB'];
            $clientphone = $row['ClientsNumber'];
            $clientemergencycontactone = $row['EmergencyContact1'];
            $clientemergencyphoneone = $row['EmergencyNumber1'];
            $clientemergencycontactwo = $row['EmergencyContact2'];
            $clientemergencyphonetwo = $row['EmergencyNumber2'];
            $allergies = $row['Allergies'];
          }

					if(isset($_GET['careplan'])) {
						// grab all related info to being previously stored
						// connection is still Active
						$id = $_GET['careplan'];
						$search_statement = "select * from CarePlan where ClientID='$id';";
						$result = $connection->query($search_statement);
						// now to grab data from it
						if($result->num_rows == 1) {
							$row = $result->fetch_assoc();
							$datecreated = $row['DateCreated'];
							$datecreated = date("m/d/Y", strtotime($datecreated));
							$impairments = $row['Impairments'];
							$personalcare = $row['PersonalCare'];
							$elimination = $row['Elimination'];
							$treatments = $row['Treatments'];
							$activity = $row['Activity'];
							$safetyprecautions = $row['SafetyPrecautions'];
							$typeofservices = $row['TypeOfServices'];
							$clientenvironment = $row['ClientEnvironment'];
							$importantclientinformation = $row['ImportantClientInformation'];
							$notes = $row['Notes'];
						}
					}
        }

        mysqli_close($connection);
        ?>
				// Required if PHP -> Javascript is desired
        window.onload = function(){
          document.getElementById('membername').value='<?php echo "$membername"; ?>';
          var dob = "<?php echo "$dob"; ?>";
          document.getElementById('dobyear').value = dob.substring(0, 4);
          document.getElementById('dobmonth').value = dob.substring(5, 7);
          document.getElementById('dobday').value = dob.substring(8,10);
          document.getElementById('address').value='<?php echo "$address"; ?>';
          document.getElementById('clientsphonenumber').value = '<?php echo "$clientphone"; ?>';
          document.getElementById('phonecontact1').value = '<?php echo "$clientemergencyphoneone"; ?>';
          document.getElementById('emergencycontact1').value = '<?php echo "$clientemergencycontactone"; ?>';
          document.getElementById('emergencycontact2').value = '<?php echo "$clientemergencycontactwo"; ?>';
          document.getElementById('phonecontact2').value = '<?php echo "$clientemergencyphonetwo"; ?>';
          document.getElementById('allergies').value = '<?php echo "$allergies"; ?>';
					document.getElementById('todaysdate').value = '<?php echo "$datecreated"; ?>';
					<?php
						if(isset($_GET['evaluate'])){
							// auto fill todays date, may be changed if desired
							echo "var today = new Date();
										var dd = today.getDate();
										var mm = today.getMonth()+1; //January is 0!

										var yyyy = today.getFullYear();
										if(dd<10){
												dd='0'+dd;
										}
										if(mm<10){
												mm='0'+mm;
										}
										var today = mm+'/'+dd+'/'+yyyy;
										document.getElementById('todaysdate').value = today;";
						}
						// use js.split for client rather than php
						echo "var activityplan = '$activity';
									var myactivityplan = activityplan.split('#');
									var activityplanchk = document.getElementsByName('activityplan[]');
									for(i = 0; i < activityplanchk.length; i++) {
										for(j = 0; j < myactivityplan.length; j++) {
											// check if theres a dash, will need to split due to note Devices
											var spl = myactivityplan[j].split('-');
											spl[0] = spl[0].slice(0, -1);
											var tmp = activityplanchk[i].value;
											if((tmp == spl[0]) && myactivityplan[j].includes('-')) {
												activityplanchk[i].checked = 'true';
												document.getElementById('notedevices').value = spl[1].substr(1);
											}
											if(activityplanchk[i].value == myactivityplan[j]) {
												activityplanchk[i].checked = 'true';
											}
										}
									}";

						echo "var safety = '$safetyprecautions';
									var mysafety = safety.split('#');
									var safetychk = document.getElementsByName('safetyprecautions[]');
									for(i = 0; i < safetychk.length; i++) {
										for(j = 0; j < mysafety.length; j++) {
											if(safetychk[i].value == mysafety[j]) {
												safetychk[i].checked = 'true';
											}
										}
									}";

						echo "var impairments = '$impairments';
									var myimpairments = impairments.split('#');
									var impairmentschk = document.getElementsByName('checkifapplicableplan[]');
									for(i = 0; i < impairmentschk.length; i++) {
										for(j = 0; j < myimpairments.length; j++) {
											if(impairmentschk[i].value == myimpairments[j]) {
												impairmentschk[i].checked = 'true';
											}
										}
									}";

						echo "var personalcare = '$personalcare';
									var mypersonalcare = personalcare.split('#');
									var personalcarechk = document.getElementsByName('personalcare[]');
									for(i = 0; i < personalcarechk.length; i++) {
										for(j = 0; j < mypersonalcare.length; j++) {
											if(personalcarechk[i].value == mypersonalcare[j]) {
												personalcarechk[i].checked = 'true';
											}
										}
									}";

						echo "var typeofservice = '$typeofservices';
									var mytypeofservice = typeofservice.split('#');
									var typeofservicechk = document.getElementsByName('typeofservice[]');
									for(i = 0; i < typeofservicechk.length; i++) {
										for(j = 0; j < mytypeofservice.length; j++) {
											if(typeofservicechk[i].value == mytypeofservice[j]) {
												typeofservicechk[i].checked = 'true';
											}
										}
									}";

							echo "var clientenvironment = '$clientenvironment';
										var myclientenvironment = clientenvironment.split('#');
										var clientenvironmentchk = document.getElementsByName('clientenvironment[]');
										for(i = 0; i < clientenvironmentchk.length; i++) {
											for(j = 0; j < myclientenvironment.length; j++) {
												// check if theres a dash, will need to split due to note Devices
												var spl = myclientenvironment[j].split('-');
												spl[0] = spl[0].slice(0, -1);
												var tmp = clientenvironmentchk[i].value;
												if((tmp == spl[0]) && myclientenvironment[j].includes('-')) {
													clientenvironmentchk[i].checked = 'true';
													document.getElementById('livewithfamily').value = spl[1].substr(1);
												}
												if(clientenvironmentchk[i].value == myclientenvironment[j]) {
													clientenvironmentchk[i].checked = 'true';
												}
											}
										}";

						echo "loadCheckboxNormal('$elimination', 'elimination[]');";

						echo "loadCheckboxNormal('$treatments', 'treatments[]');";

						echo "var important = '$importantclientinformation';
									var importantarray = important.split('#');
									if(importantarray[1] != null && importantarray[0] != 'undefined') {
										document.getElementById('suppliesneeded').value = importantarray[0];
									}
									if(importantarray[1] != null && importantarray[1] != 'undefined') {
										document.getElementById('specialrequest').value = importantarray[1];
									}
									if(importantarray[1] != null && importantarray[2] != 'undefined') {
										document.getElementById('clientspecifiedcare').value = importantarray[2];
									}
									document.getElementById('additionalcomments').value = '$notes';";

					 ?>

        }

				function loadCheckboxNormal(theString, element) {
					var a = theString.split('#');
					var chk = document.getElementsByName(element);
					for(i = 0; i < chk.length; i++) {
						for(j = 0; j < a.length; j++) {
							if(chk[i].value == a[j]) {
								chk[i].checked = 'true';
							}
						}
					}
				}

				function loadCheckboxExtra(theString, element, input) {
					var a = theString.split('#');
					var chk = document.getElementsByName(element);
					for(i = 0; i < chk.length; i++) {
						for(j = 0; j < a.length; j++) {
							// check if theres a dash, will need to split due to note Devices
							var spl = a[j].split('-');
							spl[0] = spl[0].slice(0, -1);
							var tmp = chk[i].value;
							if((tmp == spl[0]) && a[j].includes('-')) {
								chk[i].checked = 'true';
								document.getElementById(input).value = spl[1];
							}
							if(chk[i].value == a[j]) {
								chk[i].checked = 'true';
							}
						}
					}
				}

    </script>
		<script type="text/javascript">
			function validateInput() {
				// validate
				var noerrors = true;

				var clientnumber = document.getElementById('clientsphonenumber');
				if(!clientnumber.value.match(/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/)) {
					clientnumber.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error('Clients phone number has an invalid format/character.', 'Error!');
						});
						noerrors = false;
				} else {
					clientnumber.style.border = "0";
					clientnumber.style.borderBottom = "1px solid black";
				}

				var dobday = document.getElementById('dobday');
				if(!dobday.value.match(/^[0-9]{2}$/)) {
					dobday.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error('Invalid Day.', 'Error!');
						});
						noerrors = false;
				} else {
					dobday.style.border = "0";
					dobday.style.borderBottom = "1px solid black";
				}

				var dobmonth = document.getElementById('dobmonth');
				if(!dobmonth.value.match(/^[0-9]{2}$/)) {
					dobmonth.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error('Invalid Month.', 'Error!');
						});
						noerrors = false;
				} else {
					dobmonth.style.border = "0";
					dobmonth.style.borderBottom = "1px solid black";
				}

				var dobyear = document.getElementById('dobyear');
				if(!dobyear.value.match(/^[0-9]{4}$/)) {
					dobyear.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error('Invalid Year.', 'Error!');
						});
						noerrors = false;
				} else {
					dobyear.style.border = "0";
					dobyear.style.borderBottom = "1px solid black";
				}

				var member = document.getElementById('membername');
				if(!member.value.match(/^[A-Za-z- ]+$/)) {
					member.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Members name contains numbers or unrecognized characters.', 'Error!');
					});
					noerrors = false;
				} else {
					member.style.border = "0";
					member.style.borderBottom = "1px solid black";
				}

				var emergencycontact1name = document.getElementById('emergencycontact1');
				if(!emergencycontact1name.value == '' && !emergencycontact1name.value.match(/^[A-Za-z- ]+$/)) {
					emergencycontact1name.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Emergency contact name contains numbers or unrecognized characters.', 'Error!');
					});
					noerrors = false;
				} else {
					emergencycontact1name.style.border = "0";
					emergencycontact1name.style.borderBottom = "1px solid black";
				}

				var phonecontact1number = document.getElementById('phonecontact1');
				if(!phonecontact1number.value == '' && !phonecontact1number.value.match(/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/)) {
					phonecontact1number.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error('Emergency contact phone number has an invalid format/character.', 'Error!');
						});
						noerrors = false;
				} else {
					phonecontact1number.style.border = "0";
					phonecontact1number.style.borderBottom = "1px solid black";
				}

				var emergencycontact2name = document.getElementById('emergencycontact2');
				if(!emergencycontact2name.value == '' && !emergencycontact2name.value.match(/^[A-Za-z- ]+$/)) {
					emergencycontact2name.style.border = "2px solid #fc677d";
					$( document ).ready(function() {
						toastr.error('Emergency contact name contains numbers or unrecognized characters.', 'Error!');
					});
					noerrors = false;
				} else {
					emergencycontact2name.style.border = "0";
					emergencycontact2name.style.borderBottom = "1px solid black";
				}

				var phonecontact2number = document.getElementById('phonecontact2');
				if(!phonecontact2number.value == '' && !phonecontact2number.value.match(/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/)) {
					phonecontact2number.style.border = "2px solid #fc677d";
						$( document ).ready(function() {
							toastr.error('Emergency contact phone number has an invalid format/character.', 'Error!');
						});
						noerrors = false;
				} else {
					phonecontact2number.style.border = "0";
					phonecontact2number.style.borderBottom = "1px solid black";
				}

				var activityboxes = document.getElementsByName('activityplan[]');
		    var len = activityboxes.length;
		    for (var i=0; i<len; i++) {
		        if(activityboxes[i].checked) {
							if(activityboxes[i].value == "Assist with Medical Devices") {
								var devices = document.getElementById('notedevices');
								if(devices.value != "") {
									devices.style.border = "0";
									devices.style.borderBottom = "1px solid black";
									// append devices onto this, later we will parse it back into proper format.
									activityboxes[i].value = "" + activityboxes[i].value + " - " + devices.value;
								} else {
									devices.style.border = "2px solid #fc677d";
									$( document ).ready(function() {
										toastr.error('Assist with Medical devices was checked but no devices were listed.', 'Error!');
									});
									noerrors = false;
								}
							}
						}
			    }

					var clientboxes = document.getElementsByName('clientenvironment[]');
			    var len = clientboxes.length;
			    for (var i=0; i<len; i++) {
			        if(clientboxes[i].checked) {
								if(clientboxes[i].value == "Live with Family") {
									var client = document.getElementById('livewithfamily');
									if(client.value != "") {
										client.style.border = "0";
										client.style.borderBottom = "1px solid black";
										// append devices onto this, later we will parse it back into proper format.
										clientboxes[i].value = "" + clientboxes[i].value + " - " + client.value;
									} else {
										client.style.border = "2px solid #fc677d";
										$( document ).ready(function() {
											toastr.error('Live with Family was checked but no family were listed.', 'Error!');
										});
										noerrors = false;
									}
								}
							}
				    }

				return noerrors;
			}
		</script>
    <style>
      body {
        font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
				width: 75%;
      }
      table {
        border: 0;
				border-collapse: separate;
  			border-spacing: 10px;
      }
      td {
        text-align: left;
        padding-left: 25px;
        padding-right: 25px;
        font-size: 14px;
				border: 0;
      }
			.form-control {
				font-weight: bold;
				font-size: 14px;
			}
			#titletable {
				width: 100%;
			}
      #customblueheader {
        background-color: #c7dbf9;
        color: #4f7dc1;
        font-weight: bold;
        border-top: 1px solid black;
        font-size: 14px;
      }
      #infoblockleft {
        width: 45%;
        float: left;
        margin-left: 15%;
      }
      #infoblockright {
        width: 45%;
        float: right;
        margin-right: 15%;
      }
			@media screen and (max-width: 1020px) {
			  .form-control {
					font-size: 10px;
					width: 100%;
				}
				#titletable {
					width: 100%;
				}
				body {
					width: 100%;
				}
			}
    </style>
  </head>

  <body>
		<div class="content-wrapper">
	    <div class="container-fluid">
		    <form name="generationsform" action="careplan_handler.php" method="post" onsubmit="return validateInput();">
		      <?php
		        echo '<input type="hidden" name="redirect" id="redirect" value="';
		          if(isset($_GET['redirect'])) {
		            echo htmlspecialchars($_GET['redirect']);
		          }
		        echo '" />';
		        echo '<input type="hidden" name="client_id" id="client_id" value="';
		          if(isset($_GET['careplan'])) {
		            echo htmlspecialchars($_GET['careplan']);
		          } else
		            if(isset($_GET['evaluate'])) {
		              echo htmlspecialchars($_GET['evaluate']);
		            }
		        echo '" />';
		       ?>
		      <!-- Header -->
						<div class="card-body">
				        <img src="../../../img/generations.png" alt="Generations Home Care Logo" width="300" height="100">
				        <p style="font-size: 20px; font-weight: bold;">Care Plan</p>
							<div class="table-responsive">
				        <table class="table" id="titletable">
									<tr>
				          	<td>
											<label for="membersname">Members Name</label>
										</td>
										<td>
											<label for="dob">DOB</label>
										</td>
									</tr>
									<tr>
										<td>
											<input class="form-control no-border" id="membername" name="membername" placeholder="Name" type="text"/>
										</td>
										<td>
											<input class="form-control no-border" id="dobmonth" size="2" maxlength="2" placeholder="MM" type="text"/>
										</td>
										<td>
											<input class="form-control no-border" id="dobday" size="2" maxlength="2" placeholder="DD" type="text"/>
										</td>
										<td>
											<input class="form-control no-border" id="dobyear" size="4" maxlength="4" placeholder="YYYY" type="text"/>
										</td>
									</tr>
								</table>
							</div>
			          <div class="table-responsive">
			            <table class="table borderless" id="dataTable" width="100%" cellspacing="0">
					          <tbody><tr>
					            <td>
					              <label for="address" style="font-weight: bold;">Address</label>
					              <input class="form-control no-border" id="address" name="address" placeholder="Client Address" type="text">
					            </td>
					            <td id="customblueheader">
					              ACTIVITY
					            </td>
					          </tr>
					          <tr>
					            <td>
					               <label for="clientsphone">Clients Phone #</label>
					               <input class="form-control no-border" name="clientsphonenumber" id="clientsphonenumber" placeholder="Phone Number" type="text">
					            </td>
					            <td>
					              <input class="form-check-input" value="Walk with Assistance" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Walk with Assistance</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <label for="emergencycontact1">Emergency Contact #1</label>
					              <input class="form-control no-border" name="emergencycontact1" id="emergencycontact1" placeholder="Name" type="text">
					            </td>
					            <td>
					              <input class="form-check-input" value="Guard While Walking" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Guard While Walking</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <label for="phonecontact1">Phone #</label>
					              <input class="form-control no-border" name="phonecontact1" id="phonecontact1" placeholder="Number" type="text">
					            </td>
					            <td>
					              <input class="form-check-input" value="Walker/ Crutches /Cane (circle)" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Walker/ Crutches /Cane (circle)</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <label for="emergencycontact2">Emergency Contact #2</label>
					              <input class="form-control no-border" name="emergencycontact2" id="emergencycontact2" placeholder="Name" type="text">
					            </td>
					            <td>
					              <input class="form-check-input" value="Assist with Transfer" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Assist with Transfer</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <label for="phonecontact2">Phone #</label>
					              <input class="form-control no-border" name="phonecontact2" id="phonecontact2" placeholder="Number" type="text">
					            </td>
					            <td>
					              <input class="form-check-input" value="Wheelchair (use with precaution)" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Wheelchair (use with precaution)</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <label for="allergies">Allergies</label>
					              <input class="form-control no-border" name="allergies" id="allergies" placeholder="List off allergies" type="text">
					            </td>
					            <td>
					              <input class="form-check-input" value="Transfer with Hoyer" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Transfer with Hoyer</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <label for="todaysdate">Today's Date</label>
					              <input class="form-control no-border" name="todaysdate" id="todaysdate" placeholder="Date" type="text">
					            </td>
					            <td>
					              <input class="form-check-input" value="Bed Test/Turn every 2hrs" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Bed Rest/ Turn every 2hrs</label>
					            </td>
					          </tr>
					          <tr>
					            <td id="customblueheader">
					              CHECK IF APPLICABLE
					            </td>
					            <td>
					              <input class="form-check-input" value="Active - Range of Motion" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Active - Range of Motion</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Cognitive Loss" name="checkifapplicableplan[]" id="checkifapplicableplan[]" type="checkbox">
					              <label for="check-if"> Cognitive Loss</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Passive - Range of Motion" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Passive - Range of Motion</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Hearing Impaired" name="checkifapplicableplan[]" id="checkifapplicableplan[]" type="checkbox">
					              <label for="check-if"> Hearing Impaired</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Assist with Medical Devices" name="activityplan[]" id="activityplan[]" type="checkbox">
					              <label for="activity-walk"> Assist with Medical Devices</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Poor Vision" name="checkifapplicableplan[]" id="checkifapplicableplan[]" type="checkbox">
					              <label for="check-if"> Poor Vision</label>
					            </td>
					            <td>
					              <label for="activity-walk"> Note Devices</label>
					              <input class="form-control no-border" name="notedevices" id="notedevices" placeholder="Devices" type="text">
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Emotional Support" name="checkifapplicableplan[]" id="checkifapplicableplan[]" type="checkbox">
					              <label for="check-if"> Emotional Support</label>
					            </td>
					            <td id="customblueheader">
					              SAFETY PRECAUTIONS
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="DNR" name="checkifapplicableplan[]" id="checkifapplicableplan[]" type="checkbox">
					              <label for="check-if"> DNR</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Standard/Fall Precautions" name="safetyprecautions[]" id="safetyprecautions[]" type="checkbox">
					              <label for="safety-precautions"> Standard/Fall Precautions</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Total Assist" name="checkifapplicableplan[]" id="checkifapplicableplan[]" type="checkbox">
					              <label for="check-if"> Total Assist</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Fall Risk" name="safetyprecautions[]" id="safetyprecautions[]" type="checkbox">
					              <label for="safety-precautions"> Fall Risk</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Hospice" name="checkifapplicableplan[]" id="checkifapplicableplan[]" type="checkbox">
					              <label for="check-if"> Hospice</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Bleeding Precautions" name="safetyprecautions[]" id="safetyprecautions[]" type="checkbox">
					              <label for="safety-precautions"> Bleeding Precautions</label>
					            </td>
					          </tr>
					          <tr>
					            <td id="customblueheader">
					              PERSONAL CARE
					            </td>
					            <td>
					              <input class="form-check-input" value="Oxygen Precautions" name="safetyprecautions[]" id="safetyprecautions[]" type="checkbox">
					              <label for="safety-precautions"> Oxygen Precautions</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Tub Bath" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Tub Bath</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Seizures Precautions" name="safetyprecautions[]" id="safetyprecautions[]" type="checkbox">
					              <label for="safety-precautions"> Seizures Precautions</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Shower/ Assist with Shower" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Shower/ Assist with Shower</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Heart Attack Precautions" name="safetyprecautions[]" id="safetyprecautions[]" type="checkbox">
					              <label for="safety-precautions"> Heart Attack Precautions</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Sponge Bath" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Sponge Bath</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Stroke Precautions" name="safetyprecautions[]" id="safetyprecautions[]" type="checkbox">
					              <label for="safety-precautions"> Stroke Precautions</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Bed Bath" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Bed Bath</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Oversight and Supervision" name="safetyprecautions[]" id="safetyprecautions[]" type="checkbox">
					              <label for="safety-precautions"> Oversight and Supervision</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Oral/ Denture Care" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Oral/ Denture Care</label>
					            </td>
					            <td id="customblueheader">
					              TYPE OF SERVICE
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Foot Care" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Foot Care</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="24/7 HR Care" name="typeofservice[]" id="typeofservice[]" type="checkbox">
					              <label for="safety-precautions"> 24/7 HR Care</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Shampoo" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Shampoo</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Overnight Care" name="typeofservice[]" id="typeofservice[]" type="checkbox">
					              <label for="safety-precautions"> Overnight Care</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Shave/Skin Care" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Shave/Skin Care</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Hourly Care" name="typeofservice[]" id="typeofservice[]" type="checkbox">
					              <label for="safety-precautions"> Hourly Care</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Dress/Assist with Dress" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Dress/Assist with Dress</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Transportation" name="typeofservice[]" id="typeofservice[]" type="checkbox">
					              <label for="safety-precautions"> Transportation</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Assist with Cleaning" name="personalcare[]" id="personalcare[]" type="checkbox">
					              <label for="safety-precautions"> Assist with Cleaning</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Weekend Care" name="typeofservice[]" id="typeofservice[]" type="checkbox">
					              <label for="safety-precautions"> Weekend Care</label>
					            </td>
					          </tr>
					          <tr>
					            <td id="customblueheader">
					              ELIMINATION
					            </td>
					            <td id="customblueheader">
					              CLIENT ENVIRONMENT
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Assist to Bathroom" name="elimination[]" id="elimination[]" type="checkbox">
					              <label for="safety-precautions"> Assist to Bathroom</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Live Alone" name="clientenvironment[]" id="clientenvironment[]" type="checkbox">
					              <label for="safety-precautions"> Live Alone</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Incontinent Care" name="elimination[]" id="elimination[]" type="checkbox">
					              <label for="safety-precautions"> Incontinent Care</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Live with Family" name="clientenvironment[]" id="clientenvironment[]" type="checkbox">
					              <label for="safety-precautions"> Live with Family</label>
					              <input class="form-control no-border" name="livewithfamily" id="livewithfamily" placeholder="Family" type="text">
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Commode" name="elimination[]" id="elimination[]" type="checkbox">
					              <label for="safety-precautions"> Commode</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Live in Community" name="clientenvironment[]" id="clientenvironment[]" type="checkbox">
					              <label for="safety-precautions"> Live in Community</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Bed Pan/ Urinal" name="elimination[]" id="elimination[]" type="checkbox">
					              <label for="safety-precautions"> Bed Pan/ Urinal</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Light Housekeeping (Kitchen, Bathroom, Sweep/Vaccum, Linen Change)" name="clientenvironment[]" id="clientenvironment[]" type="checkbox">
					              <label for="safety-precautions"> Light Housekeeping (Kitchen, Bathroom, Sweep/Vaccum, Linen Change)</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Catheter Care" name="elimination[]" id="elimination[]" type="checkbox">
					              <label for="safety-precautions"> Catheter Care</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Laundry" name="clientenvironment[]" id="clientenvironment[]" type="checkbox">
					              <label for="safety-precautions"> Laundry</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Ostomy Care" name="elimination[]" id="elimination[]" type="checkbox">
					              <label for="safety-precautions"> Ostomy Care</label>
					            </td>
					            <td>
					              <input class="form-check-input" value="Grocery Shopping" name="clientenvironment[]" id="clientenvironment[]" type="checkbox">
					              <label for="safety-precautions"> Grocery Shopping</label>
					            </td>
					          </tr>
					          <tr>
					            <td id="customblueheader">
					              TREATMENTS
					            </td>
					            <td>
					              <input class="form-check-input" value="Accompany To MD Appt." name="clientenvironment[]" id="clientenvironment[]" type="checkbox">
					              <label for="safety-precautions"> Accompany To MD Appt.</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Oral Temperature" name="treatments[]" id="treatments[]" type="checkbox">
					              <label for="safety-precautions"> Oral Temperature</label>
					            </td>
					            <td id="customblueheader">
					              IMPORTANT CLIENT INFORMATION
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Pulse" name="treatments[]" id="treatments[]" type="checkbox">
					              <label for="safety-precautions"> Pulse</label>
					            </td>
					            <td>
					              <ul><li>Supplies that May be Needed</li></ul>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Respiration" name="treatments[]" id="treatments[]" type="checkbox">
					              <label for="safety-precautions"> Respiration</label>
					            </td>
					            <td>
					              <input style="width: 100%;" class="form-control no-border" name="suppliesneeded" id="suppliesneeded" placeholder="Needed Supplies" type="text">
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Blood Pressure" name="treatments[]" id="treatments[]" type="checkbox">
					              <label for="safety-precautions"> Blood Pressure</label>
					            </td>
					            <td>
					              <ul><li>Special Request</li></ul>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Blood sugar" name="treatments[]" id="treatments[]" type="checkbox">
					              <label for="safety-precautions"> Blood sugar</label>
					            </td>
					            <td>
					              <input style="width: 100%;" class="form-control no-border" name="specialrequest" id="specialrequest" placeholder="Request" type="text">
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Weight" name="treatments[]" id="treatments[]" type="checkbox">
					              <label for="safety-precautions"> Weight</label>
					            </td>
					            <td>
					              <ul><li>Client Specified Care</li></ul>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Medications" name="treatments[]" id="treatments[]" type="checkbox">
					              <label for="safety-precautions"> Medications</label>
					            </td>
					            <td>
					              <input style="width: 100%;" class="form-control no-border" name="clientspecifiedcare" id="clientspecifiedcare" placeholder="Specified Care" type="text">
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <input class="form-check-input" value="Dementia Care" name="treatments[]" id="treatments[]" type="checkbox">
					              <label for="safety-precautions"> Dementia Care</label>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              Additional Comments
					            </td>
					            <td>
					              <textarea style="width: 100%; " class="form-control" cols="20" rows="5" name="additionalcomments" id="additionalcomments"></textarea>
					            </td>
					          </tr>
					          <tr>
					            <td>
					              <button type="submit" class="button">Submit</button>
					              <button class="button" onclick="<?php  if(isset($_GET['redirect'])) {
					 		            echo "location.href='" . htmlspecialchars($_GET['redirect']) . "'";
					 		          }?>">Close</button>
					            </td>
					          </tr>
					        </tbody>
							</table>
						</div>
					</div>
		    </div>
		   </form>
		 </div>
		 <!-- End of Logout Modal -->
     <!-- Bootstrap core JavaScript-->
     <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
     <!-- Core plugin JavaScript-->
     <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
     <!-- Page level plugin JavaScript-->
     <script src="vendor/chart.js/Chart.min.js"></script>
     <script src="vendor/datatables/jquery.dataTables.js"></script>
     <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
     <!-- Custom scripts for all pages-->
     <script src="js/sb-admin.min.js"></script>
     <!-- Custom scripts for this page-->
     <script src="js/sb-admin-datatables.min.js"></script>
     <script src="js/sb-admin-charts.min.js"></script>
	 </div>
  </body>
</html>
