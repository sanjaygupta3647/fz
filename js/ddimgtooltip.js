var ddimgtooltip={tiparray:function(){var tooltips=[]
tooltips[0]=["images/garments.jpg","Here is a theme option<br /> on a white background",{background:"#FFFFFF",color:"black",border:"5px ridge darkblue"}]
tooltips[1]=["images/restaurant.gif","Here is a duck on a light blue background.",{background:"#DDECFF",width:"182px"}]
tooltips[2]=[""]
tooltips[3]=["images/sports.jpg","Bridge to somewhere.",{background:"white",font:"bold 12px Arial"}]
return tooltips}(),tooltipoffsets:[20,-30],tipprefix:'imgtip',createtip:function($,tipid,tipinfo){if($('#'+tipid).length==0){return $('<div id="'+tipid+'" class="ddimgtooltip" />').html('<div style="text-align:center"><img src="'+tipinfo[0]+'" /></div>'+((tipinfo[1])?'<div style="text-align:left; margin-top:5px">'+tipinfo[1]+'</div>':'')).css(tipinfo[2]||{}).appendTo(document.body)}
return null},positiontooltip:function($,$tooltip,e){var x=e.pageX+this.tooltipoffsets[0],y=e.pageY+this.tooltipoffsets[1]
var tipw=$tooltip.outerWidth(),tiph=$tooltip.outerHeight(),x=(x+tipw>$(document).scrollLeft()+$(window).width())?x-tipw-(ddimgtooltip.tooltipoffsets[0]*2):x
y=(y+tiph>$(document).scrollTop()+$(window).height())?$(document).scrollTop()+$(window).height()-tiph-10:y
$tooltip.css({left:x,top:y})},showbox:function($,$tooltip,e){$tooltip.show()
this.positiontooltip($,$tooltip,e)},hidebox:function($,$tooltip){$tooltip.hide()},init:function(targetselector){jQuery(document).ready(function($){var tiparray=ddimgtooltip.tiparray
var $targets=$(targetselector)
if($targets.length==0)
return
var tipids=[]
$targets.each(function(){var $target=$(this)
$target.attr('rel').match(/\[(\d+)\]/)
var tipsuffix=parseInt(RegExp.$1)
var tipid=this._tipid=ddimgtooltip.tipprefix+tipsuffix
var $tooltip=ddimgtooltip.createtip($,tipid,tiparray[tipsuffix])
$target.mouseenter(function(e){var $tooltip=$("#"+this._tipid)
ddimgtooltip.showbox($,$tooltip,e)})
$target.mouseleave(function(e){var $tooltip=$("#"+this._tipid)
ddimgtooltip.hidebox($,$tooltip)})
$target.mousemove(function(e){var $tooltip=$("#"+this._tipid)
ddimgtooltip.positiontooltip($,$tooltip,e)})
if($tooltip){$tooltip.mouseenter(function(){ddimgtooltip.hidebox($,$(this))})}})})}}
ddimgtooltip.init("*[rel^=imgtip]")