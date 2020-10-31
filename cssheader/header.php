<?php session_start();

include ("../settings.php");
include ("../../../../$cfg_configfile");
include ("../language/$cfg_language");
include ("../classes/db_functions.php");
include ("../classes/security_functions.php");



$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);

$tablename = $cfg_tableprefix.'users';
$auth = $dbf->idToField($tablename,'type',$_SESSION['session_user_id']);
$userLoginName= $dbf->idToField($tablename,'username',$_SESSION['session_user_id']);
$userFirstName= $dbf->idToField($tablename,'first_name',$_SESSION['session_user_id']);
$userLastName= $dbf->idToField($tablename,'last_name',$_SESSION['session_user_id']);



$storecityNversion=$cfg_company_city.' '.$cfg_pos_version;


$dbf->closeDBlink();


$greenbgcolor='"'.'#0B610B'.'"';
$blubgcolor='"'.'#2275BF'.'"';



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; " />
<title></title>

<link rel="shortcut icon" type="image/x-icon" href="https://www.whmcsthemes.com/favicon.png" />

<link rel="stylesheet" href="../csstooltip/style1.css">
<link href="css/style.css" rel="stylesheet" type="text/css" />



<SCRIPT LANGUAGE="Javascript">
<!---
function decision(message, url)
{
	if(confirm(message) )
  {
    parent.location.href = url;
  }
}
// --->
</SCRIPT>

<script type="text/javascript">









var currenttime = '<?PHP print date("F d, Y H:i:s", time())?>' 



var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
var serverdate=new Date(currenttime)

function padlength(what){
var output=(what.toString().length==1)? "0"+what : what
return output
}

function displaytime(){
serverdate.setSeconds(serverdate.getSeconds()+1)
var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()
var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
document.getElementById("servertime").innerHTML=datestring+" "+timestring
}

window.onload=function(){
setInterval("displaytime()", 1000)
}

</script>



</head>



<body >


<div class="body">

<?php if ($cfg_headerBGcolor == "darkorange") { ?>
	<h1 id="ff-proof" class="ribbon"> <div class="logo"> </div> &nbsp;&nbsp;</h1>

<?php }elseif ($cfg_headerBGcolor == "darkblack"){ ?>
	<div id="head"></div>
	<div class="logo"> </div> 

<?php }else{ ?>

<div class="logo"> </div> 

<?php } ?>   





   <div class="welcome"><span><b><font face="Verdana" size="2" color="#FFFFFF"><?php echo "Welcome" ?></b>&nbsp;<?php echo $userFirstName; ?>&nbsp;<?php echo $userLastName; ?>!</span>

</font>
   </div> 
 
   <div class="username"><span><b><font face="Verdana" size="2" color="#FFFFFF"><?php echo $userLoginName; ?></span>
   <span><b><?php echo "->" ?></b>&nbsp;<?php echo $auth; ?></font></span></div>
   
  <div class="logout"><span> <a href="javascript:decision('<?php echo $lang->logoutConfirm ?>','../logout.php')">
  <img src="images/logout_blue.png" alt="" style="width:20px;height:20px">
 </div>
 
 <div class="logout"><span> <a href="javascript:decision('<?php echo $lang->logoutConfirm ?>','../logout.php')">
 &nbsp;&nbsp;&nbsp; &nbsp; <font color="#FFFFFF"><?php echo $lang->logout ?></font></a></font></span>
 </div>

 
  <div class="legend"><span><b><font size="5" color="#FFFFFF"><?php echo "Jewelry & Electronic Exchange"; ?></font></a></font></b></span></div>
  <div class="location"><span><b><font size="4" color="#FFFFFF"><?php echo $cfg_company_city ?></font></a></font></b></span></div>
   <div class="time"><span><font face="Verdana" size="2" color="#FFFFFF"><p><span id="servertime"></span></p></font></b></span></div> 






<div class="version"><span><font size="2" color="#FFFFFF"><a href="#" class="tooltip">
    <img src="images/about.png" alt="" style="width:20px;height:20px"/>
    <span>
        <img class="callout" src="../csstooltip/callout.gif" />
        <img src="../csstooltip/versionicon.png" style="float:right; width:40px;height:40px" />
        <strong><?php echo $cfg_pos_version ?></strong><br />
        
    </span>
</a>  
</font></a></font></span></div>
  
  

   

  </div> 
   





 </body>
 </html>