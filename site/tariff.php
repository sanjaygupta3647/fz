<?php  
include "site/search.inc.php";
       $metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='tarrif-plans' and store_user_id = '0'");
		$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='tarrif-plans' and store_user_id = '0'");
		$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='tarrif-plans' and store_user_id = '0'");
		$body = $cms->getSingleresult("SELECT body FROM `#_pages` where url ='tariff' and status = 'Active'  and store_user_id = '0'	 ");
$heading = $cms->getSingleresult("SELECT heading FROM `#_pages` where url ='tariff' and status = 'Active' and store_user_id = '0'");  
?>

<div class="row" style="margin-top:20px;">
  <div class="col-md-12 col-sm-12">
    <div class="heading2 col-md-3 col-sm-3"><?=$cms->removeSlash($heading)?> </div>
	<div class="heading2 col-md-2 col-sm-3">
    <a href="<?=SITE_PATH?>renewal_account">
    Renew Account</a></div>
	<div class="heading2 col-md-3 col-sm-2">
    <a href="<?=SITE_PATH?>renewal_sms">
    Renew SMS</a></div>
	<div class="heading2 col-md-3 col-sm-3">
    <a href="<?=SITE_PATH?>renewal_product">
    Renew Product</a></div>
    <!--<div class="subtext"><?=$cms->removeSlash($body)?> </div>-->
  </div>
  <div class="col-md-12 col-sm-12" style="margin-top:20px;color:#fff;">
    <div class="heading col-md-12 col-sm-12" style="color:#fff;text-align:left;">Fizzkart Tariff list > > ></div>
          <div class="registr_maindiv-1 col-md-12 col-sm-12" style="margin:10px 0px 20px 0px">
            <div class="col-md-1 col-sm-1"></div>
			<div class="col-md-11 col-sm-11"><h2 class="benefit_plan-h2">We Provide Best Benefit Plans to You</h2></div>
          </div>
          <div class="">
            <div class="registr_maindiv-2-left col-md-6 col-sm-5" style="margin-bottom:20px;">
              
			  <h2 class="plan_heading-h2">Our <span>Store Owner</span> Plans</h2>
              <ul>
			  <?php  
				$sql=$cms->db_query("select * from #_plans  where status='Active' and type = 'store' order by name"); 
				$i = 1;
				while($result=$cms->db_fetch_array($sql)){?>
					 <li class="item <?=($i%2==0)?' color':''?>" ><a data-toggle="modal" data-target="#myModal"><?=ucwords(strtolower($result['name']))?></a>
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="color:black;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color:black;">Tariff & Hosting Plans for <?=ucwords(strtolower($result['name']))?></h4>
      </div>
      <div class="modal-body" style="height:195px;">
						<div class="main_tooltip">
						  
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
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
					 </li><?php $i++;
				}?>  
              </ul>
				
            </div>
            <div class="registr_maindiv-2-left col-md-6 col-sm-5 col-sm-offset-2">
              
			  <h2 class="plan_heading-h2">Our <span>Brand Owner</span> Plans</h2>
              <ul>
                 <?php  
				$sql2=$cms->db_query("select * from #_plans  where status='Active' and type = 'brand' order by name "); 
				$j = 1;
				while($result2=$cms->db_fetch_array($sql2)){?>
					 <li class="item <?=($j%2==0)?' color':''?>" ><a data-toggle="modal" data-target="#myModal1"><?=ucwords(strtolower($result2['name']))?></a>
					 <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content" style="color:black;">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel" style="color:black;">Tariff & Hosting Plans for <?=ucwords(strtolower($result2['name']))?></h4>
						  </div>
						  <div class="modal-body" style="height:250px;">
								<div class="main_tooltip">
								  <h2 class="tooltip_h2"></h2>
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
						  <div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
							
						  </div>
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
