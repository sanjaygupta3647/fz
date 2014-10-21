<?php
class DAL {  
	//public function __construct(){} 
	private $var;
	public $catarr=0;
 	public function connect_db() {
		global $ARR_CFGS;
		if (!isset($GLOBALS['dbcon'])) {
			$GLOBALS['dbcon'] =	mysql_connect($ARR_CFGS["db_host"], $ARR_CFGS["db_user"], $ARR_CFGS["db_pass"]);
			mysql_select_db($ARR_CFGS["db_name"]) or die("Could not connect to database. Please check configuration and ensure MySQL is running.");
		}
	}
	public function db_query_($sql, $dbcon2 = null) {
		if($dbcon2=='') {
			if(!isset($GLOBALS['dbcon'])) {
				$this->connect_db();
			}
			$dbcon2	= $GLOBALS['dbcon'];
		}
		$time_before_sql = $this->checkpoint();
		$result	= mysql_query($sql,	$dbcon2) or	die($this->db_error($sql));
		return $result;
	}
	
	public function db_query($sql, $dbcon2 = null) {
		$sql = str_replace("#_", tb_Prefix, $sql);
		if($dbcon2=='') {
			if(!isset($GLOBALS['dbcon'])) {
				$this->connect_db();
			}
			$dbcon2	= $GLOBALS['dbcon'];
		}
		$time_before_sql = $this->checkpoint();
		$result	= mysql_query($sql,	$dbcon2) or	die($this->db_error($sql));
		return $result;
	}
	
	public function db_fetch_array($rs) {
		$array	= mysql_fetch_array($rs);
		return $array;
	}
	
	
	public function db_scalar($sql, $dbcon2 = null) {
		if($dbcon2=='') {
			if(!isset($GLOBALS['dbcon'])) {
				$this->connect_db();
			}
			$dbcon2	= $GLOBALS['dbcon'];
		}
		$result	= $this->db_query($sql, $dbcon2);
		if ($line =	$this->db_fetch_array($result)) {
			$response =	$line[0];
		}
		return $response;
	}
	
	
	public function getSingleresult($sql, $dbcon2 = null) {
		if($dbcon2=='') {
			if(!isset($GLOBALS['dbcon'])) {
				$this->connect_db();
			}
			$dbcon2	= $GLOBALS['dbcon'];
		}
		$result	=$this->db_query($sql, $dbcon2);
		if ($line =	$this->db_fetch_array($result)) {
			$response =	$line[0];
		}
		return $response;
	}
	public function sqlquery_($rs='exe',$tablename,$arr,$update='',$id='',$update2='',$id2='') {
	
		$sql = $this->db_query_("DESC $tablename");
		$row = mysql_fetch_array($sql);
		if($update == '')
			$makesql = "insert into ";
		else
			$makesql = "update " ;
		$makesql .= "$tablename set ";
	
		$i = 1;
		while($row = mysql_fetch_array($sql)) {
			if(array_key_exists($row['Field'], $arr)) {
	
	
				if($i != 1)
					$makesql .= ", ";
	
				//$makesql .= $row['Field']."='".$this->ms_addslashes((is_array($arr[$row['Field']]))?implode(":",$arr[$row['Field']]):$arr[$row['Field']])."'";
				
				$makesql .= $row['Field']."='".addslashes((is_array($arr[$row['Field']]))?implode(":",$arr[$row['Field']]):$arr[$row['Field']])."'";
				
				
				$i++;
			}
	
		}
		if($update)
			$makesql .= " where ".$update."='".$id."'".(($update2 && $id2)?" and ".$update2."='".$id2."'":"");
		if($rs == 'show') {
			echo $makesql;
			exit;
		}
		else {
			$this->db_query_($makesql);
		}
		return ($update)?$id:mysql_insert_id();
	}
	
	public function sqlquery($rs='exe',$tablename,$arr,$update='',$id='',$update2='',$id2='') {
	
		$sql = $this->db_query("DESC ".tb_Prefix."$tablename");
		$row = mysql_fetch_array($sql);
		if($update == '')
			$makesql = "insert into ";
		else
			$makesql = "update " ;
		$makesql .= tb_Prefix."$tablename set ";
	
		$i = 1;
		while($row = mysql_fetch_array($sql)) {
			if(array_key_exists($row['Field'], $arr)) {
	
	
				if($i != 1)
					$makesql .= ", ";
	
				//$makesql .= $row['Field']."='".$this->ms_addslashes((is_array($arr[$row['Field']]))?implode(":",$arr[$row['Field']]):$arr[$row['Field']])."'";
				
				$makesql .= $row['Field']."='".addslashes((is_array($arr[$row['Field']]))?implode(":",$arr[$row['Field']]):$arr[$row['Field']])."'";
				
				
				$i++;
			}
	
		}
		if($update)
			$makesql .= " where ".$update."='".$id."'".(($update2 && $id2)?" and ".$update2."='".$id2."'":"");
		if($rs == 'show') {
			echo $makesql;
			exit;
		}
		else {
			$this->db_query($makesql);
		}
		return ($update)?$id:mysql_insert_id();
	}
	public function filequery($rs='exe',$tablename,$foldername,$arr,$update='',$id='',$update2='',$id2='') {
		$sp = array_keys($arr);
		$aa = "";
		for($c=0;$c<=(count($sp)-1);$c++) {
			if($arr[$sp[$c]]['name']) {
				$path = $this->bannerup($foldername);
				$sql = $this->db_query("DESC ".tb_Prefix."$tablename");
				$row = mysql_fetch_array($sql);
				if($update == '')
					$makesql = "insert into ";
				else
					$makesql = "update " ;
				$makesql .= tb_Prefix."$tablename set ";
	
				$i = 1;
				while($row = mysql_fetch_array($sql)) {
	
					if($row['Field'] == $sp[$c]) {
						$filename =$this-> uploadFile1($path,$arr[$row['Field']]['name'],$row['Field']);
						if($i != 1)
							$makesql .= ", ";
	
						//$makesql .= $row['Field']."='".$this->ms_addslashes($filename)."'";
						$makesql .= $row['Field']."='".addslashes($filename)."'";
						$i++;
					}
	
				}
				if($update)
					$makesql .= " where ".$update."='".$id."'".(($update2 && $id2)?" and ".$update2."='".$id2."'":"");
				if($rs == 'show') {
					echo $makesql;
					exit;
				}
				else {
					$this->db_query($makesql);
				}
				return ($update)?$id:mysql_insert_id();
			}
		}
	}
	
	public function getSingleresult_($sql, $dbcon2 = null) {
		if($dbcon2=='') {
			if(!isset($GLOBALS['dbcon'])) {
				$this->connect_db();
			}
			$dbcon2	= $GLOBALS['dbcon'];
		}
		$result	=$this->db_query_($sql, $dbcon2);
		if ($line =	$this->db_fetch_array($result)) {
			$response =	$line[0];
		}
		return $response;
	}
	
	
	public function db_error($sql) {
		echo "<div style='font-family: tahoma; font-size: 11px; color: #333333'><br>".mysql_error()."<br>";
		$this->print_error();
		if(LOCAL_MODE) {
			echo "<br>sql: $sql";
		}
		echo "</div>";
	}
	
	public function print_error() {
		$debug_backtrace = debug_backtrace();
		for ($i = 1; $i < count($debug_backtrace); $i++) {
			$error = $debug_backtrace[$i];
			echo "<br><div><span>File:</span> ".str_replace(SITE_FS_PATH, '',$error['file'])."<br><span>Line:</span> ".$error['line']."<br><span>Function:</span> ".$error['function']."<br></div>";
		}
	}
	
	
	public function mysql_time($hour, $minute,	$ampm) {
		if ($ampm == 'PM' && $hour != '12') {
			$hour += 12;
		}
		if ($ampm == 'AM' && $hour == '12') {
			$hour =	'00';
		}
		$mysql_time	= $hour	. ':' .	$minute	. ':00';
		return $mysql_time;
	}
	
	
	public function price_format($price) {
		if ($price != '' &&	$price != '0') {
			$price = number_format($price, 0); 
			return CUR.$price;
		}
	}
	
	
	public function opin_date_format($date) {
		if (strlen($date) >= 10) {
			if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
				return '';
			}
			$mktime	= mktime(0,	0, 0, substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
			return date("M j, Y", $mktime);
		} else {
			return $s;
		}
	}
	public function dateshow($time,$format='F j,Y'){
		return date($format,$time);
	}
	
	
	public function datetime_format($date) {
		global $arr_month_short;
		if (strlen($date) >= 10) {
			if ($date == '0000-00-00 00:00:00' || $date	== '0000-00-00') {
				return '';
			}
			$mktime	= mktime(substr($date, 11, 2), substr($date, 14, 2), substr($date, 17, 2),substr($date,	5, 2), substr($date, 8,	2),	substr($date, 0, 4));
			return date("M j, Y h:i A ", $mktime);
		} else {
			return $s;
		}
	}
	
	
	public function time_format($time) {
		if (strlen($time) >= 5) {
			$hour =	substr($time, 0, 2);
			$hour =	str_pad($hour, 2, "0", STR_PAD_LEFT);
	
			return $hour . ':' . substr($time, 3, 2) . ' ' . $ampm;
		} else {
			return $s;
		}
	}
	
	
	public function ms_print_r($var) {
		//if(LOCAL_MODE || $_SESSION['debug']){
		echo "<textarea rows='10' cols='148' style='font-size: 11px; font-family: tahoma'>";
		print_r($var);
		echo "</textarea>";
		//}
	}
	
	
	public function ms_form_value($var) {
		return is_array($var) ? array_map('ms_form_value', $var) : htmlspecialchars(stripslashes(trim($var)));
	}
	
	
	public function ms_display_value($var) {
		return is_array($var) ? array_map('ms_display_value', $var) : nl2br(htmlspecialchars(stripslashes(trim($var))));
	}
	
	public function ms_adds($var) {
		return trim(addslashes(stripslashes($var)));
	}
	
	
	public function ms_stripslashes($var) {
		return is_array($var) ? array_map('ms_stripslashes', $var) : stripslashes(trim($var));
	}
	
	
	public function ms_addslashes($var) {
		//return is_array($var) ? array_map('ms_addslashes', $var) : addslashes(stripslashes(trim($var)));
		//return addslashes(stripslashes(trim($var)));
	}
	
	
	public function ms_trim($var) {
		return is_array($var) ? array_map('ms_trim', $var) : trim($var);
	}
	
