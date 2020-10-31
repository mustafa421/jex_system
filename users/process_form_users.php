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


$tablename="$cfg_tableprefix".'users';
$field_names=null;
$field_data=null;
$id=-1;



	
	if(isset($_GET['action']) and isset($_GET['id']))
	{
		$action=$_GET['action'];
		$id=$_GET['id'];
	}
	
	elseif(isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['username']) 
	and isset($_POST['password']) and isset($_POST['cpassword']) and isset($_POST['type'])
	and isset($_POST['id']) and isset($_POST['action']) )
	{
	
		$action=$_POST['action'];
		$id = $_POST['id'];
		
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$cpassword = $_POST['cpassword'];
		$type = $_POST['type'];
		
		
		
		if($first_name=='' or $last_name=='' or $username=='' or $password=='' or $cpassword=='' or $type=='')
		{
			echo "$lang->forgottenFields";
			exit();
		}
		elseif($password!=$cpassword)
		{
			echo "$lang->passwordsDoNotMatch";
			exit();
		}
		elseif($action=='insert')
		{
			
			$password=md5($password);
			$field_names=array('first_name','last_name','username','password','type');
			$field_data=array("$first_name","$last_name","$username","$password","$type");
	
		}
		elseif($password=="*notchanged*")
		{
			/*
			Does NOT encrypt password because user did not change their password, but other
			info might have changed and needs to be updated.  Info stored in arrays.
			*/
			
			$field_names=array('first_name','last_name','username','type');
			$field_data=array("$first_name","$last_name","$username","$type");	
		}
		else
		{

			$password=md5($password);
			$field_names=array('first_name','last_name','username','password','type');
			$field_data=array("$first_name","$last_name","$username","$password","$type");	
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
<a href="manage_users.php"><?php echo "$lang->manageUsers"; ?>--></a>
<br>
<a href="form_users.php?action=insert"><?php echo "$lang->createUser"; ?>--></a>
</body>
</html>