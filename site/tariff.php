<?php  
include "site/search.inc.php";
       $metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='tarrif-plans' and store_user_id = '0'");
		$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='tarrif-plans' and store_user_id = '0'");
		$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='tarrif-plans' and store_user_id = '0'");
		$body = $cms->getSingleresult("SELECT body FROM `#_pages` where url ='tariff' and status = 'Active'  and store_user_id = '0'	 ");
$heading = $cms->getSingleresult("SELECT heading FROM `#_pages` where url ='tariff' and status = 'Active' and store_user_id = '0'");  
?>

<div class="contentarea">
  <div class="registerheadbox">
    <div class="heading"><img src="images/heading-arrow-icon.jpg" width="11" height="7" alt="Register with us" /> <?=$cms->removeSlash($heading)?> </div>
    <div class="subtext"><?=$cms->removeSlash($body)?> </div>
  </div>
  <div class="registerarea">
    <div class="heading">Fizzkart Tariff list</div>
    <div class="subarea">  
        <div class="registr_maindiv">
          <div class="registr_maindiv-1">
            <h2 class="benefit_plan-h2">We Provide Best Benefit Plans to You</h2>
          </div>
          <div class="registr_maindiv-2">
            <div class="registr_maindiv-2-left">
              <h2 class="plan_heading-h2">Our <span>Store Owner</span> Plans</h2>
              <ul>
			  <?php  
				$sql=$cms->db_query("select * from #_plans  where status='Active' and type = 'store'"); 
				$i = 1;
				while($result=$cms->db_fetch_array($sql)){?>
					 <li class="item <?=($i%2==0)?' color':''?>" ><a href="Javascript:void(0)"><?=ucwords(strtolower($result['name']))?></a>
						<div class="tooltip-div" hidden="hidden">
                        <span class="opener"></span>
                        <span class="closetip">Close</span>
						<div class="main_tooltip">
						  <h2 class="tooltip_h2">Tariff & Hosting Plans for <?=ucwords(strtolower($result['name']))?></h2>
						  <div class="plan_selection">
							<ul><?php
							  $qry = $cms->db_query("SELECT pid,noOfDays,amount,noOfMessage FROM `#_plans_hosting` where plan_id ='".$result['pid']."'  ");
								if(mysql_num_rows($qry)){  
									while($res = $cms->db_fetch_array($qry)){
										@extract($res); ?>
										<li><a href="<?=SITE_PATH?>Step-1/skip/store/<?=$result['pid']?>/<?=$pid?>"><?=$noOfDays?> Days / <?=$cms->price_format($amount)?> / <?=$noOfMessage?> Message</a></li><?php 
									}
								
								}?> 
							</ul>
						  </div>
						  <div class="plan_description" id="tooltip_show">
							<p class="tooltip_p"><strong>No. of Products:</strong> <?=$result['noOfProducts']?></p>
							<p class="tooltip_p"><strong>No. of Brands:</strong><?=$result['noOfBrands']?></p>
							<p class="tooltip_p"><strong>Categories:</strong> <?=$result['body']?>.</p>
						  </div>
						</div>
					  </div> 
					 </li><?php $i++;
				}?>  
              </ul>
            </div>
            <div class="registr_maindiv-2-left">
              <h2 class="plan_heading-h2">Our <span>Brand Owner</span> Plans</h2>
              <ul>
                 <?php  
				$sql2=$cms->db_query("select * from #_plans  where status='Active' and type = 'brand'"); 
				$j = 1;
				while($result2=$cms->db_fetch_array($sql2)){?>
					 <li class="item <?=($j%2==0)?' color':''?>" ><a href="Javascript:void(0)"><?=ucwords(strtolower($result2['name']))?></a>
					 
					 
					<div class="tooltip-div" style="position:absolute; left:0;">
                    <span class="orange_right"></span>
                        <span class="closetip">Close</span>
						<div class="main_tooltip">
						  <h2 class="tooltip_h2">Tariff & Hosting Plans for <?=ucwords(strtolower($result2['name']))?></h2>
						  <div class="plan_selection">
							<ul><?php
							  $qry2 = $cms->db_query("SELECT pid,noOfDays,amount,noOfMessage FROM `#_plans_hosting` where plan_id ='".$result2['pid']."'  ");
								if(mysql_num_rows($qry2)){  
									while($res1 = $cms->db_fetch_array($qry2)){
										@extract($res1); ?>
										<li><a href="<?=SITE_PATH?>Step-1/skip/brand/<?=$result2['pid']?>/<?=$pid?>"><?=$noOfDays?> Days / <?=$cms->price_format($amount)?> / <?=$noOfMessage?> Message</a></li><?php 
									}
								
								}?> 
							</ul>
						  </div>
						  <div class="plan_description" id="tooltip_show">
							<p class="tooltip_p"><strong>No. of Products:</strong> <?=$result2['noOfProducts']?></p>
							<p class="tooltip_p"><strong>No. of Store:</strong><?=$result2['noOfStores']?></p>
							<p class="tooltip_p"><strong>Categories:</strong> <?=$result2['body']?>.</p>
						  </div>
						</div>
					  </div> 
					 </li>
					 <?php $j++;
				}?>
                 
              </ul>
            </div>
            
            <div class="registr_maindiv-2-mid">&nbsp;</div>
            <div class="registr_maindiv-2-right">&nbsp;</div>
          </div>
        </div>
     </div>
  </div>
</div>
