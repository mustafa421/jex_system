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


$tablename="$cfg_tableprefix".'checkprinting_coordinates';
$field_names=null;
$field_data=null;
$id=-1;
$id = 1;
   
 



	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];
	}
	
	
	
	elseif(isset($_POST['datexpos']) and isset($_POST['id']) and isset($_POST['action']) )
	
	{
		
		$action=$_POST['action'];
		$id = $_POST['id'];
		$id = 1;
		
		$datexpos = $_POST['datexpos'];
		$dateypos = $_POST['dateypos'];
		$namexpos = $_POST['namexpos'];
		$nameypos = $_POST['nameypos'];
		$amountinwordsxpos = $_POST['amountinwordsxpos'];
		$amountinwordsypos = $_POST['amountinwordsypos'];
		$amountxpos = $_POST['amountxpos'];
		$amountypos = $_POST['amountypos'];
		$notexpos = $_POST['notexpos'];
		$noteypos = $_POST['noteypos'];
	
	
	 
	
	







	
	
		
		
		if($datexpos=='')
		{
			echo "$lang->forgottenFields";
			exit();
		}
		else
		{
			$field_names=array('date_xpos','date_ypos','name_xpos','name_ypos','amount_inwords_xpos','amount_inwords_ypos','amount_xpos','amount_ypos','note_xpos','note_ypos','id');
			$field_data=array("$datexpos","$dateypos","$namexpos","$nameypos","$amountinwordsxpos","$amountinwordsypos","$amountxpos","$amountypos","$notexpos","$noteypos","$id");	
		
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
<a href="manage_checkprinting.php"><?php echo "Manage Check Printing" ?>--></a>
<br>
<a href="form_checkprinting.php?action=insert"><?php echo "Enter check printing coordinates" ?>--></a>
</body>
</html>