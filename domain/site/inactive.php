<style type="text/css">
body {
	margin: 0;
	padding: 0;
	background-color: #fff;
	font-family: 'Open Sans', sans-serif;
}
#colorbox {
	display: block !important;
	position: absolute !important;
	overflow: hidden !important;
	width: 900px !important;
	height: 558px !important;
	left: 0px;
	padding-right: 0px !important;
	padding-bottom: 0px !important;
}
#cboxClose {
	position: absolute;
	top: -4px;
	right: 5px;
	display: block;
	font-size: 20px;
	color: #000;
	font-weight: bold;
	font-family: 'Open Sans', sans-serif;
}
#cboxWrapper {
	position: absolute;
	top: 0px;
	left: 0;
	z-index: 9999;
	overflow: hidden;
}
#cboxContent {
	background: #fff;
	overflow: hidden;
	border-radius: 10px;
	box-shadow: 0 0 80px 15px rgba(255, 255, 255, 5)
}
#cboxLoadedContent {
	padding: 10px;
	margin: 0px;
}
.main_quick_view {
	width: 100%;
	height: auto;
	float: left;
}
.wrap_quick_view {
	width: 838px;
	height: auto;
	margin: 0 auto;
}
.area_quick_view {
	width: 838px;
	height: auto;
	float: left;
}
.area_quick_view_left {
	width: 320px;
	height: auto;
	float: left;
}
.area_quick_view_right {
	width: 518px;
	height: auto;
	float: left;
	font-family: 'Open Sans', sans-serif;
}
.area_quick_view_right h2 {
	font-size: 20px;
	font-style: normal;
	font-weight: normal;
	text-decoration: none;
	color: #000;
}
.area_quick_view_right small {
	color: #333;
	font-size: 12px;
}
.pad_top {
	margin: 10px 0 0 0;
}
.area_quick_view_right1 {
	width: 518px;
	height: auto;
	float: left;
}
.area_quick_view_right1_left {
	width: 259px;
	height: auto;
	float: left;
}
.area_quick_view_right1_right {
	width: 259px;
	height: auto;
	float: left;
}
span.size_selection-color{
	float:left;
	font-size:14px;
}
.color_boxes_maindiv{
	width:auto;
	height:auto;
	float:left;
	margin:0px;
}
.qty_boxes_maindiv{
	width:auto;
	height:auto;
	float:left;
}




</style>
<style> 
					label.checkbox-1-3{
						display: inline;
					}
					.regular-checkbox3{
						display: none;
					}
					.regular-checkbox3:checked + label.checkbox-1-3:after {
						content: '\2714';
						font-size: 14px;
						color: #fff;
						text-align: center;
						display: block;
						vertical-align: middle;
						line-height: 20px;
						/*background-color:#E81321;*/
					}
				  .regular-checkbox3+ label.checkbox-1-3 {
					    background-color: #E81321;  
						border: 1px solid #cacece;
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
						padding: 0px;
						border-radius: 3px;
						margin: 0px;
						width: 20px;
						height: 20px;
						display: block;
					}
					.regular-checkbox3 + label.checkbox-1-3:active, .regular-checkbox:checked + label.checkbox-1-3:active { 
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1); 
						background: #E81321;   
					}
					.regular-checkbox3:checked + label.checkbox-1-3 {
						background-color: #E81321;
						border: 1px solid #adb8c0;
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
						color: #FFFFFF;
					} 
</style>
<style> 
					label.checkbox-1-1{
						display: inline;
					}
					.regular-checkbox1{
						display: none;
					}
					.regular-checkbox1:checked + label.checkbox-1-1:after {
						content: '\2714';
						font-size: 14px;
						color: #fff;
						text-align: center;
						display: block;
						vertical-align: middle;
						line-height: 20px;
						/*background-color:#3B1DEB;*/
					}
				  .regular-checkbox1+ label.checkbox-1-1 {
					    background-color: #3B1DEB;  
						border: 1px solid #cacece;
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
						padding: 0px;
						border-radius: 3px;
						margin: 0px;
						width: 20px;
						height: 20px;
						display: block;
					}
					.regular-checkbox1 + label.checkbox-1-1:active, .regular-checkbox:checked + label.checkbox-1-1:active { 
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1); 
						background: #3B1DEB;   
					}
					.regular-checkbox1:checked + label.checkbox-1-1 {
						background-color: #3B1DEB;
						border: 1px solid #adb8c0;
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
						color: #FFFFFF;
					} 
				</style>
<style> 
					label.checkbox-1-2{
						display: inline;
					}
					.regular-checkbox2{
						display: none;
					}
					.regular-checkbox2:checked + label.checkbox-1-2:after {
						content: '\2714';
						font-size: 14px;
						color: #fff;
						text-align: center;
						display: block;
						vertical-align: middle;
						line-height: 20px;
						/*background-color:#ED5994;*/
					}
				  .regular-checkbox2+ label.checkbox-1-2 {
					    background-color: #ED5994;  
						border: 1px solid #cacece;
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
						padding: 0px;
						border-radius: 3px;
						margin: 0px;
						width: 20px;
						height: 20px;
						display: block;
					}
					.regular-checkbox2 + label.checkbox-1-2:active, .regular-checkbox:checked + label.checkbox-1-2:active { 
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1); 
						background: #ED5994;   
					}
					.regular-checkbox2:checked + label.checkbox-1-2 {
						background-color: #ED5994;
						border: 1px solid #adb8c0;
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
						color: #FFFFFF;
					} 
				</style>
<p style="color: red;float: left;font-weight: bolder;font-size: 14px;">
The subscription of this store has expired, Please renew your subscription if you are the owner of the store / brand.</p>