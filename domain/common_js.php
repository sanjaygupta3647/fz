<script src="<?=SITE_PATH?>js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="<?=SITE_PATH?>js/jquery.glasscase.min.js" type="text/javascript"></script>
<script type="text/javascript">
        $(function () {
            //Demo 1
            $("#girlstop").glassCase({'thumbsPosition': 'bottom', 'widthDisplay': '300', 'heightDisplay': '450'});
        });
    </script>
<script type="text/javascript" src="<?=SITE_PATH?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/vertical.slider.standard.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/jquery.custombox.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/jquery-paged-scroll.js"></script>

<script type="text/javascript" src="<?=SITE_PATH?>js/demo_popup.js"></script>
<script type="text/javascript">var switchTo5x=true;</script>
<?php if($items[0]=='detail'){ ?>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "486c816d-11df-464d-913e-33336bb090df", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<?php }?>
<script type="text/javascript" src="<?=SITE_PATH?>colorbox/jquery.colorbox.js"></script>  
<script type="text/javascript" src="<?=SITE_PATH?>js/cycle.js"></script> 
<script src="<?=SITE_PATH?>js/flowslider.jquery.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/validate.js"></script>
<div id="fb-root"></div>

<script type="text/javascript" src="<?=SITE_PATH?>js/jquery.accordion.js"></script>
<script type="text/javascript"> 
<?php
if($die){?>  
    $(document).ready(function(){
	urls = '<?=SITE_PATH?>ms_file/inactive';
	$.colorbox({width:"900",height:"100",iframe:false, href:urls });  
	});
<?php
}
?> 
   $( "body" ).delegate( ".popupdetail", "click", function(){ 
		  var urls = $(this).attr('lang'); 
		  urls = urls+'?parent=<?=$cms->geturl()?>';
		  $.colorbox({width:"900",height:"500",iframe:true, href:urls });  
   });
</script>
<script type="text/javascript">
	jQuery().ready(function(){
		// simple accordion
		jQuery('#list1a').accordion(); 
		// second simple accordion with special markup
		jQuery('#navigation').accordion({
			active: false,
			header: '.head',
			navigation: true,
			event: 'mouseover',
			fillSpace: true,
			animated: 'easeslide'
		});
	});
	</script>
<?php if($items[0]=='detail'){ ?>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){ 
    $('#main-banner').cycle({ 
    fx: 'scrollLeft', 
    timeout: 5000, 
    
 });
}); 

$(document).ready(function(){  

$('.cate-menu').mouseover(function(){
 x=$(this).position(); 
 $(this).find('.list-menu').css("left",'-'+x.left+'px');
}); 
})
</script>
<script type="text/javascript"> 
 $(document).ready(function() {
            $(".carouse").FlowSlider(); 
			$('.www_FlowSlider_com-branding').hide();
			 
 }); 
 
