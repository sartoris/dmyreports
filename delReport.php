<?php
    require_once('includes/config.php');
    //Code to Delete Reports
    if(isset($_GET['id'])) {
        $colname_recDel = $_GET['id'];

        mysqli_select_db($connReports, $database_connReports);
        $query_recDel = sprintf("SELECT status FROM tblreports WHERE id = %s", $colname_recDel);
        $recDel = mysqli_query($connReports, $query_recDel) or die(mysqli_error());
        $row_recDel = mysqli_fetch_assoc($recDel);
        $totalRows_recDel = mysqli_num_rows($recDel);

        $updateSQL = "UPDATE tblreports SET status=1 WHERE id = " . $colname_recDel;

        mysqli_select_db($connReports, $database_connReports);
        $Result1 = mysqli_query($connReports, $updateSQL) or die(mysqli_error());
        mysqli_free_result($recDel);
    }
    header("Location:index.php");
?>