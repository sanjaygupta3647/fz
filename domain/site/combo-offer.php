<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='combo-offers' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='combo-offers' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='combo-offers' and store_user_id = '$current_store_user_id'");
$storeQry = "select *  from fz_combo_prod where store_user_id='$current_store_user_id' and status = 'Active' ";
?>  
<div  class="main_matter_area">
<?php 
$_SESSION[catname]=$items[1];
$_SESSION[catid]=$items[2];
	  echo $cms->breadcrumbs(); 
       ?>
<div class="main_text_brdr_none"><?php 
include "../site/Paging.php";
$Obj=new Paging($storeQry);
$Obj->setLimit(30);//set record limit per page
$limit=$Obj->getLimit();
$offset=$Obj->getOffset($_REQUEST["page"]);
$sql = " $storeQry limit $offset,$limit";
$searchexe = $cms->db_query($sql);
$count = mysql_num_rows($searchexe);
$tcount = mysql_num_rows($cms->db_query($storeQry));?> 
<div class="apparel_paging3" style="width:1002px;">
  <div style="width:100%" class="main_text_areain_apparel">
    <h3>Combo Offer<span>(<?=$tcount?> Product<?=($tcount>1)?'s':''?>)</span></h3>
  </div>
  <?php  
if($count){ ?> 
<div id="content"><?php 
 $k = 1;
 while($storeres=$cms->db_fetch_array($searchexe))
	{   
		$status = $cms->getSingleresult("select status from #_barnds_product where prod_id = '".$storeres[pid]."' and store_user_id = '".$current_store_user_id."'");
		if($status=='Inactive'){
			$storeres[status] = 'Inactive';					
		}
		if($storeres[status]!='Inactive'){?> 
		
    <div class="cat_product_div" style="width:315px;">
	  <?php 
	   $allp = explode(",",$storeres['comboprod']); 
	   $p1 = $cms->getSingleresult("select title from #_products_user where status='Active' and pid = '".$storeres['prod_id']."'");
	   $p1image = $cms->getSingleresult("select image1 from #_products_user where status='Active' and pid = '".$storeres['prod_id']."'");
	   $p2 = $cms->getSingleresult("select title from #_products_user where status='Active' and pid = '".$allp[0]."'");
	   $p2image = $cms->getSingleresult("select image1 from #_products_user where status='Active' and pid = '".$allp[0]."'");
	   $p2title = $cms->getSingleresult("select title from #_products_user where status='Active' and pid = '".$allp[0]."'"); ?>
         <h2 title="<?=$p1?>" style="margin-bottom: 10px;"> 
		 <marquee  behavior=scroll direction=left onmouseover="this.stop();" onmouseout="this.start();" >
         <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($p1)?>/<?=$storeres['prod_id']?>#combo"><?=substr(trim($p1),0,30)?></a>
		 <?php 
		$explode  = explode('$$',$storeres['prod_id']);
		$pric =	$cms->getPriceSize($explode[0],$current_store_user_id,$explode[1]);  
		$pr = explode(",",$storeres['comboprod']); 
		if(count($pr)){
			foreach($pr as $val){
				$v  = explode('$$',$val);
				$prc = $cms->getPriceSize($v[0],$current_store_user_id,$v[1]); 
				$title = $cms->getSingleresult("select title from #_products_user where status='Active' and pid = '".$v[0]."'"); 
				?> | <a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($title)?>/<?=$v[0]?>"><?=$title?></a> <?php
			} 
		} ?> 
		 </marquee>
      </h2>
      <div class="combo_cat_product_textmain">
        <div class="combo_cat_product_image"> 
        <div class="combo_back-png">
        <a  style="cursur:pointer" href="<?=SITE_PATH?>detail/<?=$adm->baseurl($p1)?>/<?=$storeres['prod_id']?>#combo">
		<div class="combo_cat_product_image_left">
		
		 <img border="0" src="<?=$cms->getImageUrl($p1image,135,120); ?>"  title="<?=$p1?>" alt="<?=$p1?>" /> 
        </div></a>
        <div class="plus_div">+</div>
		<a  style="cursur:pointer" href="<?=SITE_PATH?>detail/<?=$adm->baseurl($p2title)?>/<?=$allp[0]?>">
        <div class="combo_cat_product_image_right"> <img border="0"  src="<?=$cms->getImageUrl($p2image,135,120); ?>"  title="<?=$p2?>" alt="<?=$p2?>"/> 
        </div> </a>
        </div>
        </div>
        <div class="combo_offer-div">
          <div  class="main_div4tooltip tip<?=$k?>">
            <div class="hovr_tooltip_div">
			<?php 
	  		 $explode  = explode('$$',$storeres['prod_id']);
	         $pric =	$cms->getPriceSize($explode[0],$current_store_user_id,$explode[1]); 
			?>
			 <p><a href="#"><?=$p1?> = Rs. <?=$pric?> </a></p> 
			 
			<?php  
	  $pr = explode(",",$storeres['comboprod']); 
			if(count($pr)){
				foreach($pr as $val){
					$v  = explode('$$',$val);
					$prc = $cms->getPriceSize($v[0],$current_store_user_id,$v[1]);

				    $title = $cms->getSingleresult("select title from #_products_user where status='Active' and pid = '".$v[0]."'");

					?><p><a href="#"><?=$title?><?php if($v[1]!='NA'){ ?>(<?=$v[1]?>) <?php } ?>= Rs. <?=$prc?> </a></p><?php
					}
					 
			} ?>
			 
				</p> 
              <p><a href="#">Total = Rs. <?=$storeres['comboprice']?>   && Total Saving = Rs. <?=($storeres['totalprice']-$storeres['comboprice'])?>  </a></p>
			 
            </div>
			
          </div>
          <a href="Javascript:void(0)" lang="tip<?=$k?>" class="tooltip"><?=($storeres['totalcomboproduct']+1)?> Combo Offers Available</a> </div> 
        <div class="combo_cat_product_text_info"> 
          <div class="combo_cat_product_text_info_buttn">
            <div class="combo_cat_product_text_info_buttn_left"> <a class="combo_product_price">
              <?=$storeres['comboprice']?>
              /-</a>
               
              <a class="combo_product_price combo_right_price">
              <?=$storeres['totalprice']?>
              /-</a>
			  
            <a href="javascript:void(0)" class="buycombo" style="padding: 0 5px 0 5px;  background: #<?=$colres[sstrip]?>; color: #fff; margin-bottom: 5px; float: left;" lang="<?=$storeres[pid]?>">Buy This Combo</a>  
            </div> 
             <span style="padding: 15px; display:none;width:150px"  id="ajaxload"><img src="<?=SITE_PATH?>images/ajax-loading.gif" alt="" title="" /></span>
               
            
          </div>
          
        </div>
        
      </div>
    </div>
    <?php $k++;
			  }
	  }?>
    <div class="pag_no" style="color:black;width: 940px;">
      <?php $Obj->getPageNo(); ?>
    </div>
  </div>
  <?php		
	}else{ 
		echo ' <p style="color:black; margin-left:20px;">No Record Found</p> ';
	}?>
</div>
</div>
</div>
