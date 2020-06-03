<?php session_start(); if(isset($_SESSION['pollanket'])){ define("include",true); include("../vendor/config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="robots" content="noindex,nofollow,nosnippet,noodp,noarchive,noimageindex">
	<meta name="author" content="hyPerdarKness - github.com/hyPerdarKness">
	
    <title><?php echo $print['siteadi']; ?> Yönetim Paneli</title>
	
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/pages/dashboard.css" rel="stylesheet">
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
</head>
<body>

<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="home.php"><?php echo $print['siteadi']; ?> Yönetim Paneli</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
		<li><a href="../index.php" target="_blank">Siteyi Görüntüle <i class="icon-chevron-right"></i></a></li>		
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="yonetim.php?id=<?php echo $_SESSION['pollanket']; ?>">Şifre Değiştir</a></li>
              <li><a href="logout.php">Çıkış Yap</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php include("plug/menu.php"); ?>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
          <div class="widget">
            <div class="widget-header"><i class="icon-cog"></i>
              <h3>Ayarlar</h3>
            </div>
            <div class="widget-content">
<?php if(isset($_POST['kaydet'])){ 

if($_POST['siteadi']==""){ echo '<div class="alert alert-danger">Site Adı alanını boş bırakmayın! Gerisi not matters..</div>'; }else{

$kayit = $db->prepare("update settings set siteadi=?,anket_id=?,email=?,analytics=?"); 
$kayit->execute(array($_POST['siteadi'], $_POST['anket_id'], $_POST['email'], $_POST['analytics']));
echo '<div class="alert alert-success">Düzenleme kaydedildi...</div>'; echo '<meta http-equiv="refresh" content="2">'; } } ?>
	<form method="post">
		<div class="control-group">											
			<label class="control-label">Site Adı</label>
			<div class="controls">
			<input type="text" class="span5" name="siteadi" value="<?php echo $print['siteadi']; ?>">
			</div>				
		</div>
		
		<div class="control-group">											
			<label class="control-label">Anasayfa Anketi</label>
			<div class="controls">
			<select class="span5" name="anket_id"><option><?php echo $print['anket_id']; ?></option>
<?php foreach($db->query("select * from sorular order by id desc") as $jjj){ echo '<option value="'.$jjj['sID'].'">'.$jjj['baslik'].'</option>'; } ?>
			</select>
			</div>				
		</div>		

		<div class="control-group">											
			<label class="control-label">Sayaç Kodu</label>
			<div class="controls">
			<textarea class="span5" name="analytics"><?php echo $print['analytics']; ?></textarea>
			<p class="help-block">analytics, metrica vb.</p>			
			</div>				
		</div>	
	
		<div class="control-group">											
			<label class="control-label">E-Mail</label>
			<div class="controls">
			<input type="text" class="span5" name="email" value="<?php echo $print['email']; ?>">
			<p class="help-block">İletişime geçmek isteyenler için...</p>			
			</div>				
		</div>	

		<div class="form-actions">
			<button type="submit" name="kaydet" class="btn btn-primary"><i class="icon-save"></i> Kaydet</button> 
			<a class="btn btn-danger" href="home.php"><i class="icon-remove-circle"></i> İptal</a>
		</div> 		
	</form>

            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="footer" align="center">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> Tasarım: <a href="http://www.egrappler.com" target="_blank">Bootstrap Responsive Admin Template</a> <# --- #> PHP Kodlama: <a href="https://github.com/hyPerdarKness" target="_blank">hyPerdarKness</a></div>
      </div>
    </div>
  </div>
</div>

	<script src="js/jquery-1.7.2.min.js"></script> 
	<script src="js/bootstrap.js"></script>
	<script src="js/base.js"></script> 
	
</body>
</html>
<?php }else{ echo '<meta http-equiv="refresh" content="0;URL=../index.php">'; } ?>