$('#slideshowHolder').cycle({ 
    fx:        'turnUp',
    //direction: 'left',
    delay: -2000 
});
$('#prodimg').cycle({ 
    fx:        'cover',
    direction: 'left',
    delay: -2000 
});
<?php
$ur = explode('/?',$cms->curPageURL());
if($items[0]=='category-product'){
?> 
var ur = '<?=$ur[0]?>/?search=1';
$(".refine").click(function(){	
          ///alert('hi...');
			var brand = [];
			var specification = [];
			var price = [];
			var category = [];
			 
			$('input:checkbox[name=category]').each(function(){    
			 if($(this).is(':checked')){
				category.push(this.value);
			 }			 
			 
			});
			var pr = $('input:radio[name=price]:checked').val();		 
			price.push(pr);

			var br = $('input:radio[name=brand]:checked').val();		 
			brand.push(br);
			 
			$('input:checkbox[name=specification]').each(function(){    
			if($(this).is(':checked'))			 
				specification.push(this.value);
			});
			if(brand){
			ur +="&brand="+brand; 
			}
			if(category){
			ur +="&category="+category; 
			}
			if(price){
				ur +="&price="+price;
			}
			if(specification){
				ur +="&specification="+specification;
			}
			window.location=ur;
	});
<?php
}
if($items[0]=='search'){
?> var ur = '<?=$ur[0]?>/?keywords=<?=$_GET[keywords]?>'; 
			$(".refine").click(function(){ 
			var brand = [];
			var specification = [];
			var price = [];
			var category = []; 
			 
			 
			$('input:radio[name=category]').each(function(){    
			 if($(this).is(':checked')){
				category.push(this.value);
			 }			 
			 
			});
			var pr = $('input:radio[name=price]:checked').val();		 
			price.push(pr);

			var br = $('input:radio[name=brand]:checked').val();		 
			brand.push(br);
			 
			$('input:checkbox[name=specification]').each(function(){    
			if($(this).is(':checked'))			 
				specification.push(this.value);
			});
			if(brand){
			ur +="&brand="+brand; 
			}
			if(category){
			ur +="&category="+category; 
			}
			if(price){
				ur +="&price="+price;
			}
			if(specification){
				ur +="&specification="+specification;
			}
			window.location=ur;
	});

<?php
} 
if($items[0]=='combo-offer'||$items[0]=='hot-deal'||$items[0]=='period-offer' || $items[0]=='brand-product'){
?> var ur = '<?=$ur[0]?>/?'; 
			$(".refine").click(function(){	 
			var brand = [];
			var specification = [];
			var price = [];
			var category = [];
			var discount = [];
			$('input:checkbox[name=brand]').each(function(){    
			 if($(this).is(':checked')){
				brand.push(this.value);
			 }			 
			 
			});
			$('input:radio[name=category]').each(function(){    
			 if($(this).is(':checked')){
				category.push(this.value);
			 }			 
			 
			});

			$('input:radio[name=discount]').each(function(){    
			 if($(this).is(':checked')){
				discount.push(this.value);
			 } 
			});

			var pr = $('input:radio[name=price]:checked').val();		 
			price.push(pr);
			 
			$('input:checkbox[name=specification]').each(function(){    
			if($(this).is(':checked'))			 
				specification.push(this.value);
			});
			if(brand){
			ur +="&brand="+brand; 
			}
			if(category){
			ur +="&category="+category; 
			}
			if(price){
				ur +="&price="+price;
			}
			if(discount){
				ur +="&discount="+discount;
			}
			if(specification){
				ur +="&specification="+specification;
			}
			window.location=ur;
	});

<?php
}
?>

	$("#checkoutcnf").click(function(){
		var len = 0;  
		$('input:checkbox[name=t_s]').each(function(){    
			if($(this).is(':checked'))			 
				len = 1;  
			});
		
 		if(len) {
			return true;
		}
		else{
			alert('Please Accept Terms & Conditions!');
			return false;
		}
	
	});
	$(".removeComp").click(function(){
		var pid = $(this).attr('alt');
		var formData = {product_id:pid}; //Array 
		$.ajax({
	    url : "<?=SITE_PATH?>ms_file/add-remove",
	    type: "POST",
	    data : formData,
	    success: function(data, textStatus, jqXHR){
	       location.reload();
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
		});
	});
	$( "body" ).delegate( ".cmp", "click", function(){
		var pid = $(this).val();
 		var formData = {product_id:pid}; //Array 
		$.ajax({
	    url : "<?=SITE_PATH?>ms_file/add-remove",
	    type: "POST",
	    data : formData,
	    success: function(data, textStatus, jqXHR){
		   data = $.trim(data);
	       if(data=='no'){
	       				alert('You can not add more then 4 products in compare list.');
			} 
		    location.reload();
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
		});
	});
 $("#checkout").click(function(){  
  <?php   
	$pathlerod = SITE_PATH."checkout";
	if($_SESSION[userid]){
	
	?>
	window.location = '<?=$pathlerod?>';
	<?php
	}
	else{ 
	?> alert("Please login to checkout, Thanks");<?php
	}
  ?>
 });

$(".location").click(function(){
	var uri = $(this).attr('lang');
	if(uri){
		window.location = uri;
	}
});
setSlider($('#scroll-pane'));
<?php if(!$disp){?>
$("#scroll-pane").hide();
<?php }?> 

$(".compare_div-close").click(function(){ 
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/remove-compare-product",
	    type: "POST", 
	    success: function(data, textStatus, jqXHR){
		   data = $.trim(data); 
	       if(data=='deleted'){
	       		$(".compare_div").hide();		 
			}  
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
		});

});

$(window).scroll(function(){
    if  ($(window).scrollTop() >= 235){
         $('.compare_div').css({position:'fixed',top:30,right:'auto',margin:'5px 0 5px 8px',width:'737'});
    } else {
         $('.compare_div').css({position:'relative',padding:'5px',top:0,right:'0',margin:'5px 0 5px 9px',width:'737'});
        }
});
$('#fituredprod').cycle({ 
    fx:    'fade',  
    speed:  2500 
});
$("#fituredprod").css({padding:'8px',height:'280px'});

$(document).ready(function(e) {
	var tottab = '<?=$cntcmbo?>';
	for(i=1; i<=tottab;i++){
		$(".Combo"+i).hide();
	} 
	$(".Combo1").show();
	$(".tab").click(function(){
			$( ".tab" ).removeClass( "active" );
			$(this).addClass( "active" );
			var car_class = $(this).attr("lang");
			for(i=1; i<=tottab;i++){
				$(".Combo"+i).hide();
			}  
			$("."+car_class).show(); 
	});	
}); 
$(document).ready(function(){  
  $( ".tooltip" )
  .on( "mouseenter", function() {
	var cls = $(this).attr("lang");
   $("."+cls).fadeIn("fast");
  })
  .on( "mouseleave", function() {
	  var cls = $(this).attr("lang");
    $("."+cls).fadeOut("fast");
  });   
	//$('.main_div4tooltip').css({position:'absolute',padding:'0',top:0,right:'0',margin:'0',width:'0'});
  });

  $(".buycombo").click(function(){
	var pid = $(this).attr("lang"); 
	$("#ajaxload").show();  
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/ajax-combo-add/?pid="+pid+"&current_store_user_id=<?=$current_store_user_id?>",
	    type: "POST", 
	    success: function(data, textStatus, jqXHR){
		   data = $.trim(data);  
	     //  if(data=='done'){ 
	 
	       		$("#ajaxload").html('<font style="color:green;">Added Successfully!</font>');
				window.setTimeout('location.reload()', 3000); 
			//}  
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
		});
  });
  $("#chnageolor").change(function(){
	 var colorcode = $(this).val();
 	 $("#clr").css('background-color','#'+colorcode);
  });
  
  $(".rating1").click(function(){
	img_enable = '<?=SITE_PATH?>images/star_rate.png';
	img_disable = '<?=SITE_PATH?>images/star-rate-dis.png';
	var lang = $(this).attr("lang");  
	var alt = $(this).attr("alt");  
	$("#star").val(alt);
	for(i =1; i<=5;i++){ 
		if(i<=alt)	$("#"+lang+i).attr('src',img_enable); else $("#"+lang+i).attr('src',img_disable);
	} 
  });  
  
   
  $(".rating2").click(function(){
	img_enable = '<?=SITE_PATH?>images/star_rate.png';
	img_disable = '<?=SITE_PATH?>images/star-rate-dis.png';
	var lang = $(this).attr("lang");  
	var alt = $(this).attr("alt");  
	$("#star").val(alt);
	for(i =1; i<=5;i++){ 
		if(i<=alt)	$("#"+lang+i).attr('src',img_enable); else $("#"+lang+i).attr('src',img_disable);
	} 
  });  
  
  
   $(".checkout_kart").click(function(){  
  <?php   
	$pathlerod = SITE_PATH."checkout";
	if($_SESSION[userid]){
	
	?>
	           $(".modal").hide();
				window.location = '<?=$pathlerod?>';
	<?php
	}
	else{ 
	$pathlerod = SITE_PATH."user-login";
	
	?> $(".modal").show();
	window.location = '<?=$pathlerod?>';
	<?php
	}
  ?>
 });
  
