<?php session_start(); 
$id=$_GET['id'];
$supplier_name=$_GET['sname'];

?>

<html>

<head>
 <SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url){
if(confirm(message)) location.href = url;
}
// --->
</SCRIPT>

</head>

<body lang=EN-US style='tab-interval:.5in'>

<div class=Section1>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><u><span style='color:blue'>SALE AGREEMENT FOR SUPPLIER ID: <?php echo "$id";?><o:p></o:p></span></u></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><u><span style='color:blue'>Supplier Name: <?php echo "$supplier_name";?><o:p></o:p></span></u></b></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='color:blue'>Click the file name below to view/print sale agreement <span
class=SpellE>PDF</span>.<o:p></o:p></span></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='color:blue'><o:p>&nbsp;</o:p></span></p>

<a href="suppliers/manage_suppliers.php">Back to Manage Suppliers Page</a>

<p class=MsoNormal align=center style='text-align:center'><span
style='color:blue'><o:p>&nbsp;</o:p></span></p>
	
</div>

<?php
include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../classes/cryptastic.php");
include ("../language/$cfg_language");
include ("../classes/security_functions.php");
include ("../classes/db_functions.php");
include ("../classes/display.php");  
include ("../classes/form.php");


if ($cfg_enable_deleteSAPDF=="yes"){
  
  $newlinetage='';
}else{
   $newlinetage='<br /><br />';
}

if(isset($_GET['action'])){ 
   $action=$_GET['action'];
  
}else{
 $action='done';
}
if(isset($_GET['pdffile'])){ 
   $filepdf=$_GET['pdffile'];
}else{
  $filepdf ='';
}

if ($action=="delete"){
 $zipnewnamepath3tempjpg=$cfg_data_csapdf_pathdir.'/'.$id.'/'.$filepdf;

  unlink($zipnewnamepath3tempjpg);
  $action='done';
}
  
  
$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);



$sec=new security_functions($dbf,'Sales Clerk',$lang);
if(!$sec->isLoggedIn())
{
	header ("location: ../../login.php");
	exit();
}



$userstable="$cfg_tableprefix".'users';
$userid=$_SESSION['session_user_id'];
$user_result = mysql_query("SELECT type FROM $userstable WHERE id = $userid ",$dbf->conn);
$usertable_row = mysql_fetch_assoc($user_result);
$usertype=$usertable_row['type'];









If ($action=="done"){
$dir="$cfg_data_csapdf_pathdir/$id";
exec("ls -t $cfg_data_csapdf_pathdir/$id/", $dirfiles); 

foreach ($dirfiles as &$file) {
	$fileurl="$dir/".$file;
    
	$pdffilename= substr($file, 0, -4); 
	
	echo "<a href=\"displaypdf.php?&pdffile=$file&spid=$id\" target=\"_blank\">$pdffilename</a> $newlinetage";
	
	if ($usertype=="Admin"){
	$deletepdffile='Delete';
	
    
	
   
   
   if ($cfg_enable_deleteSAPDF=="yes"){
      echo "<=================== ";
	  echo "<a href=\"javascript:decision('You are going to Delete file: $pdffilename','saleagreements.php?&action=delete&pdffile=$file&id=$id&sname=$supplier_name')\" target=\"_self\" style='text-decoration: none; color=red;'>$deletepdffile</a><br /><br />";
   }
	
 
   }
}
} 
?>


<p class=MsoNormal align=center style='text-align:center'><span
style='color:blue'><o:p>&nbsp;</o:p></span></p>

<br>
<a href="suppliers/manage_suppliers.php">Back to Manage Suppliers Page</a>
<br>
</body>

</html>