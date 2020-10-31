<?php session_start();

include ("settings.php");
include ("../../../$cfg_configfile");
include ("language/$cfg_language");
include ("classes/db_functions.php");
include ("classes/security_functions.php");


$lang=new language();
$dbf=new db_functions($cfg_server,$cfg_username,$cfg_password,$cfg_database,$cfg_tableprefix,$cfg_theme,$lang);
$sec=new security_functions($dbf,'Public',$lang);

if (($cfg_UnderMaintenance == "yes") and ($username <> "jeadmin")){ 

}
?>
<?php if (($cfg_UnderMaintenance == "yes") and ($username <> "jeadmin")){ 
echo "</br></br></br></br></br></br>";
echo " <center> ";?>
<div style="font-size: large; font-family: sans-serif">
 <a style="color: #000000; background-color: #ffff42">System Under Maintenance. Please check back!</a>
</div>
<?php echo "</center>"; } ?>

<?php
if(isset($_POST['username']) and isset($_POST['password']))
{
	$username = $_POST['username'];
	$password = md5 ($_POST['password']);
	
	if (($cfg_UnderMaintenance == "yes") and ($username <> "jeadmin")){ 
	
     }
	 
?>
<?php if (($cfg_UnderMaintenance == "yes") and ($username <> "jeadmin")){ 
echo "</br></br></br></br></br></br>";
echo " <center> ";?>
<div style="font-size: large; font-family: sans-serif">
 <a style="color: #000000; background-color: #ffff42">System Under Maintenance. Please check back!</a>
</div>
<?php echo "</center>"; exit;} ?>
<?php
	 
	 
	 
	 
	 
	 
	 
		if($sec->checkLogin($username,$password))
		{
		 	$_SESSION['session_user_id'] = $dbf->getUserID($username,$password);
			header ("location: index.php");
		}
	    else
	    {
			

  	
	       ?>
	  
				<?php echo "</br></br></br></br></br></br> <center> "; ?>
		    	<div style="font-size: large; font-family: sans-serif">
				<a style="color: #ffffff; background-color: #ff0000">Username Or Password Incorrect</a>
				</div>
				<?php echo "</center>"; ?>
	
	      <?php
		}
}

if($sec->isLoggedIn())
{
	header ("Location: index.php");	
}

$dbf->closeDBlink();

?> 
<html>
<head>

<style>
  body {background-color:lightgray}
  h1   {color:blue}
  p    {color:green}
</style>


<link rel="stylesheet" href="cssloginpage/style.css">

</head>
<body>




			    
<form id="login" action="login.php" method="post" name="Login">
    	<center> <div class="storename"><span><?php echo $cfg_company_city ?></span></div></center>
    <h1 id="ff-proof" class="ribbon"><div class="logo"> </div>Employee Login &nbsp;&nbsp;</h1>
    <div class="apple">
    	<div class="top"><span></span></div>
    	<div class="butt"><span></span></div>
    	<div class="bite"></div>
	</div>
    <fieldset id="inputs">
        <input id="username" name="username" type="text" onblur="if(this.value=='')this.value='username';" onfocus="if(this.value=='username')this.value='';" value="username" />
        <input id="password" name="password" type="password" onblur="if(this.value=='')this.value='password';" onfocus="if(this.value=='password')this.value='';" value="password" />
    </fieldset>
    <fieldset id="actions">

		<input type="submit" id="submit" name="login" value="login">
       
	   </fieldset>
	  	<center> <div class="note"><span></span>
		
		 <center>
  <b><font color='#C94B11'>IMPORTANT NOTE - Please Read</font></b></center><center><b><font color='#C94B11'>***************************************</font></b>
  </center><center><b><font color='white'>Do not login with same username on two PC's<br> </font></b></center>
  <center><b><font color='white'>and process items at same time.<br> </font></b>
  </center>
		
		</div></center>
</form>

</body>

</html>