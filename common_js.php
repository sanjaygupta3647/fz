<script type="text/javascript" src="<?=SITE_PATH?>js/jquery-1.7.1.min.js"></script> 
<script type="text/javascript" src="<?=SITE_PATH?>js/jmpress.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(e) { 
		$(function() { 
				$( '#jms-slideshow' ).jmslideshow(); 
		});
	});
</script>

<script type="text/javascript" src="<?=SITE_PATH?>js/jquery.smartTab.js"></script> 
<script type="text/javascript" src="<?=SITE_PATH?>colorbox/jquery.colorbox.js"></script>  
<script type="text/javascript" src="<?=SITE_PATH?>js/jquery.als-1.4.min.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/custom.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?=SITE_PATH?>js/stepcarousel.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/ddimgtooltip.js"></script>
<script type="text/javascript" src="<?=SITE_PATH?>js/validate.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script type="text/javascript" src="<?=SITE_PATH?>js/modernizr.custom.js"></script>
<!-------Social icon js------> 
<?php /*?>Accordion js<?php */?>
	<script type="text/javascript" src="<?=SITE_PATH?>js/jquery.accordion.js"></script>
   
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


 
<script type="text/javascript">/*
$(window).load(function() {  
    $("#flexiselDemo3").flexisel({
        visibleItems: 7,
        animationSpeed: 2000,
        autoPlay: true,
        autoPlaySpeed: 6000,            
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: { 
            portrait: { 
                changePoint:480,
                visibleItems: 2
            }, 
            landscape: { 
                changePoint:640,
                visibleItems: 4
            },
            tablet: { 
                changePoint:768,
                visibleItems: 4
            }
        }
    }); 
});*/
</script> 
<script type="text/javascript">/*
$(function(){
	$('#slides').slides({
		preload: true,
		preloadImage: 'images/loading.gif',
		play: 8000,
		pause: 2500,
		hoverPause: true,
		animationStart: function(current){
			$('.caption').animate({
				bottom:-35
			},100);
			if (window.console && console.log) {
				// example return of current slide number
				console.log('animationStart on slide: ', current);
			};
		},
		animationComplete: function(current){
			$('.caption').animate({
				bottom:0
			},200);
			if (window.console && console.log) {
				// example return of current slide number
				console.log('animationComplete on slide: ', current);
			};
		},
		slidesLoaded: function() {
			$('.caption').animate({
				bottom:0
			},200);
		}
	});
});

stepcarousel.setup({
	galleryid: 'mygallery', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:true, moveby:11, pause:10},
	panelbehavior: {speed:5000, wraparound:true, wrapbehavior:'slide', persist:true},
	defaultbuttons: {enable: false, moveby: 1, leftnav: ['images/left-arrow-home.png', -5, 30], rightnav: ['images/right-arrow-home.png', -20, 30]},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'] //content setting ['inline'] or ['ajax', 'path_to_external_file']
});*/
 $(document).ready(function(){
	$(".store").show();
	$(".brand").hide();
	$(".brand-store").hide();
	$("#radio1").click(function(){
		$(".store").show();
		$(".brand").hide();
		$(".brand-store").hide();
		$("#tarifplan").html('');
	});
	$("#radio2").click(function(){
		$(".store").hide();
		$(".brand").show();
		$(".brand-store").hide();
		$("#tarifplan").html('');
	});
	$("#radio3").click(function(){
		$(".store").hide();
		$(".brand").hide();
		$(".brand-store").show();
		$("#tarifplan").html('');
	});
  
  });
  $(".plan_id").click(function(){
		var plan_id = $(this).val(); 
		$.ajax({ 
			url: '<?=SITE_PATH?>ms_file/tarif-plans/'+plan_id, 
			success: function (data) {
				$("#tarifplan").html(data); 			 
			},
			error: function (request, status, error) {
			alert(request.responseText);
			}
		}); 
		
	}); 
 
	
	
	 $("#store-brand-reg").click(function(){  	 
	var planID = $(':radio[name="planID"]:checked, :radio[name="planID"]:checked').length;
	var theme = $(':radio[name="theme"]:checked, :radio[name="theme"]:checked').length;
	var tarif = $(':radio[name="tarifid"]:checked, :radio[name="tarifid"]:checked').length;
	 
	if(!tarif){
		alert('Please choose a tarif plan.');
		$(this).focus;
		return false;
	}
	if(!planID){
		alert('Please choose a hosting plan.');
		$(this).focus;
		return false;
	}
	
  
  });
  $("#store_name").keyup(function(){
		var store_name = $(this).val();
		$.ajax({ 
		url: '<?=SITE_PATH?>ms_file/ajax-url/'+store_name, 
		success: function (data) {
			$("#store_url").val(data); 
		},
		error: function (request, status, error) {
		alert(request.responseText);
		}
		});  
	}); 
	$("#user_name").keyup(function(){
		var user_name = $(this).val();
		$.ajax({ 
		url: '<?=SITE_PATH?>ms_file/check-user/user_name/'+user_name, 
		success: function (data) {
			$("#txtHint1").html(data); 
		},
		error: function (request, status, error) {
		alert(request.responseText);
		}
		});  
	}); 
	$("#search-city").change(function(){
	    var city_id = $(this).val(); 
		$.ajax({ 
		url: '<?=SITE_PATH?>ms_file/ajax-market/'+city_id, 
		success: function (data) {  
			$("#city-market").html(data); 
		},
		error: function (request, status, error) {
		alert(request.responseText);
		}
		});  
	}); 
	$("#subscribe").click(function(){
	var email = $("#subemail").val();
 	if(email){
		$.ajax({ 
		url: '<?=SITE_PATH?>ms_file/subscribe/'+email, 
		success: function (data) {
			$("#subscribeMsg").html(data); 
		},
		error: function (request, status, error) {
		alert(request.responseText);
		}
		}); 
	}else{
	$("#subscribeMsg").html('Please enter your email id');
	}
	});

	$("#city_id2").change(function(){
	    var city_id = $(this).val();
		$.ajax({ 
		url: '<?=SITE_PATH?>ms_file/ajax-markets/'+city_id, 
		success: function (data) {
			$("#marketDiv2").html(data); 
		},
		error: function (request, status, error) {
		alert(request.responseText);
		}
		});  
	}); 
