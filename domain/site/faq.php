<?php 
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='f.a.qs' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='f.a.qs' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='f.a.qs' and store_user_id = '$current_store_user_id'"); 
?>
<div class="domain_faq_main">
<div class="domain_faq">
<h2>Frequently asked Question</h2>
<div class="basic" style="float:left;"  id="list1a">
			  <?php
				$i = 1;
				$rsAdmin=$cms->db_query("select * from #_faq where store_user_id='$current_store_user_id' and ftype='Site' and status='Active'");
				if(mysql_num_rows($rsAdmin)){
				while($arrAdmin=$cms->db_fetch_array($rsAdmin)){
				@extract($arrAdmin);
			  ?>
			  <a>Q:<?=$i?> <?=$qsn?></a>
			  <div><?=$cms->removeSlash($body)?></div> <?php			  
			    $i++;
				} }?>
				  
			</div>

</div>
</div>  