	public function is_image_valid($file_name) {
		global $ARR_VALID_IMG_EXTS;
		$ext = file_ext($file_name);
		if (in_array($ext, $ARR_VALID_IMG_EXTS)) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function getmicrotime() {
		list($usec,	$sec) =	explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	
	
	public function file_ext($file_name) {
		$path_parts = pathinfo($file_name);
		$ext = strtolower($path_parts["extension"]);
		return $ext;
	}
	
	
	public function blank_filter($var) {
		$var = trim($var);
		return ($var != '' && $var != '&nbsp;');
	}
	
	
	public function apply_filter($sql,	$field,	$field_filter, $column) {
		if (!empty($field)) {
			if ($field_filter == "=" || $field_filter == "") {
				$sql = $sql	. "	and	$column	= '$field' ";
			} else if ($field_filter == "like") {
				$sql = $sql	. "	and	$column	like '%$field%'	";
			} else if ($field_filter ==	"starts_with") {
				$sql = $sql	. "	and	$column	like '$field%' ";
			} else if ($field_filter ==	"ends_with") {
				$sql = $sql	. "	and	$column	like '%$field' ";
			} else if ($field_filter ==	"not_contains") {
				$sql = $sql	. "	and	$column	not	like '%$field%'	";
			} else if ($field_filter == ">") {
				$sql = $sql . " and $column > '$field' ";
			} else if ($field_filter == "<") {
				$sql = $sql . " and $column < '$field' ";
			} else if ($field_filter ==	"!=") {
				$sql = $sql	. "	and	$column	!= '$field'	";
			}
		}
		return $sql;
	}
	
	public function filter_dropdown($name	= 'filter',	$sel_value) {
		$arr = array( "like" => 'Contains', '=' => 'Is', "starts_with" => 'Starts with', "ends_with"	=> 'Ends with', "!=" => 'Is not' , "not_contains" => 'Not contains');
		return $this->array_dropdown($arr, $sel_value, $name);
	}
	
	
	public function move_up($table_name, $where_clause_all, $where_clause_item, $sort_order, $move_by) {
		$dest_order	= $sort_order -	$move_by;
		// $arr_ids_to_move=Array();
		// echo	"<br>$movie_artist_id, $movie_id, $artistcate_id, $sort_order, $move_by, $dest_order<br>";
		for($i = $sort_order-1;	$i > $dest_order-1;	$i--) {
			$sql = " update	$table_name	set	sort_order=sort_order+1	where $where_clause_all	and	sort_order='$i'";
			// echo	"<br>$sql<br>";
			$this->db_query($sql);
		}
		$sql = " update	$table_name	set	sort_order=sort_order-$move_by where $where_clause_item";
		// echo	"<br>$sql<br>";
		$this->db_query($sql);
	}
	
	
	public function move_down($table_name,	$where_clause_all, $where_clause_item, $sort_order,	$move_by) {
		$dest_order	= $sort_order +	$move_by;
		// $arr_ids_to_move=Array();
		// echo	"<br>$movie_artist_id, $movie_id, $artistcate_id, $sort_order, $move_by, $dest_order<br>";
		for($i = $sort_order + 1; $i < $dest_order + 1;	$i++) {
			$sql = " update	$table_name	set	sort_order=sort_order-1	where $where_clause_all	and	sort_order='$i'	";
			// echo	"<br>$sql<br>";
			$this->db_query($sql);
		}
		$sql = " update	$table_name	set	sort_order=sort_order+$move_by where $where_clause_item";
		// echo	"<br>$sql<br>";
		$this->db_query($sql);
	}
	
	// refine_list: Updated 31 may 2006
	public function refine_list($id_column, $table_name, $where_clause) {
		$sql = " select	$id_column,	sort_order from	$table_name	where $where_clause	order by sort_order";
		// echo	"<br>$sql<br>";
		$result	= $this->db_query($sql);
		$i = 1;
		while ($line = mysql_fetch_array($result)) {
			$sql = " update	$table_name	set	sort_order='$i'	where $id_column='$line[0]'";
			// echo	"<br>$sql<br>";
			$this->db_query($sql);
			$i++;
		}
	}
	
	
	public function make_url($url) {
		$parsed_url	= parse_url($url);
		if ($parsed_url['scheme'] == '') {
			return 'http://' . $url;
		} else {
			return $url;
		}
	}
	
	public function url($url, $dir='') {
		return SITE_PATH.(($dir)?$dir."/":'').$url.".html";
	}
	public function folder($url) {
		//$bodytag = str_replace(" ", "-", strtolower($url));
		//$bodytag = str_replace(" ", "-", $url);
		return $url;
	}
	public function onclickurl($url, $dir='') {
		return "onClick=\"location.href='".SITE_PATH.(($dir)?$dir."/":'').$url.".html'\"";
	}
	
	public function url2($url, $dir='') {
		return SITE_PATH.(($dir)?$dir."/":'').$url;
	}
	public function ms_mail($to, $subject, $message, $arr_headers= array()) {
		$str_headers = '';
		foreach($arr_headers as $name=>$value) {
			$str_headers .= "$name: $value\n";
		}
		@mail($to, $subject, $message, $str_headers);
		return true;
	}
	
	// make_thumb_im
	public function make_thumb_im($file_path, $arr_options) {
		$width		= $arr_options['width'];
		$height		= $arr_options['height'];
		$prefix		= $arr_options['prefix'];
		$target_dir	= $arr_options['target_dir'];
		$quality	= $arr_options['quality'];
	
		$path_parts = pathinfo($file_path);
	
		if($width=='') {
			$width = '120';
		}
	
		if($prefix=='') {
			$prefix = 'thumb_';
		}
		if($target_dir=='') {
			$target_dir = $path_parts["dirname"];
		}
	
		if($quality=='') {
			$quality = '70';
		}
	
		$size = @getimagesize($file_path);
		if($size=='') {
			return false;
		}
		$path_parts = pathinfo($file_path);
	
		$thumb_path="$target_dir/".$prefix.$path_parts["basename"];
	
		$cmd ="convert -resize ".$width.'x'." -quality $quality \"$file_path\" \"$thumb_path\" ";
		system($cmd);
		//echo("<br>$cmd");
		return $prefix.$path_parts["basename"];
	}
	
	
	public function date_to_mysql($date) {
		list($month, $day, $year) = explode('/', $date);
		return "$year-$month-$day";
	}
	
	
	public function export_delimited_file($sql, $arr_columns, $file_name='', $arr_substitutes='', $arr_tpls='' ) {
		if($file_name=='') {
			$file_name = time().'.txt';
		}
		header("Content-type: application/txt");
		header("Content-Disposition: attachment; filename=$file_name");
		$arr_db_cols= array_keys($arr_columns);
		$arr_headers= array_values($arr_columns);
		$str_columns = implode(',', $arr_db_cols);
		$sql= "select ".$str_columns." $sql" ;
	
		$result = $this->db_query($sql);
		$num_cols = count($arr_columns);
		//$i=0;
	
		foreach($arr_headers as $header) {
			//$i++;
			echo $header."\t";
			//if($i!=$num_cols){
			//	echo "\t";
			//}
		}
		while($line=mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "\r\n";
			//echo("<br> ");
			foreach($line as $key => $value) {
				$value=str_replace("\n","",$value);
				$value=str_replace("\r","",$value);
				$value=str_replace("\t","",$value);
				if(is_array($arr_substitutes[$key])) {
					$value = $arr_substitutes[$key][$value];
				}
				if(isset($arr_tpls[$key])) {
					$code = str_replace('{1}', $value, $arr_tpls[$key]);
					//echo ("\$value = $code;");
					//echo("<br>");
					eval ("\$value = $code;");
				}
				echo $value."\t";
			}
		}
	}
	
	// to check how much time is lapsed before first call of this public function
	public function checkpoint($from_start = false) {
		global $PREV_CHECKPOINT;
		if($PREV_CHECKPOINT=='') {
			$PREV_CHECKPOINT = SCRIPT_START_TIME;
		}
		$cur_microtime = $this->getmicrotime();
	
		if($from_start) {
			return $cur_microtime - SCRIPT_START_TIME;
		} else {
			$time_taken = $cur_microtime - $PREV_CHECKPOINT;
			$PREV_CHECKPOINT = $cur_microtime;
			return $time_taken;
		}
	}
	
	
	public function readable_col_name($str) {
		return ucwords( str_replace('_', ' ', strtolower($str) ) );
	}
	
	
	public function ms_echo($str) {
		if(LOCAL_MODE) {
			echo($str);
		}
	}
	
	
	public function make_dropdown($sql, $sel_value =	'',	$combo_name, $extra = '', $choose_one = '') {
	
		$result	= $this->db_query($sql);
		if (mysql_num_rows($result)	> 0) {
			$str_dropdown = "<select name='$combo_name' id='$combo_name' $extra>";
			if(is_array($choose_one)) {
				foreach($choose_one as $key => $value) {
					$str_dropdown .= "<option value='$key '>$value</option>";
				}
			} else if ($choose_one	!= '') {
				$str_dropdown .= "<option value=''>$choose_one</option>";
			}
			while	($line = mysql_fetch_array($result)) {
				// if($css== "opt1"){ $css='opt2';}else{$css='opt1';};
				$str_dropdown .= "<option value=\"" . $this->ms_form_value($line[0]) . "\"";
				if(is_array($sel_value)) {
					if (in_array($line[0], $sel_value )) {
						$str_dropdown .= " selected ";
					}
				} else {
					if (trim($sel_value) == $line[0]) {
						$str_dropdown .= " selected='selected' ";
					} else {
						$str_dropdown .= "";
					}
				}
				$str_dropdown .= ">" .	$line[1] . "</option>";
			}
			$str_dropdown .= "</select>";
		}
		return $str_dropdown;
	}
	
	
	public function array_dropdown( $arr, $sel_value='', $name='', $extra='', $choose_one='', $arr_skip= array()) {
		$combo="<select name='$name' id='$name' $extra >";
		if($choose_one!='') {
			$combo.="<option value=\"\">$choose_one</option>";
		}
		foreach($arr as $key => $value) {
			if(is_array($arr_skip) && in_array($key, $arr_skip)) {
				continue;
			}
			$combo.='<option value="'.htmlspecialchars($key).'"';
			if(is_array($sel_value)) {
				if(in_array($key, $sel_value) || in_array(htmlspecialchars($key), $sel_value)) {
					$combo.=" selected ";
				}
			} else {
				if($sel_value==$key || $sel_value==htmlspecialchars($key)) {
					$combo.=" selected ";
				}
			}
			$combo.=" >$value</option>";
		}
		$combo.=" </select>";
		return $combo;
	}
	public function make_checkboxes($arr_tmp, $checkname, $checksel = '', $cols,	$missit, $style	= '', $tableattr = '') {
		if ($style != "") {
			$style = "class='" . $style	. "'";
		}
	
		$colwidth =	100	/ $cols;
		$colwidth =	round($colwidth, 2);
		$j = 0;
		/*
		$arr_tmp['Any']="Any";
		if($checksel==''){
			$checksel=Array("Any");
		}
		*/
		if(is_array($arr_tmp) && count($arr_tmp)) {
			foreach($arr_tmp as	$key =>	$value) {
				$tochecked = "";
				if (is_array($checksel)	&& in_array($key, $checksel)) {
					$tochecked = "checked";
				}
				if ($key !=	$missit) {
					if ($value != "") {
						if ($j == 0) {
							$checkstr .= "<table $tableattr><tr>\n";
						} else if (($j % $cols)	== 0) {
							$checkstr .= "</tr><tr>\n";
						}
						$checkstr .= "<td valign=top><INPUT TYPE='checkbox' $javascript	 NAME='$checkname" . '[]' .	"' value='$key'	$tochecked ></td><td $style nowrap> $value	</td>\n";
						$j++;
					}
				}
			}
			$j--;
			// echo	"$cols-($j%$cols)=".$cols-($j%$cols);
			// echo	"<BR>($j%$cols)=".($j%$cols);
			for($x = $j	% $cols;$x < 4;$x++) {
				if ($x != 3) {
					$checkstr .= "<td>&nbsp;</td>\n";
				} else {
					$checkstr .= "<td>&nbsp;</td></tr>\n";
				}
			}
			$checkstr .= "</table>";
		}
		return $checkstr;
	}
	
	
	public function make_radios($arr_tmp, $checkname, $checksel = '', $cols,	$missit, $style	= '', $tableattr = '') {
		if ($style != "") {
			$style = "class='" . $style	. "'";
		}
	
		$colwidth =	100	/ $cols;
		$colwidth =	round($colwidth, 2);
		$j = 1;
		/*
		$arr_tmp['Any']="Any";
		if($checksel==''){
			$checksel=Array("Any");
		}
		*/
		foreach($arr_tmp as	$key =>	$value) {
			$tochecked = "";
			if ($checksel == $key) {
				$tochecked = "checked";
			}
			if ($key !=	$missit) {
				if ($value != "") {
					if ($j == 1) {
						$checkstr .= "<table $tableattr><tr>\n";
					} else if (($j % $cols)	== 1) {
						$checkstr .= "</tr><tr>\n";
					}
					$checkstr .= "<td width='" . $colwidth . "%' $style	valign=top><INPUT TYPE='radio' $javascript	 NAME='$checkname' value='$key'	$tochecked	   > $value	</td>\n";
					$j++;
				}
			}
		}
		$j--;
		// echo	"$cols-($j%$cols)=".$cols-($j%$cols);
		// echo	"<BR>($j%$cols)=".($j%$cols);
		for($x = $j	% $cols;$x < 4;$x++) {
			if ($x != 3) {
				$checkstr .= "<td>&nbsp;</td>\n";
			} else {
				$checkstr .= "<td>&nbsp;</td></tr>\n";
			}
		}
		$checkstr .= "</table>";
		return $checkstr;
	}
	
	
	public function date_dropdown($pre, $selected_date = '', $start_year='', $end_year = '', $sort = 'asc') {
		$cur_date =	date("Y-m-d");
		$cur_date_day =	substr($cur_date, 8, 2);
		$cur_date_month	= substr($cur_date,	5, 2);
		$cur_date_year = substr($cur_date, 0, 4);
	
		if ($selected_date != '') {
			$selected_date_day = substr($selected_date,	8, 2);
			$selected_date_month = substr($selected_date, 5, 2);
			$selected_date_year	= substr($selected_date, 0,	4);
		}
		$date_dropdown	.= $this->month_dropdown($pre	. "month", $selected_date_month);
		$date_dropdown	.= $this->day_dropdown($pre .	"day", $selected_date_day);
		// echo($pre . "year: ". $selected_date_year);
		$date_dropdown	.= $this->year_dropdown($pre . "year", $selected_date_year, $start_year,	$end_year,	$sort);
		return $date_dropdown;
	}
	
	
	public function month_dropdown($name,	$selected_date_month = '', $extra='') {
		global $ARR_MONTHS;
	
		$date_dropdown	= "	<select	name='$name' $extra> <option value='0'>Month</option>";
		$i = 0;
		foreach ($ARR_MONTHS as $key => $value) {
			$date_dropdown	.= " <option ";
			if ($key == $selected_date_month) {
				$date_dropdown	.= " selected ";
			}
			$date_dropdown	.= " value='" .	str_pad($key, 2, "0",	STR_PAD_LEFT) .	"'>$value</option>";
		}
		$date_dropdown	.= "</select>";
		return $date_dropdown;
	}
	
	
	public function day_dropdown($name, $selected_date_day = '', $extra='') {
		$date_dropdown	.= "<select	name='$name' $extra>";
		$date_dropdown	.= "<option	value='0'>Date</option>";
		for($i = 1;$i <= 31;$i++) {
			//$s = date('S', mktime(1, 0,	0, 3, $i, 1970));
			$date_dropdown	.= " <option ";
			if ($i == $selected_date_day) {
				$date_dropdown	.= " selected ";
			}
			$date_dropdown	.= " value='" .	str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . $i .	$s . "</option>";
		}
		$date_dropdown	.= "</select>";
		return $date_dropdown;
	}
	
	
	public function year_dropdown($name, $selected_date_year = '', $start_year =	'',	$end_year = '', $extra='') {
		if ($start_year	== '') {
			$start_year	= DEFAULT_START_YEAR;
		}
	
		if ($end_year == '') {
			$end_year =	DEFAULT_END_YEAR;
		}
	
		$date_dropdown	.= "<select	name='$name' $extra>";
		$date_dropdown	.= "<option	value='0'>Year</option>";
	
		for($i = $start_year; $i <= $end_year; $i++) {
			$date_dropdown	.= " <option ";
			if ($i == $selected_date_year) {
				$date_dropdown	.= " selected ";
			}
			$date_dropdown	.= " value='" .	str_pad($i,	2, "0",	STR_PAD_LEFT) .	"'>" . str_pad($i, 2, "0", STR_PAD_LEFT) .	"</option>";
		}
		$date_dropdown	.= "</select>";
		return $date_dropdown;
	}
	
	
	public function time_dropdown($pre, $selected_time = '') {
		// echo("<br>selected_time:$selected_time");
		if ($selected_time != '' &&	$selected_time != ':') {
			$selected_hour = substr($selected_time,	0, 2);
			$selected_minute = substr($selected_time, 3, 2);
			/*
			if($selected_hour >11){
				$selected_ampm = "PM";
				$selected_hour -= 12;
			}else{
				$selected_ampm = "AM";
			}
			if($selected_hour==0){
				$selected_hour = 12;
			}
			*/
		}
		$str .= $this->hour_dropdown($pre, $selected_hour);
		$str .= '<b>:</b>';
		$str .= $this->minute_dropdown($pre, $selected_minute);
		return $str;
		// echo	"<br>$selected_hour, $selected_minute $selected_ampm <br>";
	}
	
	
	
	public function get_qry_str($over_write_key = array(),	$over_write_value =	array()) {
		global $_GET;
		$m = $_GET;
		if (is_array($over_write_key)) {
			$i = 0;
			foreach($over_write_key	as $key) {
				$m[$key] = $over_write_value[$i];
				$i++;
			}
		} else {
			$m[$over_write_key]	= $over_write_value;
		}
		$qry_str = $this->qry_str($m);
		return $qry_str;
	}
	
	
	public function qry_str($arr, $skip = '') {
		$s = "?";
		$i = 0;
		foreach($arr as	$key =>	$value) {
			if ($key !=	$skip) {
				if (is_array($value)) {
					foreach($value as $value2) {
						if ($i == 0) {
							$s .= $key . '[]=' . $value2;
							$i = 1;
						} else {
							$s .= '&' .	$key . '[]=' . $value2;
						}
					}
				} else {
					if ($i == 0) {
						$s .= "$key=$value";
						$i = 1;
					} else {
						$s .= "&$key=$value";
					}
				}
			}
		}
		return $s;
	}
	
	
	public function check_radio($s, $s2) {
		if (is_array($s2)) {
			// echo("<br>$s");
			// print_r($s2);
			if (in_array($s, $s2)) {
				return " checked ";
			}
		} else if ($s == $s2) {
			return " checked ";
		}
	}
	

	
	public function is_post_back() {
		if(count($_POST)>0) {
			return true;
		} else {
			return false;
		}
	
	}
	
	
	public function request_to_hidden($arr_skip='') {
		foreach($_REQUEST as $name => $value) {
			$s .= '<input type="hidden" name="'.$name.'" value="'.htmlspecialchars(stripslashes($value)).'">'."\n";
		}
		return $s;
	}
	
	public function sql_to_array_file($arr_name, $sql, $file, $full_table=false) {
		$str = "<?\n";
		$result = $this->db_query($sql);
		while ($line = mysql_fetch_array($result)) {
			//$line = $this->ms_addslashes($line);
			$line = addslashes($line);
			if($full_table) {
				$key = $line[0];
				foreach($line as $name=>$value) {
					if(!is_numeric($name)) {
						$str .= '$'.$arr_name."['".$key."']['".$name."'] = '".$value."';\n";
					}
				}
				$str .= "\n";
			} else {
				$str .= '$'.$arr_name."['".$line[0]."'] = '".$line[1]."';\n";
			}
		}
		$str .= "\n?>";
	
		$fh = fopen($file, 'w');
		fwrite($fh, $str);
		fclose($fh);
		return true;
	}
	
	
	public function array_radios($arr, $sel_value = '', $name = '', $cols = 3, $extra = '') {
		if ($style != "") {
			$style = "class='" . $style . "'";
		}
	
		$colwidth = 100 / $cols;
		$colwidth = round($colwidth, 2);
		$j = 1;
		foreach($arr as $key => $value) {
			$tochecked = "";
			if (is_array($sel_value) && in_array($key, $sel_value)) {
				$tochecked = "checked";
			}
			if ($key != $missit) {
				if ($value != "") {
					if ($j == 1) {
						$checkstr .= "<table $tableattr><tr>\n";
					} else if (($j % $cols) == 1 || $cols==1) {
						$checkstr .= "</tr><tr>\n";
					}
	
					$checkstr .= "<td width='" . $colwidth . "%' $style valign=top><INPUT TYPE='radio' $javascript  NAME='$name' value='$key' $tochecked     > $value </td>\n";
					$j++;
				}
			}
		}
		$j--;
		for($x = $j % $cols;$x < 4;$x++) {
			if ($x != 3) {
				$checkstr .= "<td>&nbsp;</td>\n";
			} else {
				$checkstr .= "<td>&nbsp;</td></tr>\n";
			}
		}
		$checkstr .= "</table>";
		return $checkstr;
	} 
	
	
	public function make_thumb_gd($imgPath, $destPath, $newWidth, $newHeight, $ratio_type = 'width', $quality = 70, $verbose = false) {
		$size = getimagesize($imgPath);
		if (!$size) {
			if ($verbose) {
				echo "Unable to read image info.";
			}
			return false;
		}
		$curWidth	= $size[0];
		$curHeight	= $size[1];
		$fileType	= $size[2];
	
		// width/height ratio
		$ratio =  $curWidth / $curHeight;
		$thumbRatio = $newWidth / $newHeight;
	
		$srcX = 0;
		$srcY = 0;
		$srcWidth = $curWidth;
		$srcHeight = $curHeight;
	
		if($ratio_type=='width_height') {
			$tmpWidth	= $newHeight * $ratio;
			if($tmpWidth > $newWidth) {
				$ratio_type='width';
			} else {
				$ratio_type='height';
			}
		}
	
	
		if($ratio_type=='width') {
			// If the dimensions for thumbnails are greater than original image do not enlarge
			if($newWidth > $curWidth) {
				$newWidth = $curWidth;
			}
			$newHeight	= $newWidth / $ratio;
		} else if($ratio_type=='height') {
			// If the dimensions for thumbnails are greater than original image do not enlarge
			if($newHeight > $curHeight) {
				$newHeight = $curHeight;
			}
			$newWidth	= $newHeight * $ratio;
		} else if($ratio_type=='crop') {
			if($ratio < $thumbRatio) {
				$srcHeight = round($curHeight*$ratio/$thumbRatio);
				$srcY = round(($curHeight-$srcHeight)/2);
			} else {
				$srcWidth = round($curWidth*$thumbRatio/$ratio);
				$srcX = round(($curWidth-$srcWidth)/2);
			}
		} else if($ratio_type=='distort') {
		}
	
		// create image
		switch ($fileType) {
			case 1:
				if (function_exists("imagecreatefromgif")) {
					$originalImage = imagecreatefromgif($imgPath);
				} else {
					if ($verbose) {
						echo "GIF images are not support in this php installation.";
						return false;
					}
				}
				$fileExt = 'gif';
				break;
			case 2:
				$originalImage = imagecreatefromjpeg($imgPath);
				$fileExt = 'jpg';
				break;
			case 3:
				$originalImage = imagecreatefrompng($imgPath);
				$fileExt = 'png';
				break;
			default:
				if ($verbose) {
					echo "Not a valid image type.";
				}
				return false;
		}
		// create new image
	
		$resizedImage = imagecreatetruecolor($newWidth, $newHeight);
		//echo "$srcX, $srcY, $newWidth, $newHeight, $curWidth, $curHeight";
		//echo "<br>$srcX, $srcY, $newWidth, $newHeight, $srcWidth, $srcHeight<br>";
		imagecopyresampled($resizedImage, $originalImage, 0, 0, $srcX, $srcY, $newWidth, $newHeight, $srcWidth, $srcHeight);
		imageinterlace($resizedImage, 1);
		switch ($fileExt) {
			case 'gif':
				imagegif($resizedImage, $destPath, $quality);
				break;
			case 'jpg':
				imagejpeg($resizedImage, $destPath, $quality);
				break;
			case 'png':
				imagepng($resizedImage, $destPath, $quality);
				break;
		}
		// return true if successfull
		return true;
	} 
	
	// show_thumb
	public function show_thumbOld($file_org, $width, $height, $ratio_type = 'width') {
		$path_parts = pathinfo($file_org);
		/*$file_name = str_replace(SITE_WS_PATH."/", "", $file_org);
		$file_name = str_replace("/", "^", $file_name);
		$cache_file = $width."x".$height.'__'.$ratio_type .'__'.$file_name;
	
		$file_fs_path = str_replace(SITE_WS_PATH, SITE_FS_PATH, $file_org);*/
		//$file_fs_path = str_replace(SITE_WS_PATH, SITE_FS_PATH, $file_org);
	
		$file_name = $path_parts['basename'];
		$file_name = str_replace("/", "^", $file_name);
		$cache_file = $width."x".$height.'__'.$ratio_type .'__'.$file_name;
		if(!is_file($path_parts['dirname']."/".$cache_file)) {
			$this->make_thumb_gd($file_org, $path_parts['dirname']."/".$cache_file, $width, $height, $ratio_type );
	
		}
		return $path_parts['dirname']."/".$cache_file;
	}
	
	public function show_thumb($file_org, $width, $height, $ratio_type = 'width') {
		$file_name = str_replace(SITE_WS_PATH."/", "", $file_org);
		$file_name = str_replace("/", "^", $file_name);
		$cache_file = $width."x".$height.'__'.$ratio_type .'__'.$file_name;
	
		$file_fs_path = str_replace(SITE_WS_PATH, SITE_FS_PATH, $file_org);
		if(!is_file(SITE_FS_PATH."/".THUMB_CACHE_DIR."/".$cache_file)) {
			$this->make_thumb_gd($file_fs_path, SITE_FS_PATH."/".THUMB_CACHE_DIR."/".$cache_file, $width, $height, $ratio_type );
		}
		return SITE_WS_PATH.THUMB_CACHE_DIR."/".$cache_file;
	}
	// ms_parse_keywords: Updated 31 may 2006
	// Temporary function. Need to be made more elegant or replace with regular expression
	public function ms_parse_keywords($keywords) {
		$arr_keywords = array();
		$dq_end =true;
		$sp_end = true;
		for ($i=0;$i<strlen($keywords);$i++) {
			//echo "<br>cur_token:$cur_token, cur_keyword:$cur_keyword, dq_start:$dq_start, dq_end:$dq_end, sp_start:$sp_start, sp_end:$sp_end,";
			$cur_token = $keywords[$i];
			if($cur_token=='"') {
				if($dq_start) {
					$dq_end = true;
					$dq_start = false;
					$arr_keywords[] = $cur_keyword;
					$cur_keyword = '';
				} else if($dq_end) {
					$dq_end = false;
					$dq_start = true;
					$sp_start = false;
				} else {
					$dq_end = false;
					$dq_start = true;
				}
			} else if($cur_token==' ') {
				if($sp_start || $dq_end) {
					$sp_end = true;
					$sp_start = false;
					$arr_keywords[] = $cur_keyword;
					$cur_keyword = '';
				} else if($sp_end && !$dq_start) {
					$sp_end = false;
					$sp_start = true;
				} else if($dq_start) {
					$cur_keyword .= $cur_token;
				}
			} else {
				$cur_keyword .= $cur_token;
			}
		}
	
		$arr_keywords[] =$cur_keyword;
		return $arr_keywords;
	}
	
	
	// pagesize_dropdown
	public function pagesize_dropdown($name, $value) {
		$arr = array('1'=>'1','10'=>'10','25'=>'25','50'=>'50','100'=>'100');
		$m = $_GET;
		unset($m['pagesize']);
		return $this->array_dropdown($arr, $value , $name, '  onchange="location.href=\''.$_SERVER['PHP_SELF'].qry_str($m).'&pagesize=\'+this.value" ');
	}
	
	// sql_to_assoc_array
	public function sql_to_assoc_array($sql) {
		$arr = array();
		$result = $this->db_query($sql);
		while ($line = mysql_fetch_array($result)) {
			$line = $this->ms_form_value($line);
			$arr[$line[0]] = $line[1];
		}
		return $arr;
	}
	
	
	// sql_to_index_array
	public function sql_to_index_array($sql) {
		$arr = array();
		$result = $this->db_query($sql);
		while ($line = mysql_fetch_array($result)) {
			$line = $this->ms_form_value($line);
			$arr[] = $line[0];
		}
		return $arr;
	}
	
	// sql_to_array
	public function sql_to_array($sql) {
		$arr = array();
		$result = $this->db_query($sql);
		while ($line = mysql_fetch_array($result)) {
			$line = $this->ms_form_value($line);
			array_push($arr, $line);
		}
		return $arr;
	}
	
	
	public function qry_str_to_hidden($str) {
		$fields='';
		if(substr($str,0,1)=='?') {
			$str = substr($str,1);
		}
		$arr = explode('&', $str);
		foreach($arr as $pair) {
			list($name, $value) = explode('=',$pair);
			if($name!='') {
				$fields.='<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'" />';
			}
		}
		return $fields;
	}
	
	// enum_to_array
	
	public function enum_to_array($table, $column) {
		$result = $this->db_query("show fields from $table");
		while ($line_raw = mysql_fetch_assoc($result)) {
			$line = $this->ms_display_value($line_raw);
			if($line['Field']==$column) {
				$Type = $line['Type'];
				$Type = substr($Type,6,-2);
				$arr_tmp = explode("','", $Type);
				foreach($arr_tmp as $val) {
					$arr[$val]=$val;
				}
				return $arr;
			}
		}
	}
	
	public function redir($url,$inpage=0) {
		if($inpage==0) {
			header('location: '.$url) or die("Cannot Send to next page");
			exit;
		}
		else {
			echo '
			<script type="text/javascript">
			<!--
			window.location.href="'.$url.'";
			-->
			</SCRIPT>'
			;
			exit;
		}
	}
			
	public function getFilename($filename) {
		$uniq = uniqid("");
		$arr=explode('.',$filename);
		$ext = $arr[count($arr)-1];
	
		$allowed = "/[^a-z0-9\\_]/i";
		$arr[0] = preg_replace($allowed,"",$arr[0]);
	
		$filename=$uniq.$arr[0]."_.".$ext;
	
		return $filename;
	}
	public function getextention($fname){
		$fext=explode(".",$fname);
		$ext=$fext[count($fext)-1];
		return $ext;
	}
	
	public  function checkpath($PATH){
		if(!is_dir($PATH)){
			mkdir($PATH,0777);
		}
	}
	public function uploadFile($PATH,$FILENAME,$FILEBOX){
		global $temp_file; 
		$this->checkpath($PATH);
		$PATH = $PATH.'/';
		$ext = strtolower($this->getextention($FILENAME));
		$FILENAME_= time()."_".mt_rand(1,1000);
		$temp_file = SITE_FS_PATH."/".THUMB_CACHE_DIR."/".$FILENAME_;
		if (isset($_FILES[$FILEBOX])){
			switch($_FILES[$FILEBOX]['type']){
				case "image/png":
					$file = $temp_file.".".$ext;
					$FILENAME = $FILENAME_.".jpg";
					move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
					$imageObject = imagecreatefrompng($file);
					imagejpeg($imageObject,$PATH.$FILENAME);
					unlink($file);
					//imagedestroy($imageObject);
					break;
				case "image/gif":
					$file = $temp_file.".".$ext;
					$FILENAME = $FILENAME_.".jpg";
					move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
					$imageObject = imagecreatefromgif($file);
					imagejpeg($imageObject,$PATH.$FILENAME);
					unlink($file);
					//imagedestroy($imageObject);
					break; 
				case "image/bmp":
					$file = $temp_file.".".$ext;
					$FILENAME = $FILENAME_.".jpeg";
					move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);
					$imageObject = imagecreatefromwbmp($file);
					imagejpeg($imageObject,$PATH.$FILENAME);
					unlink($file);
					//imagedestroy($imageObject);
					break; 
				default:
					$file = $PATH.$FILENAME_.".".$ext;
					$FILENAME = $FILENAME_.".".$ext;
					move_uploaded_file($_FILES[$FILEBOX]['tmp_name'], $file);	
			}
		}	
		return $FILENAME;
	}
	public function storeImage1($tmp_name, $filename, $path, $type, $typeid, $name='Main') {
		$filename = $this->getFilename($filename);
		$PATH = $path.'/';
		list($wi,$hi)=getimagesize($tmp_name);

		$this->db_query("insert into ".tb_Prefix."images set id='', name='$name', type='$type', type_id='$typeid', path= '$filename', status='Active'");
	}
	
	public function storeImage($tmp_name, $filename, $path, $type, $typeid, $name='Main') {
		$filename = $this->getFilename($filename);
		$PATH = $path.'/';
		list($wi,$hi)=getimagesize($tmp_name);
		$this->sqlquery("rs","pages",array($name=>$filename),'page_id',$typeid);
	}
	
	public function showimg($type,$id,$fol,$imgid='') {
		$nn = $fol;
		if($imgid)
			$wh = " and name='".$imgid."'";
		$img = $this->getSingleresult("select path from ".tb_Prefix."images where type='".$type."' and type_id='".$id."'".$wh);
		if($img != '' && file_exists($nn.'/'.$img)) {
			return $nn.'/'.$img;
		}
		else {
			return "images/noimgbig.gif";
		}
	}
	
	public function showmess(){
		if($_SESSION['sessmsg']){
			echo "<table width='100%'>";
			echo "<tr>";
			echo "<td class='error-item'><span>";
			echo $_SESSION['sessmsg'];
			echo "</span></td>";
			echo "</tr>";
			echo "</table>";
			$_SESSION['sessmsg'] = '';
			unset($_SESSION['sessmsg']);
		}
	}
	public function sessset($val){
		$_SESSION['sessmsg'] = $val;
	}
	public function alt($val){
		return 'alt="'.$val.'" title="'.$val.'"';
	}
	
	public function sendmail($to, $subject, $message, $fname='', $femail=''){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.(($fname)?$fname:$this->getSingleresult("select company from #_setting where `id`='1'")).' <'.(($femail)?$femail:$this->getSingleresult("select email from #_setting where `id`='1'")).'>' . "\r\n";
		@mail($to, $subject, $message, $headers);
	}
	public function  sform($vals=''){
		return '<form method="post" enctype="multipart/form-data" name="aforms" action=""  '.$vals.'>';
	}
	
	public function  eform(){
		return '</form>';
	}
	public function pageinfo($page){
		$pageInfo = array();
		$pageInfo[title] = $this->get_static_content('meta_title',$page);
		$pageInfo[keyword] = $this->get_static_content('meta_keyword',$page);
		$pageInfo[description] = $this->get_static_content('meta_description',$page);
		$pageInfo[heading] = $this->get_static_content('heading',$page);
		$pageInfo[body] = $this->get_static_content('body',$page);
		$pageInfo[pimage] = $this->get_static_content('pimage',$page);
		return $pageInfo;
	}

	public function get_static_content($key,$pname){
		return $rs = $this->db_scalar("select ".$key." from #_pages where url='$pname'");
	}
	
	public function cal($fld,$val="",$class='', $frmt='yyyy/mm/dd'){
	  return '<input type="text" value="'.(($val)?$val:'').'" class="'.$class.'" readonly name="'.$fld.'" onclick="displayCalendar(document.forms[0].'.$fld.',\''.$frmt.'\',this)"/><div id="debug"></div>';
		
	}
	public function ptr($key){
		$key1 = str_replace("<p>","", $key);
		$rs = str_replace("</p>","", $key1);
		$rs = str_replace("<span>","", $rs);
		$rs = str_replace("</span>","", $rs);
		return $rs;
	}
	public function access(){
		if(!$_SESSION[uid] and !$_SESSION[eid]){
			$this->redir($this->url("login"),true);	
		}
	}
	function getShipping($shipamt)
	{
	$rsAdmin=$this->db_query("select * from #_shipping"); 
	$totCount = mysql_num_rows($rsAdmin);
	$i =1;
		while($arrAdmin=$this->db_fetch_array($rsAdmin))
		{
			 @extract($arrAdmin); 
			  if($shipamt>=$ranges && $shipamt<=$rangee) 
			  {
					//return  "case : ".$i ." for '$shipamt' =>".$ranges." & ".$rangee." = ".  $ship; 
				 return $ship;
				 exit; 
			  } 
			  else
			  if($i==$totCount)	
			  {
				return $ship;
			   //return  $ranges." & ".$rangee." = ".  $ship; 
			  }
			  $i++;
			  
		} 
	}
 function getDiscountPercent($actprice, $disPricwe)
	{
	if(!$actprice) return 0; 
	if(!$disPricwe) return 0;
	$diff  =  $actprice - $disPricwe;
	$per = ceil(($diff*100)/$actprice);
	return $per; 
	}
	public function imgthumb($imgpath,$h,$w){  
			$image = imagecreatefromjpeg($imgpath); 
			//get image dimension
			$dim=getimagesize($imgpath); 
			//create empty image
			$thumb_image=imagecreatetruecolor($w, $h); 
			//Resize original image and copy it to thumb image
			imagecopyresampled($thumb_image, $image, 0, 0, 0, 0,
								$w, $h, $dim[0], $dim[1]); 
			//display thumb image
			return imagejpeg($thumb_image);
	}
	public function make_thumb($src, $dest, $desired_width,$desired_height) {

	/* read the source image */
	$source_image = imagecreatefromjpeg($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	//$desired_height = floor($height * ($desired_width / $width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $dest);
	}
	public function geturl(){
		$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
		if ($_SERVER["SERVER_PORT"] != "80")
		{
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else 
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	 
	
	public function getRelatedbradsSearach($searchexe){
		$list='';
		$storeId = array();
		$stores = array();
 		while($brandarray=$this->db_fetch_array($searchexe)){ @extract($brandarray); 
			 $stores[] = $store_user_id;
		} 
		
		if(count($stores)){
			$qry  = $this->db_query("select brand_id from #_request_brand where  store_user_id in (".implode(',',$stores).") and status ='Active' group by brand_id ");
			while($storeRes=$this->db_fetch_array($qry)){  
			 $storeId[] = $storeRes[brand_id]; 
			} 
		}
		 
		if(count($storeId)){
				foreach($storeId as $val){
					$title = $this->getSingleresult("select title from #_store_detail where store_user_id = '".$val."'");  
					$theme = $this->getSingleresult("select theme from #_store_detail where store_user_id = '".$val."'"); 
					$store_url = $this->getSingleresult("select store_url from #_store_detail where store_user_id = '".$val."'"); 
					$link = 'http://'.$store_url.".fizzkart.com/";
					if($title){
					$list .= '<div class="logonamebox"><a href="'.$link.'">'.ucwords(strtolower($title)).'</a></div>'; 
					}
				}
		} 
		 
		if($list==''){
			$list .= '<div class="logonamebox"><a href="#">NA</a></div>';
		}
		return $list;
	
	 }	
	 public function getRelatedStoreSearach($searchexe){
		$list='';
		$storeId = array();
		$brands = array();
 		while($brandarray=$this->db_fetch_array($searchexe)){ @extract($brandarray); 
			 $brands[] = $store_user_id;
		} 
		if(count($brands)){
			$qry  = $this->db_query("select store_user_id from #_request_brand where brand_id in (".implode(',',$brands).") and status ='Active' group by store_user_id ");
			while($storeRes=$this->db_fetch_array($qry)){  
			 $storeId[] = $storeRes[store_user_id];
			} 
		}
		if(count($storeId)){
				foreach($storeId as $val){
					$title = $this->getSingleresult("select title from #_store_detail where store_user_id = '".$val."'");  
					$theme = $this->getSingleresult("select theme from #_store_detail where store_user_id = '".$val."'"); 
					$store_url = $this->getSingleresult("select store_url from #_store_detail where store_user_id = '".$val."'"); 
					$link = 'http://'.$store_url.".fizzkart.com/";
 					if($title){
					$list .= '<div class="logonamebox"><a href="'.$link.'">'.strtoupper($title).'</a></div>'; 
					}
				}
		}
		if($list==''){
			$list .= '<div class="logonamebox"><a href="#">NA</a></div>';
		}
		return $list;
	
	 }	
	 public function removeSlash($str) {
	 $badFriends = '/(\\\)/';
	 $str = preg_replace($badFriends, '', $str);
	 return $str;
	}
	 function curPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}
	public function getSiteEmails($store_id = 0){
		if($store_id == 0){
		$qry = "select email from #_subscribe_list where status = 'Active'";
		}
		else{
		$qry = "select email from #_subscribe_list where status = 'Active' and store_id = '$store_id'";
		}
		$rsAdmin=$this->db_query($qry);
		while($arrAdmin=$this->db_fetch_array($rsAdmin)){
		extract($arrAdmin);
		$emails .= $email.", ";
		}
		$emails = substr($emails,0,-2);
		return $emails;
	}
	/*function getPlanBrands($planid){
 	 $qry = $this->db_query("SELECT brand_id FROM `#_plans_brand` where plan_id = '$planid' ");
	 if(mysql_num_rows($qry)){ 
 	 	while($res = $this->db_fetch_array($qry)){
			@extract($res);
			$name = $this->getSingleresult("SELECT name FROM `#_brand` where pid = '".$brand_id."' ");  
			$brands .= $name . ", "; 
		}
		$brands = substr($brands,0,-2);
		$ms = "----------------Brands---------------<br/>  $brands <br/>";
 	 }
	 return $ms;
	print_r($_REQUEST);
	}*/
	function getCategoriesPlan($plan_id){
		$qry = $this->db_query("SELECT cat_id FROM `#_plans_category` where plan_id ='$plan_id' and parent = '0'  ");
 	 	if(mysql_num_rows($qry)){  
		while($res = $this->db_fetch_array($qry)){
			@extract($res);
			$parent = $this->removeSlash($this->getSingleresult("select name from #_category where pid = '$cat_id' "));
			$qry2 = $this->db_query("SELECT cat_id FROM `#_plans_category` where plan_id ='$plan_id' and parent = '$cat_id'  ");
			if(mysql_num_rows($qry2)){
				while($res = $this->db_fetch_array($qry2)){ 
					$name = $this->getSingleresult("SELECT name FROM `#_category` where pid = '".$res[cat_id]."' ");  
					$catte .= $this->removeSlash($name) . ", ";  
				 }
				 $catte = substr($catte,0,-2);  
			}
			
		 $ms .= $catte; 
		}
		
		}
		return $ms;
	}
	function getTarifPlan($plan_id){
		$qry = $this->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where plan_id ='$plan_id'  ");
 	 	if(mysql_num_rows($qry)){  
			while($res = $this->db_fetch_array($qry)){
				@extract($res); 
				$ms .= ' For '.$noOfDays. ' days => '.$this->price_format($amount).'<br/>'; 
			}
		
		}
		return $ms;
	}
	
	function getPlanIdByCat($catid){
	$plan_qry = $this->db_query("select plan_id from #_plans_category where cat_id = '".$catid."'");
			 $plans = array();
			 if(mysql_num_rows($plan_qry)){
				while($results =$this->db_fetch_array($plan_qry)){
					@extract($results);
					$plans[]  = $plan_id;
				}
				$plans = array_unique($plans);
			 }
			 return $plans;
	
	}
	function getPlanIdByBrand($brandid){
	$plan_qry = $this->db_query("select plan_id from #_plans_brand where brand_id = '".$brandid."'");
			 $plans = array();
			 if(mysql_num_rows($plan_qry)){
				while($results =$this->db_fetch_array($plan_qry)){
					@extract($results);
					$plans[]  = $plan_id;
				}
				$plans = array_unique($plans);
			 }
			 return $plans;
	
	}
	function getBrandsByPlanID($planid){
	$plan_qry = $this->db_query("select brand_id from #_plans_brand where plan_id = '".$planid."'");
			 $brands = array();
			 if(mysql_num_rows($plan_qry)){
				while($results =$this->db_fetch_array($plan_qry)){
					@extract($results);
					$brands[]  = $brand_id;
				}
				$brands = array_unique($brands);
			 }
			 return $brands;
	
	}
	function getRemainDays($date){
		$startTimeStamp = strtotime($date);
		$endTimeStamp = time(); 
		$timeDiff = abs($endTimeStamp - $startTimeStamp); 
		$numberDays = $timeDiff/86400;  // 86400 seconds in one day 
		// and you might want to convert to integer
		$numberDays = intval($numberDays);
		return $numberDays;
	}
	function getBrandAdmin($brandid){
			$brand_owner = $this->getSingleresult("select brand_owner from #_brand where pid = '".$brandid."'"); 
			if($brand_owner>0){
				$brandemail = $this->getSingleresult("select email_id from #_store_user where  pid = '".$brand_owner."'");
				return $brandemail;			
			}else{
			return SITE_MAIL;
			}
			return SITE_MAIL; 
	}
	function getBradcum($id){
			global $catarr; 
			$catarr[] = $id;
			$getParent = $this->getSingleresult("select parentId from #_category where pid='$id'");
			if($getParent){
			$this->getBradcum($getParent);
			} 
			return array_reverse($catarr); 
	}
	  
	function getList($catId,$name){
						$prosubcat=$this->db_query("select pid,name from #_category where parentId='".$catId."' order by porder");
						if(mysql_num_rows($prosubcat)){?>
							<!--<optgroup label="<?=$name?>">--><?php
							while($subres=$this->db_fetch_array($prosubcat)){ 
								$prosubcat2=$this->db_query("select pid,name from #_category where parentId='".$subres[pid]."'order by porder");
								if(mysql_num_rows($prosubcat2)){									
									$subres2=$this->db_fetch_array($prosubcat2);
									?>															
								<option value="<?=$subres[pid]?>" <?=(($subres[pid]==$cat_id)?'selected="selected"':'')?>>
								<?=$name?> => <?=$subres[name]?></option><?php
									$this->getList($subres2[pid],$subres2[name]);									
								}else{?>															
								<option value="<?=$subres[pid]?>" <?=(($subres[pid]==$cat_id)?'selected="selected"':'')?>>
								<?=$subres[name]?></option><?php
								}
						} 
						//echo "</optgroup>";
						}else{?> 
							<option value="<?=$catId?>" <?=(($catId==$cat_id)?'selected="selected"':'')?>>
							<?=$name?></option>  <?php
						} 		
	}
	   	
	 function getList2($catId){
	 					//global $catarr; 
 						$subcat=$this->getSingleresult("select pid from #_category where parentId='".$catId."' order by porder");
						$subname=$this->getSingleresult("select name from #_category where pid='".$catId."' order by porder");
						//$catarr[] = $subname;	 
						if($subcat){ 
							
							 $catarr[] = $subname;	 
							//$catarr[] = "last ".$catId;
							$this->getList2($subcat);
						}
						else{
							 $catarr[] = "last ".$subname;
							//$catarr[] = "last ".$catId;	 
						} 
						return $catarr;
						 	
	}
	function roundUptoNearestN($biggs){ 
       $rounders = (strlen($biggs)-2) * -1;
       $places = strlen($biggs)-2;

       $counter = 0;
               while ($counter <= $places) {
                   $counter++;
                       if($counter==1) {
                               $holder = $holder.'1'; }
                       else {
                               $holder = $holder.'0'; }
               }

                       $biggs = $biggs + $holder;
                       $biggs = round($biggs, $rounders);

                       if($biggs<100) {
                                       if($biggs<100) { $biggs = 100; }
                                       else { $biggs = 100; }
                                                       }
       return $biggs;
}
function generateCode($maxLength){
  $length = $maxLength; // how long promotional code required
  $random= "";
  srand((double)microtime()*1000000);
  $data = "ABCDE123IJKLMN67QRSTUVWXYZ";
  $data .= "ABCDEFGHIJKLMN123PQ45RS67TUV89WXYZ";
  $data .= "FGH45P89";

  $uniqueCode = uniqid(); //the returned string will be 13 characters long
  $addRandLength = ($length - strlen($uniqueCode));
  for($i = 0; $i < $addRandLength; $i++){
    $random .= substr($data, (rand()%(strlen($data))), 1);
  }
  $Code = $prefix.$random.$uniqueCode;
  return strtoupper($Code);
}
function encryptcode($string){
 
  $key ='3647';
  
  $result = '';
  for($i=0; $i<strlen($string); $i++){
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)+ord($keychar));
    $result.=$char;
  }
return base64_encode($result);
}


/*function to decrypt promotional code*/
function decryptcode($string){
  $key ='3647';
  $result = '';
  $string = base64_decode($string);
  for($i=0; $i<strlen($string); $i++){
    $char = substr($string, $i, 1);
    $keychar = substr($key, ($i % strlen($key))-1, 1);
    $char = chr(ord($char)-ord($keychar));
    $result.=$char;
  }
  return $result;
}
function validatePromotionalCode($code){
	$qry="select id from #_gift_voucher where voucherCode ='".trim(encryptcode($code))."' and status='0'";
	$qurSql = $this->db_query($qry);
	$count =(int)mysql_num_rows($qurSql);
	if($count){ 
		return true; 
	}
	else{
    	return false;
	}
}
function checkEmail($email){
	$check = preg_match('/^([a-z0-9]+([_\.\-]{1}[a-z0-9]+)*){1}([@]){1}([a-z0-9]+([_\-]{1}[a-z0-9]+)*)+(([\.]{1}[a-z]{2,6}){0,3}){1}$/i', $email);
	if($check) return true;
	else return false;
}
public function baseurl21($vals){
		$vals = $this->removeSlash($vals);
		$vals = "$vals";
		$cnt = strlen(trim(strtolower($vals)));
		if($cnt<15){
			$vals = str_replace(" ", "",trim(strtolower($vals)));
		}else{
			$vals = str_replace(" ", "-",trim(strtolower($vals)));
		}
		
		$vals = str_replace("///", "-",$vals);
		$vals = str_replace("//", "-",$vals);
		$vals = str_replace("/", "-",$vals);
		$vals = str_replace("/'", "-",$vals);
		$vals = str_replace("(", "-",$vals);
		$vals = str_replace(")", "-",$vals);
		$vals = str_replace("&", "-",$vals);
		$vals = str_replace("#", "-",$vals);
		$vals = str_replace("---", "-",$vals);
		$vals = str_replace("--", "-",$vals);
		$vals = str_replace("\'", "",$vals);
		$vals = str_replace("'", "",$vals);
		$vals = str_replace("\/", "",$vals);
		$vals = str_replace("'", "",$vals);
		$vals = str_replace('""', "",$vals);

		return $vals;
}
public function sendSms($number,$mess,$storeid){
	if(!$storeid){  
		$this->db_query("insert into #_message_stats set msg = '$mess',number = '$number',store_id ='".$storeid."'  ");
		$mess = urlencode($mess);
		$url="http://sms.softgains.com/sendurlcomma.aspx?user=20066766&pwd=b62k6d&senderid=FIZZKT&mobileno=".$number."&msgtext=".$mess;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_scraped_page = curl_exec($ch);
		curl_close($ch); 
 	}else{
		$noOfMessage = $this->getSingleresult("select noOfMessage from #_store_detail where store_user_id = '".$storeid."' ");
		$currentUse = $this->getSingleresult("select count(*) from #_message_stats where store_id ='".$storeid."' "); 
		if($currentUse<$noOfMessage){
			$this->db_query("insert into #_message_stats set msg = '$mess',number = '$number',store_id ='".$storeid."'  ");
			$mess = urlencode($mess);
			$url = "http://sms.softgains.com/sendurlcomma.aspx?user=20066766&pwd=b62k6d&senderid=FIZZKT&mobileno=".$number."&msgtext=".$mess;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$curl_scraped_page = curl_exec($ch);
			curl_close($ch); 
		}
	}
}

public function findPrice($vals){ 
		$vals = str_replace(".00", "",$vals);
		$vals = str_replace(".0", "",$vals);
		$vals = str_replace("Rs", "",$vals);
		$vals = str_replace("," , "",$vals);
		$vals = str_replace(".","",$vals);
		$vals = str_replace("RS", "",$vals);
		$vals = str_replace(" ", "",$vals);
		$vals = str_replace("---", "-",$vals);
		$vals = str_replace("--", "-",$vals);
		$vals = str_replace("-", "-",$vals);
		
		return $vals;
}
 
 function createThumbnailAny($pathToImage, $dest, $thumbWidth = 180, $thumbHeight=125) {
	$result = 'Failed';
	if (is_file($pathToImage)) {
		$info = pathinfo($pathToImage);
		 $extension = strtolower($info['extension']);
		if (in_array($extension, array('jpg', 'jpeg', 'png', 'gif'))) {

				switch ($extension) {
					case 'jpg':
						$img = imagecreatefromjpeg("{$pathToImage}");
						break;
					case 'jpeg':
						$img = imagecreatefromjpeg("{$pathToImage}");
						break;
					case 'png':
						$img = imagecreatefrompng("{$pathToImage}");
						break;
					case 'gif':
						$img = imagecreatefromgif("{$pathToImage}");
						break;
					default:
						$img = imagecreatefromjpeg("{$pathToImage}");
				}
				// load image and get image size

				$width = imagesx($img);
				$height = imagesy($img);

				// calculate thumbnail size
				$new_width = $thumbWidth;
				$new_height = $thumbHeight;

				// create a new temporary image
				$tmp_img = imagecreatetruecolor($new_width, $new_height);

				// copy and resize old image into new image
				imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					$pathToImage = $dest."/".$info['filename'].".". $extension;
				// save thumbnail into a file
				imagejpeg($tmp_img, "{$pathToImage}");
				 $result = $pathToImage;
			} else {
				$result = 'Failed|Not an accepted image type (JPG, PNG, GIF).';
			}
		} else {
			$result = 'Failed|Image file does not exist.';
		}
		return $result;
	}
	function subdomain($str, $separator = 'dash', $lowercase = FALSE)
    {   
		$str  =  trim($str);
		$length = strlen($str);
		if($length<=15){ $str  = $str = str_replace(' ','', $str);   }
        $foreign_characters = array(
            '/ä|æ|ǽ/' => 'ae',
            '/ö|œ/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|А/' => 'A',
            '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|а/' => 'a',
            '/Б/' => 'B',
            '/б/' => 'b',
            '/Ç|Ć|Ĉ|Ċ|Č|Ц/' => 'C',
            '/ç|ć|ĉ|ċ|č|ц/' => 'c',
            '/Ð|Ď|Đ|Д/' => 'D',
            '/ð|ď|đ|д/' => 'd',
            '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Е|Ё|Э/' => 'E',
            '/è|é|ê|ë|ē|ĕ|ė|ę|ě|е|ё|э/' => 'e',
            '/Ф/' => 'F',
            '/ф/' => 'f',
            '/Ĝ|Ğ|Ġ|Ģ|Г/' => 'G',
            '/ĝ|ğ|ġ|ģ|г/' => 'g',
            '/Ĥ|Ħ|Х/' => 'H',
            '/ĥ|ħ|х/' => 'h',
            '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|И/' => 'I',
            '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|и/' => 'i',
            '/Ĵ|Й/' => 'J',
            '/ĵ|й/' => 'j',
            '/Ķ|К/' => 'K',
            '/ķ|к/' => 'k',
            '/Ĺ|Ļ|Ľ|Ŀ|Ł|Л/' => 'L',
            '/ĺ|ļ|ľ|ŀ|ł|л/' => 'l',
            '/М/' => 'M',
            '/м/' => 'm',
            '/Ñ|Ń|Ņ|Ň|Н/' => 'N',
            '/ñ|ń|ņ|ň|ŉ|н/' => 'n',
            '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|О/' => 'O',
            '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|о/' => 'o',
            '/П/' => 'P',
            '/п/' => 'p',
            '/Ŕ|Ŗ|Ř|Р/' => 'R',
            '/ŕ|ŗ|ř|р/' => 'r',
            '/Ś|Ŝ|Ş|Š|С/' => 'S',
            '/ś|ŝ|ş|š|ſ|с/' => 's',
            '/Ţ|Ť|Ŧ|Т/' => 'T',
            '/ţ|ť|ŧ|т/' => 't',
            '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|У/' => 'U',
            '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|у/' => 'u',
            '/В/' => 'V',
            '/в/' => 'v',
            '/Ý|Ÿ|Ŷ|Ы/' => 'Y',
            '/ý|ÿ|ŷ|ы/' => 'y',
            '/Ŵ/' => 'W',
            '/ŵ/' => 'w',
            '/Ź|Ż|Ž|З/' => 'Z',
            '/ź|ż|ž|з/' => 'z',
            '/Æ|Ǽ/' => 'AE',
            '/ß/'=> 'ss',
            '/Ĳ/' => 'IJ',
            '/ĳ/' => 'ij',
            '/Œ/' => 'OE',
            '/ƒ/' => 'f',
            '/Ч/' => 'Ch',
            '/ч/' => 'ch',
            '/Ю/' => 'Ju',
            '/ю/' => 'ju',
            '/Я/' => 'Ja',
            '/я/' => 'ja',
            '/Ш/' => 'Sh',
            '/ш/' => 'sh',
            '/Щ/' => 'Shch',
            '/щ/' => 'shch',
            '/Ж/' => 'Zh',
            '/ж/' => 'zh',
			'/æ Æ/'=>'&',
        ); 
        $str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), trim($str));  
	    $replace =($separator == 'dash') ? ' ' : '-'; 
		$replace =($separator == '	zdsZ') ? '-' : '-';   
        $trans = array(
            '&\#\d+?;'               => '', 
            '&\S+?;'                 => '',
            '\s+'                    => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace.'+'            => $replace,
            $replace.'$'            => $replace,  
            '^'.$replace            => $replace,  
            '\.+$'                    => ''
        ); 
        $str = strip_tags($str); 
        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        } 
        if ($lowercase === TRUE)
        {
            if( function_exists('mb_convert_case') )
            {
                $str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
            }
            else
            {
                $str = strtolower($str);
            }
        } 
        $str = preg_replace('#[^a-z 0-9~%.:_\-]#i', '', $str);
	    $str = str_replace('','', $str);  
		$str = strtolower($str);
		
        return trim(stripslashes($str));
    }  
	function generate_random_password($length = 6) {
    //$alphabets = range('A','Z');
    $numbers =range('1','9');
    //$additional_characters = array('.');
    $final_array = array_merge($numbers);
         
    $password = '';
  
    while($length--) {
      $key = array_rand($final_array);
      $password .= $final_array[$key];
    } 
    return $password;
  }
  function member_update_mail($ids,$case,$storeid=0){
	if($case=='Active'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Active Site User' and store_id = '0'"); 
	}
	if($case=='Inactive'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Inactive Site User' and store_id = '0'");
	}
	
	if(!$storeid){ $adminEmail = SITE_MAIL;}else{
	$adminEmail = $this->getSingleresult("select email_id from #_store_user where pid='$storeid'");
	}
	$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail;
	$idqry = $this->db_query("select email,password,fname,lname from #_members where pid in ($ids)"); 
	if(mysql_num_rows($idqry)){
		while($rs = $this->db_fetch_array($idqry)){
			$tempRes = $this->db_fetch_array($Qryrs); 
			$subject = $tempRes[subject]; 
			$mess = $tempRes[body];
			$subject = str_replace("%%sitename%%",SITE_PATH,$subject); 
			$mess = str_replace("%%sitename%%",SITE_PATH,$mess);
			$mess = str_replace("%%name%%",$rs[fname]." ".$rs[lname],$mess);
			$mess = str_replace("%%email%%",$rs[email],$mess);
			$mess = str_replace("%%password%%",$this->decryptcode($rs[password]),$mess);
			@mail($rs[email],$subject,$mess,$headers); 
			 
		}
	} 
	return true;
}



