<link href="colorbox.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="jquery-latest.js"></script>
<script type="text/javascript" src="jquery.colorbox.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	$('a.inline_popup').colorbox({
      close:"CLOSE",
	  width:$('a.inline_popup').attr("w"),
	  height:$('a.inline_popup').attr("h"),
	  iframe:true,
      onComplete : function() { 
           
      }
	});

});
	
</script>
<body>
 <a href="unsubscribe.php" class="inline_popup" w="600" h="400">Click</a>
 </body>