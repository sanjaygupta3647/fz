<?php 
 
include "site/search.inc.php";
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='f.a.qs' and store_user_id = '0'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='f.a.qs' and store_user_id = '0'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='f.a.qs' and store_user_id = '0'");
?>

<div class="contentarea">
  <div class="registerheadbox">
    
  </div>
  <div class="registerarea">
    <?php
			$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_SESSION[planID]."'  ");
			$res = $cms->db_fetch_array($qry);	

			$sql=$cms->db_query("select name from #_plans  where status='Active' and pid = '".$_SESSION[tarifid]."'");
			$res2 = $cms->db_fetch_array($sql);	
					 
			?>
    <div class="heading2">Frequently asked questions
      
    </div>
    <form method="post" action="" onSubmit="return formvalid(this);">
      <div class="subarea">
        <div class="contact_msg"></div>  
         <div class="main_register">
			<div class="basic" style="float:left;"  id="list1a">
			  <?php
				$i = 1;
				$rsAdmin=$cms->db_query("select * from #_faq where store_user_id='0' and ftype='Site' and status='Active'");
				while($arrAdmin=$cms->db_fetch_array($rsAdmin)){
				@extract($arrAdmin);
			  ?>
			  <a>Q:<?=$i?> <?=$qsn?></a>
			  <div><?=$cms->removeSlash($body)?></div> <?php			  
			    $i++;
				}?>
				 
			</div>
        </div>
      </div>
    </form>
  </div>
</div>