function user_update_mail($ids,$case,$storeid=0){
	if($case=='Active'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Active Site User' and store_id = '0'"); 
	}
	if($case=='Inactive'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Inactive Site User' and store_id = '0'");
	}
	
	if(!$storeid){ $adminEmail = SITE_MAIL;}else{
	$adminEmail = $this->getSingleresult("select email_id from #_store_user where pid='$storeid'");
	}
	$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail;
	$idqry = $this->db_query("select email_id,password,name,user_name from #_store_user where pid in ($ids)"); 
	if(mysql_num_rows($idqry)){
		while($rs = $this->db_fetch_array($idqry)){
			$tempRes = $this->db_fetch_array($Qryrs); 
			$subject = $tempRes[subject]; 
			$mess = $tempRes[body];
			$subject = str_replace("%%sitename%%",SITE_PATH,$subject); 
			$mess = str_replace("%%sitename%%",SITE_PATH,$mess);
			$mess = str_replace("%%name%%",$rs[name],$mess);
			$mess = str_replace("%%username%%",$rs[user_name],$mess);
			$mess = str_replace("%%email%%",$rs[email_id],$mess);
			$mess = str_replace("%%password%%",$this->decryptcode($rs[password]),$mess);
			@mail($rs[email_id],$subject,$mess,$headers); 
			 
		}
	} 
	return true;
}

 function product_update_mail($ids,$case,$storeid=0){
	if($case=='Active'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Active Product' and store_id = '0'"); 
	}
	if($case=='Inactive'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Inactive Product' and store_id = '0'");
	}
	
	if(!$storeid){ $adminEmail = SITE_MAIL;}else{
	$adminEmail = $this->getSingleresult("select email_id from #_store_user where pid='$storeid'");
	}
	 
	                    $adminUser = $this->getSingleresult("select user_name from #_store_user where pid='$storeid'");
						$ch1=$this->db_query("select store_user_id,title from #_products_user where pid in ($ids)");
						while($tempRes1 =$this->db_fetch_array($ch1)){
						 	$store_id=$tempRes1['store_user_id'];  
						    $store_u=$this->db_query("select email_id,user_name from #_store_user where pid ='$store_id'");
							$store_result=$this->db_fetch_array($store_u);
							$adminEmail=$store_result['email_id'];
							$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					        $tempRes = $this->db_fetch_array($Qryrs); 
						    $subject = $tempRes[subject];   
							$mess = $tempRes[body];
							$url=$this->curPageURL();
							$subject = str_replace("%%productname%%",$tempRes1['title'],$subject);
							$subject = str_replace("%%subdomain%%",$adminUser.".".SITE_PATH,$subject);
							$mess = $tempRes[body]; 
							$mess = str_replace("%%subdomain%%",SITE_PATH,$mess);
							$mess = str_replace("%%storename%%",$store_result['user_name'],$mess);
							$mess = str_replace("%%productname%%",$tempRes1['title'],$mess);
							$mess = str_replace("%%url%%",$url,$mess);
							@mail($adminEmail,$subject, $mess,$headers); 						
						 
					 
	} 
	return true;
}  
function product_del_mail($ids,$case,$storeid=0){
 
	   $ch=$this->db_query(" select * from #_products_user where pid  in ($ids)"); 
		while($tempRes =$this->db_fetch_array($ch)){
		@extract($tempRes);
		$arr=array();
		$arr[store_user_id] = $_SESSION[uid];
		$arr[admin_product_id] = $pid; 
		$arr[cat_id] = $cat_id; 
		$arr[kf2] = $kf2;
	    $arr[kf3] = $kf3;
	    $arr[meta_title] = $meta_title;
		$arr[meta_keyword] = $meta_keyword;
		$arr[meta_description] = $meta_description;
        $arr[shipping] = $shipping;
		$arr[pcode] = $pcode;
		$arr[discount] = $discount;
		$arr[combo] = $combo;
		$arr[seasional_offer] = $seasional_offer;
		$arr[hot_deal] = $hot_deal;
 		$arr[title] = $title;
		$arr[image1] = $image1;
		$arr[image2] = $image2;
		$arr[image3] = $image3;
		$arr[image4] = $image4;
		$arr[body1] = $body1;
		$arr[url] = $url;
		$arr[status] = $status;
		$arr[submitdate] = time();
		$arr[size] = $size;
		$arr[price] = $price;
		$arr[show_home] = $show_home;
		$arr[porder] = $porder;
		$arr[offerprice] = $offerprice;
		$arr[color] = $color; 
		 
		$this->sqlquery("rs","products_user_temp",$arr);
		$lastid = mysql_insert_id();
		}
		
		$features=$this->db_query("select * from #_product_feature where prod_id='".$ids."'");
		if(mysql_num_rows($features)){
			while($res=$this->db_fetch_array($features)){ 
				@extract($res);
				$arr2 = array();
				$arr2[prod_id] =$lastid;
				$arr2[ftitle] = $ftitle;
				$arr2[fdescription] =$fdescription;			
				$this->sqlquery("rs","product_feature_temp",$arr2); 
			}
	}
	
	if($case=='delete' || $case=='del'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Product Delete' and store_id = '0'"); 
	}
	 if(!$storeid){ $adminEmail = SITE_MAIL;}else{
	$adminEmail = $this->getSingleresult("select email_id from #_store_user where pid='$storeid'");
	}      
							
	           $brand_w = $this->getSingleresult("select user_name from #_store_user where pid ='$storeid'");
	         $ch1=$this->db_query("select store_user_id,title from #_products_user where pid='$ids'");
						while($tempRes1 =$this->db_fetch_array($ch1)){ 
						    $store_id=$tempRes1['store_user_id'];   
						    $store_u=$this->db_query("select email_id,user_name from #_store_user where pid ='$store_id'");
							$store_result=$this->db_fetch_array($store_u);
							$adminEmail=$store_result['email_id'];
							$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail;
					        $tempRes = $this->db_fetch_array($Qryrs); 
						    $subject = $tempRes[subject];   
							$mess = $tempRes[body];
							$url=$this->curPageURL();
							$subject = str_replace("%%productname%%", $tempRes1['title'],$subject);
							$subject = str_replace("%%subdomain%%",$store_result[user_name],$subject);
							$mess = $tempRes[body]; 
							$mess = str_replace("%%subdomain%%",SITE_PATH,$mess);
							$mess = str_replace("%%storename%%",$store_result[user_name],$mess);
							$mess = str_replace("%%productname%%",$tempRes1[title],$mess);
							$mess = str_replace("%%url%%",$url,$mess);
						    @mail($store_result[email_id], $subject, $mess,$headers); 	 
	    }
	return true;
} 


