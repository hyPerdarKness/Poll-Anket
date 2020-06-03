<?php define("include",true); include("vendor/config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex,nofollow,nosnippet,noodp,noarchive,noimageindex">
  <meta name="author" content="hyPerdarKness - github.com/hyPerdarKness">	
	
  <title><?php echo $print['siteadi']; ?></title>

  <link rel="shortcut icon" href="vendor/favicon.png">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome/all.min.css" rel="stylesheet">
<?php echo $print['analytics']; ?>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><i class="fas fa-poll"></i> <?php echo $print['siteadi']; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link"><i class="far fa-calendar-alt"></i> <?php echo date('d.m.Y'); ?>&nbsp;&nbsp;&nbsp;<i class="far fa-clock"></i> <?php echo date('H:i'); ?></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
<?php $sorgu = $db->prepare("select * from sorular where sID=?"); $sorgu->execute(array($print['anket_id'])); if($sorgu->rowCount()=="0"){  
echo '<div class="alert alert-warning mt-5"><i class="fas fa-exclamation-triangle"></i> Seçilmiş bir anket olmadığı için bu uyarıyı görüyorsunuz! Bu sayfada anket görünmesi için yönetici panelinde yer alan ayarlar sayfasından anket seçmeniz gerekir...</div>'; }else{ $aaa = $sorgu->fetch(PDO::FETCH_ASSOC);
$say = $db->query("select count(*) from ip_list where ip='".$ip."' AND sID='".$aaa['sID']."'")->fetchColumn(); if($say>="1"){ ?>
        <h3 class="mt-5"><i class="fas fa-poll-h"></i> <?php echo $aaa['baslik']; ?> <u>Sonuçları</u></h3>
		<div class="alert alert-info"><i class="fas fa-info-circle"></i> Bu ankette daha önce oy kullanmışsınız. IP adresinizi değiştirmediğiniz sürece ankete tekrar katılamazsınız!</div>	
		<ul class="list-group">
<?php foreach($db->query("select * from cevaplar where sID='".$aaa['sID']."'") as $ccc){ $ddd = $db->query("select sum(oy_sayisi) from cevaplar where sID='".$aaa['sID']."'")->fetchColumn(); ?>		
		  <li class="list-group-item">
			<i class="fas fa-asterisk"></i> <?php echo $ccc['baslik']; ?> <small>(<?php echo number_format($ccc['oy_sayisi']); ?> oy)</small>
			<div class="progress">
			  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">%<?php echo round((($ccc['oy_sayisi']/$ddd)*100),2); ?></div>
			</div>	  
		  </li>	 
<?php } ?>		  
		</ul>
<?php }else{ ?>
        <h3 class="mt-5"><i class="far fa-question-circle"></i> <?php echo $aaa['baslik']; ?></h3>
<?php if(isset($_POST['send'])){

if(!isset($_POST['cevap_id'])){ echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Ankete katılmak için seçim yapmanız gerekir!</div>'; }else{ $id = intval($_POST['cevap_id']);

if($id==""){ echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Bir hata oluştu! Lütfen sayfayı yenileyip tekrar deneyin.</div>'; }else{
	
$db->query("update cevaplar set oy_sayisi=oy_sayisi+1 where id='".$id."'"); $db->query("insert into ip_list set ip='".$ip."',sID='".$aaa['sID']."'");

echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Seçiminiz kaydedildi! Ankete katıldığınız için teşekkür ederiz. Sayfa yenileniyor...</div>'; 
echo '<meta http-equiv="refresh" content="3;URL=index.php">'; } } } ?>
		<div class="list-group">
		<form method="post">
<?php foreach($db->query("select * from cevaplar where sID='".$aaa['sID']."'") as $bbb){ ?>
		  <span class="list-group-item list-group-item-action"><input type="radio" name="cevap_id" value="<?php echo $bbb['id']; ?>"> <?php echo $bbb['baslik']; ?></span>
<?php } ?><br>
			<button type="submit" name="send" class="btn btn-primary"><i class="far fa-hand-point-right"></i> Ankete Katıl</button>
		</form>
		</div>
<?php } }  ?>
      </div>
    </div>
  </div>

    <footer class="footer">
      <div class="container">
        <span class="text-muted small">&copy; <?php echo date('Y'); ?>, <?php echo $print['siteadi']; ?>. PHP Kodlama: <a href="https://github.com/hyPerdarKness" target="_blank" rel="nofollow">hyPerdarKness</a></span>
      </div>
    </footer>

  <script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/fontawesome/all.min.js"></script>
  <script>$('.list-group-item').on('click', e => { $('input', e.target).prop('checked', true); });</script>

</body>
</html>