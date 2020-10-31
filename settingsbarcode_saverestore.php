<?php session_start(); ?>
<?php
include ("settings.php");
include ("../../../$cfg_configfile");
include ("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");
include ("classes/form.php");
include ("classes/display.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Admin',$lang);
$display=new display($dbf->conn,$cfg_theme,$cfg_currency_symbol,$lang);


if(!$sec->isLoggedIn())
{
		header ("location: login.php");
		exit();
}

$restoredefault=$_GET['restoredefault'];
$savesettings=$_GET['savesettings'];
$restoresaved=$_GET['restoresaved'];


if ($restoredefault=="yes")
{
$defaultfilepathname ='../../../jeconfig/'.$cfg_storeDirname.'/'.'settings_barcode_default.txt';
$settingsfilepathname ='../../../jeconfig/'.$cfg_storeDirname.'/'.'settings_barcode.php';
if (file_exists($defaultfilepathname)) {  }else{ echo "Error: Default Barcode setting file not found."; exit;}

$shellcommand="cp -f $defaultfilepathname $settingsfilepathname";
$status=shell_exec("$shellcommand 2>&1; echo $?");

if ($status==0) 
{
 echo "Default barcode settings file has been restored successfully.";
}else{
 echo "Unable to restore default barcode settings file. status: $status";
}
echo "<br><br>";
echo "<a href=\"settings_barcode_edit.php\">Open Barcode Settings File</a>";
}


if ($savesettings=="yes")
{
$settingsfilepathname ='../../../jeconfig/'.$cfg_storeDirname.'/'.'settings_barcode.php';
$savedfilepathname ='../../../jeconfig/'.$cfg_storeDirname.'/'.'settings_barcode_saved.php';
if (file_exists($settingsfilepathname)) {  }else{ echo "Error: Barcode setting file not found."; exit;}

$shellcommand="cp -f $settingsfilepathname $savedfilepathname";
$status=shell_exec("$shellcommand 2>&1; echo $?");

if ($status==0) 
{
 echo "Your Barcode settings file has been saved successfully.";
}else{
 echo "Unable to save your barcode settings file. status: $status";
}
echo "<br><br>";
echo "<a href=\"settings_barcode_edit.php\">Open Barcode Settings File</a>";
}


if ($restoresaved=="yes")
{
$settingsfilepathname ='../../../jeconfig/'.$cfg_storeDirname.'/'.'settings_barcode.php';
$savedfilepathname ='../../../jeconfig/'.$cfg_storeDirname.'/'.'settings_barcode_saved.php';

if (file_exists($savedfilepathname)) {  }else{ echo "Error: Saved barcode setting file not found."; exit;}

$shellcommand="cp -f $savedfilepathname $settingsfilepathname";
$status=shell_exec("$shellcommand 2>&1; echo $?");

if ($status==0) 
{
 echo "Your Saved Barcode settings file has been restored successfully.";
}else{
 echo "Unable to restore your saved barcode settings file. status: $status";
}
echo "<br><br>";
echo "<a href=\"settings_barcode_edit.php\">Open Barcode Settings File</a>";
}


?>