function product_addedit_mail($ids,$case,$storeid=0){
	  if($case=='add'){ 
		        $Qryrs = $this->db_query("select * from #_template where title ='Add or update product of barands' and store_id = '0'"); 
	}
	if($case=='update'){ 
		       $Qryrs = $this->db_query("select * from #_template where title ='Add or update product of barands' and store_id = '0'");
	}
	
	if(!$storeid){ $adminEmail = SITE_MAIL;}else{
	$adminEmail = $this->getSingleresult("select email_id from #_store_user where pid='$storeid'");
	}
						    $store_woner = $this->getSingleresult("select user_name from #_store_user where pid='$storeid'");
							$ch12=$this->db_query("select store_user_id,title,pid from  #_products_user where pid='$ids'");
							$tempRes1 =$this->db_fetch_array($ch12);
							 
							 
							 
		                    $store_u=$this->db_query("select email_id,user_name from #_store_user where pid ='$storeid'");
							$store_result=$this->db_fetch_array($store_u);
						    $adminEmail=$store_result['email_id'];
							$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$rs[email];
					        $tempRes = $this->db_fetch_array($Qryrs); 
						    $subject = $tempRes[subject];   
							$mess = $tempRes[body];
							$url=$this->curPageURL();
							$subject = str_replace("%%productname%%",$tempRes1['title'],$subject);
							$mess = $tempRes[body]; 
							$mess = str_replace("%%subdomain%%", SITE_PATH,$mess);
							$mess = str_replace("%%storename%%","http://".$store_woner."."."fizzkart.com/detail"."/".$this->subdomain($tempRes1['title'])."/".$tempRes1['pid'],$mess);
							$mess = str_replace("%%productname%%",$tempRes1['title'],$mess);
							$mess = str_replace("%%url%%",$url,$mess);
						    
						   @mail($adminEmail,$subject, $mess,$headers); 
	                      
	 
	return true; 
}
  
 function req_forbrands_member_mail($ids,$case,$storeid=0){
	if($case=='Active'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Store Request Active' and store_id = '0'"); 
	}
	if($case=='Inactive'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Store Inactive Request' and store_id = '0'");
	}
	 
	if($case=='Cancle'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Store Cancel Request' and store_id = '0'");
	}
	
	if(!$storeid){ $adminEmail = SITE_MAIL;}else{
	$adminEmail = $this->getSingleresult("select email from #_request_brand where brand_id='$ids'");
	}
	 $store_name = $this->getSingleresult("select title from #_store_detail where store_user_id='$ids'");
	 
			$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail;
			$idqry = $this->db_query("select email_id,name,user_name,type from #_store_user where pid='$storeid'"); 
			if(mysql_num_rows($idqry)){
		    while($rs = $this->db_fetch_array($idqry)){
		    $tempRes = $this->db_fetch_array($Qryrs); 
			$subject = $tempRes[subject]; 
			$mess = $tempRes[body];
			 
			$subject = str_replace("%%brandname%%",$store_name,$subject);
			   
			$subject = str_replace("%%storename%%",$rs[name],$subject);
				  
			$mess = str_replace("%%sitename%%",SITE_PATH,$mess);
			$mess = str_replace("%%brandname%%",$store_name,$mess);
			$mess = str_replace("%%storename%%",$rs[name],$mess);
			$mess = str_replace("%%email%%",$rs[email_id],$mess);
			$mess = str_replace("%%username%%",$rs[user_name],$mess); 
			@mail($rs[email_id],$subject,$mess,$headers);  
		}
	} 
	return true;
}
 
  
  function req_forbrands_brans_mail($ids,$case,$storeid=0){
	if($case=='Active'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Brand Request Active' and store_id = '0'"); 
	}
	if($case=='Inactive'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Brand Inactive Request' and store_id = '0'");
	} 
	if($case=='Cancle'){ 
		 $Qryrs = $this->db_query("select * from #_template where title ='Brand Cancel Request' and store_id = '0'");
	}
	
	if(!$storeid){ $adminEmail = SITE_MAIL;}else{
	$adminEmail = $this->getSingleresult("select email from #_request_brand where brand_id='$ids'");
	}        
			 $remark = $this->getSingleresult("select remark from #_request_brand where store_user_id='$ids' and brand_id='$storeid'");
			 $store_name = $this->getSingleresult("select title from #_store_detail where store_user_id='$ids'");
			 
			$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail;
			$idqry = $this->db_query("select email_id,name,user_name from #_store_user where pid='$storeid'"); 
			if(mysql_num_rows($idqry)){
		    while($rs = $this->db_fetch_array($idqry)){
		    $tempRes = $this->db_fetch_array($Qryrs); 
			$subject = $tempRes[subject]; 
			$mess = $tempRes[body];
			$subject = str_replace("%%brandname%%",$rs[name] ,$subject); 
			$subject = str_replace("%%storename%%",$store_name ,$subject); 
			
			$mess = str_replace("%%sitename%%",SITE_PATH,$mess);
			$mess = str_replace("%%brandname%%",$rs[name] ,$mess);  
			$mess = str_replace("%%storename%%",$store_name,$mess);
			$mess = str_replace("%%remark%%",$remark,$mess);
			$mess = str_replace("%%email%%",$rs[email_id],$mess);
			$mess = str_replace("%%username%%",$rs[user_name],$mess);
			@mail($rs[email_id],$subject,$mess,$headers); 
			 
		}
	} 
	return true;
}
 
