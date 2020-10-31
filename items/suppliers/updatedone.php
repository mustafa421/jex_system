<?php session_start();?>

<html>
<head>
<script language="JavaScript" type="text/javascript">

function winClose()
{
window.close();


}
</script>
</head>


<body onload="winClose();">
<?php
include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/db_functions.php");
include ("../../classes/security_functions.php");
include ("../../classes/resizeimage.php");
include ("../../classes/cryptastic.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
if ($cfg_common_supplierNcustomers_allstores == "yes"){
$commondbf=new db_functions($cfg_server,$cfg_commondbuser,$cfg_commondbpwd,$cfg_commondbname,$cfg_tableprefix,$cfg_theme,$lang);
}

$sec=new security_functions($dbf,'Sales Clerk',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../../login.php");
	exit ();
}


echo "Done Page will close in few";
?>
</body>
</html>