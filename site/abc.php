<?php 
$folder = UP_FILES_FS_PATH.'/orginal/';
$dest = UP_FILES_FS_PATH.'/thumb/';
$filetype = '*.*';
$files = glob($folder.$filetype); 
$count = count($files); 
for ($i = 0; $i < $count; $i++){  
	  $name   = str_replace($folder,'',$files[$i]); 
	  $end = end(explode('.',$name)); 
	  $err = 0;
	  if($end=='png' || $end =='PNG' $end=='gif' || $end =='GIF') $err = 1;
	  if(!$err)$cms->make_thumb($files[$i], $dest.$name, 200,180); 
	 }  
 ?>
		
		
		 
		
		
		
 