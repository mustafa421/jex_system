<?php session_start();
include ("settings.php");
include ("../../../$cfg_configfile");



if (($_SERVER['SERVER_ADDR']) != $cfg_serverIP)
{

exit;
}


if(empty($cfg_language) or empty($cfg_database))
{
	echo "It appears that you have not installed Inventory Exchange Point Of Sale System, please
	go to the <a href='install/index.php'>install page</a>.";
	exit;
}


include ("language/$cfg_language");
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
	
$dbf->optimizeTables();
$dbf->closeDBlink();

?>


<HTML>
<head>
<title><?php echo $cfg_company ?>-- <?php echo $lang->poweredBy?> Inventory Exchange System</title>


<script language="JavaScript">
<!--
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
//-->
</script>

</head>

<?php if ($cfg_menulocation == "side") { ?>
<frameset border="0" frameborder="no" framespacing="0" rows="100,*">
   <frame name="TopFrame"  noresize scrolling="no" src="cssheader/header.php">

   <FRAMESET border="1" frameborder="yes" framespacing="0" COLS="12%,*">
 	  
	  <frame name="SideBarFrame"  scrolling="yes" src="verticalmenu/index.php">
	    
   <frame name="MainFrame" noresize  src="home.php">
   </FRAMESET>

   <NOFRAMES>
   <H1>Great Recipes</H1>
   No frames? No Problem! Take a look at our 
   <A HREF="recipes.html">no-frames</A> version.
   </NOFRAMES>

</FRAMESET>

<?php } ?>

<?php if ($cfg_menulocation == "top") { ?>
<frameset border="0" frameborder="no" framespacing="0" rows="100,*">
   <frame name="TopFrame"  noresize scrolling="no" src="cssheader/header.php">

   <FRAMESET   border="1" frameborder="no" framespacing="0" ROWS="7%,*">


		  <frame name="SideBarFrame" scrolling="yes" src="horizontalmenu/index.php">
		
		 
      <frame name="MainFrame" noresize  src="home.php">
   </FRAMESET>

   <NOFRAMES>
   <H1>Great Recipes</H1>
   No frames? No Problem! Take a look at our 
   <A HREF="recipes.html">no-frames</A> version.
   </NOFRAMES>

</FRAMESET>
  
<?php } ?>



<?php if ($cfg_menulocation == "header") { ?>
<frameset border="0" frameborder="no" framespacing="0" rows="100,*">
   <frame name="TopFrame"  noresize scrolling="no" src="cssheader/header.php">

    <FRAMESET   border="1" frameborder="no" framespacing="0" ROWS="7%,*">
     
      <frame name="SideBarFrame" scrolling="yes" src="horizontalmenu/index.php">
	  
      <frame name="MainFrame" noresize  src="home.php">
   </FRAMESET>

   <NOFRAMES>
   <H1>Great Recipes</H1>
   No frames? No Problem! Take a look at our 
   <A HREF="recipes.html">no-frames</A> version.
   </NOFRAMES>

</FRAMESET>

<?php } ?>

</HTML>