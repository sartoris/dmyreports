<?php
	session_start();
	if ($_POST["inputValue"]=="field"){
?>
		<select name="lstFieldNames" id="inputValue">
		<?php
			$tmpFields = explode("~",$_SESSION['selectedFields']);
			for ($x=0; $x<=count($tmpFields)-1; $x+=1) {
				if ($tmpFields[$x]!=""){
		?>
				<option value="<?php echo $tmpFields[$x];?>"><?php echo $tmpFields[$x];?></option>
		<?php
				}
			}
		?>
		</select>
<?php
	}
	if ($_POST["inputValue"]=="input"){
?>
		<input name="inputValue" type="text" id="inputValue" size="10" />
<?php
	}
?>

