<?php session_start();
include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);




$usertablename = $cfg_tableprefix.'users';
$username= $dbf->idToField($usertablename,'username',$_SESSION['session_user_id']);

if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}
?>
<?php







 
echo "
<html>
<head>


	<link rel='stylesheet' type='text/css' href='../cssbutton/css/style.css' />
</head>
<body>

    <td><img border=\"0\" src=\"../je_images/custom-reports-icon.png\" width=\"80\" height=\"80\" valign='top'><font color='#005B7F' size='4'>&nbsp;<b>$lang->reports</b></font><br>
      <br>
      <center><font face=\"Verdana\" size=\"2\">$lang->reportsWelcomeMessage</font></center>
  
</br></br>	
<span class=\"tab\"></span>	
<span class=\"tab\"></span>	  
</b><b><font color='blue'>Sale Reports</font></b>
<span class=\"tab\"></span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
</b><b><font color='blue'>Cost Reports</font></b>
</br></br>



<div id=\"button-box\"> <span class=\"tab\"></span>
</br>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"daily.php\" class=\"button\">Daily Items Sale Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=CostReport\" class=\"button\">Cost Report</a></div>
</br></br>



<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=$lang->dateRangeReport\" class=\"button\">Date Range Items Sale Report</a> 
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=$lang->jeallItemsReportDateRange\" class=\"button\">Date Range Cost Report</a>
</br></br></br>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
 <a href=\"form.php?report=$lang->profitReport\" class=\"button\">Sale Profit Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=$lang->itemCostReportDateRange\" class=\"button\">Date Range Item Cost Report</a>
 </br></br></br>
 <span class=\"tab\"></span>
 <span class=\"tab\"></span>
<a href=\"form.php?report=$lang->taxReport\" class=\"button\">Sale Tax Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=$lang->jecategoryCostReport\" class=\"button\">Date Range Category Cost Report</a>
</br></br></br>
 <span class=\"tab\"></span>
 <span class=\"tab\"></span>
<a href=\"form.php?report=ServicesDateRangeReport\" class=\"button\">Services Sale Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>  
<a href=\"form.php?report=InventoryCostReport\" class=\"button\">Inventory Onhand Cost Report</a>
</div>


</br>



</body>
</html>";



if ($username == "jeadmin"){
echo "
<html>
<head>


        <link rel='stylesheet' type='text/css' href='../cssbutton/css/style.css' />
</head>
<body>

</br></br>	
<span class=\"tab\"></span>	
<span class=\"tab\"></span>	 

</b><b><font color='blue'>New ReFund and Sale Reports (Click REPORTS to get back to this page)</font></b>

<div id=\"button-box\"> <span class=\"tab\"></span>
</br>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"reportico45/run2.php?execute_mode=EXECUTE&project=Reports&xmlin=SaleReport_Daily.xml\" class=\"button\">Sale Report Daily</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"reportico45/run2.php?execute_mode=EXECUTE&project=Reports&xmlin=SaleReport_DateRange.xml\" class=\"button\">Sale Report Date Range</a></div>
</br></br>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"reportico45/run2.php?execute_mode=EXECUTE&project=Reports&xmlin=Refund_Report.xml\" class=\"button\">Refund Report</a> 
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"reportico45/run2.php?execute_mode=EXECUTE&project=Reports&xmlin=Monthly_Refund_Report.xml\" class=\"button\">Monthly Refund Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
</div>



</body>
</html>";
}





$dbf->closeDBlink();









	

?>
