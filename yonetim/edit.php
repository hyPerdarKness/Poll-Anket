<?php session_start(); if(isset($_SESSION['pollanket'])){ define("include",true); include("../vendor/config.php"); $id = intval($_GET['id']); ?>
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
            <div class="widget-header"><i class="icon-edit"></i>
              <h3>Anket Düzenle</h3>
            </div>
            <div class="widget-content">
<?php if(isset($_GET['sil'])){ $check = $db->query("select count(*) from cevaplar where sID='".$_GET['sID']."'")->fetchColumn(); if($check=="2"){ echo '<div class="alert alert-danger">Son kalan 2 seçeneği veritabanından silemezsiniz! Sadece güncelleme işlemine izin verilmektedir.</div> <meta http-equiv="refresh" content="4;URL=edit.php?id='.$id.'">';  }else{
$db->query("delete from cevaplar where id='".intval($_GET['sil'])."'"); echo '<div class="alert alert-warning">Seçenek silindi...</div> <meta http-equiv="refresh" content="2;URL=edit.php?id='.$id.'">'; } }

if(isset($_POST['kaydet'])){ $baslik = htmlclean($_POST['baslik']); $anketid = $_POST['anketid'];

if($baslik==""){ echo '<div class="alert alert-danger">Anket sorusunu boş bırakırsanız, başsız olur. Olmaz!! yapmayın..</div>'; }else{

$kayit = $db->prepare("update sorular set baslik=? where id=?"); $kayit->execute(array($baslik, $id));
for($a=0;$a<count($_POST['secenek']);$a++){ $kayit1 = $db->prepare("update cevaplar set baslik=? where id=?"); $kayit1->execute(array($_POST['secenek'][$a], $_POST['cID'][$a])); }
if(isset($_POST['cevap'])){ for($b=0;$b<count($_POST['cevap']);$b++){ $kayit2 = $db->prepare("insert cevaplar set sID=?,baslik=?"); $kayit2->execute(array($anketid, $_POST['cevap'][$b])); } }

echo '<div class="alert alert-success">Değişiklikler kaydedildi...</div>'; echo '<meta http-equiv="refresh" content="2">'; } } ?>
<form method="post">
<?php foreach($db->query("select * from sorular where id='".$id."'") as $aaa){ ?>
		<div class="control-group">											
			<label class="control-label">Anket ID</label>
			<div class="controls">
			<input type="number" min="1" class="span6" name="anketid" value="<?php echo $aaa['sID']; ?>" readonly>
			<span class="help-block">Bu alanda yer alan bilgi diğer tablo ilişkilerinde kullanıldığı için değiştirilemez!</span>
			</div>				
		</div>
		
		<div class="control-group">											
			<label class="control-label">Anket Sorusu</label>
			<div class="controls">
			<input type="text" class="span6" name="baslik" value="<?php echo $aaa['baslik']; ?>">
			</div>				
		</div>
		
		<div class="control-group">											
			<label class="control-label">Seçenekler</label>
			<div class="controls cevap">
<?php foreach($db->query("select * from cevaplar where sID='".$aaa['sID']."'") as $bbb){ ?>	
			<input type="hidden" name="cID[]" value="<?php echo $bbb['id']; ?>">
			<input type="text" class="span6" name="secenek[]" value="<?php echo $bbb['baslik']; ?>">&nbsp;&nbsp;<a href="edit.php?id=<?php echo $id; ?>&sil=<?php echo $bbb['id']; ?>&sID=<?php echo $bbb['sID']; ?>" style="color:red;"><i class="icon-remove-circle"></i> Veritabanından Sil</a><br>
<?php } ?>
			</div>				
		</div>	
<?php } ?>
	<a href="#" class="btn btn-info addinput"><i class="icon-plus"></i> Seçenek/Cevap Alanı Ekle</a>		

		<div class="form-actions">
			<button type="submit" name="kaydet" class="btn btn-warning"><i class="icon-save"></i> Kaydet</button> 
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
<script>
$(document).ready(function() {
    var max_fields = 999;
    var wrapper = $(".cevap");
    var add_button = $(".addinput");

    var x = 1;
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append('<div><input type="text" class="span6" placeholder="Seçenek.." name="cevap[]">&nbsp;&nbsp;<a href="#" class="delete" style="color:red;"><i class="icon-remove-circle"></i> Sil</a></div>');
        } else {
            alert('Helal olsun 999 adet eklemeyi nasıl başardın!?!!??!')
        }
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })
});
</script>

</body>
</html>
<?php }else{ echo '<meta http-equiv="refresh" content="0;URL=../index.php">'; } ?>