<?php 
 
include "site/search.inc.php";
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='f.a.qs' and store_user_id = '0'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='f.a.qs' and store_user_id = '0'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='f.a.qs' and store_user_id = '0'");
?>

<div class="row" style="margin-top:20px;">
  <div class="registerheadbox">
    
  </div>
  <div class="col-md-12 col-sm-12">
    <?php
			$qry = $cms->db_query("SELECT noOfDays,amount FROM `#_plans_hosting` where pid ='".$_SESSION[planID]."'  ");
			$res = $cms->db_fetch_array($qry);	

			$sql=$cms->db_query("select name from #_plans  where status='Active' and pid = '".$_SESSION[tarifid]."'");
			$res2 = $cms->db_fetch_array($sql);	
					 
			?>
    <div class="heading2 col-md-12 col-sm-12">Frequently asked questions
      
    </div>
    <form method="post" action="" onSubmit="return formvalid(this);">
      <div class="col-md-12 col-sm-12">
        <div class="col-md-12 col-sm-12"></div>  
         <div class="col-md-12 col-sm-12">
			<div class="col-md-12 col-sm-12" id="list1a">
			  <?php
				$i = 1;
				$rsAdmin=$cms->db_query("select * from #_faq where store_user_id='0' and ftype='Site' and status='Active'");
				while($arrAdmin=$cms->db_fetch_array($rsAdmin)){
				@extract($arrAdmin);
			  ?>
			  <a class="btn btn-primary col-md-12 col-sm-12" style="text-align:left;margin-top:10px;margin-bottom:10px;">Q:<?=$i?> <?=$qsn?></a>
			  <div class="col-md-12 col-sm-12"><?=$cms->removeSlash($body)?></div> <?php			  
			    $i++;
				}?>
				 
			</div>
        </div>
      </div>
    </form>
  </div>
</div>
