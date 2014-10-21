<?php
$metaTitle = $cms->getSingleresult("select meta_title from #_meta_info where url='product-reviews' and store_user_id = '$current_store_user_id'");
$metaIntro = $cms->getSingleresult("select meta_description from #_meta_info where url='product-reviews' and store_user_id = '$current_store_user_id'");
$metaKeyword = $cms->getSingleresult("select meta_keyword from #_meta_info where url='product-reviews' and store_user_id = '$current_store_user_id'");?>
<div class="reviews_intro">
<?php 
   // print_r($_POST);die;
 	$_SESSION[review]='review'; 
	$_SESSION[title1]=$items[1]; 
	$_SESSION[prod_id1]=$items[2]; 
if($cms->is_post_back()){ 
		$er = "";
	if(!$_SESSION[userid]){
		$er .= "Please login to post your review. <br/>";
		
	} 
	$wordscnt = count(explode(' ',trim($_POST[title]))); 
	if(!$_POST[title] || $wordscnt>20){
		$er .= "Please enter title between 1-20 words $wordscnt. <br/>";
	}
	if(strlen(trim($_POST[comment]))<50){
		$er .= "Comment must be minimum of 50 characters. <br/>";
	} 
	if(!$er && isset($_POST['submit_post']) && ($_POST['submit_post']=="Post Your Review")){
	   // $arr[]=array();
		$_POST[user_id] = $_SESSION[userid];
		$_POST[prod_id]=$_SESSION[prod_id1];
		//$arr=$_POST[user_id] ;
		//$arr=$_POST[prod_id];
		//$arr=$_POST[title];
		$_POST[type]='product';
		$cms->sqlquery("rs","review",$_POST);  
 		$lastId  = mysql_insert_id(); 
		if($lastId) $_POST = false ;
		 
 	     
	}
	//unset($_POST);
}
?>  
<h2>Post your Reviews</h2>
<p> <?php if($body=$cms->removeSlash($cms->getSingleresult("select body from #_pages where url='review' and store_user_id = '$current_store_user_id' "))){ echo $body; }else{ ?>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis .  
<?php } ?></p>
</div> 
<div class="main_product_reviews">
<div class="reviews_system_scnd">
        <h2>Post Your Reviews for title</h2>
        <div class="prod_rate_leftdiv">
        <div class="prodrate_leftdiv">
        <h3>You have chosen to review</h3>
		<?php $img=$cms->getSingleresult("select image1 from #_products_user where pid='".$_SESSION[prod_id1]."' ");  ?>
        <img src="<?=$cms->getImageSrc($img)?> " width="80" height="70"  alt="" align="left"/>
        <p><?=$items[1]?></p>
        </div>
        <div class="prodrate_leftdiv_info">
        <h3>What makes a good review</h3>
		<?php $productQ=$cms->db_query("select * from #_faq where  store_user_id = '$current_store_user_id' and ftype='product' order by pid desc limit 0,5");
		if(mysql_num_rows($productQ)){
		 while($qdata=$cms->db_fetch_array($productQ)){  
		     @extract($qdata);
		 ?>
        <p><strong><?=$qsn?></strong><br />
        <?=$cms->removeSlash($body)?>
        </p>
       
	   <?php }}else{ ?> <p><strong> Have you used this product?</strong><br />
It's always better to review a product you have personally experienced.</p>

 <p><strong>Educate your readers</strong><br />
Provide a relevant, unbiased overview of the product. Readers are interested in the pros and the cons of the product.
</p>
 <p><strong>Be yourself, be informative</strong><br />
Let your personality shine through, but it's equally important to provide facts to back up your opinion.
</p>
<p><strong>Get your facts right!</strong><br />
Nothing is worse than inaccurate information. If you're not really sure, research always helps.
</p>
<p><strong>Stay concise</strong><br />
Be creative but also remember to stay on topic. A catchy title will always get attention! </p>
 <?php } ?>
        </div>
        </div>
        <div class="prod_rate_rightdiv">
        <div class="prod_reviews_div_scnd"> 
          <div class="successmsg" style="<?=($lastId)?'':'display:none;'?>"> Thanku for successfully posted your review.</div>
		  <?php
		  if($er){?>
			<div class="errormsg"><?=$er?></div>
		  <?php

		  }?>
		  
          <form method="post" action=""> 
          <div class="prod_reviews_div1_scnd creme_clr"><p>Title :</p>
           	<div class="prod_rating">
            <input type="text" name="title" value="<?=$_POST[title]?>" id="textfield" class="prod_reviews_title" /><p style="float:left; text-align: left;font-size: 10px;">(Maximum 20 words)</p> 
            </div>
           </div>
           <div class="prod_reviews_div1_scnd white_clr"><p >Your Comments :</p>
           	<div class="prod_rating">
            <textarea name="comment" id="textarear" rows="5" cols="22" class="prod_comment_textarea"><?=$_POST[comment]?> </textarea>  
			<p style="text-align: left;font-size: 10px;width: auto;">(Please make sure that your review contain atlest 50 characters)</p> 
            </div>
           </div>
		 <div class="prod_reviews_div1_scnd white_clr"><p>Lorem Ipsum 1:</p>
          <div class="prod_rating">
               <img src="<?=SITE_PATH?>images/star-rate-dis.png" class="rating1" lang="rat1_" id="rat1_1" alt="1" />
               <img src="<?=SITE_PATH?>images/star-rate-dis.png" class="rating1" lang="rat1_" id="rat1_2" alt="2" />
               <img src="<?=SITE_PATH?>images/star-rate-dis.png" class="rating1" lang="rat1_" id="rat1_3" alt="3" />
               <img src="<?=SITE_PATH?>images/star-rate-dis.png" class="rating1" lang="rat1_" id="rat1_4" alt="4" />
               <img src="<?=SITE_PATH?>images/star-rate-dis.png" class="rating1" lang="rat1_" id="rat1_5" alt="5" /><br/><br/>
			   <p style="text-align: left;font-size: 10px;width: auto;">(Click on stars to rate on scale of 1-5)</p> 
			   <br/><br/>
		  <input type="hidden" id="star" name="star" value="0">
		  <input type="hidden" id="store" name="type" value="store">
		  <input type="hidden" id="store_id" name="store_id" value="<?=($current_store_id)?$current_store_id:'0'?>">
		  <input type="hidden" id="user_id" name="user_id" value="<?=($_SESSION[userid])?$_SESSION[userid]:'0'?>">
		  <input type="submit" name="submit_post" class="prod_submit_post_cls" value="Post Your Review" /> 
            </div>
		   </form>	 
          </div> 
		 
        <div class="prod_posted_reviews_scnd">
        <h4 style="padding-left: 10px;">Posted Reviews by Users </h4>
		 <?php  
		 $productR=$cms->db_query("select * from #_review where prod_id='".$_SESSION[prod_id1]."' and store_id = '$current_store_user_id' order by pid desc limit 0,3");
		if(mysql_num_rows($productR)){
		 while($data=$cms->db_fetch_array($productR)){  
		     @extract($data);
		 ?>
           <div class="prod_only_posted_reviews_scnd">  
        	<div class="prod_posted_reviews_left_scnd">
              <?=$cms->getSingleresult("select fname from #_members where pid='".$data[user_id]."'")?>&nbsp;<?=$cms->getSingleresult("select lname from #_members where pid='".$data[user_id]."' ")?>
            </div>
            <div class="prod_posted_reviews_right_scnd">
              <?php for($i =1; $i<=$data[star]; $i++){?> <img src="<?=SITE_PATH?>images/active.png"/><?php } ?>
               <?php for($j =$i; $j<=5; $j++){?><img src="<?=SITE_PATH?>images/deactive.png" /> <?php } ?>
			<div class="review_comments_scnd"><p> <?=$data[comment]?></p>
            <span><?=$date =date('j F, Y, h:m:s a', strtotime($data[createTime]));?></span></div>
            </div>
            </div> </div> 
         <?php } }else{?> &nbsp;&nbsp;No Available Review For This Product.<?php }?> 
	    </div>
        </div>
      </div>