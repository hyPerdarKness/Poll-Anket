<?php if(!defined("include")){ echo '<meta http-equiv="refresh" content="0;URL=../index.php">'; exit(); } $p = basename($_SERVER['REQUEST_URI']); ?>
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li<?php if($p=="home.php"){ echo ' class="active"'; } ?>><a href="home.php"><i class="icon-dashboard"></i><span>Anasayfa</span> </a> </li>
        <li<?php if($p=="anketler.php"||$p=="add.php"||$p=="edit.php?id=".@$id.""){ echo ' class="active"'; } ?>><a href="anketler.php"><i class="icon-bar-chart"></i><span>Anketler</span> </a> </li>
        <li<?php if($p=="siteler.php"||$p=="sitedit.php?id=".@$id.""||$p=="siteadd.php"){ echo ' class="active"'; } ?>><a href="siteler.php"><i class="icon-file"></i><span>Siteler</span> </a> </li>
        <li<?php if($p=="ayarlar.php"){ echo ' class="active"'; } ?>><a href="ayarlar.php"><i class="icon-cog"></i><span>Ayarlar</span> </a> </li>
        <li<?php if($p=="yonetim.php?id=".$_SESSION['pollanket'].""){ echo ' class="active"'; } ?>><a href="yonetim.php?id=<?php echo $_SESSION['pollanket']; ?>"><i class="icon-user"></i><span>Yönetim</span> </a> </li>
      </ul>
    </div>
  </div>
</div>