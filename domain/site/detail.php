<?php 
/* product view code */  
//$cms->productView($current_store_user_id,$items[2]);
$cms->BrandProdView($current_store_user_id,$items[2]);
/* end */
	$cms->db_query("update #_products_user set clicks = (clicks+1) where pid='".$items[2]."' ");
	if($_GET[addToCompair]){
				$ur = @explode('?',$cms->curPageURL()); 
				$totalComp = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."'");
				$check = $cms->getSingleresult("select count(*) from #_product_compare where  ssid = '".session_id()."' and  product_id = '".$_GET[pid]."'");
				if($check){
					$_SESSION['comp'] = 'already'; 
					$cms->redir(substr($ur[0],0,-1), true);die;
				}
				if($totalComp>=4){
					$_SESSION['comp'] = 'no';	
					$cms->redir(substr($ur[0],0,-1), true);die;
				}else{
					 $insertQry = "insert into #_product_compare set product_id = '".$_GET[pid]."',   ssid = '".session_id()."' ";  	
					 $cms->db_query($insertQry);
					 $last = mysql_insert_id();
					 if($last){
						 $_SESSION['comp'] = 'yes';
						 $cms->redir(substr($ur[0],0,-1), true);die;
					 } 
				}  
		} 
	$prod=$cms->db_query("select * from #_products_user where pid='".$items[2]."' ");
	$res=$cms->db_fetch_array($prod);  
     if($cms->is_post_back()) { 
		 if(strtolower($_POST['secCode'])==strtolower($_POST['captcha'])){
			if($_POST[Submit]=='Submit Enquiry' && $_POST[name]!='' && $_POST[email]!=''){
			$getAdminemail = $cms->getSingleresult("select email_id from #_store_user where  pid = '$current_store_user_id'");
			$uids =  $cms->sqlquery("rs","products_inquery",$_POST); 
			if($uids){
			 
			    $arr[user_id] = $lastId;
				$arr[store_id] = $current_store_id;
				$cms->sqlquery("rs","member_access",$arr);
				$adminEmail = $cms->getSingleresult("select email_id from #_store_user where pid = '$current_store_user_id' ");
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Fizzkart@fizzkart.com' . "\r\n" .'CC: '.$adminEmail;
                $ch = $cms->db_query("select * from #_template where title ='Product Query' and store_id = '$current_store_user_id' ");
				if(!mysql_num_rows($ch)){
					$ch = $cms->db_query("select * from #_template where title ='Product Query' and store_id = '0' ");
				} 
				$tempRes = $cms->db_fetch_array($ch);
				$subject2 = $tempRes[subject]; 
				$url=$cms->curPageURL();
				$subject2 = str_replace("%%productname%%", $res['title'],$subject2);
				$mess2 = $tempRes[body]; 
				$mess2 = str_replace("%%subdomain%%", SITE_PATH,$mess2);
				$mess2 = str_replace("%%productname%%",$res['title'],$mess2);
				$mess2 = str_replace("%%name%%", $_POST[name],$mess2);
				$mess2 = str_replace("%%phone%%", $_POST[phone],$mess2);
				$mess2 = str_replace("%%email%%", $_POST[email],$mess2);
				$mess2 = str_replace("%%querytime%%", time(),$mess2);
				$mess2 = str_replace("%%city%%", $_POST[city],$mess2);
				$mess2 = str_replace("%%address%%", $_POST[address],$mess2);
				$mess2 = str_replace("%%pincode%%", $_POST[pincode],$mess2);
				$mess2 = str_replace("%%query%%", $_POST[query],$mess2); 
				$mess2 = str_replace("%%url%%", $url,$mess2); 
				@mail($_POST[email], $subject2, $mess2,$headers); 
 				$er= '<p align="left" style="color:green; margin:10px 0; display:block; ">Thank You For Submit Your Query. We Will Get You Back Soon.</p>';
				$_POST = false;  
				
			} 
			 }
	      }
		 
}
$metaTitle = ($res[meta_title])?$res[meta_title]:$res[title];
$metaIntro = ($res[meta_description])?$res[meta_description]:substr(str_replace("_x000D_"," ",strip_tags($res[body1])),0,200);
$metaKeyword = $res[meta_keyword];
$proimages = SITE_PATH_M."uploaded_files/orginal/".$res['image1']; 

