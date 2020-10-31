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


$tablename="$cfg_tableprefix".'categories';
$field_names=null;
$field_data=null;
$id=-1;



	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];
	}
	
	elseif(isset($_POST['category']) and isset($_POST['id']) and isset($_POST['action']) )
	{
		
		$action=$_POST['action'];
		$id = $_POST['id'];
		
		
		$category = $_POST['category'];
		$activatecategory = $_POST['activatecategory'];
	  
		if ($activatecategory == '') {
			$activatecategory = "N";
		}
	 
		
		$report_transaction = $_POST['report_transaction'];
		if ($report_transaction == '') {
			$report_transaction = "N";
		}
		$showon_itempanel = $_POST['showon_itempanel'];
		if ($showon_itempanel == '') {
			$showon_itempanel = "N";
		}
		$showon_moviespanel = $_POST['showon_moviespanel'];
		if ($showon_moviespanel == '') {
			$showon_moviespanel = "N";
		}
		$showon_gamespanel = $_POST['showon_gamespanel'];
		if ($showon_gamespanel == '') {
			$showon_gamespanel = "N";
		}
		$showon_jewelrypanel = $_POST['showon_jewelrypanel'];
		if ($showon_jewelrypanel == '') {
			$showon_jewelrypanel = "N";
		}
		$showon_saleservicepanel = $_POST['showon_saleservicepanel'];
		if ($showon_saleservicepanel == '') {
			$showon_saleservicepanel = "N";
		}
		
		
		
		
		
		
		
		if($category=='')
		{
			echo "$lang->forgottenFields";
			exit();
		}
		else
		{
			$field_names=array('category','activate_category','report_transaction','showon_itempanel','showon_moviespanel','showon_gamespanel','showon_jewelrypanel','showon_saleservicepanel');
			$field_data=array("$category","$activatecategory","$report_transaction","$showon_itempanel","$showon_moviespanel","$showon_gamespanel","$showon_jewelrypanel","$showon_saleservicepanel");	
	
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
<a href="manage_categories.php"><?php echo $lang->manageCategories ?>--></a>
<br>
<a href="form_categories.php?action=insert"><?php echo $lang->createCategory ?>--></a>
</body>
</html>