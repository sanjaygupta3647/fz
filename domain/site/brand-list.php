<div class="main_text_area">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" align="center" class="enq_text_fild2">Brand</td>
      </tr>
      <tr>
        <td align="center" valign="top">	
		<?php $brandqry=$cms->db_query("select brand_id from #_request_brand where store_user_id='$current_store_user_id' and status ='Active' ");
		
	if(mysql_num_rows($brandqry)){
    	while($brandRes=$cms->db_fetch_array($brandqry)){
			$brandImage = $cms->getSingleresult("select image from #_store_detail where pid = '".$brandRes[brand_id]."'");
			$title = $cms->getSingleresult("select title from #_store_detail where pid = '".$brandRes[brand_id]."'");
			$img = SITE_PATH."uploaded_files/orginal/no-img.gif";
			if(file_exists('../uploaded_files/orginal/'.$brandImage) && $brandImage!=""){
				  $img = SITE_PATH."uploaded_files/orginal/".$brandImage;
			}
			?><div class="store_logo"><a href="#"><img  src="<?=$img?>" alt="<?=$title?>" title="<?=$title?>" height="60" width="60"></a></div><?php
		}        	 
	}
	else{
		echo "<strong>No Brands Available</strong>";
	}
	?>
			
		  
        </td>
      </tr>
    </table>
  </div>