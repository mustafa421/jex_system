<?php session_start();
include ("settings.php");
include ("../../../$cfg_configfile");
include("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);

if(!$sec->isLoggedIn())
{
header ("location: login.php");
exit();
}

shell_exec("rm -f $cfg_xmlfilecreatedir/runjobrequest.txt");
shell_exec("rm -f  $cfg_xmlfilecreatedir/requesttransfile.php");
shell_exec("rm -f $cfg_xmlfilecreatedir/transcreatedfilenames.php");
shell_exec("rm -f  $cfg_xmlfilecreatedir/f_0_*");
shell_exec("rm -f  $cfg_xmlfilecreatedir/IMG_*.zip");

shell_exec("echo '<?php'  > $cfg_xmlfilecreatedir/requesttransfile.php");

$theDate = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
$rundate='\$cfg_rundate='.'\"'.$theDate.'\"'.'\;';

shell_exec("echo $rundate  >> $cfg_xmlfilecreatedir/requesttransfile.php");

 $fileDate = str_replace("-", "", "$theDate");
 $fileDate_month = substr("$fileDate",4,2);
 $fileDate_day = substr("$fileDate",6,2);
 $fileDate_year = substr("$fileDate",0,4);
 $fileDate=$fileDate_month.$fileDate_day.$fileDate_year;
 $mm_dd_yyyy=$fileDate_month.'_'.$fileDate_day.'_'.$fileDate_year;

$fileRunDate='\$cfg_filerundate='.'\"'.$fileDate.'\"'.'\;';
shell_exec("echo $fileRunDate >> $cfg_xmlfilecreatedir/requesttransfile.php");
$mmddyyy='\$cfg_mm_dd_yyyy='.'\"'.$mm_dd_yyyy.'\"'.'\;';
shell_exec("echo $mmddyyy >> $cfg_xmlfilecreatedir/requesttransfile.php");
shell_exec("echo '?>'  >> $cfg_xmlfilecreatedir/requesttransfile.php"); 


$RunForTransactionDate="'".$theDate."'"; 
$result=mysql_query("SELECT * FROM jestore_item_transactions WHERE date= $RunForTransactionDate AND supplier_id <> 1 and report_item <> 'N' ORDER BY date ASC",$dbf->conn);

if(@mysql_num_rows($result) >= 1)
{
  
}else{
	 echo "<br /><br />";
	 echo "<center><b><font color='red' size='6'>There are NO Transactions for</font><font color='blue' size='6'> $fileDate_day/$fileDate_month/$fileDate_year <br /> </font> <font color='black'>(Please Select a Date with Transactions)</font></b></center>";
     shell_exec("rm -f  $cfg_xmlfilecreatedir/requesttransfile.php");
	 echo "<br /><br />";
	 echo "<center><a href=\"home.php\">Go Back</a></center> \n";
	 exit();
}  


shell_exec("touch  $cfg_xmlfilecreatedir/runjobrequest.txt");


$pos = strpos($cfg_xmlfilecreatedir, 'jedata', 1); 
$jescriptpath=substr($cfg_xmlfilecreatedir,0,$pos);
$jescriptpath=$jescriptpath.'jescripts';
$runscriptpathname=$jescriptpath.'/'.$cfg_create_extractFilename; 

exec("php $runscriptpathname > /dev/null &");


header("Location: home.php?processingtransfile=yes");
exit();
?>