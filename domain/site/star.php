<div class="reviews_intro">
<?php
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
	if(!$er){
		$_POST[user_id] = $_SESSION[userid];
		$cms->sqlquery("rs","review",$_POST);
 		$lastId  = mysql_insert_id();
		if($lastId) $_POST = false;
 	}
	 
}
?>
<h2>Post your Reviews</h2>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis </p>
</div>

<div class="reviews_system_scnd">
        <h2>Post Your Reviews for title</h2>
        <div class="reviews_div_scnd"> 
          <div class="successmsg" style="<?=($lastId)?'':'display:none;'?>"> Thanku for successfully posted your review.</div>
		  <?php
		  if($er){?>
			<div class="errormsg"><?=$er?></div>
		  <?php

		  }?>
		  
		  
             
          <form method="post" action=""> 
          <div class="reviews_div1_scnd creme_clr"><p>Title :</p>
           	<div class="rating">
            <input type="text" name="title" value="<?=$_POST[title]?>" id="textfield" class="reviews_title" /><p style="text-align: left;font-size: 10px;">(Maximum 20 words)</p> 
            </div>
           </div>
           <div class="reviews_div1_scnd white_clr"><p >Your Comments :</p>
           	<div class="rating">
            <textarea name="comment" id="textarear" rows="5" cols="22" class="comment_textarea"><?=$_POST[comment]?></textarea>  
			<p style="text-align: left;font-size: 10px;width: auto;">(Please make sure that your review contain atlest 50 characters)</p> 
            </div>
           </div>
		 <div class="reviews_div1_scnd white_clr"><p>Lorem Ipsum 1:</p>
          <div class="rating">
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
		  <input type="submit" name="submit_post" class="submitbutton" value="Post Your Review" /> 
            </div>
		   </form>	 
          </div> 
		 
        </div>
        <div class="posted_reviews_scnd">
        <h4 style="padding-left: 10px;">Posted Reviews by Users</h4>
		<?php  $star=$cms->db_query("select * from #_review where store_id='".$_SESSION[user_store_id]."' and status='Active' order by pid desc limit 1,3");
		      if(mysql_num_rows($star)){
			   while($data=$cms->db_fetch_array($star)){  
			  // extract($data);
			      ?>
           <div class="only_posted_reviews_scnd">
        	<div class="posted_reviews_left_scnd">
            <?=$cms->getSingleresult("select fname from #_members where pid='".$data[user_id]."'")?>&nbsp;<?=$cms->getSingleresult("select lname from #_members where pid='".$data[user_id]."' ")?>
            </div>
            <div class="posted_reviews_right_scnd"> 
			  <div class="rating_imgsdiv">
               <?php for($i =1; $i<=$data[star]; $i++){?> <img src="<?=SITE_PATH?>images/active.png"/><?php } ?>
               <?php for($j =$i; $j<=5; $j++){?><img src="<?=SITE_PATH?>images/deactive.png" /> <?php } ?>
              </div>
			<div class="review_comments_scnd"> <p> <?=$data[title]?></p> <p> <?=$data[comment]?></p>
            <span><?=$date = date('j F, Y, h:m:s', strtotime($data[createTime]));?></span></div>
            </div>
            </div>
			<?  } }else{ echo "No Record"; }   ?>
             
        </div>
      </div>
	  </div>