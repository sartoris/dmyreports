<?php
  session_start();
  require_once('includes/config.php');

  if(isset($_POST["txtReportName"])){
    $_SESSION['txtReportName'] = $_POST["txtReportName"]; 
  }
  if(isset($_POST["appliedConditions"])){
    $_SESSION['appliedConditions'] = $_POST["appliedConditions"]; 
  }
  if(isset($_POST["lstSortName"])){
    $_SESSION['lstSortName'] = $_POST["lstSortName"]; 
  }
  if(isset($_POST["lstSortOrder"])){
    $_SESSION['lstSortOrder'] = $_POST["lstSortOrder"]; 
  }
  if(isset($_POST["txtRecPerPage"])){
    $_SESSION['txtRecPerPage'] = $_POST["txtRecPerPage"]; 
  }
  $sessionSelectedTables = isset($_SESSION['selectedTables']) ? $_SESSION['selectedTables'] : "";
  $sessionSelectedFields = isset($_SESSION['selectedFields']) ? $_SESSION['selectedFields'] : "";
  $lstSave = isset($_POST['lstSave']) ? $_POST['lstSave'] : "0";


  function dmyError($sql){
    $_SESSION["dmyError"] = "An error has occurred in generating the report. SQL Statement:<br/>";
    $_SESSION["dmyError"] .= $sql;
    $_SESSION["dmyErrorUrl"] = "selectTables.php";
    print "<script language=\"JavaScript\">";
    print "window.location = 'genError.php' ";
    print "</script>";
  }

  function GetSQLValueString($theValue, $theType) 
  {
    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;    
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
    }
    return $theValue;
  }

  if ($_SESSION["txtReportName"] != "") {
    if ($lstSave==1){
      $insertSQL = sprintf("INSERT INTO tblreports (appliedConditions, txtReportName, lstSortName, lstSortOrder, txtRecPerPage, selectedFields, selectedTables) VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_SESSION['appliedConditions'], "text"),
        GetSQLValueString($_SESSION['txtReportName'], "text"),
        GetSQLValueString($_SESSION['lstSortName'], "text"),
        GetSQLValueString($_SESSION['lstSortOrder'], "text"),
        GetSQLValueString($_SESSION['txtRecPerPage'], "text"),
        GetSQLValueString($sessionSelectedFields, "text"),
        GetSQLValueString($sessionSelectedTables, "text"));
      mysqli_select_db($connReports, $database_connReports);
      $Result1 = mysqli_query($connReports, $insertSQL) or die(mysqli_error($connReports));
    }
  }

  // The code to generate the SQL statement
  $tmpSQL = "SELECT ";

  $tmpFields = explode("~",$sessionSelectedFields);
  for ($x=0; $x<=count($tmpFields)-1; $x+=1) {
    if ($tmpFields[$x]!=""){
      $tmpSQL = $tmpSQL . $tmpFields[$x] . ", ";
    }
  }

  $tmpSQL = substr($tmpSQL, 0, (strlen($tmpSQL)-2) );

  $tmpSQL = $tmpSQL . " FROM ";

  $tmpTables = explode("~",$sessionSelectedTables);
  for ($x=0; $x<=count($tmpTables)-1; $x+=1) {
    if ($tmpTables[$x]!=""){
      $tmpSQL = $tmpSQL . $tmpTables[$x] . ", ";
    }
  }

  $tmpSQL = substr($tmpSQL, 0, (strlen($tmpSQL)-2) );

  if ($_SESSION['appliedConditions']!="")	{
    $tmpSQL = $tmpSQL . " WHERE ";
    
    $tmpCondition = explode("~",str_replace('``','\'',$_SESSION['appliedConditions']));
    for ($x=0; $x<=count($tmpCondition)-1; $x+=1) {
      if ($tmpCondition[$x]!=""){
        $tmpSQL = $tmpSQL . stripslashes($tmpCondition[$x]) . " ";
      }
    }
  }

  if ($_SESSION['lstSortName']!=""){
    $tmpSQL = $tmpSQL . " ORDER BY " . $_SESSION['lstSortName'] . " " . $_SESSION['lstSortOrder'];
  }

  $_SESSION["tmpSQL"] = $tmpSQL;

  $currentPage = $_SERVER["PHP_SELF"];

  if ($_SESSION['txtRecPerPage']==""){
    $maxRows_recSQL = "18446744073709551615";
  }else{
    $maxRows_recSQL = $_SESSION['txtRecPerPage'];
  }
  $pageNum_recSQL = 0;
  if (isset($_GET['pageNum_recSQL'])) {
    $pageNum_recSQL = $_GET['pageNum_recSQL'];
  }
  $startRow_recSQL = $pageNum_recSQL * $maxRows_recSQL;

  mysqli_select_db($connDB, $database_connDB);
  $query_recSQL = $tmpSQL;
  $query_limit_recSQL = sprintf("%s LIMIT %d, %d", $query_recSQL, $startRow_recSQL, $maxRows_recSQL);
  $recSQL = mysqli_query($connDB, $query_limit_recSQL) or die(dmyError($query_limit_recSQL));
  $column_count = mysqli_num_fields($recSQL) or die("display_db_query:" . mysqli_error($connDB));

  if (isset($_GET['totalRows_recSQL'])) {
    $totalRows_recSQL = $_GET['totalRows_recSQL'];
  } else {
    $all_recSQL = mysqli_query($connDB, $query_recSQL);
    $totalRows_recSQL = mysqli_num_rows($all_recSQL);
  }
  $totalPages_recSQL = ceil($totalRows_recSQL/$maxRows_recSQL)-1;

  $queryString_recSQL = "";
  if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
    if (stristr($param, "pageNum_recSQL") == false && 
      stristr($param, "totalRows_recSQL") == false) {
      array_push($newParams, $param);
    }
    }
    if (count($newParams) != 0) {
    $queryString_recSQL = "&" . htmlentities(implode("&", $newParams));
    }
  }

  $queryString_recSQL = sprintf("&totalRows_recSQL=%d%s", $totalRows_recSQL, $queryString_recSQL);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <?php
        include "includes/header.php";
    ?>
  </head>
  <body bgcolor="#dcdedb">
    <!--<?php echo $tmpSQL; ?> -->
    <table width="693" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="13" height="47"><img src="images/main_window/top_left_corner.gif" width="15" height="47"></td>
        <td width="668" background="images/main_window/top.gif"><img src="images/main_window/title.gif" width="169" height="47"></td>
        <td width="12"><img src="images/main_window/top_right_corner.gif" width="18" height="47"></td>
      </tr>
      <tr>
        <td height="306" background="images/main_window/left.gif">&nbsp;</td>
        <td valign="top" bgcolor="#FBF9F9">
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="pageHeader"><?php echo $pageTitle;?></td>
            </tr>
          </table>
          <table width="100%"  border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td height="22">
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="27">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td class="reportHeading">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="6%"><img src="images/create.gif" alt="View Report" width="32" height="32"></td>
                                <td width="94%"><?php echo $_SESSION['txtReportName'];?></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td><hr size="1" /></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td height="27">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="reportNavi">
                        <tr>
                          <td width="74%" bgcolor="#F0F0F0" class="subHeader">&nbsp;
                            Records <?php echo ($startRow_recSQL + 1) ?> to <?php echo min($startRow_recSQL + $maxRows_recSQL, $totalRows_recSQL) ?> of <?php echo $totalRows_recSQL ?>
                          </td>
                          <td width="26%" bgcolor="#F0F0F0" class="subHeader">
                            <table width="50%" border="0" align="center" cellpadding="5">
                              <tr>
                                <td width="23%" align="center" bgcolor="#C2F4BD"><?php if ($pageNum_recSQL > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_recSQL=%d%s", $currentPage, 0, $queryString_recSQL); ?>"><b>First</b></a>
                                  <?php }else{echo"First";} // Show if not first page ?>
                                </td>
                                <td width="31%" align="center" bgcolor="#C2F4BD"><?php if ($pageNum_recSQL > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_recSQL=%d%s", $currentPage, max(0, $pageNum_recSQL - 1), $queryString_recSQL); ?>"><b>Previous</b></a>
                                  <?php }else{echo"Previous";} // Show if not first page ?>
                                </td>
                                <td width="23%" align="center" bgcolor="#C2F4BD"><?php if ($pageNum_recSQL < $totalPages_recSQL) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_recSQL=%d%s", $currentPage, min($totalPages_recSQL, $pageNum_recSQL + 1), $queryString_recSQL); ?>"><b>Next</b></a>
                                  <?php }else{echo"Next";} // Show if not last page ?>
                                </td>
                                <td width="23%" align="center" bgcolor="#C2F4BD"><?php if ($pageNum_recSQL < $totalPages_recSQL) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_recSQL=%d%s", $currentPage, $totalPages_recSQL, $queryString_recSQL); ?>"><b>Last</b></a>
                                  <?php }else{echo"Last";} // Show if not last page ?>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td height="27">
                      <?php
                        print("<TABLE width='100%' cellspacing='0' cellpading='0' class='tableReports'> \n");
                        print("<TR ALIGN=LEFT VALIGN=TOP>");
                        for($column_num = 0; $column_num < $column_count; $column_num++) {
                          $field_name = mysqli_fetch_field_direct($recSQL, $column_num);
                          print("<TD class='tableHeader'><b>$field_name->name</b></TD>");
                        }
                        print("</TR>\n");
                        
                        $row = mysqli_fetch_row($recSQL);
                        do {
                          print("<TR ALIGN=LEFT VALIGN=TOP>");
                          for($column_num = 0; $column_num < $column_count; $column_num++) {
                            print("<TD>");
                            if ($row[$column_num]!=""){
                              print($row[$column_num]);
                            }else{
                              print("&nbsp;");
                            }
                            print("</TD>\n");
                          }
                          print("</TR>\n");
                        } while ($row = mysqli_fetch_row($recSQL));
                      ?>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="57%">&nbsp;</td>
                          <td width="43%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>
                            <input name="cmdBack" type="button" class="button" id="cmdBack" onclick="javascript:window.location.href ='setConditions.php'" value="&lt;&lt; Back" />
                            <input name="cmdExportExcel" type="button" class="button" id="cmdExportExcel" onclick="javascript:window.location.href ='exportExcel.php'" value="Export to Excel">
                            <input name="cmdExportCSV" type="button" class="button" id="cmdExportCSV" onclick="javascript:window.location.href ='exportCSV.php'" value="Export to CSV">
                          </td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
        <td background="images/main_window/right.gif">&nbsp;</td>
      </tr>
      <tr>
        <td height="14"><img src="images/main_window/bottom_left_corner.gif" width="15" height="14"></td>
        <td background="images/main_window/bottom.gif"><img src="images/main_window/bottom.gif" width="668" height="14"></td>
        <td><img src="images/main_window/bottom_right_corner.gif" width="18" height="14"></td>
      </tr>
    </table>
  </body>
</html>
<?php
  mysqli_free_result($recSQL);
?>
