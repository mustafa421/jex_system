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
$field_names=null;
$field_data=null;
$id=-1;




	if(isset($_POST['paid_with']) and isset($_POST['id']))
	{
	
		$id = $_POST['id'];
		
		
		$paid_with = $_POST['paid_with'];
		$comment=$_POST['comment'];
		
		
		
		if($paid_with=='')
		{
			echo "$lang->forgottenFields";
			exit();
		}
		
	}
	else
	{
		
		echo "$lang->mustUseForm";
		exit();
	}
	
	$field_names=array('paid_with','comment');
	$field_data=array("$paid_with","$comment");

	$dbf->update($field_names,$field_data,$tablename,$id,true);
	$dbf->closeDBlink();

?>
<br>
<a href="manage_sales.php"><?php echo $lang->manageSales ?>--></a>
<br>
<a href="sale_ui.php"><?php echo $lang->startSale ?>--></a>
</body>
</html>