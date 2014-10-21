<div class="profile_tabs1" >
<?php 
if(!$_SESSION[userid]){ 
$redpath = SITE_PATH;
$cms->redir($redpath,true);die;
}
$cls = 'class="active"';
if($_SESSION[user_store_id] != $current_store_id){
 	echo"<script>self.location='".SITE_PATH."domain'</script>";
}
?>
  <ul>
    <li><a href="<?=SITE_PATH?>profile" <?php if($items[0]=='profile' || $items[0]== 'profile_edit') echo $cls;  ?>>Profile</a></li>
    <li><a href="<?=SITE_PATH?>mytransaction" <?php if($items[0]== 'mytransaction') echo $cls;  ?>>My Transaction</a></li>
    <li><a href="<?=SITE_PATH?>my-fav-store" <?php if($items[0]== 'my-fav-store') echo $cls;  ?>>My Favourite Stores</a></li>
   </ul>
</div>
