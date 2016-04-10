<?php session_start();?>
<?php require_once('includes/config.php'); ?>
<?php
$colname_recLoad = "-1";
if (isset($_GET['id'])) {
  $colname_recLoad = $_GET['id'];
}
mysqli_select_db($connSave, $database_connSave);
$query_recLoad = sprintf("SELECT * FROM tblreports WHERE id = %s", $colname_recLoad);
$recLoad = mysqli_query($connSave, $query_recLoad) or die(mysqli_error());
$row_recLoad = mysqli_fetch_assoc($recLoad);
$totalRows_recLoad = mysqli_num_rows($recLoad);

$_SESSION['appliedConditions'] = $row_recLoad['appliedConditions'];
$_SESSION['txtReportName'] = $row_recLoad['txtReportName'];
$_SESSION['lstSortName'] =$row_recLoad['lstSortName'];
$_SESSION['lstSortOrder'] = $row_recLoad['lstSortOrder'];
$_SESSION['txtRecPerPage'] = $row_recLoad['txtRecPerPage'];
$_SESSION['selectedFields'] = $row_recLoad['selectedFields'];
$_SESSION['selectedTables'] = $row_recLoad['selectedTables'];

header("Location:generateSQL.php");

mysqli_free_result($recLoad);
?>