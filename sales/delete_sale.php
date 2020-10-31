<?php session_start(); ?>

<html>
<head>
</head>

<body>
<?php

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit ();
}


$tablename="$cfg_tableprefix".'sales';

	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		
	}
	
	$dbf->deleteRow($tablename,$id);
		
	

$dbf->closeDBlink();

?>
<br>
<a href="manage_sales.php"><?php echo $lang->manageSales ?>--></a>
<br>
<a href="sale_ui.php"><?php echo $lang->startSale ?>--></a>
</body>
</html>