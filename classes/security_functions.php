<?php

class security_functions
{	
	var $conn;
	var $lang;
	var $tblprefix;
	
	
	function security_functions($dbf,$page_type,$language)
	{
		
		
		
		
		
		
		
		
		$this->conn=$dbf->conn;
		$this->lang=$language;
		$this->tblprefix=$dbf->tblprefix;
		
		if(isset($_SESSION['session_user_id']))
		{
			$user_id=$_SESSION['session_user_id'];
			
			$tablename="$this->tblprefix".'users';
			$result = mysql_query ("SELECT * FROM $tablename WHERE id=\"$user_id\"",$this->conn);
			$row = mysql_fetch_assoc($result);
			$usertype= $row['type'];
			
			
			
			if($page_type!='Public' or $usertype!='Admin')
			{
				if($usertype!='Admin' and $usertype!='Sales Clerk' and $usertype!='Report Viewer')
				{
					

					echo "{$this->lang->attemptedSecurityBreech}";
					exit();
				}
				elseif($page_type!='Public' and $page_type!='Admin' and $page_type!='Sales Clerk' and $page_type!='Report Viewer')
				{
					

					echo "{$this->lang->attemptedSecurityBreech}";				
					exit();
				
				}
				elseif($usertype!='Admin' and $page_type=='Admin')
				{
					

					echo "{$this->lang->mustBeAdmin}";				
					exit();	
				}
				elseif(($usertype=='Sales Clerk') and $page_type =='Report Viewer')
				{
					
					
					echo "{$this->lang->mustBeReportOrAdmin}";				
					exit();
				}
				elseif(($usertype=='Report Viewer') and $page_type =='Sales Clerk')
				{
					
					
					echo "{$this->lang->mustBeSalesClerkOrAdmin}";				
					exit();
				}
			}
		}
	}
	
	function isLoggedIn()
	{
		
		
		if(isset($_SESSION['session_user_id']))
		{
			$user_id=$_SESSION['session_user_id'];
			$tablename="$this->tblprefix".'users';
			$result = mysql_query ("SELECT * FROM $tablename WHERE id=\"$user_id\"",$this->conn);
			$num = @mysql_num_rows($result);
			if($num> 0)
			{
				return true;
			}
			else
			{
			
				return false;
			}
		}
		return false;
	}
	
	function checkLogin($username,$password)
	{
		
		
		
		$tablename="$this->tblprefix".'users';
		$result = mysql_query ("SELECT * FROM $tablename WHERE username=\"$username\" and password=\"$password\"",$this->conn);	
		$num = @mysql_num_rows($result);
		
		if($num > 0)
		{
			return true;
		}
		
		return false;
	}

	function closeSale()
	{
		
		session_unregister('items_in_return');
		session_unregister('items_in_sale'); 
    	session_unregister('current_sale_customer_id'); 
    	session_unregister('current_item_search'); 
    	session_unregister('current_customer_search'); 

	}
}

?>