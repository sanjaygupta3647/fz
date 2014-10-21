<footer>
      <div class="copyright">Copyright <?=date('Y')?>. All rights reserved</div> 
      <div class="cl"></div>
</footer>
<input type="hidden" name="action" id="action"/>
<input type="hidden" name="submitdate" id="submitdate" value="<?=time()?>"/>
<input type="hidden" name="updateid" id="updateid" value="<?=$id?>"/>
<?=$cms->eform();?>
<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
 $(document).ready(function(){ 
	 $("#hed-tit").html('<?=$hedtitle?>');
	 <?php 
	 if($hedtitle!=""){
	 ?>
	// $("#innertit").html('<?=$hedtitle?>');
	 <?php }?>
	});
	$('.qty').keyup(function() {
		var val = $(this).val();
		if(isNaN(val) || val=='0'){
		alert("Invalid Quantity value!")
		$(this).val(1); 
		$(this).focus(); 
	}
	});
</script>
 