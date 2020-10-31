<?php session_start(); ?>

<html>
<head>

</head>

<body>
<?php

include ("../../settings.php");
include ("../../../../../$cfg_configfile");
include ("../../language/$cfg_language");
include ("../../classes/db_functions.php");
include ("../../classes/security_functions.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);


if(!$sec->isLoggedIn())
{
	header ("location: ../../login.php");
	exit ();
}


$tablename="$cfg_tableprefix".'checknumber';
$field_names=null;
$field_data=null;
$id=-1;
$id = 1;
   
   


	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];
	}
	
	
	elseif(isset($_POST['startcknumber']) and isset($_POST['id']) and isset($_POST['action']) )
	
	{
		
		$action=$_POST['action'];
		$id = $_POST['id'];
		$id = 1;
		
		$startcknumber = $_POST['startcknumber'];
		$nextcknumber = $_POST['nextcknumber'];
		$bankname = $_POST['bankname'];
	
		
		
		if($startcknumber=='')
		{
			echo "$lang->forgottenFields";
			exit();
		}
		else
		{
			$field_names=array('start_check_number','next_check_number','bank_name','id');
			$field_data=array("$startcknumber","$nextcknumber","$bankname","$id");	
		
		}
		
	}
	else
	{
		
		echo "$lang->mustUseForm";
		exit();
	}
	


switch ($action)
{
	
	case $action=="insert":
		$dbf->insert($field_names,$field_data,$tablename,true);

	break;
		
	case $action=="update":
		$dbf->update($field_names,$field_data,$tablename,$id,true);
				
	break;
	
	case $action=="delete":
		$dbf->deleteRow($tablename,$id);
	
	break;
	
	default:
		echo "$lang->noActionSpecified";
	break;
}
$dbf->closeDBlink();

?>
<br>
<a href="manage_checknumber.php"><?php echo "Manage Check Number" ?>--></a>
<br>
<a href="form_checknumber.php?action=insert"><?php echo "Enter Check Number" ?>--></a>
</body>
</html>