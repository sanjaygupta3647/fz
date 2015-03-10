<div class="row" style="margin-top:10px;">
<div class="col-lg-9 col-md-8 col-sm-7">
<div id="myCarousel" class="carousel slide" data-ride="carousel">

  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>


  <div class="carousel-inner" role="listbox">
    
     <?php
		$beannerQry=$cms->db_query("SELECT image FROM #_slider where store_id='0' and slider_type='1' and status = 'Active' order by porder asc"); 
		if(mysql_num_rows($beannerQry)){ 
			$i=1;
			while($res=$cms->db_fetch_array($beannerQry)){ 
				?>
					 <div class="item <?=$i==1?'active':''?>">
					  <img src="http://fizzkart.com/uploaded_files/orginal/<?=$res[image]?>" alt="">
					</div> 
				<?php
					$i++;
			}
		}?>
   
  </div>

  
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<!--<section id="jms-slideshow" class="jms-slideshow">
 <?php
		$beannerQry=$cms->db_query("SELECT * FROM #_slider where store_id='0' and slider_type='1' and status = 'Active' order by porder asc"); 
		if(mysql_num_rows($beannerQry)){ 
		$i=1;
		while($res=$cms->db_fetch_array($beannerQry)){  
		if($res[background]=='image'){ $style = 'style="background:url(http://fizzkart.com/uploaded_files/orginal/'.$res[image].') left top no-repeat;"';
	  }else{ $style = 'style="background:#'.$res[color].'"';     } ?>
	
	 
		<div <?=$style?> class="step" data-color="color-<?=$i?>" <?php if($i==2 || $i==7){?> data-y="500" data-scale="0.4" data-rotate-x="30" <?php }?><?php if($i==3 || $i==8){?> data-x="2000" data-z="3000" data-rotate="170" <?php }?><?php if($i==4){?> data-x="3000"<?php }?><?php if($i==5){?>data-x="4500" data-z="1000" data-rotate-y="45"<?php }?>>
					<div class="jms-content"> 
				<h3 <?=($res[title])?'':'style="display:none;"'?>><?=$res[title]?></h3>
				 <p <?=($res[contents])?'':'style="display:none;"'?>><?=$res[contents]?></p> 
				<a class="jms-link" <?=($res[linkurl]!='')?'':'style="display:none;"'?> href="<?=$res[linkurl]?>">Read more</a>
			</div>
			<img <?=($res[side_image])?'':'style="display:none;"'?> src="<?=$cms->getImageSrc($res[side_image])?>" />
		</div>
		
		<?php $i++; } } ?>
				 
</section>-->
</div>
<div class="col-lg-3 col-md-4 col-sm-5 hidden-xs">
<div class="right_quote pull-right">
<h3><a href="<?=SITE_PATH?>updates" style="color:#fff">Latest updates from us</a></h3>
<div class="some_text">
	<?php
	$updateQry=$cms->db_query("SELECT subtitle,url  FROM #_updates where store_user_id='0'  and status = 'Active' order by pid desc limit 6"); 
	if(mysql_num_rows($updateQry)){
		while($r=$cms->db_fetch_array($updateQry)){
		?><p><a href="<?=SITE_PATH?>updates/<?=$r[url]?>"><?=$r[subtitle]?></a></p> <?php
		}
	}
	?>
	
</div>
<div class="join_button">
<a href="<?=SITE_PATH?>step-1" target="_blank">Join Now</a>
</div>
</div>   
</div>
</div>