<?php
// Basic Parameters
$pageTitle = "Report Manager"; 
$contact = "Support<br/>support@mydomain.com";
$loginLogo = "images/logo.png";
$icon = "images/icon.png";
$dmyReportsFolder = "";
$loginPage = "/login.php";

// Database To Be Queried
$hostname_connDB = "localhost"; 	// The host name of the MySql server
$database_connDB = "jayhar_hed"; 			// The name of the Database to be queired
$username_connDB = "jayhar_su";			// Username to login to the server
$password_connDB = "nPe^vk^^-{ge";			// Password to the MySQL server

// The name of the tables/views to be displayed seperated by commas. 
// eg $dbVisTables = "table1,table2,table3";
// Leave this blank if all the tables and views are to be displayed.
$dbVisTables = "";

//Database To Save Reports
$hostname_connReports = "localhost"; 	// The host name of the MySql server where the generated reports are to be saved
$database_connReports = "dmyreports"; 	// The name of the Database to save the generated reports
$username_connReports = "jayhar_su";		// Username to login to the server
$password_connReports = "nPe^vk^^-{ge";		// Password to the MySQL server

//Do not edit after this point
$connDB = mysqli_connect($hostname_connDB, $username_connDB, $password_connDB) or trigger_error(mysqli_error(),E_USER_ERROR);
$connReports = mysqli_connect($hostname_connReports, $username_connReports, $password_connReports) or trigger_error(mysqli_error(),E_USER_ERROR);
?>