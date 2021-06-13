<?php
    session_start();
    $_SESSION['appliedConditions'] = "";
    $_SESSION['txtReportName'] = ""; 
    $_SESSION['lstSortName'] = ""; 
    $_SESSION['lstSortOrder'] = "ASC"; 
    $_SESSION['txtRecPerPage'] = "20";
    $_SESSION['selectedFields'] = "";
    $_SESSION['selectedTables'] = ""; 
    header("Location:index.php");
?>