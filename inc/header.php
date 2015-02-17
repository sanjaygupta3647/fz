<div class="top-header">
  <div class="logo-icon"><a href="<?=SITE_PATH?>"><img src="<?=SITE_PATH?>images/logo-icon.png" border="0" width="120" height="34" alt="Fizzkart - Home" /></a></div>
  <div class="toprightbox"> <span style="color:#fff; float:left; font-family:Arial; font-size:12px; margin:0 10px 0 0;">
    <?php if($_SESSION[fname]){ ?>
    Welcome, &nbsp;
    <?php } ?>
    <a href="<?=SITE_PATH?>profile" style="color:#fff; text-decoration: none;
">
    <?=ucwords($_SESSION[fname])?>
    </a>
    <?php if($_SESSION[fname]){ ?>
    !
    <?php } ?>
    </span>
    <div class="commonbox">
      <div class="imgbox"><img src="<?=SITE_PATH?>images/customer-login-icon.jpg" width="18" height="18" alt="Customer Login" /></div>
      <div class="link"> <a href="<?=SITE_PATH?>tariff">Tariff Plans</a> </div>
    </div>
    <div class="commonbox">
      <div class="imgbox"><img src="<?=SITE_PATH?>images/customer-login-icon.jpg" width="18" height="18" alt="Customer Login" /></div>
      <div class="link">
        <?php if($_SESSION[userid]==''){ ?>
        <a href="<?=SITE_PATH?>user-login">Member Login</a>
        <? }else{ ?>
        <a href="<?=SITE_PATH?>logout">Logout</a>
        <? }?>
      </div>
    </div>
    <div class="commonbox">
      <?php if($_SESSION[userid]==''){ ?>
      <div class="imgbox"><img src="<?=SITE_PATH?>images/customer-login-icon.jpg" width="18" height="18" alt="Customer Login" /></div>
      <div class="link"> <a href="<?=SITE_PATH?>Step-1">Member Sign up</a> </div>
      <?php } ?>
    </div>
  </div>
</div>
