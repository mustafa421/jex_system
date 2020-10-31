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
			
			for($k=0;$k<count($_SESSION['items_in_sale']);$k++)
			{
				if($k==$pos)
				{
					unset($_SESSION['items_in_sale'][$k]);
					$_SESSION['items_in_sale']=array_values($_SESSION['items_in_sale']);
					
					if(count($_SESSION['items_in_sale'])==0)
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
  
  
   header ("location: sale_ui.php");
  }
$dbf->closeDBlink();
ob_end_flush();

?>
</body>
</html>