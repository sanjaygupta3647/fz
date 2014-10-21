 <style> 
					label.checkbox-1-<?=$k?>{
						display: inline;
					}
					.regular-checkbox<?=$k?>{
						display: none;
					}
					.regular-checkbox<?=$k?>:checked + label.checkbox-1-<?=$k?>:after {
						content: '\2714';
						font-size: 14px;
						color: #fff;
						text-align: center;
						display: block;
						vertical-align: middle;
						line-height: 20px;
						/*background-color:#<?=$clrcode?>;*/
					}
				  .regular-checkbox<?=$k?>+ label.checkbox-1-<?=$k?> {
					    background-color: #<?=$clrcode?>;  
						border: 1px solid #cacece;
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
						padding: 0px;
						border-radius: 3px;
						margin: 0px;
						width: 20px;
						height: 20px;
						display: block;
					}
					.regular-checkbox<?=$k?> + label.checkbox-1-<?=$k?>:active, .regular-checkbox:checked + label.checkbox-1-<?=$k?>:active { 
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1); 
						background: #<?=$clrcode?>;   
					}
					.regular-checkbox<?=$k?>:checked + label.checkbox-1-<?=$k?> {
						background-color: #<?=$clrcode?>;
						border: 1px solid #adb8c0;
						box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
						color: #FFFFFF;
					} 
				</style>