?>  
<div  class="main_matter_area">
  <div class="product_view_main">
    <div class="product_view_main_left">
      <div class="product_view_main_left1">
        <?php 
	  $catarray = array();
	  $getcatid = $cms->getSingleresult("select cat_id from #_products_user where pid = '".$items[2]."'");
	  $title = $cms->getSingleresult("select title from #_products_user where pid = '".$items[2]."'");
	  $getparent = $cms->getSingleresult("select parentId from #_category where pid = '".$getcatid."'");
	  if($getparent){
		$pane = $cms->getSingleresult("select name from #_store_menu where cat_id = '$getparent'");  
		?>
        <a href="<?=SITE_PATH?>category-product/<?=$adm->baseurl($pane)?>/<?=$getparent?>">
        <?=$pane?>
        </a>
        <?php
	  }
	   if($getparent){?>
        <a href="#">>></a>
        <?php
	  }
	   
	  $caname =  $cms->getSingleresult("select name from #_store_menu where cat_id = '$getcatid' and store_user_id = '$current_store_user_id'");
	  ?>
        <a href="<?=SITE_PATH?>category-product/<?=$adm->baseurl($caname)?>/<?=$getcatid?>">
        <?=$caname?>
        </a> |<a style="margin-left:5px;" href="<?=$cms->curPageURL()?>/?addToCompair=1&pid=<?=$items[2]?>"> ADD TO COMPARE LIST </a> </div>
      <div class="product_view_main_left2">
    <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-7">
                <ul id='girlstop' class='fz-start'>
				<?php
                  $cms->zoomImg($res[image1],$res[title]);
				  $cms->zoomImg($res[image2],$res[title]);
				  $cms->zoomImg($res[image3],$res[title]);
				  $cms->zoomImg($res[image4],$res[title]);
				 ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
    


        <div class="view">
          <div class="view1">
            <div class="write_review"><a href="<?=SITE_PATH.'product_rate/'.$items[1].'/'.$items[2]?>">Write a Review</a></div>
            <h3>
              <?=$res['title']?>
            </h3>
            <?php   
					$offerprice2 = $cms->getSingleresult("select offerprice from #_barnds_product where prod_id = '".$res[pid]."' and store_user_id = '".$current_store_user_id."'");
					if($offerprice2){
						$res['offerprice'] = $offerprice2;
					}
			 $ms = $cms->checkoffer($items[2],$current_store_user_id);  
				    ?>
            <div class="view1_2">
              <?php
			  if(count($ms)){
				foreach($ms as $val){?>
				 <p style="background:url(<?=SITE_PATH_M?>domain/images/tickmark.png) left top no-repeat; line-height:20px; padding-left:20px; font-size:11px; ">
                <?=$val?>
              </p><?php
				}
			  }
			  ?>
              <p style="background:url(<?=SITE_PATH_M?>domain/images/tickmark.png) left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;<?=($res[kf1]=="")?'display:none':''?>">
                <?=str_replace('_x000D_','',$cms->removeSlash($res[kf1]))?>
              </p>
              <p style="background:url(<?=SITE_PATH_M?>domain/images/tickmark.png) left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;<?=($res[kf2]=="")?'display:none':''?>">
                <?=str_replace('_x000D_','',$cms->removeSlash($res[kf2]))?>
              </p>
              <p style="background:url(<?=SITE_PATH_M?>domain/images/tickmark.png)  left top no-repeat; line-height:20px; padding-left:20px; font-size:11px;<?=($res[kf3]=="")?'display:none':''?>">
                <?=str_replace('_x000D_','',$cms->removeSlash($res[kf3]))?>
              </p>
            </div> 
			<samp class="sizesuccesshide">
			 <div style="clear:both"></div>
            <?php  $price = $cms->getBothPrice($res['pid'],$current_store_user_id); 
		    ?>
            <p>Price:
              <?php  if($price[1]>0 && $price[1]< $price[0]){ ?>
              <span  style="text-decoration:line-through; padding-right:10px; color:#FF0000">
              <?=$cms->price_format($price[0])?>
              </span>
              <?php } 
			   $cost = $price[0];
				 if($price[1]>0 && $price[1]< $price[0]){
					$cost = $price[1];
				 }?>
              <span>
              <?=$cms->price_format($cost)?>
              </span> <br />
            </p>
			</samp>
			 <samp class="sizesuccess"> </samp> 
			    
			 <form method="post" action="" > 

		    <div class="size_selection">
			<div class="color_boxes_maindiv" <?=($current_store_type=="store")?'':'style="display:none"'?>>
			<input type="text"   class="tex-field" style="width: 90px;border:gray solid 1px;" value="1" id="cartQty" name="qty">

			 
			</div>
			 <?php	
			$st_usr_id = $cms->getSingleresult("select store_user_id from #_products_user where pid = '".$items[2]."'");
			$ownername = $cms->getSingleresult("select title from #_store_detail where store_user_id = '".$st_usr_id."'");
			if($st_usr_id == $current_store_user_id){
				$own = 'Owner';
                
			}else{			
				$own = 'Brand';
				
			}
			 
			?>
			 <?php 
			 $clr = @explode(',', $res[color]); 
 			$k=1; 
		 if(count($clr)>1){   ?>
            <div class="color_boxes_maindiv">
			
			<span class="size_selection-color">Select Your Colour :</span> 
	<?php	
				foreach($clr as $val){ 
				 
				 $clrcode = $cms->getSingleresult("select colorcode from #_color where name = '$val' and store_user_id = '$st_usr_id' ");  
	?>     <div class="color_boxes">
				<input type="radio" id="checkbox-1-<?=$k?>" name="pcolor" value="<?=$clrcode?>" class="regular-checkbox<?=$k?>" />
				<label for="checkbox-1-<?=$k?>" class="checkbox-1-<?=$k?>"></label>
				<?php include("color_css.php"); ?>
             </div>
  <?php $k++;  }  ?> 
            </div>
  <?php }  	
		 $prod_price =$cms->db_query("SELECT dsize FROM #_product_price WHERE  proid ='".$items[2]."' and (dsize!='' and dsize!='0') ");
		if(mysql_num_rows($prod_price)){ ?>
            <div class="qty_boxes_maindiv">
			<span class="size_selection-color">Select Your Option :</span><br/>
               <div class="qty_commondiv" style=" float: left; ">
			    <?php  
			    $i = 1;
				while($pro_p=$cms->db_fetch_array($prod_price)){ 
				 	?> 
                <input type="radio"  <?=($i==1)?'checked':''?> id="checkbox-1-1" class="qty_commondiv1" name="size" value="<?=$pro_p[dsize]?>" alt="<?=$res[pid]?>" title="<?=$m?>" />
				<label for="checkbox-1-1" class="qty_commondiv_label"><?=$pro_p[dsize]?></label>
				 
		 <?php $i++; } ?></div>
			  
            </div>
<?php } ?>		  
              
             </div>
			 
              <p> 
                <input type="hidden" value="1" name="addtocart" />
                <a <?=($current_store_type!="store")?'':'style="display:none"'?> href="<?=SITE_PATH.'locate-store/'.$items[1].'/'.$items[2]?>">
                <input type="button" style="width:auto"  class="button" value="Locate product store(s)" />
                </a>
             <?php if($price[0]!=0){ ?>   <input type="button" <?=($current_store_type=="brand")?'style="display:none"':''?> style="width:auto" id="addtocart" class="button addtocart" value="Add To Cart" alt="<?=$res['pid']?>" title="<?=$clrcode?>" lang="<?=$pro_p[dsize]?>" /><?php } ?>
              <p style="color:#009900"> <span class="cartsuccess1">	  </span></p>
 			    <?php if($_SESSION['crt']=='yes'){?>
              <p style="color:#009900">This product has been added to cart!</p>
              <?php }else if($_SESSION['crt']=='no'){?>
              <p style="color:#FF0000">This product has been already added to cart!</p>
              <?php } unset($_SESSION['crt']);?>
              <?php if($_SESSION['comp']=='yes'){?>
              <p style="color:#009900">This product has been added to compare list!</p>
              <?php }else if($_SESSION['comp']=='no'){?>
              <p style="color:#FF0000">You can not compare more then 4 product at a time!</p>
              <?php } 
			  else if($_SESSION['comp']=='already'){?>
              <p style="color:red">This product has been already added to your compare list!</p>
              <?php }unset($_SESSION['comp']);?>
              </p>
            </form>
          </div>
          <div class="view2">
            <h3>Product Detail</h3>
            <table width="100%" border="1" cellspacing="0.1" cellpadding="0.1" class="brdr">
              <tr>
                <td class="space">Prod Title : </td>
                <td class="space"><?=$res['title']?></td>
              </tr>
              <tr>
                <td class="space">Category : </td>
                <td class="space" ><?=$cms->getSingleresult("select name from #_store_menu where  cat_id = '".$res['cat_id']."' and store_user_id = '$current_store_user_id' ")?></td>
              </tr>
              <tr <?=($res[color])?'':'style="display:none"'?>>
                <td class="space">Color : </td>
                <td class="space" ><?=$res[color]?></td>
              </tr> 
              <tr >
                <td class="space"><?=$own?>
                  : </td>
                <td class="space" ><?=ucwords($ownername)?></td>
              </tr>
              <?php
		$prodf=$cms->db_query("select * from #_product_feature where prod_id='".$items[2]."' ");
		if(mysql_num_rows($prodf)){?>
              <?php
			while($resf=$cms->db_fetch_array($prodf)){ extract($resf);
				if($fdescription!=""){?>
              <tr>
                <td  class="space"><?=$ftitle?></td>
                <td  class="space"><?=str_replace('_x000D_','',$fdescription)?></td>
              </tr>
              <?php
				}
			}
			 
		}?>
              <tr>
                <td class="space">Added On : </td>
                <td class="space" ><?=date("d-M-Y",$res['submitdate'])?></td>
              </tr>
            </table>
          </div>
          <div class="view3"> <span class='st_sharethis_hcount' displayText='ShareThis'></span> <span class='st_facebook_hcount' displayText='Facebook'></span> <span class='st_twitter_hcount' displayText='Tweet'></span>
            <?php /*?><span class='st_linkedin_hcount' displayText='LinkedIn'></span> 
				<span class='st_pinterest_hcount' displayText='Pinterest'></span>
				<span class='st_email_hcount' displayText='Email'></span><?php */?>
          </div>
        </div>
      </div>
      <div class="description">
        <h4>Product Description</h4>
        <?=str_replace("_x000D_"," ",$res[body1])?>
      </div><?php 
	  $offer = $cms->checkofferProduct($items[2],$current_store_user_id);  
	  if(count($offer)){
	  ?>
      <h3 class="undefined_div_h3"><a name="viewoffer" href="javascript:void(0);">Product's Avail on Offer</a> 
	  <span class="cartsuccess"></span></h3>
      <div class="undefined_div_scroll"> <?php

		foreach($offer as $val){?>
			<div class="undefined_div">
			  <div class="undefined_check">
				<input type="checkbox" name="checkbox" value="<?=$val?>"  class="undefined_checkbox offerprodcheckbox" />
				<img id="offerprodcheckbox<?=$val?>" src="<?=SITE_PATH?>images/ajax-loading.gif">
			  </div><?php
			   $qry = $cms->db_query("select title,image1,kf1,kf2,kf3  from #_products_user where pid='$val'"); 
			   $bp=$cms->db_fetch_array($qry);
			   $Cprice = $cms->getBothPrice($val,$current_store_user_id);
			   $mainprice = $Cprice[0];
			   $disprice = $Cprice[1];  
			  ?> 
			  <div class="undefined_imag"><img src="<?=$cms->getImageSrc($bp['image1'])?>" width="100" height="75"  alt=""/></div>
			  <div class="undefined_name">
				<p><strong><a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($bp[title])?>/<?=$val?>"><?=$bp[title]?></a></strong></p>
				<p class="desc_text_p"><?=($bp[kf1])?str_replace("_x000D_"," ",$bp[kf1]):''?><?=($bp[kf2])?', '.str_replace("_x000D_"," ",$bp[kf2]):''?><?=($bp[kf3])?', '.str_replace("_x000D_"," ",$bp[kf3]):''?></p>
			  </div>
			  <div class="undefined_price"> 
			  <?php if($disprice >0 && $disprice < $mainprice){?><span><?=$cms->price_format($mainprice)?></span><?php }?> 
			  <?php if($disprice < $mainprice && $disprice!=0 ){ echo $cms->price_format($disprice);   } else { echo $cms->price_format($mainprice); } ?></div>
			</div>  
		<?php
		}?> 
      </div>
      <?php 
	  }
	 $comboQry=$cms->db_query("select * from #_combo_prod where prod_id='".$items[2]."' ");
	 $cntcmbo = mysql_num_rows($comboQry);
	 if($cntcmbo){   include "site/tab-combo.php"; }?>
    </div>
    <div class="product_view_main_right_main">
      <div class="product_view_main_right">
        <h3>Fill this Form to Get your Product</h3>
        <h5>
          <?=$er?>
        </h5>
           <table width="100%" cellspacing="0" cellpadding="0" border="0">
		   
        <form action="" method="post" onSubmit="return formvalid3(this);" >
          <tbody>
            <tr>
              <td width="31%" align="right" class="form_div_text">Name* :</td>
              <td width="69%" align="left" class="form_div_text"><label>
                <input type="text" class="tex-field" id="name" name="name" lang="R" title="Name"   value="<?=$_POST[name]?>" />
                </label></td>
            </tr>
          </tbody>
          <input type="hidden" name="productname"  value="<?=$res['title']?>" />
          <input type="hidden" name="product_id"  value="<?=$items[2]?>" />
          <input type="hidden" name="store_id"  value="<?=$current_store_user_id?>" />
          <tr>
            <td align="right" class="form_div_text">Phone* :</td>
            <td align="left" class="form_div_text"><input type="text" maxlength="10" class="tex-field" lang="R isMobile" title="Phone"   id="phone" name="phone" value="<?=$_POST[phone]?>" /></td>
          </tr>
          <tr>
            <td align="right" class="form_div_text">Email* :</td>
            <td align="left" class="form_div_text"><input type="text" class="tex-field" id="email" lang="RisEmail" title="Email"  name="email" value="<?=$_POST[email]?>"  /></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="form_div_text">Address* :</td>
            <td align="left" class="form_div_text"><textarea name="address" lang="R" title="Address"  id="address" class="fld_area" ><?=$_POST[address]?>
