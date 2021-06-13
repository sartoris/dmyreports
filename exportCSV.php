<?php
	session_start();
	require_once('includes/config.php');
	$txtReportName = isset($_SESSION['txtReportName']) && $_SESSION['txtReportName'] != "" ? $_SESSION['txtReportName'] : "dmyreports";

	if (isset($_SESSION["tmpSQL"])) {
		mysqli_select_db($connDB, $database_connDB);
		$recSQL = mysqli_query($connDB, $_SESSION["tmpSQL"]) or die(mysqli_error());

		$column_count = mysqli_num_fields($recSQL) or die("display_db_query:" . mysqli_error());
		$field_name = mysqli_fetch_field_direct($recSQL, 0);
		$data = $field_name->name;
		$types[] = $field_name->type;
		for($column_num = 1; $column_num < $column_count; $column_num++) {
			$data .= ",";
			$field_name = mysqli_fetch_field_direct($recSQL, $column_num);
			$data .= $field_name->name;
			$types[] = $field_name->type;
		}
		$data .= "\n";
		
		while ($row = mysqli_fetch_row($recSQL)) {
			for($column_num = 0; $column_num < $column_count; $column_num++) {
				if ($column_num > 0) {
					$data .= ",";
				}
				if($types[$column_num] > 16) {
					$data .= "\"".$row[$column_num]."\"";
				} else {
					$data .= $row[$column_num];
				}
			}
			$data .= "\n";
		}
		mysqli_free_result($recSQL);

		header('Content-Type: application/csv');
		header("content-disposition: attachment;filename=" . $txtReportName . ".csv");
		echo $data; exit();
	}
?>