function renewal_hosting($storeid){ 
	$create_date = $this->getSingleresult("select create_date from #_store_detail where  store_user_id = '$storeid'");
	$reCreate_date = $this->getSingleresult("select create_date from #_reg_renewal where  user_id = '$storeid' order by pid desc limit 1"); 
	$noOfDays = $this->getSingleresult("select noOfDays from #_store_detail where  store_user_id = '$storeid'");
    $Qryrs = $this->db_query("select * from #_template where title ='Renewal Hosting' and store_id = '0'"); 
	$adminEmail = SITE_MAIL;  
	if($reCreate_date){
		$create_date=$reCreate_date;
	}
	$start_date=date('d/m/y',strtotime($create_date));
	$date = date_create($create_date);  
    date_add($date, date_interval_create_from_date_string($noOfDays.' days'));
    $expired_date=date_format($date, 'd/m/y');
	$user1 = $this->db_query("select * from #_store_user where pid='$storeid'");
	$user_data = $this->db_fetch_array($user1);
	$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail; 
	$user = $this->db_query("SELECT * FROM #_reg_renewal where user_id='$storeid' order by pid DESC LIMIT 1");
	$rs = $this->db_fetch_array($user);
	$plan_name = $this->getSingleresult("select name from #_plans where pid='$rs[plan_id]'");
	$storeName = $this->getSingleresult("select title from #_store_detail where store_user_id='$storeid'");
	$store_url = $this->getSingleresult("select store_url from #_store_detail where store_user_id='$storeid'");
	$store_url="http://".$store_url.".fizzkart.com";
	$tempRes = $this->db_fetch_array($Qryrs); 
	$subject = $tempRes[subject]; 
	$mess = $tempRes[body];
	$store_LoginUrl="http://fizzkart.com/user-login";
	$subject =str_replace("%%storename%%",$user_data[name],$subject); 
	$mess = str_replace("%%storename%%",$storeName,$mess); 
	$mess = str_replace("%%name%%",$user_data[name],$mess);
	$mess = str_replace("%%planname%%",$plan_name,$mess);
	$mess = str_replace("%%startdate%%",$start_date,$mess);
	$mess = str_replace("%%expireddate%%",$expired_date,$mess); 
	$mess = str_replace("%%amount%%",$rs[total_amount],$mess); 
	$mess = str_replace("%%storeurl%%",$store_url,$mess); 
	$mess = str_replace("%%storeloginurl%%",$store_LoginUrl,$mess); 
	@mail($user_data[email_id],$subject,$mess,$headers);  
	return true;
}

