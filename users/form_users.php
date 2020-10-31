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
include ("../classes/form.php");
include ("../classes/display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);

if(!$sec->isLoggedIn())
{
	header ("location: ../login.php");
	exit();
}

$first_name_value='';
$last_name_value='';
$username_value='';
$type_value='';
$password_value='';
$id=-1;


if(isset($_GET['action']))
{
	$action=$_GET['action'];
}
else
{
	$action="insert";
}


if($action=="update")
{
	$display->displayTitle("$lang->updateUser");
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$tablename = "$cfg_tableprefix".'users';
		$result = mysql_query("SELECT * FROM $tablename WHERE id=\"$id\"",$dbf->conn);
		
		$row = mysql_fetch_assoc($result);
		$first_name_value=$row['first_name'];
		$last_name_value=$row['last_name'];
		$username_value=$row['username'];
		$password_value="*notchanged*";
		$type_value=$row['type'];
	
	}

}
else
{
	$display->displayTitle("$lang->addUser");

}	

$f1=new form('return validateFormOnSubmit(this)','process_form_users.php','POST','users','415',$cfg_theme,$lang);


$f1->createInputField("<b>$lang->firstName:</b>",'text','first_name',"$first_name_value",'24','180');
$f1->createInputField("<b>$lang->lastName:</b>",'text','last_name',"$last_name_value",'24','180');
$f1->createInputField("<b>$lang->username:</b><i>($lang->usedInLogin)</i>",'text','username',"$username_value",'24','180');

$option_values=array("$type_value",'Admin','Sales Clerk', 'Report Viewer');
$option_titles=array("$type_value","$lang->admin","$lang->salesClerk", "$lang->reportViewer");
$f1->createSelectField("<b>$lang->type:</b> ",'type',$option_values,$option_titles,'180');

$f1->createInputField("<b>$lang->password:</b>",'password','password',"$password_value",'24','180');
$f1->createInputField("<b>$lang->confirmPassword:</b>",'password','cpassword',"$password_value",'24','180');


echo "		
		<input type='hidden' name='action' value='$action'>
		<input type='hidden' name='id' value='$id'>";
$f1->endForm();

$dbf->closeDBlink();

?>
</body>
</html>	