$(document).ready(function(){
	var searchfor = $("#searchfor").val();
 	if(searchfor=='product'){
	$("#citydiv").hide();
	$("#marketdiv").hide();
	}else{
		$("#citydiv").show();
		$("#marketdiv").show(); 
	}
});
$("#searchfor").change(function(){
var searchfor = $(this).val();
if(searchfor=='product'){
	$("#citydiv").hide();
	$("#marketdiv").hide();
}else{
	$("#citydiv").show();
	$("#marketdiv").show(); 
}

});
$(document).ready(function(e) {
   $("#user").hide();	
	$("#owner").hide(); 
});
$(".log").click(function(){
	var usr=$(this).val();
	if(usr=='user'){
	$("#user").show('1000');	
	$("#owner").hide();
	}
	if(usr=='owner'){
	$("#user").hide();	
	$("#owner").show('1000');
	}
});
$(".noclass").click(function(){
 	var page =  $(this).attr("lang");	 
	var red = "<?=SITE_PATH?>"+page;
	window.location = red;

});
/* $(document).ready(function(e) {
	var lp; 
    for(lp=2; lp<=5; lp++){
		$("."+lp).hide();
	}
	
	$(".noclass").click(function(){
		var getid = $(this).attr("id");
		$(".noclass").removeClass("active");
		$("#"+getid).addClass("active");
		var lp; 
		for(lp=1; lp<=5; lp++){
			if(getid==lp){
				$("."+lp).show('slow');
			}else{
			$("."+lp).hide('slow');
			}
			
		}
    });
});*/

 /* $("#profile_edit").click(function(){
	    var fname = $("#fname").val();
		var lname = $("#lname").val();
		var gender = $("#gender").val();
		var gender = $(':radio[name="gender"]:checked, :radio[name="gender"]:checked').val();
		//var gender=$('input[gender=gender]:radio:checked').val();
		var mob = $("#mob").val();
		var city = $("#city").val();
		var state = $("#state").val();
		var zipcode = $("#zipcode").val();
		var address = $("#address").val();
		var formData = {fname:fname,lname:lname,gender:gender,mob:mob,city:city,state:state,zipcode:zipcode,address:address};
		$.ajax({ 
		url: '<?=SITE_PATH?>ms_file/ajax-profile-edit',
		type: "POST",
		data : formData,
		success: function (data) {
			$("#succDiv").html(data); 
		},
		error: function (request, status, error) {
		alert(request.responseText);
		}
		});  
	});
	*/
	/*
	 */
        $("#passsubmit").click(function(){
        $(".error").hide();
        var hasError = false;
         var pass = $("#password1").val();
		  var newpass = $("#password").val();
         var checkVal = $("#password-check").val();
		
		//var formData = {fname:fname,lname:lname,gender:gender,mob:mob,city:city,state:state,zipcode:zipcode,address:address};
        if (newpass == '') {
            $("#password").after('<span class="error">Please enter a password.</span>');
            hasError = true;
        } else if (checkVal == '') {
            $("#password-check").after('<span class="error">Please re-enter your password.</span>');
            hasError = true;
        } else if (newpass != checkVal ) {
            $("#password-check").after('<span class="error">Passwords do not match.</span>');
            hasError = true;
        }

        if(hasError == true) {return false;}

        if(hasError == false) {
                $.ajax({
                type: "POST",
                url: '<?=SITE_PATH?>ms_file/ajax_changepassword',
                data: {newpass:newpass,pass:pass},
                success: function (data){
			$("#succeDiv").html(data); 
		},
                });
        };
    }); 
 
