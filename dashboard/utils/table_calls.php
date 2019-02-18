<?php
 include('../../services/server_connection.inc');
 $selectedid = "";
 /*
 * Calls for Job creation
 */
 // returns id and name. Id is the value, name is the option displayed
function grab_client_names() {
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
  $statement = "select ID, Name from Clients;";
  $result = $connection->query($statement);
  mysqli_close($connection);
  return $result;
}
function grab_employee_names() {
  $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
  $statement = "select ID, Name from Employees;";
  $result = $connection->query($statement);
  mysqli_close($connection);
  return $result;
}
 //----------------------------------
 function grab_all_timesheets() {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select Timesheet.ID as 'Timesheet', Employees.ID, Employees.Name, Timesheet.WeekEnding as 'Week Ending', Timesheet.TotalHours as 'Total Hours Recorded', EmployeeInvoices.Payment, EmployeeInvoices.Paid as 'Payment Status' from Timesheet, Employees, EmployeeInvoices where (Timesheet.EmployeeID = Employees.ID) AND (EmployeeInvoices.EmployeesID=Employees.ID) AND  (EmployeeInvoices.EmployeesID=Timesheet.EmployeeID) AND Paid='Not Paid';";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }
 function grab_clients($id) {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select * from Clients where ID='$id';";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function grab_clients_restricted() {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select ID, Name as 'Client Name', ClientsNumber as 'Phone Number' from Clients where Status='Active';";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function grab_employees($id) {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select * from Employees where ID='$id';";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function grab_employees_restricted() {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select ID, Position, Name as 'Employee Name', PhoneNumber as 'Phone Number' from Employees where Status='Active';";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function grab_employee_linked_jobs($id) {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select Jobs.ID as 'JobID', Jobs.StartOfWeek, Jobs.EndOfWeek, Employees.Name as 'Employee', Clients.Name as 'Client' from Clients, Employees, Jobs where (Jobs.AssignedEmployeeID=Employees.ID) AND (Jobs.ClientID=Clients.ID) AND (Employees.ID='$id');";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function grab_employees_and_usernames() {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select Employees.Name, Credentials.UserName, Credentials.Password, Employees.Status as 'Current Employment' from Credentials, Employees where (Credentials.EmployeeID = Employees.ID);";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function check_client_plan($id) {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select * from CarePlan where ClientID='$id'";
   $result = $connection->query($statement);
   mysqli_close($connection);
   if($result->num_rows > 0) {
     return true;
   } else {
     return false;
   }
 }

 function grab_jobs() {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   date_default_timezone_set('America/New_York');
   // lets cover a 2 week period
   $monday = date('Y-m-d', strtotime("monday this week"));
   $sunday =  date('Y-m-d', strtotime("sunday next week"));
   $statement = "select Jobs.ID as 'Job ID', Clients.Name as 'Client', Employees.Name as 'Caretaker' from Jobs, Employees, Clients where (Jobs.ClientID = Clients.ID) and (Jobs.AssignedEmployeeID = Employees.ID) and CURDATE() between Jobs.MondayDate and Jobs.SundayDate;";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function grab_jobs_specified_employee($myid) {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select Jobs.ID as 'Job ID', Clients.Name as 'Client', Employees.Name as 'Caretaker' from Jobs, Employees, Clients where (Jobs.ClientID = Clients.ID) and (Jobs.AssignedEmployeeID = Employees.ID) and Employees.ID='$myid' and CURDATE() between Jobs.MondayDate and Jobs.SundayDate;";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function grab_careplan_given_job($id) {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select CarePlan.ClientID from CarePlan, Jobs where (Jobs.ID='$id') AND (Jobs.ClientID=CarePlan.ClientID);";
   $result = $connection->query($statement);
   $new_id = -1;
   if($result->num_rows == 1) {
     $row = $row=mysqli_fetch_assoc($result);
     $new_id = $row['ClientID'];
   }
   mysqli_close($connection);
   return $new_id;
 }

 function grab_careplan($careplanid) {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $id = mysqli_real_escape_string($careplanid);
   $statement = "select * from CarePlan where ClientID='$careplanid';";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }

 function grab_client_invoices() {
   $connection = connect_to_db(DB_SERVER, DB_UN, DB_PWD, DB_NAME);
   $statement = "select ClientInvoices.ID as 'ID', Clients.Name as 'Client Name', ClientInvoices.InvoiceAmount as 'Invoice Amount', ClientInvoices.Notes as 'Notes', ClientInvoices.Paid as 'Payment Status'  from ClientInvoices, Clients where (ClientInvoices.ClientID=Clients.ID) AND Paid='Not Paid';";
   $result = $connection->query($statement);
   mysqli_close($connection);
   return $result;
 }
 ?>
