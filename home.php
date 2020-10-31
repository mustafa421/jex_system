<?php session_start();

include ("settings.php");
include ("../../../$cfg_configfile");
include("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");

$createxmlfilerequest=$cfg_xmlfilecreatedir.'/'.'requesttransfile.php';
if (file_exists("$createxmlfilerequest")) {

include ("$cfg_xmlfilecreatedir/requesttransfile.php");
}

$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);

if(!$sec->isLoggedIn())
{
header ("location: login.php");
exit();
}
$tablename = $cfg_tableprefix.'users';
$auth = $dbf->idToField($tablename,'type',$_SESSION['session_user_id']);
$first_name = $dbf->idToField($tablename,'first_name',$_SESSION['session_user_id']);
$last_name= $dbf->idToField($tablename,'last_name',$_SESSION['session_user_id']);

$name=$first_name.' '.$last_name;
$dbf->optimizeTables();

?>
<HTML>
<head> 
<STYLE TYPE="text/css">

</STYLE>

<script language="javascript" src="calendar/calendar.js"></script>

</head>

<?php $showCreateFile="no"; ?> 

<body bgcolor = #FFFFFF>
<?php 
if($auth=="Admin") 
{
$showCreateFile="yes"; 
?>


<?php $processingtransfile=$_GET['processingtransfile']; ?>
<?php  if ($processingtransfile!="yes") { ?>
<p>
<img border="0" src="images/home_print.gif" width="33" height="29" valign="top"><font color="#005B7F" size="4">&nbsp;<b><?php echo $lang->home ?></b></font></p>
<p><center><font face="Verdana" size="2" color=blue><?php echo "$lang->welcomeTo $cfg_company $lang->adminHomeWelcomeMessage"; ?> </font></center></p>
<br>
<?php } ?>





<ul>
	<center>

<TABLE BORDER=0 CELLPADDING=10 >


</center>
</table>
  
</ul>
<?php } elseif($auth=="Sales Clerk") { ?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" 

bordercolor="#111111" width="550" id="AutoNumber1">
  <tr>
    <td width="37">
    <img border="0" src="images/home_print.gif" width="33" height="29"></td>
    <td width="513"><font face="Verdana" size="4" color="#336699"><?php echo "$name 
    $lang->home" ?></font></td>
  </tr>
</table>

<?php $processingtransfile=$_GET['processingtransfile']; ?>
<?php  if ($processingtransfile!="yes") { ?>
<p><center><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->salesClerkHomeWelcomeMessage"; ?></center>
<?php } ?>

<?php 
if($cfg_allow_salesclerk_tocreate_extractfile=="yes") { 
  $showCreateFile="yes";   
}
?> 

<?php
}
else
{
?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" 

bordercolor="#111111" width="550" id="AutoNumber1">
  <tr>
    <td width="37">
    <img border="0" src="images/home_print.gif" width="33" height="29"></td>
    <td width="513"><font face="Verdana" size="4" color="#336699"><?php echo "$name 
    $lang->home"?></font></td>
  </tr>
</table>

<p><font face="Verdana" size="2"><?php echo "$lang->welcomeTo $cfg_company $lang->reportViewerHomeWelcomeMessage"; ?>

<?php
}
$dbf->closeDBlink();
?>


<?php ?>
<?php

