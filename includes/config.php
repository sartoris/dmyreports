<?php
// Basic Parameters
$pageTitle = "Report Manager"; 

// Database To Be Queired
$hostname_connDB = "localhost"; 	// The host name of the MySql server
$database_connDB = "jayhar_hed"; 			// The name of the Database to be queired
$username_connDB = "jayhar_su";			// Username to login to the server
$password_connDB = "nPe^vk^^-{ge";			// Password to the MySQL server
$dbVisTables = "";			// The name of the tables to be displayed seperated by commas. 
					// Leave this blank if all the tables and views are to be displayed.
					// eg $dbVisTables = "table1,table2,table3";

//Databse To Save Reports
$hostname_connSave = "localhost"; 	// The host name of the MySql server where the generated reports are to be saved
$database_connSave = "dmyreports"; 	// The name of the Database to save the generated reports
$username_connSave = "jayhar_su";		// Username to login to the server
$password_connSave = "nPe^vk^^-{ge";		// Password to the MySQL server

//Do not edit after this point
$connDB = mysqli_connect($hostname_connDB, $username_connDB, $password_connDB) or trigger_error(mysqli_error(),E_USER_ERROR);
$connSave = mysqli_connect($hostname_connSave, $username_connSave, $password_connSave) or trigger_error(mysqli_error(),E_USER_ERROR);
?>