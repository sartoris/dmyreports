<?php require_once('includes/config.php'); ?>
<?php
//Code to Delete Reports
$colname_recDel = $_GET['id'];

mysqli_select_db($connSave, $database_connSave);
$query_recDel = sprintf("SELECT status FROM tblreports WHERE id = %s", $colname_recDel);
$recDel = mysqli_query($connSave, $query_recDel) or die(mysqli_error());
$row_recDel = mysqli_fetch_assoc($recDel);
$totalRows_recDel = mysqli_num_rows($recDel);

$updateSQL = "UPDATE tblreports SET status=1 WHERE id = " . $colname_recDel;

mysqli_select_db($connSave, $database_connSave);
$Result1 = mysqli_query($connSave, $updateSQL) or die(mysqli_error());

header("Location:index.php");

mysqli_free_result($recDel);
?>