if ($showCreateFile=="yes"){


 function filesize_n($path)
{
        $size = @filesize($path);
        if( $size < 0 ){
            ob_start();
            system('ls -al "'.$path.'" | awk \'BEGIN {FS=" "}{print $5}\'');
            $size = ob_get_clean();
        }

        return $size;
}
 
 if ($cfg_displaytranslinks=="yes"){
   
   
   if (($cfg_store_state =="wi") && ($processingtransfile!="yes")) {
   echo "<br>";
   echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
   echo "<center><b><font color='green'>Select date (default is current date) to create Transactions file. <br> </font></b></center>";
   echo "<center><b><font color='green'>After downloading files to your PC. Use FileZilla FTP client to FTP file to NEWPRS. <br> </font></b></center>";
   echo "<center><b><font color='green'>To get FileZilla Client and Setup Info Click Link Below. <br> </font></b></center>"; 
   echo "<center><a href=\"docs/filezillasetup.pdf\">Where to get and Setup FileZilla Client</a></center> \n"; 
  
   echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
   echo "<br>";
   }
 

  if (($cfg_store_state =="il") && ($processingtransfile!="yes")){
   echo "<br>";
   echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
   echo "<center><b><font color='green'>Select date (default is current date) to create Transactions files. <br> </font></b></center>";
   echo "<center><b><font color='green'>You will get one Transaction file and one zipped image file. <br> </font></b></center>";
   echo "<center><b><font color='green'>After downloading files to your PC<br> </font></b></center>";
   echo "<center><b><font color='green'>use FileZilla SFTP client to SFTP file to Leadsonline using port 22. <br> </font></b></center>";   
   echo "<center><b><font color='green'>If you do not have Filezilla FTP client click link below to download. <br> </font></b></center>";
   echo "<center><a href=\"docs/filezillasetup.pdf\">Where to get and Setup FileZilla Client</a></center> \n";  
   echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
   echo "<br>";
   }
 
 
$processingtransfile=$_GET['processingtransfile'];
$createtransfile=$_GET['createtransfile'];
$lastckfilesize=$_GET['tfilesize'];
$lastckfilesize2=$_GET['tfilesize2'];
$download_ready=$_GET['downloadready'];

$requestdate=$cfg_rundate;
$rundate=$cfg_filerundate;
 
$event_date = date("F j, Y", strtotime($requestdate));


if ($cfg_store_state =="wi") {   

$xmlfilename=$cfg_companyname.$rundate.'.xml';
$outputpathandfilename=$cfg_xmlfilecreatedir.'/'.$cfg_companyname.$rundate.'.xml';



 if ($download_ready=="yes") {
 $processingtransfile = 'done';
 $createtransfile='no';
 $download_ready='yes';
  echo "<br>";
  echo "<br>";
  echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
  echo "<center><b><font color='green'>Your XML Transaction file is ready for download. <br> </font></b></center>";
  echo "<center><b><font color='green'>Click the links below to download xml file. <br> </font></b></center>";
  echo "<center><b><font color='green'>Download to your PC and FTPS file to NEWPRS. <br> </font></b></center>";
  echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
  echo "<br>";
  echo "<center><a href=\"downloadtransfile.php?rundate=$rundate\">Click to download $event_date Transactions file</a></center> \n";
  echo "<br>";
  echo "<center><b><font color='red'>IMPORTANT NOTE</font></b></center>";
  echo "<center><b><font color='blue'>******************</font></b></center>";
  echo "<center><b><font color='blue'>It is responsibility of the store to verify the information being extracted is correct,<br> </font></b></center>";
  echo "<center><b><font color='blue'>the file/files are FTPS to NEWPRS and to make sure the file/files are loading properly<br> </font></b></center>";
  echo "<center><b><font color='blue'>on NEWPRS site<br> </font></b></center>";
  echo "<br>";
 }else{
   $createtransfile='yes';
 }
 
 
 if ($processingtransfile=="yes"){
     $createtransfile='no';
	 
    
if (file_exists("$outputpathandfilename")) {
	 

	$getfilesize="$outputpathandfilename";
     $transfilesize = filesize_n($getfilesize);
	 
	 
	 if ($lastckfilesize == $transfilesize){
	    
		shell_exec("cp -f $outputpathandfilename $cfg_copyxmlfiletodir");
        shell_exec("rm -f $outputpathandfilename");
	    
         if (file_exists("$cfg_copyxmlfiletodir/$xmlfilename")) {
	          $download_ready='yes';
			}else{
			  $download_ready='no';
			  echo "***Could not copy the file to download directory";
			}
	 
	 }else{
        $download_ready='no';

     }	 
   }else{
   $download_ready='no';
   }
   
         echo "<center><b><font color='blue' size='6'>Running for $event_date</font></b></center>";
	     echo "<center>Running script: $cfg_create_extractFilename</center><br/>";
	     echo "<center><b><font color='red' size='4'>Download link will appear when done. Please Wait! </font></b></center>";
	     echo "<center><img src=\"je_images/Processing.gif\" ></center>"; 
	     echo "<meta http-equiv=refresh content=\"10; URL=home.php?processingtransfile=$processingtransfile&createtransfile=$createtransfile&tfilesize=$transfilesize&tfilesize2=$transfilesize2&downloadready=$download_ready\">";
 

 }
 
 
 
 }
 
 
if ($cfg_store_state =="il") {   



$createdfilenames=$cfg_xmlfilecreatedir.'/'.'transcreatedfilenames.php';


if (file_exists("$createdfilenames")) {
include ("$cfg_xmlfilecreatedir/transcreatedfilenames.php");
}else{
     
	 
     
	 if ($processingtransfile=="yes"){
	 echo "<meta http-equiv=refresh content=\"10; URL=home.php?processingtransfile=$processingtransfile&createtransfile=$createtransfile&tfilesize=$transfilesize&tfilesize2=$transfilesize2&downloadready=$download_ready\">";
     }

}


$outputpathandfilename=$cfg_xmlfilecreatedir.'/'.$cfg_csvoutputfile;
$zipoutputpathanddir=$cfg_xmlfilecreatedir.'/'.$cfg_zipoutputdir;


 if ($download_ready=="yes") {
 $processingtransfile = 'done';
 $createtransfile='no';
 $download_ready='yes';
  echo "<br>";
  echo "<br>";
  echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
  echo "<center><b><font color='green'>Your Transaction csv file and Image zip folder is ready for download. <br> </font></b></center>";
  echo "<center><b><font color='green'>Click the links below to download csv & Image Zip folder. <br> </font></b></center>";
  echo "<center><b><font color='green'>Download to your PC and SFTP both files to Leadsonline. <br> </font></b></center>";
  echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
  echo "<br>";
  echo "<center><a href=\"downloadtransfile.php?iszipdir=no\">Click to download Transactions file $cfg_csvoutputfile</a></center> \n";
  echo "<br>";
  echo "<br>";
  echo "<center><a href=\"downloadtransfile.php?iszipdir=yes\">Click to download Transactions Image Zip file $cfg_zipoutputdir</a></center> \n";
  echo "<br>";
  echo "<br>";
  echo "<br>";
   echo "<center><b><font color='red'>IMPORTANT NOTE</font></b></center>";
   echo "<center><b><font color='blue'>******************</font></b></center>";
   echo "<center><b><font color='blue'>It is responsibility of the store to verify the information being extracted is correct,<br> </font></b></center>";
   echo "<center><b><font color='blue'>the file/files are SFTP to Leads Online and to make sure the file/files<br> </font></b></center>";
   echo "<center><b><font color='blue'>are loading properly on leads online site<br> </font></b></center>";
   echo "<br>";
 }else{
   $createtransfile='yes';
 }
 
 
 if ($processingtransfile=="yes"){
     $createtransfile='no';
	 
    
if ((file_exists("$outputpathandfilename")) && (file_exists("$zipoutputpathanddir"))) {
	 
	 $getfilesize="$outputpathandfilename";
     $transfilesize = filesize_n($getfilesize);
	 
	 $getfilesize2="$zipoutputpathanddir";
     $transfilesize2 = filesize_n($getfilesize2);
	 

	 
	 if (($lastckfilesize == $transfilesize) && ($lastckfilesize2 == $transfilesize2)){
	 

		
		shell_exec("cp -f $outputpathandfilename $cfg_copyxmlfiletodir");
        shell_exec("rm -f $outputpathandfilename");
		
		shell_exec("cp -f $zipoutputpathanddir $cfg_copyxmlfiletodir");
        shell_exec("rm -f $zipoutputpathanddir");
	    
		 $csvfilemovedtodownloaddir=$cfg_copyxmlfiletodir.$cfg_csvoutputfile;
		 $zipfilemovedtodownloaddir=$cfg_copyxmlfiletodir.$cfg_zipoutputdir;
         if ((file_exists("$csvfilemovedtodownloaddir")) && (file_exists("$zipfilemovedtodownloaddir"))) {
	          $download_ready='yes';
			}else{
			  $download_ready='no';
			  echo "***Could not copy the file to download directory";
			}
	 
	 }else{
        $download_ready='no';

     }	 
   }else{
   $download_ready='no';
   }
   
	     echo "<center><b><font color='blue' size='6'>Running for $event_date</font></b></center>";
	     echo "<center>Running script: $cfg_create_extractFilename</center><br/>";
	     echo "<center><b><font color='red' size='4'>Download link will appear when done. Please Wait! </font></b></center>";
	     echo "<center><img src=\"je_images/Processing.gif\" ></center>"; 
	     echo "<meta http-equiv=refresh content=\"10; URL=home.php?processingtransfile=$processingtransfile&createtransfile=$createtransfile&tfilesize=$transfilesize&tfilesize2=$transfilesize2&downloadready=$download_ready\">";
 
 }
 
 }
 
if  (($createtransfile=="yes") and (($download_ready=="no") or ($download_ready==""))){

 }
 } 
 
 




 if ($cfg_displayftpmsg=="yes"){   
  $ftpmsg= trim(shell_exec("cat ./ftpmsg.txt"));
   echo "\n";
   echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
   echo "<center><b><font color='green'>If Transaction file is Auto FTPed to Police you will see Status Message Below</font></b></center>";
   echo "<center><b><font color='blue'>*****************************************************************************</font></b></center>";
  
 
   
 
   
}
} 
?>

<?php if ($showCreateFile=="yes") { ?>

<center>
<table><tr><td>
<?php if  (($createtransfile=="yes") and (($download_ready=="no") or ($download_ready==""))){ ?>

<form action="requesttransfile.php" method="post">
<?php


require_once('calendar/classes/tc_calendar.php');


$myCalendar = new tc_calendar("date1", true);
$myCalendar->setIcon("calendar/images/iconCalendar.gif");


	  
$myCalendar->setDate(date('d'), date('m'), date('Y'));	  
$myCalendar->setPath("calendar/");	  
$myCalendar->setYearInterval((date('Y') -1) , date('Y'));	  
	  
$myCalendar->startMonday(true);	  





$myCalendar->writeScript();	  ?>
</td>
<td>
<p><input type="submit" value="Create Transaction File!"></p
</form>
           
<?php } ?>
</td>
</tr>
</table>
<?php

echo "<br>";echo "<br>";echo "<br>";echo "<br>";

    $sftpmessage = file_get_contents("$cfg_sftpmsg_file_pathName");
   
   echo "<b><font color='blue'>$sftpmessage</font></b>";
   
   

  ?>

</center> 

<?php }  ?>
<?php ?>