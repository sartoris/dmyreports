<?php
	require_once('includes/config.php');

	function dmyError() {
		print "Table Not Found.";
	}

	mysqli_select_db($connDB, $database_connDB);
	$query_recGetFields = "SHOW columns FROM " . $_POST["tableName"];
	$recGetFields = mysqli_query($connDB, $query_recGetFields) or die(dmyError());
	$row_recGetFields = mysqli_fetch_array($recGetFields);
	$totalRows_recGetFields = mysqli_num_rows($recGetFields);
?>
<select name="lstAllFields" size="10" multiple id="lstAllFields" style="width:100%">
	<?php 
		do {
	?>
	<option value="<?php echo ($_POST["tableName"] . "." . $row_recGetFields[0]) ?>"><?php echo $row_recGetFields[0]?></option>
	<?php
		} while ($row_recGetFields = mysqli_fetch_array($recGetFields));
		$rows = mysqli_num_rows($recGetFields);
		if($rows > 0) {
			mysqli_data_seek($recGetFields, 0);
			$row_recGetFields = mysqli_fetch_array($recGetFields);
		}
	?>
</select>
<input name="cmdSelectFields" type="button" id="cmdSelectFields" value="Add Field" class="button" style="width:100%" onclick="cmdSelectFields_onclick();">
<?php
	mysqli_free_result($recGetFields);
?>