function getTotalProds($current_store_user_id){ 
		$prods = array();
		$homep=$this->db_query("select pid  from #_products_user where status = 'Active' 
		and  store_user_id ='$current_store_user_id'   ");
		if(mysql_num_rows($homep)){
			while($res=$this->db_fetch_array($homep)){@extract($res);
				$prods[] = $pid;
			}
		} 
		$brand_p = $this->db_query("select prod_id from #_barnds_product where status='Active' and store_user_id ='$current_store_user_id' ");
		if(mysql_num_rows($brand_p)){
			while($bp=$this->db_fetch_array($brand_p)){
				$prods[] = $bp[prod_id];
			}
		} 
		return $prods; 
 }  
 function getPrice($pid,$current_store_user_id){  
	$priceQuery = $this->db_query("select price,offerprice from #_products_user where pid='$pid' and store_user_id ='$current_store_user_id'");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery);
		$price = $bp[price];
		$offerprice = $bp[offerprice]; 
	}else{ 
		$price = $this->getSingleresult("select price  from #_products_user where pid='$pid'");
		$offerprice = $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$current_store_user_id' ");   
	} 
	if($offerprice<$price && $offerprice >0 && $offerprice!=$price ) {
		return $offerprice;
	}  
	return $price;
 }
 
 function pageView($current_store_user_id){  
	   $rest = array('css','font','fonts','js','tools','member');
	   $cur_page = $this->geturl();
	   $err = 0;
	   foreach($rest as $val){
			if(preg_match("/$val/",$cur_page)) 
				$err = 1;
	   }
	   $ip = $_SERVER['REMOTE_ADDR']; 
	   $ssid = session_id();  
	   $hostaddress = gethostbyaddr($ip);
	   $arr=array();
	   $arr[ip]=$ip; 
	   $arr[pc_name]=$hostaddress;
	   $arr[url]=$cur_page; 
	   $arr[store_user_id]=$current_store_user_id;
	   $arr[ssid]=$ssid ;
	   $check = $this->getSingleresult("select count(*) from #_page_view where ssid='$ssid' and url = '$cur_page' ");
	   if(!$check && $cur_page!='http://fizzkart.com/js/bootstrap.min.js') $this->sqlquery("rs","page_view",$arr); 
	   return true;
 }
 function getTotalProdsByCat($current_store_user_id,$cat_id){  
		$prods = array();
		$homep=$this->db_query("select pid  from #_products_user where status = 'Active' 
		and  store_user_id ='$current_store_user_id' and cat_id = '$cat_id'   ");
		if(mysql_num_rows($homep)){
			while($res=$this->db_fetch_array($homep)){@extract($res);
				$prods[] = $pid;
			}
		} 
		$brand_p = $this->db_query("select prod_id from #_barnds_product where status='Active' and store_user_id ='$current_store_user_id' and cat_id = '$cat_id'  ");
		if(mysql_num_rows($brand_p)){
			while($bp=$this->db_fetch_array($brand_p)){
				$prods[] = $bp[prod_id];
			}
		} 
		return $prods; 
		
 } 
 
 
 public function getImageSrc($imagename) {  
  $orgi = SITE_PATH."uploaded_files/orginal/".$imagename; 
  $thumb = SITE_PATH."uploaded_files/thumb/".$imagename; 
  $noimg = SITE_PATH."image/noimg.jpg";  
  $image;
  if(!$imagename){
    return $noimg; 
  }   
	if (@fopen($thumb,"r"))  
		 return $thumb;
	else   
		if (@fopen($orgi,"r"))  
		 return $orgi;
	  
  return $noimg; 
 }
 function getCountStoreAndBrandByCat($cat_id){
	$arr = array();
 	$sqlquery=$this->db_query("select plan_id from #_plans_category where cat_id ='$cat_id' group by plan_id"); 
	if(mysql_num_rows($sqlquery)){
		$plans = array();
		while($resl=$this->db_fetch_array($sqlquery)){ 
			$plans[] = $resl[plan_id];
		}
		if(count($plans)){ 
			$arr[store_count] = $this->getSingleresult("select count(*) from  fz_store_detail as t1, fz_store_user as t2 where t1.plan_id in (".implode(',',$plans).") 
			and t1.status = 'Active' and  t1.store_user_id = t2.pid and t2.type = 'store' " );

			$arr[brand_count] = $this->getSingleresult("select count(*) from fz_store_detail as t1, fz_store_user as t2 where t1.plan_id in (".implode(',',$plans).") 
			and t1.status = 'Active' and t1.store_user_id = t2.pid and t2.type = 'brand' " );
		} 
	}

	return $arr;
 
 }
 function getAllBrandsByCat($cat_id){
	$arr = array();
 	$sqlquery=$this->db_query("select plan_id from #_plans_category where cat_id ='$cat_id' group by plan_id"); 
	if(mysql_num_rows($sqlquery)){
		$plans = array();
		while($resl=$this->db_fetch_array($sqlquery)){ 
			$plans[] = $resl[plan_id];
		}
		if(count($plans)){  
			$brand_p = $this->db_query("select t1.store_url,t1.title from fz_store_detail as t1, fz_store_user as t2 where t1.plan_id in (".implode(',',$plans).") 
			and t1.status = 'Active' and t1.store_user_id = t2.pid and t2.type = 'brand' " );
		} 
		if(mysql_num_rows($brand_p)){
			while($bp=$this->db_fetch_array($brand_p)){
				$link = "http://".$bp[store_url].".fizzkart.com";
				$list .= '<div class="logonamebox"><a href="'.$link.'">'.ucwords(strtolower($bp[title])).'</a></div>'; 
			}
		} 
	}
	if($list==""){ $list .= '<div class="logonamebox"><a href="#">NA</a></div>';} 
	return $list;
 
 }
 function getAllProductCategoriesByCat($cat_id,$cat_type='',$pcatid){
	$pcatname = $this->baseurl21($this->getSingleresult("select name from #_category where pid = '".$cat_id."'"));
  	$sqlquery12=$this->db_query("select cat_id from #_plans_category where parent ='$cat_id' group by cat_id"); 
	if(mysql_num_rows($sqlquery12)){
		$cats = array();
		while($catrs=$this->db_fetch_array($sqlquery12)){  
			$sqlquery=$this->db_query("select plan_id from #_plans_category where cat_id ='".$catrs[cat_id]."' group by plan_id"); 
			if(mysql_num_rows($sqlquery)){
				$plans = array();
				while($resl=$this->db_fetch_array($sqlquery)){ 
					$plans[] = $resl[plan_id];
				}
				if($cat_type){ 
					$link = SITE_PATH."store-category/".$pcatname."/".$cat_id."?cat_type=".$cat_type."&productcategory=".$cname."&pcatid=".$catrs[cat_id]; 
					$cond = "and t2.type = '$cat_type' ";
				}else{
					$link = SITE_PATH."store-category/".$pcatname."/".$cat_id."?productcategory=".$cname."&pcatid=".$catrs[cat_id]; ; 
					$cond = "and (t2.type = 'brand' or t2.type = 'store')";
				}
				if(count($plans)){  
					$cnt = $this->getSingleresult("select count(*) from fz_store_detail as t1, fz_store_user as t2 where t1.plan_id in (".implode(',',$plans).") 
					and t1.status = 'Active' and t1.store_user_id = t2.pid $cond  " );
				}  
 				$cname = $this->removeSlash($this->getSingleresult("select name from #_category where pid = '".$catrs[cat_id]."'"));
				
				$css = "";
				if($pcatid && $pcatid==$catrs[cat_id]){ $css =  'style="color:#000;font-weight:bold !important;"';}
				$list .= '<div class="logonamebox"><a '.$css.' href="'.$link.'">'.ucwords(strtolower($this->removeSlash($cname))).' ('.$cnt.')</a></div>';  
			} 
		}
	} 
	if($list==""){ $list .= '<div class="logonamebox"><a href="#">NA</a></div>';} 
	return $list;
 
 } 
 function getAllStoreTypeByCat($rawqry,$cat_type='',$storekey='',$mainlinik){ 
	 $qry = $this->db_query($rawqry);
	 $arr = array();
	 $allpid = array();
	 if(mysql_num_rows($qry)){
		while($rs=$this->db_fetch_array($qry)){ 
			 $allpid[] = $rs[pid];
			 $key = array();
			  if($rs[storekeys]){
					$key = explode('$',$rs[storekeys]);
					if(count($key)){
						foreach($key as $val){
							if($val){
								if(!in_array($val,$arr)){
									$arr[] = $val;
								}
							}
						}
					}
			  }	
		}
	 } 
	 if($cat_type!=''){ $cnd =  "and t2.type = '$cat_type' "; } 
	 $cururl  = str_replace('%20',' ',$this->geturl());
	 $oldurl =  "storekey=".$storekey;
	 if(count($arr)){  
		foreach($arr as $v){ 
			$link = "";
			$cnt = $this->getSingleresult("select count(*) from fz_store_detail as t1, fz_store_user as t2 where  
					  t1.status = 'Active'  and t1.pid in (".implode(',',$allpid).") and t1.store_user_id = t2.pid and t1.storekeys like '%$".$v."$%'  $cnd "); 
			if($storekey){ 
				$newurl = "storekey=".$v; 
				$link =  str_ireplace($oldurl,$newurl,$cururl);
			}else{
				 $pos = strpos($cururl,'?'); 
				 if($pos){
					$link = $cururl."&storekey=".$v;
				 }else{
					  $link = $cururl."/?storekey=".$v;
				 }
			} 
			$css  ="";
			if($storekey && $storekey==$v){ $css =  'style="color:#000;font-weight:bold !important;"';}
			$list .= '<div class="logonamebox"><a '.$css.' href="'.$link.'">'.ucwords(strtolower($v)).'('.$cnt.')</a></div>';
		}
	 }else{
		$list .= '<div class="logonamebox"><a href="#">NA</a></div>'; 
	 } 
	 return $list;
 }

 function getProductCategory($qry){
	 $sqlquery=$this->db_query($qry); 
	 $store_user_id[] = 0;
	 if(mysql_num_rows($sqlquery)){
		 while($rs=$this->db_fetch_array($sqlquery)){ 
			$store_user_id[] = $rs[store_user_id];		
		 }	 
	 }
	 $qryforcat=$this->db_query(" select cat_id, name from #_store_menu where parent = '0' and name!='' and store_user_id in (".implode(',',$store_user_id).") group by cat_id "); 
	 if(mysql_num_rows($qryforcat)){
		 while($rs2=$this->db_fetch_array($qryforcat)){ 
			$css  ="";
			$cnt = $this->getSingleresult("select count(*) from #_store_menu  where store_user_id in (".implode(',',$store_user_id).") and cat_id = '".$rs2[cat_id]."' ");
			if($_GET[pcatid]==$rs2[cat_id]){ $css =  'style="color:#000;font-weight:bold !important;"';}
			$link = SITE_PATH."search/?search=1&key=".$_GET[key]."&searchfor=".$_GET[searchfor]."&productcategory=".ucwords($this->baseurl21($rs2[name]))."&pcatid=".$rs2[cat_id];

			$list .= '<div class="logonamebox"><a '.$css.' href="'.$link.'">'.ucwords($this->baseurl21($rs2[name])).'('.$cnt.')</a></div>';	
		 }	 
	 }
	 if($list=="") $list .= '<div class="logonamebox"><a href="#">NA</a></div>';
	 return $list;
 }
	function getImageUrl($img, $w='', $h=''){ 
		if(file_exists('uploaded_files/orginal/'.$img) && $img!=""){
					  $tempUrl = SITE_PATH."uploaded_files/orginal/".$img;
		}else{
			$tempUrl=SITE_PATH."image/noimg.jpg";
		} 
		  
		// updated lines for no image available
		//$tempUrl = str_replace(" ","%20",$tempUrl);
			
		if($w!=''){
			$w='&amp;w=' . $w;
		}
		if($h!=''){
			$h='&amp;h=' . $h;
		}
		if($tempUrl!=''){		
			if(preg_match('/http/i',$tempUrl)){		
				$imgthumb = SITE_PATH . 'thumb/timthumb.php?src='.$tempUrl.$w .$h.'&q=100';
			}else{
				$imgthumb = SITE_PATH. 'thumb/timthumb.php?src='.$tempUrl.$w.$h.'&q=100';
			}
		}
		return $imgthumb;
	}
	public function getextention1($fname){
		$fext=explode(".",$fname);
		$ext=$fext[0];
		return $ext;
	}
	 
function login(){ 
	if($this->is_post_back() || $_GET['user']!=''){
			@extract($_POST);  
			if($_GET['user']){  
				$password = $this->getSingleresult("select password from #_store_user where `user_name`='".$this->decryptcode($_GET['user'])."'");  
				$password = $this->decryptcode($password);
				$user_name= $this->decryptcode($_GET['user']);
				$_POST[type]='member';
			}		
			if($_SESSION[uname]=='' && $_SESSION[fname]==''){  
				if($_POST[type]=='member'){ 
					$rsAdmin_login = $this->db_query("select pid,type, status, name, email_id from #_store_user where `user_name`='".$user_name."' and  `password`='".$this->encryptcode($password)."'");
					if(mysql_num_rows($rsAdmin_login)){
						$arrAdmin_login = $this->db_fetch_array($rsAdmin_login);
						if($arrAdmin_login[status]=='Active'){ 
							/********** cookie work *********/
							$year = time() + 31536000;
							$hour = time() + 3600;  
							if(!$mremember) {
								setcookie('mremember','', $year);
								setcookie('m_user','', $year);
								setcookie('m_pass', '', $year); 
								
							} 
							if ($mremember == "1"){ 
							  //if the Remember me is checked, it will create a cookie. 
							  setcookie('mremember', 1, $year);
							  setcookie('m_user',$user_name, $year);
							  setcookie('m_pass', $_POST['password'], $year); 
							}
							/********** cookie work *********/   
							$_SESSION[uid] = $arrAdmin_login[pid]; 
							$_SESSION[usertype] = $arrAdmin_login[type];
							$_SESSION[store_id] = $this->getSingleresult("select pid from #_store_detail where `store_user_id`='".$_SESSION[uid]."'");
							$_SESSION[eid] = $arrAdmin_login[email_id];
							$_SESSION[uname] = $arrAdmin_login[name];
							header("Location:".SITE_PATH_MEM); die;  
						}
						else{
						$er= '<p class="errormsg2" >Inactive Account, Please contact to administrator!</p>';
						} 
					} else {
					$er= '<p class="errormsg2"><span class="cross_imge"></span>Invalid User name and password. Try again!</p>';
					} 

				}else{
					if(!$uremember) {
						setcookie('uremember','', $year);
						setcookie('u_user','', $year);
						setcookie('u_pass', '', $year); 
					}
					$rsAdmin_login = $this->db_query("select pid, fname, lname, email from #_members where `email`='".$email_id."' and  `password`='".$this->encryptcode($password)."'");
					if(mysql_num_rows($rsAdmin_login)){
						$arrAdmin_login = $this->db_fetch_array($rsAdmin_login);   
						$_SESSION[userid] = $arrAdmin_login[pid]; 
						//$_SESSION[user_store_id] = $current_store_id; 
						$_SESSION[email] = $arrAdmin_login[email];
						$_SESSION[fname] = $arrAdmin_login[fname];
						$_SESSION[lname] = $arrAdmin_login[lname]; 
						/********** cookie work *********/
						$year = time() + 31536000;
						$hour = time() + 3600;
						//if the Remember me is checked, it will create a cookie.
						if ($uremember == "2"){
						   setcookie('uremember', 2, $year);
						   setcookie('u_user',$email_id, $year);
						   setcookie('u_pass', $_POST['password'], $year);   
						}
						/********** cookie work *********/ 

						$this->redir(SITE_PATH."profile",true);die;

					} 			
					else {
					$er= '<p class="errormsg2"><span class="cross_imge"></span>Invalid email id and password. Try again!</p>';
					}

				}
			}else{
			// unset($_SESSION['uname']);
			$er= '<p class="errormsg2"><span class="cross_imge"></span> Other Store/Brand User already Loing. Please firstly click here for<a href="http://fizzkart.com/logout"> Logout!</a></p>';
			}
	}		
	return $er;
}
/*
function google_fb_Login($me){
if(isset($me)){  
    $email = $cms->getSingleresult("select email from #_members where email='".$user['email']."'");
	if($me['displayName']) $name = explode(' ',$me['displayName']);
	$_SESSION[fname] = $name[0];
	$_SESSION[lname] = $name[1];
	if($email!=$user['email']){
		$_SESSION['gplusuer'] = $me; // start the session
		$_SESSION[userid]= $me; 
		$_POST[fname]=$name[0];
		$_POST[lname]=$name[1];
		$_POST[gender]=$me['gender'];
		$_POST[email]=$user['email'];
		$_POST[city]=$me['placesLived'][0]['value'];
		$cms->sqlquery("rs","members",$_POST); 
		$pid = $cms->getSingleresult("select pid from #_members where email='".$user['email']."'");
		$_SESSION[uid]=$pid;
		$_SESSION[userid]=$pid; 
		$lastId  = mysql_insert_id();  
		$adminEmail = SITE_MAIL;
		$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail; 				 
		$ch = $cms->db_query("select * from #_template where title ='Registration Update Link' and store_id = '0' ");				 
		$tempRes = $cms->db_fetch_array($ch);
		$subject2 = $tempRes[subject];  
		$link="http://fizzkart.com/registration-user?email_id=".$user['email']; 
		$subject2 = str_replace("%%sitename%%",SITE_PATH,$subject2); 
		$subject2 = str_replace("%%link%%",$link,$subject2);
		$mess2 = $tempRes[body]; 
		$mess2 = str_replace("%%subdomain%%",SITE_PATH,$mess2);
		$mess2 = str_replace("%%name%%", $_POST[fname].' ' .$_POST[lname],$mess2);
		$mess2 = str_replace("%%sex%%", $_POST[gender],$mess2);
		$mess2 = str_replace("%%email%%", $_POST[email],$mess2);
		$mess2 = str_replace("%%city%%", $_POST[city],$mess2); 
		$mess2 = str_replace("%%link%%", $link,$mess2);
		@mail($_POST[email], $subject2, $mess2,$headers);  
		$er= '<p align="left" style="color:green; margin:10px 0; display:block; " >Thank you for successful registration.</p>';
		$_POST = false;
			if($base!=""){
				$expire=time()+120;
                $path="http://$base/profile"; 
                setcookie("user_id",$pid,$expire,$path,"fizzkart.com");
				header("Location: http://$base/profile");die; 
				//$cms->redir($base."/profile",true);die;
				}else{ $cms->redir(SITE_PATH."profile",true);die;  }  
	   }else{ 	
	            $_SESSION['gplusuer'] = $me; // start the session
				$_SESSION[userid]=$_SESSION['gplusuer']; 
				$pid = $cms->getSingleresult("select pid from #_members where email='".$user['email']."'");
				$_SESSION[uid]=$pid;
				$_SESSION[userid]=$pid;
				if($base!=""){
				$expire=time()+120;
                $path="http://$base/profile"; 
                setcookie("user_id",$pid,$expire, $path, "fizzkart.com");
				header("Location: http://$base/profile");die; 
				//$cms->redir($base."/profile",true);die;
				}else{ $cms->redir(SITE_PATH."profile",true);die; 
				
				}  
	   }
}  
   return $er;

}
*/
	function array_is_unique($array) {
		   return array_unique($array) == $array;
		}
  function getPriceOnly($pid,$current_store_user_id){  
	$priceQuery = $this->db_query("select dprice from #_product_price where proid='$pid' and store_id ='$current_store_user_id'");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery);
		$price = $bp[dprice]; 
	}else{ 
		$price = $this->getSingleresult("select dprice  from #_product_price where proid='$pid'");
		$offerprice = $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$current_store_user_id' ");   
	} 
	  
	return $price;
 } 
 function getPriceSize($pid,$current_store_user_id,$dsize){  
 $price = 0;
 if($dsize == 'NA') $dsize = "";
 //echo "select pid from #_product_price where proid ='".$pid."' and store_id ='$current_store_user_id' and dsize = '$dsize'"; 
 $check=$this->db_query("select pid from #_product_price where proid ='".$pid."' and store_id ='$current_store_user_id' and dsize = '$dsize'");  
 if(mysql_num_rows($check)){
    $pro_pi=$this->db_fetch_array($check);  
	$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where pid='".$pro_pi[pid]."' and store_id ='$current_store_user_id'");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery);
		$price = $bp[dprice]; 
	    $offerprice = $bp[dofferprice]; 
 }
	}else{ 
		$price = $this->getSingleresult("select dprice from #_product_price where proid='$pid'");
		$offerprice = $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$current_store_user_id' ");   
	} 
	 if($offerprice<$price && $offerprice >0 && $offerprice!=$price ) {
		return $offerprice;
	}  
	return $price;
 } 
  
function getOfferpriceOnly($pid,$current_store_user_id){  
	$priceQuery = $this->db_query("select  dofferprice from #_product_price where proid='$pid' and store_id ='$current_store_user_id'");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery); 
		$price = $bp[dofferprice]; 
	}else{ 
		$price = $this->getSingleresult("select dofferprice  from #_product_price where proid='$pid'");
		$offerprice = $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$current_store_user_id' ");   
	} 
	 if($offerprice<$price && $offerprice >0 && $offerprice!=$price ) {
		return $offerprice;
	} 
	return $price;
 } 
function storeRegMail($city1,$city2,$store_url){
	$mess = "Thanks for Registring with us as ".$store_url.".fizzkart.com, your account will be activate soon. Admin";
				$adminEmail = SITE_MAIL;
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail; 				 
				$ch = $this->db_query("select * from #_template where title ='Store Registration' and store_id = '0' ");				 
				$tempRes = $this->db_fetch_array($ch);
				$subject2 = $tempRes[subject]; 
				$subject2 = str_replace("%%storename%%",SITE_PATH,$subject2);
				$mess2 = $tempRes[body]; 
				$mess2 = str_replace("%%subdomain%%", SITE_PATH,$mess2);
				$mess2 = str_replace("%%name%%", $_POST[name],$mess2);
				$mess2 = str_replace("%%uname%%", $_POST[user_name],$mess2);
				$mess2 = str_replace("%%password%%",$_POST[password],$mess2);
				$mess2 = str_replace("%%mobile%%", $_POST[mobile],$mess2);
				$mess2 = str_replace("%%phone%%", $_POST[phone],$mess2);
				$mess2 = str_replace("%%email%%", $_POST[email_id],$mess2);
				$mess2 = str_replace("%%city_id%%",$city1,$mess2); 
				$mess2 = str_replace("%%address%%", $_POST[address],$mess2); 
				$mess2 = str_replace("%%pincode%%", $_POST[pincode],$mess2); 
				$mess2 = str_replace("%%title%%", $_POST[title],$mess2);
				if(!$_POST[tagline]) $_POST[tagline]  = "N/A";
			    $mess2 = str_replace("%%tagline%%", $_POST[tagline],$mess2); 
			    $mess2 = str_replace("%%store_url%%",$store_url.".fizzkart.com",$mess2); 
				$mess2 = str_replace("%%description%%", $_POST[description],$mess2); 
				$mess2 = str_replace("%%city_id2%%",$city2,$mess2); 
				$mess2 = str_replace("%%address2%%", $_POST[address2],$mess2); 
				$mess2 = str_replace("%%pincode2%%", $_POST[pincode2],$mess2);  
				@mail($_POST[email_id], $subject2, $mess2,$headers); 

}
function getAllProdsOfOffer($current_store_user_id,$cat_id,$brand_id=0){ 
	    $prods = array();
		if($brand_id){
			$prodqry =  $this->db_query("SELECT prod_id FROM fz_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$brand_id."' and cat_id = '".$cat_id."'  ");  
			if(mysql_num_rows($prodqry)){
				while($pr=$this->db_fetch_array($prodqry)){
					$prods[] = $pr[prod_id];
				}
			}
		}else{
			$prodqry =  $this->db_query("SELECT pid FROM fz_products_user where store_user_id='$current_store_user_id' and status = 'Active' and cat_id =  '".$cat_id."'  ");  
			if(mysql_num_rows($prodqry)){
				while($pr=$this->db_fetch_array($prodqry)){
					$prods[] = $pr[pid];
				}
			} 
		}
		return array_unique($prods);
   }
public function getDomainSiteEmails(){ 
	$uid_arr =array();
	$query=$this->db_query("select user_id from #_member_access where store_id = '".$_SESSION[uid]."' ");
	if(mysql_num_rows($query)){
		  while($res=$this->db_fetch_array($query)){
			$uid_arr[] = $res[user_id];
		  }
	} 
    foreach($uid_arr as $key =>$val){
		    if($val){
				$email= $this->getSingleresult("select email from fz_members  where status='Active' and pid='".$val."' ");
					if($email){
					$emails .= $email.", "; 
					}
			}
		
    } 
		$emails = substr($emails,0,-2);
		return $emails;
}

function renewal_sms($storeid){  
	$noOfMessage = $this->getSingleresult("select noOfMessage from #_store_detail where  store_user_id = '$storeid'");
    $Qryrs = $this->db_query("select * from #_template where title ='Renewal SMS' and store_id = '0'"); 
	$adminEmail = SITE_MAIL; 
	$user1 = $this->db_query("select * from #_store_user where pid='$storeid'");
	$user_data = $this->db_fetch_array($user1);
	$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail; 
	$user = $this->db_query("SELECT * FROM #_reg_renewal where user_id='$storeid' order by pid DESC LIMIT 1");
	$rs = $this->db_fetch_array($user);
	$plan_name = $this->getSingleresult("select sms_pack from #_sms_pack where pid='".$_SESSION[sms_pack]."'");
	$plan_amount = $this->getSingleresult("select amount from #_sms_pack where pid='".$_SESSION[sms_pack]."'");
	$sms_qty = $this->getSingleresult("select qty from #_sms_pack where pid='".$_SESSION[sms_pack]."'");
	$storeName = $this->getSingleresult("select title from #_store_detail where store_user_id='$storeid'");
	$store_url = $this->getSingleresult("select store_url from #_store_detail where store_user_id='$storeid'"); 
	$store_url="http://".$store_url.".fizzkart.com";
	$tempRes = $this->db_fetch_array($Qryrs); 
	$subject = $tempRes[subject]; 
	$mess = $tempRes[body];
	$store_LoginUrl="http://fizzkart.com/user-login";
	$subject =str_replace("%%storename%%",$user_data[name],$subject); 
	$mess = str_replace("%%storename%%",$storeName,$mess); 
	$mess = str_replace("%%name%%",$user_data[name],$mess);
	$mess = str_replace("%%planname%%",$plan_name,$mess);
	$mess = str_replace("%%amount%%",$plan_amount,$mess);
	$mess = str_replace("%%smsqty%%",$sms_qty,$mess); 
	$mess = str_replace("%%totalsms%%",$noOfMessage,$mess); 
	$mess = str_replace("%%storeurl%%",$store_url,$mess); 
	//$mess = str_replace("%%storeurlregards%%",$store_urlr,$mess); 
	$mess = str_replace("%%storeloginurl%%",$store_LoginUrl,$mess); 
	@mail($user_data[email_id],$subject,$mess,$headers);  
	return true;
} 
function breadcrumbs($text = '<font line-height: 24px;font-size: 18px;font-weight: normal;color: #FFF;text-shadow: 1px 1px 3px #999;float: left;
		display: block;></font> ', $sep = '&raquo;', $home = 'Home') {
		//Use RDFa breadcrumb, can also be used for microformats etc.
		$bc     = $text;
		//Get the website:
		//$site   =   'http://'.$_SERVER['HTTP_HOST'];
		//Get all vars en skip the empty ones
		$crumbs =   array_filter( explode("/",$_SERVER["REQUEST_URI"]) );
		//Create the home breadcrumb
		$bc    .=   '<a href="'.$site.'" rel="v:url" property="v:title">'.$home.'</a>'.$sep; 
		//Count all not empty breadcrumbs
		$nm     =   count($crumbs);
		$i      =   1;
		//Loop the crumbs
	foreach($crumbs as $crumb){
		//Make the link look nice
		$link    =  ucfirst( str_replace( array(".php","-","_"), array(""," "," ") ,$crumb) );
		//Loose the last seperator
		$sep     =  $i==$nm?'':$sep;
		$sep= preg_replace('/[0-9]+/', '', $sep);
		//Add crumbs to the root
		$site   .=  '/'.$crumb; 
		//Make the next crumb
		$link= preg_replace('/[0-9]+/', '', $link); 
		$link = preg_replace("/search.*/", "", $link);
		$link = preg_replace("/[&].*/", "", $link);  
		
		//$link = preg_replace("Tools",'Home', $link);
		$link = strtok($link, '?');
		if(empty($link)){ 
		$sep = str_replace('/search.*/','',$link);
		} 
		$bc .=  '<a href="'.$site.'" rel="v:url" property="v:title">'.$link.' </a> '.$sep;
		$i++; 
		
	} 
		 $bc = preg_replace('/Home/','',$bc);
		 $bc = preg_replace('/Catalog/','',$bc);
		 $bc = preg_replace('/Tools /','Home',$bc);
		 $bc = preg_replace('/Member /','Home',$bc);
         //$bc = preg_replace('/&raquo;Home/','Home',$bc); 
		 //$bc = preg_replace("/&raquo;.home/", '', $bc);
		 $bc = str_replace('&raquo;<a href="/tools" rel="v:url" property="v:title">Home</a>','<a href="/tools" rel="v:url" property="v:title">Home</a>', $bc);
		 $bc = str_replace('&raquo;<a href="/tools/catalog" rel="v:url" property="v:title"> </a>','', $bc);
		 $bc = str_replace('&raquo;<a href="/member" rel="v:url" property="v:title">Home</a>','<a href="/member" rel="v:url" property="v:title">Home</a>', $bc);
		 $bc = str_replace('&raquo;<a href="/member/catalog" rel="v:url" property="v:title"> </a>','', $bc);
		//Return the result 
		 return $bc;
}

}

?>