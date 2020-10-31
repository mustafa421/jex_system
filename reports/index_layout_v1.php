<?php session_start();
include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Report Viewer',$lang);


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
	  
	  

<div id=\"button-box\"> <span class=\"tab\"></span><a href=\"daily.php\" class=\"button\">Daily Items Sale Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=$lang->dateRangeReport\" class=\"button\">Date Range Items Sale Report</a> 
<span class=\"tab\"></span>
<span class=\"tab\"></span>
 <a href=\"form.php?report=$lang->profitReport\" class=\"button\">Sale Profit Report</a>
 <span class=\"tab\"></span>
 <span class=\"tab\"></span>
<a href=\"form.php?report=$lang->taxReport\" class=\"button\">Sale Tax Report</a>
</div>


</br>

<div id=\"button-box\"><span class=\"tab\"></span> <a href=\"form.php?report=CostReport\" class=\"button\">Cost Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=$lang->jeallItemsReportDateRange\" class=\"button\">Date Range Cost Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=$lang->itemCostReportDateRange\" class=\"button\">Date Range Item Cost Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>
<a href=\"form.php?report=$lang->jecategoryCostReport\" class=\"button\">Date Range Category Cost Report</a>
</div>


</br>

<div id=\"button-box\"> <span class=\"tab\"></span><a href=\"form.php?report=ServicesDateRangeReport\" class=\"button\">Services Sale Report</a>
<span class=\"tab\"></span>
<span class=\"tab\"></span>  
<a href=\"form.php?report=InventoryCostReport\" class=\"button\">Inventory Onhand Cost Report</a>

</div>



</body>
</html>";

$dbf->closeDBlink();








	

?>