$(".item").click(function(){
	$(this).find( ".tooltip-div" ).toggle('slow');
});	

$(".id_control").click(function(){
	 var orderid = $(this).attr("title");
	 var ur='';
if(orderid){
	 ur ="orderid="+orderid; 
	}
	var red = "<?=SITE_PATH."my-trans1/?"?>"+ur;
   window.location = red; 
	 
});	
// Add onclick handler to checkbox w/id checkme
     $("#vaucher").click(function(){
		if($("#vaucher").is(":checked")){  
		   $(".renew_submit-div3").show(); 
		}else{  
		$(".renew_submit-div3").hide();  
		}
 }); 
$("#vaucher_copon").keyup(function(){
		var vaucher_copon = $(this).val();
		$.ajax({ 
		url: '<?=SITE_PATH?>ms_file/check-coupon/vaucher_copon/'+vaucher_copon,
		success: function (data) {
			data = $.trim(data); 
			if(data=='Yes'){			  
				$(".green_p").show();
				$(".red_p").hide(); 
				 $(".red_p1").hide(); 
				$.ajax({ 
				url: '<?=SITE_PATH?>ms_file/check-coupon-detail/vaucher_copon/'+vaucher_copon, 
				success: function (data) {
					$("#dis-calc").html(data);   
					$("#defaltshow").hide();
					
				},
				error: function (request, status, error) {
				alert(request.responseText);
				}
				});
				
				
			}else if(data=='1'){
			    $(".red_p1").show();
				$(".red_p").hide();
				$("#defaltshow").show();
				$(".green_p").hide();
				$("#dis-calc").html('');
			}else{ 
				$(".red_p").show();
				$(".red_p1").hide();
				$("#defaltshow").show();
				$(".green_p").hide();
				$("#dis-calc").html(''); 
				
			}
		},
		error: function (request, status, error) {
		alert(request.responseText);
		}
		});  
});	
 
$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});

$(document).ready(function() 
			{
				$("#lista1").als({
					visible_items: 5,
					scrolling_items: 4,
					orientation: "horizontal",
					circular: "yes",
					autoscroll: "yes",
					interval: 4000,
					speed: 1500,
					easing: "linear",
					direction: "left",
					start_from: 0,
				});


//logo hover
				$("#logo_img").hover(function()
				{
					$(this).attr("src","images/als_logo_hover212x110.png");
				},function()
				{
					$(this).attr("src","images/als_logo212x110.png");
				});
				
				//logo click
				$("#logo_img").click(function()
				{
					location.href = "http://als.musings.it/index.php";
				});
				
				$("a[href^='http://']").attr("target","_self");
				$("a[href^='http://als']").attr("target","_self");
			});
</script>
<script type="text/javascript">
    $(document).ready(function(){
    	// Smart Tab
  		$('#tabs').smartTab({selected: '<?=$selectTab?>',saveState:false, autoProgress: false,stopOnFocus:true,transitionEffect:'vSlide'});
	});
</script>

