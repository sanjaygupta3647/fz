<div class="tabdiv_left" >
<?php 
if(!$_SESSION[userid]){ 
$redpath = SITE_PATH;
$cms->redir($redpath,true);die;
}
$cls = 'class="active"';
?>
  
    <div class="tabdiv_left1"><a href="<?=SITE_PATH?>profile" <?php if($items[0]== 'profile' || $items[0]== 'profile_edit') echo $cls;  ?> >Profile</a> </div>
    <div class="tabdiv_left1"><a href="<?=SITE_PATH?>mytransaction" <?php if($items[0]== 'mytransaction') echo $cls;  ?>>My Transaction</a> </div>
    <div class="tabdiv_left1"><a href="<?=SITE_PATH?>my-fav-store" <?php if($items[0]== 'my-fav-store') echo $cls;  ?>>My Fabourite Stores</a> </div>
    
</div>
