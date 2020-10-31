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


$fn ='../../../jeconfig/'.$cfg_storeDirname.'/'.'settings_barcode.php';



if (isset($_POST['content']))
{
    $content = stripslashes($_POST['content']);
    $fp = fopen($fn,"w") or die ("Error opening file in write mode!");
    fputs($fp,$content);
    fclose($fp) or die ("Error closing file!");
}
?>
<a href="settingsbarcode_saverestore.php?restoredefault=yes">Restore Default Barcode Settings</a>
<?php echo " | " ?>
<a href="settingsbarcode_saverestore.php?savesettings=yes">Save My Barcode Settings</a>
<?php echo " | " ?>
<a href="settingsbarcode_saverestore.php?restoresaved=yes">Restore Saved Barcode Settings</a>
<?php echo " | " ?>
<a href="settings_barcode_edit.php">ReLoad Barcode Setting file</a>

<h3>Barcode Settings File (<font size="2" color="blue">After making changes scroll down and click</font><font color="red"> Save Changes</font><font color="blue"> Button</font>)</h3>

<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
    <textarea rows="30" cols="80" name="content"><?php readfile($fn); ?></textarea>
    <input type="submit" value="Save Changes"> 
</form>

<a href="settingsbarcode_saverestore.php?restoredefault=yes">Restore Default Barcode Settings</a>
<?php echo " | " ?>
<a href="settingsbarcode_saverestore.php?savesettings=yes">Save My Barcode Settings</a>
<?php echo " | " ?>
<a href="settingsbarcode_saverestore.php?restoresaved=yes">Restore Saved Barcode Settings</a>
<?php echo " | " ?>
<a href="settings_barcode_edit.php" >ReLoad Barcode Setting file</a>