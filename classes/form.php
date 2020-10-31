<?php

class form
{
	var $row_color,$text_color;
	var $lang;
	
	function form($form_validation,$form_action,$form_method,$form_name,$table_width,$theme,$language)
	{

		
		

		$this->lang=$language;
		$getType=explode('_',$form_action);
		$type=$getType[0];
		
		
		if($type=='manage' || $type=='viewallstore') 
		{
			$url=$_SERVER['PHP_SELF'];
			
			if(isset($_POST['search']) or isset($_GET['outofstock']) or isset($_GET['reorder']) or isset($_GET['zeroprice']))
			{
			        $fullurl=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			        $phpfilename = substr($fullurl, -20);    

			     if ($phpfilename == "manage_suppliers.php"){
				       echo "<center><a href='$url'><img src=\"../../je_images/btgray_clear_search.png\" onmouseover=\"this.src='../../je_images/btgray_clear_search_MouseOver.png';\" onmouseout=\"this.src='../../je_images/btgray_clear_search.png';\" BORDER='0'></a></center>";
			     }else{
			         echo "<center><a href='$url'><img src=\"../je_images/btgray_clear_search.png\" onmouseover=\"this.src='../je_images/btgray_clear_search_MouseOver.png';\" onmouseout=\"this.src='../je_images/btgray_clear_search.png';\" BORDER='0'></a></center>";
			     }	
			}
			
			echo "<form onsubmit='$form_validation' action='$form_action' method='$form_method' name='$form_name' enctype='multipart/form-data'> 
			<center>\n<table border='0' width='$table_width' cellspacing='2' cellpadding='0'>";
		}
	 	else
	 	{
	 		echo "<form onsubmit='$form_validation' action='$form_action' method='$form_method' name='$form_name' enctype='multipart/form-data'> 
			<center><b>*{$this->lang->itemsInBoldRequired}</b>\n<table border='0' width='$table_width' cellspacing='2' cellpadding='0'>";
		}
		
		switch($theme)
		{
			
			case $theme=='serious':
				$this->row_color='#DDDDDD';
				$this->text_color='black';
				
			break;
			
			case $theme=='big blue':
				$this->row_color='#15759B';
				$this->text_color='white';
				
			break;
		}
	}
	
	function formBreak ($table_width,$theme)
	{
		
	 	{
	 		echo "<table border='0' width='$table_width' cellspacing='2' cellpadding='0'>";
		}
		
		switch($theme)
		{
			
			case $theme=='serious':
				$this->row_color='#DDDDDD';
				$this->text_color='black';
				
			break;
			
			case $theme=='big blue':
				$this->row_color='#15759B';
				$this->text_color='white';
				
			break;
		}
	}


	function createInputField($field_title,$input_type,$input_name,$input_value,$input_size,$td_width,$checked)
	{
		
		
		
			
		echo"
		<tr bgcolor=$this->row_color>
		<td width='$td_width'><font size=\"2\" color='$this->text_color'>$field_title</font></td>
		<td><input type='$input_type' name='$input_name' value='$input_value' size='$input_size' $checked></td>
		</tr>\n";
			
	}
	
	
	function createSelectField($field_title,$select_name,$option_values,$option_titles,$td_width,$onchange)
	{
		
		
		
		echo "
		<tr bgcolor=$this->row_color>
		<td width='$td_width'><font size=\"2\" color='$this->text_color'>$field_title</font></td>
		<td><select name='$select_name' $onchange> ";
		
		if($option_values[0]!='')
		{
			echo"<option selected value=\"$option_values[0]\">$option_titles[0]</option>";
		}
		for($k=1;$k< count($option_values); $k++)
		{
			if($option_values[$k]!=$option_values[0] )
			{
				echo "
				<option value='$option_values[$k]'>$option_titles[$k]</option>"; 
			}			
		}
		
		echo '</select>
		</td>
		</tr>'."\n";
			
	}
	
	
	function createDateSelectField()
	{
		?>
			<tr bgcolor=<?php echo $this->row_color ?> ><td><b><font color=<?php echo $this->text_color ?>><?php echo" {$this->lang->fromMonth}"; ?>:</font></b> <select name=month1>
		<?php
		for($k=1;$k<=12;$k++)
			if($k==date("n"))
				echo "<option selected value=\"".$k."\">".date("M",mktime(0,0,0,$k,1,0))."</option>";	
			else
				echo "<option value=\"".$k."\">".date("M",mktime(0,0,0,$k,1,0))."</option>";
		?>
			</select></td>
		    <td><b><font color=<?php echo $this->text_color ?>><?php echo" {$this->lang->day}"; ?>:</font></b> <select name=day1>
		<?php
		for($k=1;$k<=31;$k++)
			if($k==date("j"))
				echo "<option selected value=\"".$k."\">".$k."</option>";
			else
				echo "<option value=\"".$k."\">".$k."</option>";
		?>
			</select></td>
		    <td><b><font color=<?php echo $this->text_color ?>><?php echo" {$this->lang->year}"; ?>:</font></b> <select name=year1>
		<?php
		for($k=2003;$k<=date("Y");$k++)
			if($k==date("Y"))
				echo "<option selected value=\"".$k."\">".$k."</option>";
			else
				echo "<option value=\"".$k."\">".$k."</option>";
		?>
			</select></td>
		    <td><b><font color=<?php echo $this->text_color ?>><?php echo" {$this->lang->toMonth}"; ?>:</font> <select name=month2>
		<?php
		for($k=1;$k<=12;$k++)
			if($k==date("n"))
				echo "<option selected value=\"".$k."\">".date("M",mktime(0,0,0,$k,1,0))."</option>";	
			else
				echo "<option value=\"".$k."\">".date("M",mktime(0,0,0,$k,1,0))."</option>";
		?>	
			</select></td>
    		<td><b><font color=<?php echo $this->text_color ?>><?php echo" {$this->lang->day}"; ?>:</font></b> <select name=day2>
		<?php
		for($k=1;$k<=31;$k++)
			if($k==date("j"))
				echo "<option selected value=\"".$k."\">".$k."</option>";
			else
				echo "<option value=\"".$k."\">".$k."</option>";
		?>	
		</select></td>
    	<td><b><font color=<?php echo $this->text_color ?>><?php echo" {$this->lang->year}"; ?>:</font></b> <select name=year2>
	<?php
		for($k=2003;$k<=date("Y");$k++)
		if($k==date("Y"))
			echo "<option selected value=\"".$k."\">".$k."</option>";
		else
			echo "<option value=\"".$k."\">".$k."</option>";
		?>
		</select></td></tr>
		<?php
	}
	