$(".offerprodcheckbox").click(function(){
	var getpid = $(this).val();  
	$("#offerprodcheckbox"+getpid).show();
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/addtocart/?prod_id="+getpid+'current_store_user_id=<?=$current_store_user_id?>', 
	    success: function(data, textStatus, jqXHR){ 
	            $(function(){  $("#cart").load(" #cart")  });
	       		$(".cartsuccess").html(data);	
				$("#offerprodcheckbox"+getpid).hide(); 
				var url = '<?=$cms->curPageURL()?>';
				//location.reload();
				window.location = url;
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
});  

 
   
   $(document).ready(function() {
    $('.story-small img').hover(function() {   
    var maxWidth = 275; // Max width for the image
    var maxHeight = 248;  // Max height for the image
    var ratio = 0;  // Used for aspect ratio
    var width = $(this).width();    // Current image width
    var height = $(this).height();  // Current image height 
    // Check if the current width is larger than the max
    if(width > maxWidth){
        ratio = maxWidth / width;   // get ratio for scaling image
        $(this).css("width", maxWidth); // Set new width
        $(this).css("height", height * ratio);  // Scale height based on ratio
        height = height * ratio;    // Reset height to match scaled image
    }

    // Check if current height is larger than max
    if(height > maxHeight){
        ratio = maxHeight / height; // get ratio for scaling image
        $(this).css("height", maxHeight);   // Set new height
        $(this).css("width", width * ratio);    // Scale width based on ratio
        width = width * ratio;    // Reset width to match scaled image
    }
	 
});
});
<?php
if($catmenu){?>
	$(".cat-menu").show();
<?php 
} 
?> 
$("#ordersummary_orderbtn").click(function(){  
  <?php   
	$pathlerod = SITE_PATH."index"; 
	?>
	window.location = '<?=$pathlerod?>'; 
 }); 


$(window).scroll(function(){
    if  ($(window).scrollTop() >= 190){
         $('#container_box3').css({position:'fixed',width:'227',bottom:0});
		 if ($(window).scrollTop() + $(window).height() > $('.footer_id').offset().top) {
				 $('#container_box3').css({position:'absolute',width:'227',bottom:'10px'});
			} else {
				 $('#container_box3').css({position:'fixed',width:'227',bottom:'10px'});
		}
    } else {
         $('#container_box3').css({position:'relative',width:'227', bottom:0});
        }
}); 

$(".addtocart").click(function(){
	var getpid    = $(this).attr('alt');  
	var qty = $('#cartQty').val();
	if(!qty)  qty  = 0;
	var namecolor = $('input:radio[name=pcolor]:checked').val();
	if(!namecolor)  namecolor  = 0;
    var size      = $('input:radio[name=size]:checked').val(); 
	if(!size)  size  = 0;
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/addtocart/?prod_id="+getpid+"&dsize="+size+"&color="+namecolor+'&qty='+qty, 
	    success: function(data, textStatus, jqXHR){  
			$(function(){  
		    /* $(function(){ $(" #cd-cart").load(" #cd-cart");  });   */
			$(" #cart").load(" #cart");  });  
	       	$(".cartsuccess1").html(data); 
 	            // location.reload();
				//$("#addtocart"+getpid).hide(); 
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
}); 
  
     
	 
function isElementVisible(elementToBeChecked){
	var TopView = $(window).scrollTop();
	var BotView = TopView + $(window).height();
	var TopElement = $(elementToBeChecked).offset().top;
	var BotElement = TopElement + $(elementToBeChecked).height();
	return ((BotElement <= BotView) && (TopElement >= TopView));
}
/*$(window).scroll(function () {
	   isOnView = isElementVisible('.footer_nav');
	   if(isOnView){
		  alert('The selected element is visible!');
	   } 
});*/
<?php if($items[0]!='hot-deal'){?>
$(window).paged_scroll({  
	handleScroll:function (page,container,doneCallback) {  
	$('.infinite-scroll').append('<div class="pageloadcont" style="width:100%;heigh:50px;float: left;"><img src="<?=SITE_PATH_M?>images/bigLoader.gif" width="30" height="30" style="display:block; margin:0 auto;"></div>'); 
	var formData = {page:page,query:"<?=$storeQryCnt?>",price:"<?=$_GET[price]?>"};  
	 $.ajax({
	    url : "<?=SITE_PATH?>ms_file/ajax-pagination_data/", 
		type: "POST",
		data : formData,
	    success: function(data, textStatus, jqXHR){   
	       		$('.infinite-scroll').append(data);
				$(".pageloadcont").remove(); 
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	}); 
	doneCallback(); 
	return true;
   
},
// Uncomment to enable infinite scroll
pagesToScroll : 5,
triggerFromBottom:'300',
loader:'<div class="loader">Loading next page ...</div>',
pagesToScroll: '<?=$totcontentpage?>',
debug  : true,
targetElement : $('.infinite-scroll')

});
<?php }?>


</script>   
<script type="text/javascript">

$(document).ready(function() {		
	
	//Execute the slideShow, set 4 seconds for each images
	slideShow(5000);

});

function slideShow(speed) {


	//append a LI item to the UL list for displaying caption
	$('ul.slideshow').append('<li id="slideshow-caption" class="caption"><div class="slideshow-caption-container"><h3></h3><p></p></div></li>');

	//Set the opacity of all images to 0
	$('ul.slideshow li').css({opacity: 0.0});
	
	//Get the first image and display it (set it to full opacity)
	$('ul.slideshow li:first').css({opacity: 1.0}).addClass('show');
	
	//Get the caption of the first image from REL attribute and display it
	$('#slideshow-caption h3').html($('ul.slideshow li.show').find('img').attr('title'));
	$('#slideshow-caption p').html($('ul.slideshow li.show').find('img').attr('alt'));
		
	//Display the caption
	$('#slideshow-caption').css({opacity: 0.7, bottom:0});
	
	//Call the gallery function to run the slideshow	
	var timer = setInterval('gallery()',speed);
	
	//pause the slideshow on mouse over
	$('ul.slideshow').hover(
		function () {
			clearInterval(timer);	
		}, 	
		function () {
			timer = setInterval('gallery()',speed);			
		}
	);
	
}

function gallery() { 
	//if no IMGs have the show class, grab the first image
	var current = ($('ul.slideshow li.show')?  $('ul.slideshow li.show') : $('#ul.slideshow li:first')); 
	//trying to avoid speed issue
	if(current.queue('fx').length == 0) {	 
		//Get next image, if it reached the end of the slideshow, rotate it back to the first image
		var next = ((current.next().length) ? ((current.next().attr('id') == 'slideshow-caption')? $('ul.slideshow li:first') :current.next()) : $('ul.slideshow li:first')); 
		//Get next image caption
		var title = next.find('img').attr('title');	
		var desc = next.find('img').attr('alt');	 
		//Set the fade in effect for the next image, show class has higher z-index
		next.css({opacity: 0.0}).addClass('show').animate({opacity: 1.0}, 1000);
		
		//Hide the caption first, and then set and display the caption
		$('#slideshow-caption').slideToggle(600, function () { 
			$('#slideshow-caption h3').html(title); 
			$('#slideshow-caption p').html(desc); 
			$('#slideshow-caption').slideToggle(500); 
		});	 
		//Hide the current image
		current.animate({opacity: 1}, 1000).removeClass('show'); 
	} 
}
</script>

<script type="text/javascript">
 
function toggle_panel_visibility ($lateral_panel, $background_layer, $body) {
	if( $lateral_panel.hasClass('speed-in') ) {
		$lateral_panel.removeClass('speed-in');
		$background_layer.removeClass('is-visible');
		$body.removeClass('overflow-hidden');
	} else {
		$lateral_panel.addClass('speed-in');
		$background_layer.addClass('is-visible');
		$body.addClass('overflow-hidden');
	}
}

function move_navigation( $navigation, $MQ) {
	if ( $(window).width() >= $MQ ) {
		$navigation.detach();
		$navigation.appendTo('header');
	} else {
		$navigation.detach();
		$navigation.insertAfter('header');
	}
}
/*$(".addtocart_index").click(function(){
	var size = $(this).attr('lang'); 
	var newval = $("."+size).val();
	alert(newval);
});*/
function findSelection(field) {
	var test = document.getElementsByName(field);
	var sizes = test.length; 
	for (i=0; i < sizes; i++) {
			if (test[i].checked==true) {
			//alert(test[i].value + ' you got a value');     
			return test[i].value;
		}
	}
} 
 function autoRefresh_div(){
      $("#result").load("load.html");// a function which will load data from other file after x seconds
  } 
  setInterval('autoRefresh_div()', 5000); // refresh div after 5 secs 
$(".addtocart_index").click(function(){  
	var getpid = $(this).attr('alt'); 	 
	var size = $(".size"+getpid).val();  
	var namecolor = findSelection('color'+getpid); 
	var z=(size.replace(' ','%20'));  
	var res = getpid+','+z; 
	var urls = '<?=SITE_PATH?>ms_files/popup_page_data/?prod_id='+res; 
    $.colorbox({width:"auto",height:"auto",iframe:false, href:urls }); 
 setTimeout( function() {
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/addtocart/?prod_id="+getpid+"&dsize="+size+"&color="+namecolor,  
	    success: function(data, textStatus, jqXHR){  
			 $(function(){ $("#cart").load(" #cart")  }); 
			///$(function(){ $("#cd-cart-trigger2").load("#cd-cart-trigger2") });  
			 $(function(){ $("#cd-cart ").load("<?=SITE_PATH?>inc/right_cart/ #cd-cart") });   
	       	 //$("#cd-cart-trigger2 ").html(data);   
			 location.reload(); 
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	}); 
 },50);   
}); 
  
 $(".list_of_detail").change(function() {
     var size =$(this).val(); 
	 var getpid = $(this).attr('alt');  
	 var val = $(this).attr('title'); 
	$.ajax({ 
	    url : "<?=SITE_PATH?>ms_file/change_price_ajax/?proid="+getpid+"&dsize="+size,  
	    success: function(data, textStatus, jqXHR){   
	        $(".sizesuccesshide"+val).hide();
	       	$(".sizesuccess"+val).html(data);  
	         document.getElementById("aaaa").value=data; 
	        // alert(console.log(data));
		  	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
});


 $(".qty_commondiv1").change(function() {
     var size =$(this).val(); 
	 var getpid = $(this).attr('alt');  
	// var val = $(this).attr('title');
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/change_price_ajaxd/?proid="+getpid+"&dsize="+size, 
	    success: function(data, textStatus, jqXHR){  
	//alert('lknklnlk');
	       $(".sizesuccesshide").hide();
		  // $(".sizesuccess").show();
	       	$(".sizesuccess").html(data);  
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
});

 $(".list_of_detail").change(function() {
     var size =$(this).val(); 
	 var getpid = $(this).attr('alt');  
	 var val = $(this).attr('title');
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/change_price_cat_ajax/?proid="+getpid+"&dsize="+size, 
	    success: function(data, textStatus, jqXHR){  
	//alert('lknklnlk');
	       $(".sizesuccesshide_cat"+val).hide();
	       	$(".sizesuccess_cat"+val).html(data);  
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
});
$(".dropdowncat").change(function(){
	var cat = $(this).val();
	var loc  = '<?=SITE_PATH.$items[0]."/".$items[1]."/"?>'+cat;
	window.location = loc;
});
$(".dropdowncat").click(function(){});

$(document).ready(function() {
	$('a.inline_popup').colorbox({
      close:"CLOSE",
	  width:$('a.inline_popup').attr("w"),
	  height:$('a.inline_popup').attr("h"),
	  iframe:true,
      onComplete : function() { 
           
      }
	});
 $( "body" ).delegate( ".popupdetail", "click", function(){
	$('a.inline_popup').colorbox({
      close:"CLOSE",
	  width:$('a.inline_popup').attr("w"),
	  height:$('a.inline_popup').attr("h"),
	  iframe:true,
      onComplete : function() { 
           
      }
	});
	$(".viewimages").colorbox({rel:'viewimages'});
	$("#cboxContent").css('margin-top','0px');
	});


	$(".Delcartp").click(function(){
	var id = $(this).attr('alt'); 
	var current_store_user_id = '<?=$current_store_user_id?>';
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/cart-del-pro/?id="+id+"&current_store_user_id="+current_store_user_id, 
	    success: function(data, textStatus, jqXHR){  
	       	$(".cart-main_page").html(data);  
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
   });
   $( "body" ).delegate( ".Delcartp", "click", function(){
	var id = $(this).attr('alt'); 
	var current_store_user_id = '<?=$current_store_user_id?>';
	$.ajax({
	    url : "<?=SITE_PATH?>ms_file/cart-del-pro/?id="+id+"&current_store_user_id="+current_store_user_id, 
	    success: function(data, textStatus, jqXHR){  
	       	$(".cart-main_page").html(data);  
	    },
	    error: function (jqXHR, textStatus, errorThrown){
	 		alert(errorThrown);
	    }
	});
	});

});

</script> 

