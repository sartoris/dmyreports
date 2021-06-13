<?php
    session_start();

    if (isset($_POST["selectedFields"]))
        $_SESSION['selectedFields'] = selectedFields;
    if (isset($_POST["txtReportName"]))
        $_SESSION['txtReportName'] = txtReportName;
    if (isset($_POST["appliedConditions"]))
        $_SESSION['appliedConditions'] = appliedConditions;
    if (isset($_POST["lstSortName"]))
        $_SESSION['lstSortName'] = lstSortName;
    if (isset($_POST["lstSortOrder"]))
        $_SESSION['lstSortOrder'] = lstSortOrder;
    if (isset($_POST["txtRecPerPage"]))
        $_SESSION['txtRecPerPage'] = txtRecPerPage;

?>