	function createDateSelectFieldModfied()
	{
		?>
			<tr bgcolor=AEB8B8 ><td><b><font size=2 color=<?php echo $this->text_color ?>><?php echo" {$this->lang->fromMonth}"; ?>:</font></b> <select name=month1>

			<?php
		for($k=1;$k<=12;$k++)
			if($k==date("n"))
				echo "<option selected value=\"".$k."\">".date("M",mktime(0,0,0,$k,1,0))."</option>";	
			else
				echo "<option value=\"".$k."\">".date("M",mktime(0,0,0,$k,1,0))."</option>";
		?>
			</select></td>
		    <td><b><font size=2 color=<?php echo $this->text_color ?>><?php echo" {$this->lang->day}"; ?>:</font></b> <select name=day1>
		<?php
		for($k=0;$k<=31;$k++)

			 
				echo "<option value=\"".$k."\">".$k."</option>";
		?>
			</select></td>
		    <td><b><font size=2 color=<?php echo $this->text_color ?>><?php echo" {$this->lang->year}"; ?>:</font></b> <select name=year1>
		<?php
		for($k=2003;$k<=date("Y");$k++)
			if($k==date("Y"))
				echo "<option selected value=\"".$k."\">".$k."</option>";
			else
				echo "<option value=\"".$k."\">".$k."</option>";
		?>
			</select></td>
		    <td><b><font size=2 color=<?php echo $this->text_color ?>><?php echo" {$this->lang->toMonth}"; ?>:</font> <select name=month2>
		<?php
		for($k=1;$k<=12;$k++)
			if($k==date("n"))
				echo "<option selected value=\"".$k."\">".date("M",mktime(0,0,0,$k,1,0))."</option>";	
			else
				echo "<option value=\"".$k."\">".date("M",mktime(0,0,0,$k,1,0))."</option>";
		?>	
			</select></td>
    		<td><b><font size=2 color=<?php echo $this->text_color ?>><?php echo" {$this->lang->day}"; ?>:</font></b> <select name=day2>
		<?php
		for($k=0;$k<=31;$k++)

				echo "<option value=\"".$k."\">".$k."</option>";
		?>	
		</select></td>
    	<td><b><font size=2 color=<?php echo $this->text_color ?>><?php echo" {$this->lang->year}"; ?>:</font></b> <select name=year2>
	<?php
		for($k=2003;$k<=date("Y");$k++)
		if($k==date("Y"))
			echo "<option selected value=\"".$k."\">".$k."</option>";
		else
			echo "<option value=\"".$k."\">".$k."</option>";
		?>
		</select></td></tr>
		<?php
	}
	
	function createTextareaField($field_title,$textarea_name,$textarea_rows,$textarea_cols,$textarea_value,$td_width)
	{
		
		
				
		echo "
		<tr bgcolor=$this->row_color>
		<td width='$td_width' valign='top'><font size=\"2\" color='$this->text_color'>$field_title</font></td>
		<td><textarea name='$textarea_name' rows='$textarea_rows' cols='$textarea_cols'>$textarea_value</textarea>"; 		
	}
	
	function endForm()
	{
		
		
		echo '
		<tr>
		<td colspan=2 align=center><input name=Submit type=submit value=Submit></td>
		</tr>
	</table>
  </center>
</form>';
	}



}
?>