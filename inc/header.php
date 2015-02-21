<div class="row">
  <div class="logo-icon col-md-6 col-sm-4"><a href="<?=SITE_PATH?>"><img src="<?=SITE_PATH?>images/logo-icon.png" border="0" width="120" height="34" alt="Fizzkart - Home" /></a></div>
  <div id="righthead" class="toprightbox col-md-6 col-sm-8" style="padding-top: 8px;"> <span style="color:#fff; float:left; font-family:Arial; font-size:12px; margin:0 10px 0 0;">
    <?php if($_SESSION[fname]){ ?>
    Welcome, &nbsp;
    <?php } ?>
    <a href="<?=SITE_PATH?>profile" style="color:#fff; text-decoration: none;">
    <?=ucwords($_SESSION[fname])?>
    </a>
    <?php if($_SESSION[fname]){ ?>
    !
    <?php } ?>
    </span>
    <div class="commonbox pull-right">
      <?php if($_SESSION[userid]==''){ ?>
      <img src="<?=SITE_PATH?>images/customer-login-icon.jpg" width="18" height="18" alt="Customer Login" />
      <a href="<?=SITE_PATH?>Step-1">Member Sign up</a>
      <?php } ?>
    </div>
	<div class="commonbox pull-right">
      <img src="<?=SITE_PATH?>images/customer-login-icon.jpg" width="18" height="18" alt="Customer Login" />
      
        <?php if($_SESSION[userid]==''){ ?>
        <a href="<?=SITE_PATH?>user-login">Member Login</a>
        <? }else{ ?>
        <a href="<?=SITE_PATH?>logout">Logout</a>
        <?php }?>
      
    </div>
	<div class="commonbox pull-right">
      <img src="<?=SITE_PATH?>images/customer-login-icon.jpg" width="18" height="18" alt="Customer Login" />
      <a href="<?=SITE_PATH?>tariff">Tariff Plans</a>
    </div>
    
    
  </div>
</div>
