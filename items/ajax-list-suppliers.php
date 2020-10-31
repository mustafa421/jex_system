<?php session_start(); ?>

<?php
include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Sales Clerk',$lang);

$tablename = "$cfg_tableprefix".'suppliers';



if(isset($_GET['getCountriesByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);

	$res1 = "select id,supplier from $tablename where supplier like '".$letters."%'";
	
	$res = mysql_query($res1,$dbf->conn);  

	while($inf = mysql_fetch_array($res)){

	echo $inf["id"]."-".$inf["supplier"]."|";
	
	 
	}	
}

?>
