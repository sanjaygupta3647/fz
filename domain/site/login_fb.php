<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login with Facebook</title>
</head>
<body>
<img border="0" src="login_facebook.png" onClick="fblogin();" width="130" height="28" style="cursor:pointer" />


<div id="fb-root" style="float:left; width:1px;"></div>
 
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=539322812832955";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
window.fbAsyncInit = function() {
	FB.init({
	    appId: '539322812832955',
        cookie: true,
       	xfbml: true,
        oauth: true
   });      
};
(function() {
	var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
}());

function fblogin(){
	FB.login(function(response){
	 if (response.authResponse) {
		  window.location='validatefb.php';
	 }
	},{scope: 'publish_stream,email,user_birthday'});
}
</script>
<!--<script>
window.fbAsyncInit = function() {
	FB.init({
	    appId: '539322812832955',
        cookie: true,
       	xfbml: true,
        oauth: true
   });      
};
(function() {
	var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
}());

function fblogin(){
	FB.login(function(response){
	 if (response.authResponse) {
		  window.location='validatefb.php';
	 }
	},{scope: 'publish_stream'});
}
</script> -->
</body>
</html>