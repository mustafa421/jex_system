<?php session_start(); ob_start(); ?>

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
$sec=new security_functions($dbf,'Sales Clerk',$lang);
if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

if(isset($_GET['action']))
{
	$action=$_GET['action'];
	switch($action)
	{
		case $action=='all':
			$sec->closeSale();
			break;
		case $action=='item':
			$pos=$_GET['pos'];
			$saleid=$_GET['saleid'];
			for($k=0;$k<count($_SESSION['items_in_return']);$k++)
			{
				if($k==$pos)
				{
					unset($_SESSION['items_in_return'][$k]);
					$_SESSION['items_in_return']=array_values($_SESSION['items_in_return']);
					
					if(count($_SESSION['items_in_return'])==0)
					{
						$sec->closeSale();
					}
					break;
				}
			
			}
			break;
			
		case $action=='item_search':

			unset($_SESSION['current_item_search']);
			
			break;
			
		case $action=='customer_search':
			unset($_SESSION['current_customer_search']);
			
			break;
	}

}



  $bannedcustomer_flag=$_GET['bannedcustomer'];
  if($bannedcustomer_flag=='y')
  {
  echo "<meta http-equiv=refresh content=\"0; URL=banned_customer_msg.php\">";
  }else{
  
  
   header ("location: return_ui.php?fromdeleteitem=y&saleid=$saleid&itempos=$pos");
  }
$dbf->closeDBlink();
ob_end_flush();

?>
</body>
</html>