</textarea></td>
          </tr>
          <tr>
            <td align="right" class="form_div_text">City* :</td>
            <td align="left" class="form_div_text"><input type="text" class="tex-field" id="city" name="city" lang="R" title="City" value="<?=$_POST[city]?>" /></td>
          </tr>
          <input type="hidden" name="state" id="state" value="KA" />
          <tr>
            <td align="right" class="form_div_text">Pin*:</td>
            <td align="left" class="form_div_text"><input type="text" class="tex-field" id="pincode" name="pincode" maxlength="6"   lang="R SisNaN" title="Pincode" value="<?=$_POST[pincode]?>" /></td>
          </tr>
          <tr>
            <td align="right" valign="top" class="form_div_text">Query* :</td>
            <td align="left" class="form_div_text"><textarea name="query" lang="R" title="Query"  id="query" class="fld_area" ><?=$_POST[query]?>
</textarea></td>
          </tr>
		  <tr>
        <td width="30%" align="right" valign="bottom" class="form_div_text">Security code* :</td>
        <td width="70%" align="left" valign="top">
		<?php
		$rand =$cms->generate_random_password();
		?>
		<input type="text" disabled="disabled" class="othr_flds"  value="<?=$rand?>" alt="captcha" size="5" style="text-indent:3px; background:#<?=$colres[background]?>; font-weight:bold; width:60px;"/><br /><br /> 
		<input type="hidden" name="captcha" value="<?=$rand?>">
        <input name="secCode"class="tex-field" value=""  title="Security Code" lang="R" type="text" placeholder="Enter the code above here" /></td>
      </tr> 
          <tr id="showErrorLTr">
            <td valign="middle" style="text-align:right;"></td>
            <td align="left" valign="middle" ><input type="submit" class="button" name="Submit" value="Submit Enquiry" /></td>
          </tr>
          <tr>
            <td></tbody></td>
          </tr>
          </form>
		  
        </table>
      
      </div>
      <div class="product_view_main_left3">
        <h2 style="color:black">You may also like</h2>
        <div class="carouse212121">
          <?php 
		$pr[] = 0; 
		$ids=$cms->db_query("select pid from #_products_user where store_user_id='$current_store_user_id' 
		and status = 'Active' and cat_id = '".$res[cat_id]."' and pid !='".$items[2]."' order by pid desc");
		if(mysql_num_rows($ids)){
			while($r=$cms->db_fetch_array($ids)){
				$pr[] = $r[pid];
			}
		} 
		$brandProds = $cms->db_query("select prod_id from #_barnds_product where 
		store_user_id='$current_store_user_id' 
		and cat_id = '".$res[cat_id]."' and prod_id !='".$items[2]."' ");			
		if(mysql_num_rows($brandProds)){
			while($re=$cms->db_fetch_array($brandProds)){
				$pr[] = $re[prod_id];
			}
		} 
		$show = 4;
		$tc = count($pr);
		if($tc<=4){
			$show = $tc;
		} 
		 
	$store=$cms->db_query("select pid,title,cat_id,clicks,image1 from #_products_user where  status = 'Active' and pid in (".implode(',',$pr).") order by rand() limit 0, $show");
 	if(mysql_num_rows($store)){  
		while($storeres=$cms->db_fetch_array($store)){ 
		?>
          <div class="main_view_center">
            <div class="main_view_margin-auto">
              <div class="main_view_main">
                <div class="main_view">
                  <table width="150" height="160"  cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr>
                        <td align="center" valign="middle"><a href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>"> <img src="<?=$cms->getImageSrc($storeres['image1']); ?>"  width="160" height="150"  title="<?=$storeres['title']?>" alt="<?=$storeres['title']?>" align="middle"/> </a></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="main_view_text">
                    <p>
                      <?=$storeres['title']?>
                      <?=$storeres['cat_id']?>
                    </p>
                    <span>
                    <?php if($cms->getPrice($storeres['pid'],$current_store_user_id)){?>
                    <span>
                    <?=$cms->price_format($cms->getPriceOnly($storeres['pid'],$current_store_user_id))?>
                    </span>
                    <?=$cms->price_format($cms->getPrice($storeres['pid'],$current_store_user_id))?>
                    <?php }
						else {?>
                    <?=$cms->price_format($storeres['price'])?>
                    <?php }?>
                    </span>
                    <div></div>
                    <a  href="<?=SITE_PATH?>detail/<?=$adm->baseurl($storeres['title'])?>/<?=$storeres['pid']?>">BUY NOW</a> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php }
		 }else{?>
        <div class="main_view">
          <div class="main_view_text">
            <p> No Related Products Found! </p>
          </div>
        </div>
        <?php
		 } 
		 ?>
      </div>
    </div>
  </div>
</div>
</div>
   
 