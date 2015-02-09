<?php
class DAL {  
	//public function __construct(){} 
	private $var;
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
	 public function removeSlash($str) {
	 $badFriends = '/(\\\)/';
	 $str = preg_replace($badFriends, '', $str);
	  //$str = str_replace(" ",'_',$str);
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
	function roundUptoNearestN($biggs){ 
	   $biggs = (int)$biggs;
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
public function getStyles($storeid){
	$rsAdmin=$this->db_query("select color,scolor,font_weight,sfont_weight,font_style,sfont_style,font_size,sfont_size from #_store_detail where store_user_id='".$storeid."'");
	$arr = array();
	if(mysql_num_rows($rsAdmin)){ 
		$arrAdmin=$this->db_fetch_array($rsAdmin);
		@extract($arrAdmin);
		$arr[] = "color: #$color; $font_weight; $font_style; font-size:$font_size"."px;";
		$arr[] = "color: #$scolor; $sfont_weight; $sfont_style; font-size:$sfont_size"."px;";
		return $arr;
	}
	return $arr;
}
public function sendSms($number,$mess,$storeid){
	$noOfMessage = $this->getSingleresult("select noOfMessage from #_store_detail where pid = '".$storeid."' ");
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


 function getImageUrl($img, $w='', $h=''){ 
	if(file_exists('../uploaded_files/orginal/'.$img) && $img!=""){
				  $tempUrl = SITE_PATH_M."uploaded_files/orginal/".$img;
	}else{
		$tempUrl=SITE_PATH_M."image/noimg.jpg";
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
	$imgthumb = SITE_PATH_M . 'thumb/timthumb.php?src='.$tempUrl.$w .$h.'&q=100';
	}else{
	$imgthumb = SITE_PATH_M. 'thumb/timthumb.php?src='.$tempUrl.$w.$h.'&q=100';
	}
	}
	return $imgthumb;
	}

	function getFeaturedProds($current_store_user_id,$current_store_type){ 
		$prods = array();
		$homep=$this->db_query("select pid  from #_products_user where status = 'Active' 
		and  store_user_id ='$current_store_user_id' and show_home = '1' ");
		if(mysql_num_rows($homep)){
			while($res=$this->db_fetch_array($homep)){@extract($res);
				$prods[] = $pid;
			}
		}
		if(!count($prods)){ 
			$homep=$this->db_query("select pid  from #_products_user where status = 'Active' 
			and  store_user_id ='$current_store_user_id' and clicks > 0 ");
			if(mysql_num_rows($homep)){
				while($res=$this->db_fetch_array($homep)){@extract($res);
					$prods[] = $pid;
				}
			}
		}
		if(!count($prods)){ 
			$brand_p = $this->db_query("select prod_id from #_barnds_product where status='Active' and store_user_id ='$current_store_user_id' limit 15");
			if(mysql_num_rows($brand_p)){
				while($bp=$this->db_fetch_array($brand_p)){
					$prods[] = $bp[prod_id];
				}
			}
	 
		} 
		return $prods; 
 } 
 function getStoreProductByCatid($catid,$current_store_user_id){ 
	//$prods[] = 0;
	//$t1 = $this->getSingleresult("select count(*) from #_products_user where store_user_id='$current_store_user_id' and status = 'Active' and cat_id = '$catid' " ); 
	$userp = $this->db_query("select pid from #_products_user where store_user_id='$current_store_user_id' and status = 'Active' and cat_id = '$catid' ");
	// return mysql_num_rows($userp);
	if(mysql_num_rows($userp)){
				while($up=$this->db_fetch_array($userp)){
					$prods[] = $up[pid];
				}
	} 
	$brandsarr = array();
	$brandQry = $this->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
	if(mysql_num_rows($brandQry)){
		while($brs=$this->db_fetch_array($brandQry)){
			$brandsarr[] =$brs[brand_id];
		}
	}
	if(count($brandsarr)>0){
		$brandp = $this->db_query("select prod_id from #_barnds_product where store_user_id='$current_store_user_id' and brand_id in (".implode($brandsarr,',').")  and status = 'Active' and cat_id = '$catid' ");
		
		if(mysql_num_rows($brandp)){
					while($bp=$this->db_fetch_array($brandp)){
						$prods[] = $bp[prod_id];
					}
		}
	}
	//$prods=array_unique($prods);
	if(!count($prods)) return "0";
	$total = $this->getSingleresult("select count(*) from #_products_user where pid in (".implode(",",$prods).") and status = 'Active' and cat_id = '$catid' " );
	//$total = $t2+$t1;
	return $total;
 }
 function getBothPrice($pid,$current_store_user_id){ 
	if($_REQUEST[price]){ return $this->getBothPrice2($pid,$current_store_user_id);}
	$price = array();
	$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where proid='$pid' and store_id ='$current_store_user_id'");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery);
		$price[] = $bp[dprice];
		$price[] = $bp[dofferprice]; 
	}else{ 
		$price[] = $this->getSingleresult("select dprice from #_product_price where proid='$pid'");
		$price[] = $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$current_store_user_id' ");   
	}
	return $price;
 }
 function getBothPrice2($pid,$current_store_user_id){ 
	if($_REQUEST[price]) {$arr = explode('-',$_REQUEST[price]); }
	$price = array();
	$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where proid='$pid' and store_id ='$current_store_user_id'");
	if(mysql_num_rows($priceQuery)){
		while($bp=$this->db_fetch_array($priceQuery)){
		    $pricess = $bp[dprice]; 
			if($bp[dofferprice]>0 && $bp[dofferprice] < $bp[dprice]) $pricess = $bp[dofferprice]; 
			if($pricess>=(int)$arr[0] && $pricess<=(int)$arr[1]){
				$price[] = $bp[dprice];
				$price[] = $bp[dofferprice]; 
				return $price;
			} 
		}
	}else{ 
		$priceQuery = $this->db_query("select dprice,dsize from #_product_price where proid='$pid' ");
		if(mysql_num_rows($priceQuery)){
			while($bp=$this->db_fetch_array($priceQuery)){
				$offerprice = $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and dimension = '".$bp[dsize]."' and store_user_id = '$current_store_user_id' ");
				$pricess = $bp[dprice];
				if($offerprice>0 && $offerprice<$bp[dprice]) $pricess = $offerprice; 
				if($pricess>=$arr[0] && $pricess<=$arr[1]){
					$price[] = $bp[dprice];
					$price[] = $offerprice; 
					return $price;
				} 
			}
		}
		 
	}
	return $price;
 }

 function getPrice($pid,$current_store_user_id){  
	$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where proid='$pid' and store_id ='$current_store_user_id'");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery);
		$price = $bp[dprice];
		$offerprice = $bp[dofferprice]; 
	}else{ 
		$price = $this->getSingleresult("select dprice  from #_product_price where proid='$pid'");
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
			if(preg_match("/$val/", $cur_page)) 
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
	   if($check) $err = 1;
	   if(!$err)  $this->sqlquery("rs","page_view",$arr); 
	   return true;
 }
 public function getImageSrc($imagename) { 
  $imagename = str_replace(" ",'%20',$imagename);
  $orgi = SITE_PATH_M."uploaded_files/orginal/".$imagename; 
  $thumb = SITE_PATH_M."uploaded_files/thumb/".$imagename; 
  $noimg = SITE_PATH_M."image/noimg.jpg"; 
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
  public function getImageOri($imagename) { 
	$imagename = str_replace(" ",'%20',$imagename);
	$orgi = SITE_PATH_M."uploaded_files/orginal/".$imagename;  
	if(!$imagename){
		return $noimg; 
	}    
	if (@fopen($orgi,"r"))  
		return $orgi; 
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
 function generateOrderid($length = 10) {
		$alphabets = range('A','Z');
		$numbers =range('1','9');
		//$orderId="$alphabets"."$numbers";
		//$additional_characters = array('.');
		$final_array = array_merge($alphabets,$numbers); 
		$password = ''; 
		while($length--) {
		  $key = array_rand($final_array);
		  $password .= $final_array[$key];
	           } 
		return $password;
		}  
  function getHomeCategory($sore_id){
  		$cat = array();
		$pcatcnt= $this->db_query("select count(*)  from #_store_menu where store_user_id ='$sore_id' and parent='0' ");  
		if($pcatcnt>=4){ 
			$catqry= $this->db_query("select cat_id from #_store_menu where store_user_id ='$sore_id' and parent='0'  order by rand() limit 4 ");  
			while($rs=$this->db_fetch_array($catqry)){
				$cat[] = $rs[cat_id];
			}
			 
		} 
		else{ 
			$scatcnt= $this->db_query("select count(*)  from #_store_menu where store_user_id ='$sore_id' and parent!='0' ");  
			if($scatcnt>=4){ 
				$catqry= $this->db_query("select cat_id from #_store_menu where store_user_id ='$sore_id' and parent!='0'  order by rand() limit 4 ");  
				while($rs=$this->db_fetch_array($catqry)){
					$cat[] = $rs[cat_id];
				}
				 
			} 
 		} 
		return $cat;
   } 
	
function getDiscountOfferPercent($pid, $store_user_id)
	{
	//$price = array();
	$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where proid='$pid' and store_id ='$store_user_id'");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery);
		$price = $bp[price];
		$offerprice = $bp[offerprice]; 
	}else{ 
		$price= $this->getSingleresult("select dprice  from #_product_price where pid='$pid'");
		$offerprice= $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$store_user_id' ");   
	} 
	$diff  =  $price - $offerprice;
	//per = ceil(($diff*100)/$price);
	return $diff; 
	}
	
  function checkoffer($prod_id,$store_user_id){
	$mess = array();
	$title = $this->getSingleresult("select title  from #_products_user where pid='$prod_id'");
	$cat_id = $this->getSingleresult("select cat_id  from #_products_user where pid='$prod_id'");
	$get_store_user_id =  $this->getSingleresult("select store_user_id  from #_products_user where pid='$prod_id'"); 
	if($cat_id){
		$today = date('Y-m-d');
		$checkperiodoffer = $this->db_query("select *  from #_offer where  cat_id = '$cat_id' and store_user_id = '$store_user_id' and '$today' >= dayfrom and   '$today' <= dayto   ");
		if(mysql_num_rows($checkperiodoffer)){
			if($get_store_user_id!=$store_user_id){
				$cond = " and brand_id ='$get_store_user_id' ";
			}else{
				$cond = " and brand_id ='0' ";
			}
			$rsult =$this->db_fetch_array($checkperiodoffer);
			$checkdetail = $this->db_query("select * from #_offer_detail where cat_id = '$cat_id' $cond and store_user_id = '$store_user_id'");
			if(mysql_num_rows($checkdetail)){   
				while($rs=$this->db_fetch_array($checkdetail)){extract($rs); 
					switch ($type){
						case "freeProd":
							$mess[] =  "On purchase of $onshop item(s) get $getfree items(s) free <b>till ".date('d, M Y',strtotime($rsult[dayto]))."</b> ";  
							break;
						case "flatPercent":
							$mess[] =  " Get $flatpercent % discount on each item <b>till ".date('d, M Y',strtotime($rsult[dayto]))."</b>"; 
							break;
						case "rangeQty":
							$mess[] =  "Get $qtyDisPercent % discount on shopping of product between $qty1 and $qty2 <b>till ".date('d, M Y',strtotime($rsult[dayto]))."</b>"; 
							break;
						case "rangeAmt":
							$mess[] = "Get Rs $discAmt discount on shopping of product between Rs. $amount1 and Rs. $amount2 <b>till ".date('d, M Y',strtotime($rsult[dayto]))."</b>"; 
							break;
						default:
					}
				}
			}
		}
 
	} 
	return $mess;
  }
  function checkofferProduct($prod_id,$store_user_id){
	$prod = array(); 
	$cat_id = $this->getSingleresult("select cat_id  from #_products_user where pid='$prod_id'");
	$get_store_user_id =  $this->getSingleresult("select store_user_id  from #_products_user where pid='$prod_id'"); 
	if($cat_id){
		$today = date('Y-m-d');
		$checkperiodoffer = $this->db_query("select *  from #_offer where  cat_id = '$cat_id' and store_user_id = '$store_user_id' and '$today' >= dayfrom and   '$today' <= dayto   ");
		if(mysql_num_rows($checkperiodoffer)){ 
			$checkdetail = $this->db_query("select * from #_offer_detail where cat_id = '$cat_id'  and store_user_id = '$store_user_id' ");
			if($get_store_user_id!=$store_user_id){
				$brand_p = $this->db_query("select prod_id from #_barnds_product where status='Active' and cat_id ='$cat_id' 
				and store_user_id ='$store_user_id' and prod_id!='$prod_id' "); 
				if(mysql_num_rows($brand_p)){
					while($bp=$this->db_fetch_array($brand_p)){
						$prod[] = $bp[prod_id];  
					}
				}
			}else{
				$pr = $this->db_query("select pid from #_products_user where status='Active' and  cat_id ='$cat_id' "); 
				if(mysql_num_rows($pr)){
					while($rs=$this->db_fetch_array($pr)){
						$prod[] = $rs[pid]; 
					}
				}
			}
			
			 
		}
	
	} 
	return $prod; 
  }
  function getAllofferProdByPid($prod_id,$current_store_user_id){
	  $cat_id = $this->getSingleresult("select cat_id  from #_products_user where pid='$prod_id'");
 	  $prod = array();
	  $brands = array();
	  $qry = $this->getSingleresult("select *  from #_offer where status='Active' and cat_id = '$cat_id'"); 
	  if($qry){  
				$pr = $this->db_query("select pid from #_products_user where status='Active' and cat_id in ($cat_id) and store_user_id ='$current_store_user_id'"); 
				if(mysql_num_rows($pr)){
					while($rs=$this->db_fetch_array($pr)){
						$prod[] = $rs[pid]; 
					}
				}
				$brand_p = $this->db_query("select prod_id from #_barnds_product where status='Active' and cat_id in ($cat_id) and store_user_id ='$current_store_user_id'");
				echo mysql_num_rows($brand_p);
				if(mysql_num_rows($brand_p)){
					while($bp=$this->db_fetch_array($brand_p)){
						$brands[] = $bp[prod_id];  
					}
				}
				if(count($brands)){
					$pr = $this->db_query("select pid from #_products_user where status='Active' and  pid in (".implode(',',$brands).")"); 
					if(mysql_num_rows($pr)){
						while($rs=$this->db_fetch_array($pr)){
							$prod[] = $rs[pid]; 
						}
					}
				}
				
		 
			} 
	 return $prod; 
  } 
  function getOfferProduct($ssid,$store_user_id){ 
	$arr = array();
	$cartprod=$this->db_query("select * from #_cart where  ssid = '$ssid' "); 
	$period = array();
	$periodcategory = array();
	$combo = array(); 
	$allcats = array();
	$normalprod = array(); 
	$periodtotalprice = 0; 
	$combototalprice = 0;
	$othertotalprice = 0;
	$alltotal = 0;
	$maincombo = $this->getMainComboProd($store_user_id); 
	$shippingCharge = 0;
	if(mysql_num_rows($cartprod)){
		 while($res = $this->db_fetch_array($cartprod)){ extract($res); 
			$cat_id = $this->getSingleresult("select cat_id  from #_products_user where pid='$proid' "); 
			$catname = $this->getSingleresult("select name  from #_store_menu where cat_id='$cat_id' and store_user_id ='$store_user_id'");  
			$producttitle = $this->getSingleresult("select title  from #_products_user where pid='$proid' "); 
			/*   Get Brand Id		 */
			$get_store_user_id = $this->getSingleresult("select store_user_id  from #_products_user where pid='$proid' "); 
			if($get_store_user_id==$store_user_id){
				$cond = " and brand_id  = '0' ";
			}else{
				$cond = " and brand_id  = '$get_store_user_id' ";
			}
			$shippingCharge = $shippingCharge+ $this->getShippingProd($proid,$store_user_id,$qty);
			/*   Get Brand Id		 */
			$price = $qty*$this->getPriceSize($proid,$store_user_id,$dsize); 
			$offer = $this->getSingleresult("select count(*)  from #_offer_detail where status='Active' and cat_id = '$cat_id' and store_user_id ='$store_user_id' $cond ");
			if(!$dsize) $dsize = 'NA';
            if($offer>0 and $comboid==0){
				$periodcategory[] = $cat_id;
				$period[$dsize] = $proid;
				$periodtotalprice = $periodtotalprice + $price;
			}else{
				$normalprod[$dsize] = $proid; 
				$othertotalprice = $othertotalprice + $price;
			} 
			$alltotal = $alltotal+$price;
			 
			$periodcategory = array_unique($periodcategory);
			//$diss=$this->getDiscountOfferPercentWise($proid,$store_user_id,$dsize);
			//echo $diss;die;
			$dissPercentWise=$dissPercentWise + $diss[discount_amount];
		 } 
		 //echo"All categories <pre>";print_r($allcats); echo"</pre>";
		  
		 
		 $overAlldiscount = $this->getDiscountOnShopping($store_user_id,$ssid);; 
		
		 $allshipping = $shippingCharge;

		  
		  
		$disPeriod = $this->getPeriodDiscount($ssid,$store_user_id);
		$combosave = $this->totalComboSaving($ssid,$store_user_id);
		$shipFreeAmount = $this->getSingleresult("select shipFreeAmount from fz_shipping where store_user_id = '$store_user_id'");	
		$payableAmt = ($alltotal-($combosave+$disPeriod + $overAlldiscount));
		if($shipFreeAmount && $payableAmt>=$shipFreeAmount){ 
			$allshipping = 0;
		}
		 $extracharge = $this->getSingleresult("select extracharge  from #_shipping_area_store where store_user_id = '".$store_user_id."'  and pincode = '".$_SESSION[pincode]."' and status = 'Active' ");
		 if($extracharge>0 && $allshipping>0){
			$extraShipCharge = ceil(($allshipping*$extracharge)/100);
			$allshipping = $allshipping+ $extraShipCharge;
		 }

		$pay = $payableAmt+$allshipping;
		$arr[totalCost] = $alltotal;
		$arr[comboSavng] = $combosave;
		$arr[periodSaving] = $disPeriod; 
		$arr[overAlldiscount] = $overAlldiscount;
		$arr[allshipping] = $allshipping;
		$arr[extraShipCharge] = (int)$extraShipCharge;
		$arr[dissPercentWise] = $dissPercentWise;
		$arr[paynet] = $pay;
		//echo"<br/>Combo Saving: Rs. $combosave <br/"; 
		 /*echo"Normal Prod <pre>";print_r($normalprod); echo"</pre>"; 
		 echo"<br/>Over All Some: Rs. $alltotal <br/"; 
		 echo"<br/>Combo Saving: Rs. $combosave <br/"; 
		 echo $disHotdeal; echo "<br/>";
		 echo $disPeriod; echo "<br/>";*/
		 //echo "Preview: <br/><pre>"; print_r($arr);echo "</pre><br/>"; 
	}
	return $arr;
  
  }
  function totalComboSaving($ssid,$store_user_id){
			$ursave = 0;
			$comboqry=$this->db_query("select comboid from #_cart where ssid = '$ssid' and comboid!='0' group by comboid ");
				if(mysql_num_rows($comboqry)){
					while($rs=$this->db_fetch_array($comboqry)){
						$totalprice  = $this->getSingleresult("select totalprice from fz_combo_prod where pid = '".$rs[comboid]."'");
						$comboprice  = $this->getSingleresult("select comboprice from fz_combo_prod where pid = '".$rs[comboid]."'");
						$saving = $totalprice-$comboprice;
						$ursave = $ursave+$saving;
					}
				}
				return $ursave;
			}
  function getPeriodDiscount($ssid,$store_user_id){
	 $tot = 0;
	 $today = date('Y-m-d');
	 $catarr = array();
	 $allcats=$this->db_query("select  cat_id from #_cart where  ssid = '$ssid' and comboid='0' group by cat_id "); 
	 if(mysql_num_rows($allcats)){ 
 			while($rs=$this->db_fetch_array($allcats)){ extract($rs);
				$catarr[] = $cat_id;
			}
	 }
	 $offerCat = array();
	 $discountAmt = 0;
	 if(count($catarr)){
		$checkperiodoffer = $this->db_query("select cat_id from #_offer where   cat_id in (".implode(',',$catarr).") and store_user_id = '$store_user_id' and     '$today' >= dayfrom and   '$today' <= dayto ");
		if(mysql_num_rows($checkperiodoffer)){
			 while($rs=$this->db_fetch_array($checkperiodoffer)){
				 $offerCat[] = $rs[cat_id];
			 } 
			 $offerCat = array_unique($offerCat); 
			 foreach($offerCat as $cat){  
				$detail[type] = $this->getSingleresult("select type from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id'  ");
				 
					   
						switch ($detail[type]){
							case "freeProd":
								 $discount  = $this->getDiscountFreeProd($cat,$store_user_id,$ssid);
								break;
							case "flatPercent":
								 $discount  = $this->getDiscountFlatPercent($cat,$store_user_id,$ssid);
								break;
							case "rangeQty":
								$discount  = $this->getDiscountRangeQty($cat,$store_user_id,$ssid);
								break;
							case "rangeAmt":
								  $discount  = $this->getDiscountRangeAmt($cat,$store_user_id,$ssid);
								break;
							default:
						}
						$discountAmt = $discount + $discountAmt;
					 
				 
			 } 
		}
	 }  
	 return $discountAmt;
 }
 function getDiscountRangeAmt($cat,$store_user_id,$ssid){ 
			   $brand = array();
				$offerdetail2s = $this->db_query("select brand_id  from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id' group by brand_id  "); 
				if(mysql_num_rows($offerdetail2s)){
					while($r =$this->db_fetch_array($offerdetail2s)){ 
						$brand[] = $r[brand_id];
					}
				}  
				$total = 0;  
				if(count($brand)){
					foreach($brand as $val){ 
						$offerdet = $this->db_query("select amount1,amount2,discAmt  from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id' and brand_id = '$val' order by porder asc");
						if(mysql_num_rows($offerdet)){ 
							while($detail =$this->db_fetch_array($offerdet)){ extract($detail); 
							    $isDiscounted = 0;
								$getDis = 0;
								$allQty = 0;
								$allcats=$this->db_query("select qty, proid,dsize from #_cart where brand_id = '$val' and ssid = '$ssid' and comboid='0' and cat_id='$cat' ");   
								$price = 0;
								if(mysql_num_rows($allcats)){ 
									while($rs=$this->db_fetch_array($allcats)){ extract($rs);
										$price = $price+($qty*$this->getPriceSize($proid,$store_user_id,$dsize)); 
										$allQty = $allQty+$qty;
										 
									} 
									//echo "$price>=$amount1 && $price<= $amount2&& $isDiscounted<1 <br>";
									if($price>=$amount1 && $price<= $amount2 && $isDiscounted<1){ 
										$getDis = $discAmt; 
										$total = $getDis+$total;
										$isDiscounted++;
									} 
								}  
							} 
						}
					} 
				} 
				return $total;   
 
 }
 
 function getDiscountFlatPercent($cat,$store_user_id,$ssid){ 
				$getDis = 0; 
				$brand = array();
				$offerdetail2s = $this->db_query("select brand_id  from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id' group by brand_id  "); 
				if(mysql_num_rows($offerdetail2s)){
					while($r =$this->db_fetch_array($offerdetail2s)){ 
						$brand[] = $r[brand_id];
					}
				} 
				$total = 0;  
				if(count($brand)){
					foreach($brand as $val){
						$offerdet = $this->db_query("select flatpercent  from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id' and brand_id = '$val' order by porder asc");
						if(mysql_num_rows($offerdet)){ 
							while($detail =$this->db_fetch_array($offerdet)){ extract($detail); 
							    $isDiscounted = 0;
								$getDis = 0;
								$allcats=$this->db_query("select qty, proid,dsize from #_cart where brand_id = '$val' and ssid = '$ssid' and comboid='0' and cat_id='$cat' ");  
								 
								$price = 0;
								if(mysql_num_rows($allcats)){ 
									while($rs=$this->db_fetch_array($allcats)){ extract($rs);
										$price = $price+($qty*$this->getPriceSize($proid,$store_user_id,$dsize)); 
										 
									} 
									if($isDiscounted<1){
										$getDis = ($price*$flatpercent)/100;  
										$total = $getDis+$total;
										$isDiscounted++;
									} 
								}  
							} 
						}
					} 
				} 
				return $total; 
 
 }
 function getDiscountRangeQty($cat,$store_user_id,$ssid){
			     
				$brand = array();
				$offerdetail2s = $this->db_query("select brand_id  from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id' group by brand_id  "); 
				if(mysql_num_rows($offerdetail2s)){
					while($r =$this->db_fetch_array($offerdetail2s)){ 
						$brand[] = $r[brand_id];
					}
				}  
				$total = 0;  
				if(count($brand)){
					foreach($brand as $val){ 
						$offerdet = $this->db_query("select qty1,qty2,qtyDisPercent  from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id' and brand_id = '$val' order by porder asc");
						if(mysql_num_rows($offerdet)){ 
							while($detail =$this->db_fetch_array($offerdet)){ extract($detail); 
							    $isDiscounted = 0;
								$getDis = 0;
								$allQty = 0;
								$allcats=$this->db_query("select qty, proid,dsize from #_cart where brand_id = '$val' and ssid = '$ssid' and comboid='0' and cat_id='$cat' ");   
								$price = 0;
								if(mysql_num_rows($allcats)){ 
									while($rs=$this->db_fetch_array($allcats)){ extract($rs);
										$price = $price+($qty*$this->getPriceSize($proid,$store_user_id,$dsize)); 
										$allQty = $allQty+$qty;
										 
									} 
									//echo "$allQty>=$qty1 && $allQty<= $qty2 && $isDiscounted<1 <br>";
									if($allQty>=$qty1 && $allQty<= $qty2 && $isDiscounted<1){
									
										$getDis = ($price*$qtyDisPercent)/100;
										 
										$total = $getDis+$total;
										$isDiscounted++;
									} 
								}  
							} 
						}
					} 
				} 
				return $total;   
 
 }
 function getDiscountFreeProd($cat,$store_user_id,$ssid){  
				
				$brand = array();
				$offerdetail2s = $this->db_query("select brand_id  from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id' group by brand_id  "); 
				if(mysql_num_rows($offerdetail2s)){
					while($r =$this->db_fetch_array($offerdetail2s)){ 
						$brand[] = $r[brand_id];
					}
				}
				$total = 0;  
				if(count($brand)){
					foreach($brand as $val){
						$offerdet = $this->db_query("select onshop,getfree  from #_offer_detail where cat_id='$cat' and status='Active' and store_user_id = '$store_user_id' and brand_id = '$val' order by porder asc");
						if(mysql_num_rows($offerdet)){ 
							while($detail =$this->db_fetch_array($offerdet)){ extract($detail); 
							    $isDiscounted = 0;
								$getDis = 0;
								$allcats=$this->db_query("select qty, proid,dsize from #_cart where brand_id = '$val' and ssid = '$ssid' and comboid='0' and cat_id='$cat' ");  
								$allQty = 0; 
								$price = array();
								if(mysql_num_rows($allcats)){ 
									while($rs=$this->db_fetch_array($allcats)){ extract($rs);
										for($i=1;$i<=$qty;$i++){
											$price[] =$this->getPriceSize($proid,$store_user_id,$dsize);
										}
										sort($price); 
										$allQty = $allQty+$qty;
									} 
									if($allQty>$onshop && $isDiscounted<1){
										$k = 1;
										$eccess  = $allQty-$onshop;
										if($eccess>=$getfree){
											$free = $getfree;
										}else{
											$free = $eccess;
										} 
										//echo $free; 
										foreach($price as $val){
											if($k<=$free){
													$getDis = $getDis+$val; // echo "<br/>";
													$isDiscounted++;
											}
											$k++;
										} 
										//echo "$total =$getDis+$total<br/>";
										$total = $getDis+$total;
										
									} 
								}
							 
							  
							}

						}
					} 
				} 
				return $total;
   }
  

 function getOfferdetailByCategory($cat_id,$store_user_id){
	$checkhotdeal = $this->db_query("select *  from #_offer where offertype  ='hotdeal' and  cat_id = '$cat_id' and store_user_id = '$store_user_id'  ");
	if(mysql_num_rows($checkhotdeal)){ 
 			$rs=$this->db_fetch_array($checkhotdeal); extract($rs);
			$mess[offertype] = $offertype;
			if($type=='flat' && $discounttype =='percent'){
				$mess[message] =  " Flat $flatpercent% Extra Discount ";				
			}else if($type=='flat' && $discounttype =='amount'){
				$mess[message] =  " Rs $amount  Extra Discount ";	 
			}else if($type=='qty' && $discounttype =='percent'){
				$mess[message] =  "On Purchase Of Qty $numofprod Get $flatpercent% Discount ";	 
			}else if($type=='qty' && $discounttype =='amount'){
				$mess[message] =  "On Purchase Of Qty $numofprod Get Rs. $amount Discount ";	
			}else if($type=='qty' && $discounttype =='qty1'){ 
				$mess[message] =  "On Purchase Of Qty $numofprod Get $qty1 Product Free ";	
			}   
			$mess[message]=$mess[message]."<br>";
			$mess[message] = '<p style=" left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;">'.$mess[message].' </p>' ;
		}else{
			$checkperiodoffer = $this->db_query("select *  from #_offer where offertype  ='periodoffer'  and cat_id = '$cat_id' and store_user_id = '$store_user_id'  ");
			if(mysql_num_rows($checkperiodoffer)){  
				$rs=$this->db_fetch_array($checkperiodoffer); extract($rs);
				$mess[offertype] = $offertype;
				if($type=='flat' && $discounttype =='percent'){
					$mess[message] =  " Flat $flatpercent% Extra Discount ";				
				}else if($type=='flat' && $discounttype =='amount'){
					$mess[message] =  " Rs $amount  Extra Discount ";	 
				}else if($type=='qty' && $discounttype =='percent'){
					$mess[message] =  "On Purchase Of Qty $numofprod Get $flatpercent% Discount ";	 
				}else if($type=='qty' && $discounttype =='amount'){
					$mess[message] =  "On Purchase Of Qty $numofprod Get Rs. $amount Discount ";	
				}else if($type=='qty' && $discounttype =='qty1'){ 
					$mess[message] =  "On Purchase Of Qty $numofprod Get $qty1 Product Free ";	
				} 
				
				$mess[message]=$mess[message]."<br>";
				$mess[message] = '<p style="left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;">'.$mess[message].'</p>';
			}
		
		} 
		return $mess;
 }
 function checkofferP($prod_id,$store_user_id){
	$mess = array();
	$title = $this->getSingleresult("select title  from #_products_user where pid='$prod_id'");
	$cat_id = $this->getSingleresult("select cat_id  from #_products_user where pid='$prod_id'");
	if($cat_id){ 
		$checkhotdeal = $this->db_query("select *  from #_offer_detail where offertype ='hotdeal'  and cat_id = '$cat_id' and store_user_id = '$store_user_id'  ");
		if(mysql_num_rows($checkhotdeal)){ 
 			$rs=$this->db_fetch_array($checkhotdeal); extract($rs);
			$mess[offertype] = $offertype;
			if($type=='flat' && $discounttype =='percent'){
				$mess[message] =  " Flat $flatpercent% Extra Discount ";				
			}else if($type=='flat' && $discounttype =='amount'){
				$mess[message] =  " Rs $amount  Extra Discount ";	 
			}else if($type=='qty' && $discounttype =='percent'){
				$mess[message] =  "On Purchase Of Qty $numofprod Get $flatpercent% Discount ";	 
			}else if($type=='qty' && $discounttype =='amount'){
				$mess[message] =  "On Purchase Of Qty $numofprod Get Rs. $amount Discount ";	
			}else if($type=='qty' && $discounttype =='qty1'){ 
				$mess[message] =  "On Purchase Of Qty $numofprod Get $qty1 Product Free ";	
			} 
			$mess[message]=$mess[message]."<br>"."H";
			$mess[message] = '<p style=" left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;">'.$mess[message].' </p>' ;
		}else{
			$checkperiodoffer = $this->db_query("select *  from #_offer_detail where offertype  ='periodoffer'  and cat_id = '$cat_id' and store_user_id = '$store_user_id'  ");
			if(mysql_num_rows($checkperiodoffer)){  
				$rs=$this->db_fetch_array($checkperiodoffer); extract($rs);
				$mess[offertype] = $offertype;
				if($type=='flat' && $discounttype =='percent'){
					$mess[message] =  " Flat $flatpercent% Extra Discount ";				
				}else if($type=='flat' && $discounttype =='amount'){
					$mess[message] =  " Rs $amount  Extra Discount ";	 
				}else if($type=='qty' && $discounttype =='percent'){
					$mess[message] =  "On Purchase Of Qty $numofprod Get $flatpercent% Discount ";	 
				}else if($type=='qty' && $discounttype =='amount'){
					$mess[message] =  "On Purchase Of Qty $numofprod Get Rs. $amount Discount ";	
				}  
				$mess[message]=$mess[message]."<br>"."P";
				$mess[message] = '<p style="left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;">'.$mess[message].'</p>';
			}
		
		} 
	} 
   $combo_data=$this->db_query("select * from #_combo_prod where prod_id='$prod_id' and store_user_id='$store_user_id'");   
	if(mysql_num_rows($combo_data)){ 
		$prod_id1[]= $proid; 
		  $data=$this->db_fetch_array($combo_data);extract($data); 
		  $arr = explode(',',$data[comboprod]); 
		   if(array_diff($prod_id1,$arr)){   
				$offer1[totalcomboamount] =$data[totalprice];
				$offer1[comboprice]= $data[comboprice];
				$offer1[totaldisprice]=$offer1[totalcomboamount]-$offer1[comboprice];
				$mess[message] =  "Combo Offer's ";
			}
	}  
	return $mess;
  }
 
  
function getDiscountOfferPercentWise($pid,$store_user_id,$dsize)
	{ 

	$diss = array();
	 if($dsize!=0){
		$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where proid='$pid' and store_id ='$store_user_id' and dsize='$dsize'");
		if(mysql_num_rows($priceQuery)){
			$bp=$this->db_fetch_array($priceQuery);
			$price = $bp[dprice];
			$offerprice = $bp[dofferprice];  
		}else{ 
			$price= $this->getSingleresult("select dprice  from #_product_price where proid='$pid' and store_id ='$store_user_id' and dsize='$dsize'");
			$offerprice= $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$store_user_id' ");   
		} 
	}else{ 
		$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where proid='$pid' and store_id ='$store_user_id' limit 1");
		if(mysql_num_rows($priceQuery)){
			$bp=$this->db_fetch_array($priceQuery);
			$price = $bp[dprice];
			$offerprice = $bp[dofferprice];  
		}else{ 
			$price= $this->getSingleresult("select dprice  from #_product_price where proid='$pid'"); 
			$offerprice= $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$store_user_id' ");  
		}
			
	}  
	if($price!=$offerprice && $offerprice<=$price && $offerprice!=0)
	$diff  =  $price - $offerprice;
	$diss[discount_amount] =$diff ; 
	$diss[discount_persent]=ceil(($diss[discount_amount]*100)/$price);
	return $diss; 
	}

  function getMainComboProd($store_user_id){
	   $comboarr = array();
	   $combo_data=$this->db_query("select prod_id,comboprod from #_combo_prod where   store_user_id='$store_user_id' and 	status = 'Active'"); 
		if(mysql_num_rows($combo_data)){  
			  while($data=$this->db_fetch_array($combo_data)){extract($data);  
			    //$arr = explode('$$',$prod_id);
				$comboarr[] =  $prod_id;
			  } 
		} 
		return $comboarr;
  } 
  function getComboByProd($prodid,$store_user_id){
	   $comboarr = array();
	   $combo_data=$this->db_query("select  comboprod from #_combo_prod where prod_id = '$prodid' and store_user_id='$store_user_id' and 	status = 'Active'");
	     
		if(mysql_num_rows($combo_data)){  
			   $data=$this->db_fetch_array($combo_data);
			   extract($data);  
			   if($comboprod != ""){
					$comboarr = explode(',',$comboprod); 
					$comboarr = array_unique($comboarr);
				}
			  
		}
		 
		return $comboarr;
  }  

  function getDiscountOnShopping($store_user_id,$ssid){
	$arr = array();
	$sql = $this->db_query("select proid,dsize,qty from #_cart where ssid = '$ssid'  and store_user_id='$store_user_id' ");
	$totprice = 0; 
	if(mysql_num_rows($sql)){
		while($data=$this->db_fetch_array($sql)){ @extract($data);
				$price = $qty*$this->getPriceSize($proid,$store_user_id,$dsize); 
				$getDiscnttype = $this->getSingleresult("select discount from #_products_user where pid = '$proid'"); 
				$totprice = $price+$totprice;  
		}
		//echo $totqty. " => ".$totprice;
		$getDiscountOnAmount = $this->getDiscount($totprice,$store_user_id); 
		 
	}
	return $getDiscountOnAmount;
  }
  function getDiscount($major,$store_user_id){ 
		$discount = 0;
		$rsAdmin=$this->db_query("select * from #_discount where store_user_id='".$store_user_id."' "); 
		if(mysql_num_rows($rsAdmin)){ 
			$arrAdmin=$this->db_fetch_array($rsAdmin); extract($arrAdmin); 
			if($major>=$range11 && $major<=$range12){
				$discount = $discount1;
			}else if($major>=$range21 && $major<=$range22){
				$discount = $discount2;
			}else if($major>=$range31 && $major<=$range32){
				$discount = $discount3;
			}else if($major>=$range41 && $major<=$range42){
				$discount = $discount4;
			}else if($major>=$range51 && $major<=$range52){
				$discount = $discount5;
			}else if($major>=$range61 && $major<=$range62){
				$discount = $discount6;
			}else if($major>=$range71 && $major<=$range72){
				$discount = $discount7;
			}else if($major>=$range81 && $major<=$range82){
				$discount = $discount8;
			}else {
				$discount = $discount8;
			}
		}
		return (($major*$discount)/100);
		
  }
  function getShippingOnShopping($store_user_id,$ssid){
	$arr = array();
	$sql = $this->db_query("select proid,qty from #_cart where ssid = '$ssid'  and store_user_id='$store_user_id' ");
	$totprice = 0;
	$totqty = 0;
	if(mysql_num_rows($sql)){
		while($data=$this->db_fetch_array($sql)){ @extract($data);
				$price = $qty*$this->getPrice($proid,$store_user_id); 
				$getDiscnttype = $this->getSingleresult("select shipping from #_products_user where pid = '$proid'");
				if($getDiscnttype=='cost'){
					$totprice = $price+$totprice; 
				}else if($getDiscnttype=='quantity'){ 
					$totqty = $qty+$totqty;  
				}
				 
		}
		//echo "<br/>Shipping qty and amount => ".$totqty. " => ".$totprice."<br/>";
		$getShippingOnAmount = $this->getShippingTotal($totprice,$store_user_id,'cost');
		$getShippingOnQty = $this->getShippingTotal($totqty,$store_user_id,'quantity');
		$arr[amountWiseShipping] = (int)$getShippingOnAmount;
		$arr[quantityWiseShipping] = (int)$getShippingOnQty;
		//$getShippingOnWeight = $this->getShippingTotal($totprice,$store_user_id,'weight');
		//$arr[weightWiseShipping] = (int)$getShippingOnWeight;
	}
	return $arr;
  }
  function getShippingTotal($major,$store_user_id,$type){
		$shipping = 0;
		$rsAdmin=$this->db_query("select * from #_shipping where store_user_id='".$store_user_id."' and type = '$type'"); 
		if(mysql_num_rows($rsAdmin)){
			$arrAdmin=$this->db_fetch_array($rsAdmin);
			extract($arrAdmin); 
			if($major>=$range11 && $major<=$range12){
				$shipping = $shipping1;
			}else if($major>=$range21 && $major<=$range22){
				$shipping = $shipping2;
			}else if($major>=$range31 && $major<=$range32){
				$shipping = $shipping3;
			}else if($major>=$range41 && $major<=$range42){
				$shipping = $shipping4;
			}else if($major>=$range51 && $major<=$range52){
				$shipping = $shipping5;
			}else if($major>=$range61 && $major<=$range62){
				$shipping = $shipping6;
			}else if($major>=$range71 && $major<=$range72){
				$shipping = $shipping7;
			}else if($major>=$range81 && $major<=$range82){
				$shipping = $shipping8;
			}else {
				$shipping = $shipping8;
			}
		}
		return $shipping;
		
  }
  function checkShipping($picode,$store_user_id){
		
  }
  function checkDuplicatesInArray($array)
{
    $duplicates=FALSE;
    foreach($array as $k=>$i)
    {
        if(!isset($value_{$i}))
        {
            $value_{$i}=TRUE;
        }
        else
        {
            $duplicates|=TRUE;          
        }
    }
    return ($duplicates);
}
function breadcrumbs($text = '<font color:red></font> ', $sep = '&raquo; ', $home = 'Home') {
//Use RDFa breadcrumb, can also be used for microformats etc.
$bc     =   '<div xmlns:v="http://rdf.data-vocabulary.org/#" id="crums" class="breadcrumb_text">'.$text;
//Get the website:
$site   =   'http://'.$_SERVER['HTTP_HOST'];
//Get all vars en skip the empty ones
$crumbs =   array_filter( explode("/",$_SERVER["REQUEST_URI"]) );
//Create the home breadcrumb
$bc    .=   '<span typeof="v:Breadcrumb"><a href="'.$site.'" rel="v:url" property="v:title">'.$home.'</a>'.$sep.'</span>'; 
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
	 if($site!='category-product'){
	$site=$_SESSION[catid];
	}  
    //Make the next crumb
	$link= preg_replace('/[0-9]+/', '', $link); 
	$link = preg_replace("/search.*/", "", $link);
	$link = preg_replace("/[&].*/", "", $link); 
	$link = strtok($link, '?');
	if(empty($link)){ 
	$sep = str_replace('/search.*/','',$link);
	} 
    $bc .=  '<span typeof="v:Breadcrumb"><a href="'.$site.'" rel="v:url" property="v:title">'.$link.' </a> '.$sep.'</span>';
    $i++;
}
$bc .=  '</div>';
//Return the result
return $bc;}
 public function removeSpace($str) { 
	  $str = str_replace(" ",'%2',$str);
	 return $str;
	}
	
	function getBothPriceSize($pid,$current_store_user_id,$size){ 
	$price = array();
	$cond1 = " and  dsize = '$size' ";
	if($size=='0' or $size==''){ $cond1 = " and ( dsize = '0' or dsize = '') "; } 
	$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where proid='$pid' and store_id ='$current_store_user_id' $cond1");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery);
		$price[] = $bp[dprice];
		$price[] = $bp[dofferprice]; 
	}else{ 
		$price[] = $this->getSingleresult("select dprice from #_product_price where proid='$pid' $cond1");
		$cond = " and  dimension = '$size' ";
		if($size=='0' or $size==''){ $cond = " and ( dimension = '0' or dimension = '') "; }
		$price[] = $this->getSingleresult("select  offerprice from #_barnds_product where prod_id = '$pid' and 
		store_user_id = '$current_store_user_id' $cond ");   
	}
	return $price;
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
	if($offerprice<$price && $offerprice >0 && $offerprice!=$price ) {
		return $offerprice;
	}   
	return $price;
 } 
 
function getPriceSize($pid,$current_store_user_id,$dsize){  
	$price = 0;   
	$cond1 = " and  dsize = '$dsize' ";
	if($dsize=='0' or $dsize==''){ $cond1 = " and ( dsize = '0' or dsize = '') "; } 
	$priceQuery = $this->db_query("select dprice,dofferprice from #_product_price where proid='$pid' and store_id ='$current_store_user_id' $cond1");
	if(mysql_num_rows($priceQuery)){
		$bp=$this->db_fetch_array($priceQuery);
		$price = $bp[dprice];
		$offerprice = $bp[dofferprice]; 
	}else{ 
		$price = $this->getSingleresult("select dprice from #_product_price where proid='$pid' $cond1");
		$cond = " and  dimension = '$dsize' ";
		if($dsize=='0' or $dsize==''){ $cond = " and ( dimension = '0' or dimension = '') "; }
		 
		$offerprice = $this->getSingleresult("select offerprice from #_barnds_product where prod_id = '$pid' and store_user_id = '$current_store_user_id' $cond 
		 "); 
	} 
	if($offerprice < $price && $offerprice >0 && $offerprice!=$price ) {
		return $offerprice;
	}  
	return $price;
 } 
  function zoomImg($image,$title){
	if(!$image){
		return false; 
	}
	$image = str_replace(" ",'%20',$image);
	 if($image){ 
	 		$orgi =SITE_PATH_M."uploaded_files/orginal/".$image; 
	 }else{ 
	  		$orgi=SITE_PATH_M."image/noimg.jpg"; 
	 }
	if (@fopen($orgi,"r"))  
		echo '<li><img src="'.$orgi.'" alt="'.$title.'" /></li>'; 
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
 function productView($current_store_user_id,$pid){  
	   $stores_id = $this->getSingleresult("select store_user_id from fz_products_user where pid ='$pid'");
	    if($stores_id==0){
	   $stores_id = $this->getSingleresult("select store_user_id from fz_barnds_product where prod_id ='$pid'");
	   }  
	   $store_type=$this->getSingleresult("select type from #_store_user where pid = '$stores_id'"); 
	   $rest = array('css','font','fonts','js','tools','member');
	   $cur_page = $this->geturl();
	   $err = 0;
	   foreach($rest as $val){
			if(preg_match("/$val/",$cur_page)) 
				$err = 1;
	   }
	   $ip = $_SERVER['REMOTE_ADDR']; 
	   $ssid = session_id();  
	   $arr=array();
	   $arr[prod_id]=$pid;
	   $arr[ip]=$ip; 
	   $arr[brand_id]= $stores_id; 
	   $arr[store_user_id]=$current_store_user_id;
	   $arr[ssid]=$ssid ;
	   $check = $this->getSingleresult("select count(*) from #_product_view where ssid='$ssid' and prod_id='$pid'");
	   if($store_type=='store') $err = 1; 
	   if($current_store_user_id==$stores_id) $err = 1; 
	   if($check) $err = 1;
	   if(!$err)  $this->sqlquery("rs","product_view",$arr); 
	   return true;
 }

	function getAllPeriodOfferProducts($current_store_user_id){
		$today = date('Y-m-d');
		$cats_arr = array();
		$pro_cat = array();
		$prods = array();
		$brandslist = array();
		$cat_ids =  $this->db_query("SELECT cat_id FROM `fz_offer` where store_user_id='$current_store_user_id' and status = 'Active' and '$today' >= dayfrom and   '$today' <= dayto "); 
		if(mysql_num_rows($cat_ids)){
			  while($rs=$this->db_fetch_array($cat_ids)){
				$cats_arr[] = $rs[cat_id];
			  }
		} 
		if(count($cats_arr)){
			foreach($cats_arr as $val){ 
				$brands =  $this->db_query("SELECT brand_id,cat_id FROM `fz_offer_detail` where store_user_id='$current_store_user_id' and status = 'Active'  and   cat_id= '$val' "); 
				if(mysql_num_rows($brands)){
					while($r=$this->db_fetch_array($brands)){
						if($r[brand_id]){
							$brandslist[] = $r[brand_id];
							$prodqry =  $this->db_query("SELECT prod_id FROM fz_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$r[brand_id]."' and cat_id = '$val'  ");  
							if(mysql_num_rows($prodqry)){
								while($pr=$this->db_fetch_array($prodqry)){
									$prods[] = $pr[prod_id];
								}
							}
						}else{
							if(!in_array($val,$pro_cat)){
								$pro_cat[] = $val;
								$prodqry =  $this->db_query("SELECT pid FROM fz_products_user where store_user_id='$current_store_user_id' and status = 'Active' and cat_id = '$val'  ");  
								if(mysql_num_rows($prodqry)){
									while($pr=$this->db_fetch_array($prodqry)){
										$prods[] = $pr[pid];
									}
								}
							}  
						}
					  }
				}
			}
		}
		$brandslist = array_unique($brandslist);
		$pro_cat = array_unique($pro_cat);
		$prods = array_unique($prods);
		return $prods;
	}
	function getAllPeriodOfferProductsById($current_store_user_id,$pid){ 
		$prods = array();  
		$brands =  $this->db_query("SELECT brand_id,cat_id FROM `fz_offer_detail` where pid= '$pid' "); 
		if(mysql_num_rows($brands)){
			while($r=$this->db_fetch_array($brands)){
				if($r[brand_id]){
					$brandslist[] = $r[brand_id];
					$prodqry =  $this->db_query("SELECT prod_id FROM fz_barnds_product where store_user_id='$current_store_user_id' and brand_id = '".$r[brand_id]."' and cat_id = '".$r[cat_id]."'  ");  
					if(mysql_num_rows($prodqry)){
						while($pr=$this->db_fetch_array($prodqry)){
							$prods[] = $pr[prod_id];
						}
					}
				}else{ 
					$prodqry =  $this->db_query("SELECT pid FROM fz_products_user where store_user_id='$current_store_user_id' and status = 'Active' and cat_id =  '".$r[cat_id]."'  ");  
					if(mysql_num_rows($prodqry)){
						while($pr=$this->db_fetch_array($prodqry)){
							$prods[] = $pr[pid];
						}
					} 
				}
			  }
		} 
		$prods = array_unique($prods);
		return $prods;
	}
	function getProductCountByPrice($prod_arr,$start=0,$end=0,$current_store_user_id){
		$pro = array();
		if(count($prod_arr)){
			foreach($prod_arr as $proid){
				//store_id='$current_store_user_id' and 
				$prodqry =  $this->db_query("SELECT dprice,dofferprice,store_id,dsize FROM fz_product_price where proid = '$proid'  ");
				if(mysql_num_rows($prodqry)){
					while($pr=$this->db_fetch_array($prodqry)){extract($pr); 
						$price = $dprice;
						if($store_id!=$current_store_user_id){
							$dofferprice = $this->getSingleresult("select offerprice from fz_barnds_product where store_user_id = '$current_store_user_id' and  prod_id = '$proid' and dimension='$dsize'");
							if($dofferprice>0.00 && $dofferprice<$dprice){
								$price = $dofferprice;
							}
						}else if($dofferprice>0.00 && $dofferprice<$dprice){
							$price = $dofferprice;
						}
						 
						if($price>=$start && $price<=$end){
							$pro[]  = $proid;
						} 
					}
				} 
			}
		}
		 
		return array_unique($pro);
	}

   function getDiscountProd($current_store_user_id,$prod_arr,$p1,$p2){
	   $pr = array();
	   if(count($prod_arr)){
			foreach($prod_arr as $val){
				$price = $this->getBothPrice($val,$current_store_user_id);
				$getDiff = $price[0]-$price[1];
				if($getDiff>0 && $price[1]!=0 && $price[1]!=$price[0]){
					  $getPersent = ceil(($getDiff*100)/$price[0]);
					if($getPersent>=$p1 && $getPersent<=$p2) $pr[] = $val;
				}
			}
	   }  
   return array_unique($pr);
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
		return $prods;
   }
   function BrandProdView($current_store_user_id,$prod_id){  
	   $count = $this->getSingleresult("select count from #_barnds_product where prod_id='$prod_id' and store_user_id = '$current_store_user_id' "); 
	   if($count>=1){
			$count=$count + 1;
	   }else{
		   $count=1;
       }
	   $this->db_query("update #_barnds_product set count='$count' where prod_id='$prod_id' and store_user_id = '$current_store_user_id' "); 
	   return true;
 }

 function getShippingProd($proid,$current_store_user_id,$qty=1){
	$ship = $this->getSingleresult("select shipping from #_products_user where pid='$proid' and store_user_id = '$current_store_user_id' "); 
	if(!$ship){
	$ship = $this->getSingleresult("select shipping from #_barnds_product where prod_id='$proid' and store_user_id = '$current_store_user_id' "); 
	}
	return (int)$ship*$qty;
 
 }
 function daysLeft($current_store_user_id){
    $noOfDays = $this->getSingleresult("select noOfDays from #_store_detail where  store_user_id ='".$current_store_user_id."' and status='Active'");
	$create_date = $this->getSingleresult("select create_date from #_store_detail where store_user_id ='".$current_store_user_id."' and status='Active'");
    $reCreate_date = $this->getSingleresult("select create_date from #_reg_renewal where  user_id = '$current_store_user_id' order by pid desc limit 1");
	if($reCreate_date){
		$create_date=$reCreate_date;
	}
	$re_noOfDays=$noOfDays-$this->getRemainDays($create_date); 
	return $re_noOfDays;
 }
 function calShippTime($store_user_id,$pincode){
	 $ms = "";
	 $rs = $this->db_query("select day1,day2,hrs,minutes from  #_shipping_area_store where store_user_id='$store_user_id' and pincode = '$pincode' "); 
	 $r=$this->db_fetch_array($rs); @extract($r);
	 if($hrs || $minutes){ 
		if($hrs)  $ms .= $hrs." Hours";
		if($hrs && $minutes) $ms .=  " and ";
		if($minutes)  $ms .= $minutes." Minutes";
	 }else{
		$ms .= "$day1 to $day2 days";
	 } 

	 return $ms;

  }  
}
?>