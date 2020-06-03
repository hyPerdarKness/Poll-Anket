<?php session_start(); define("include",true); include("vendor/config.php"); if(!isset($_SESSION['referer']) AND empty($_SERVER['HTTP_REFERER'])){ echo 'Bu sayfayı iframe üzerinden, sadece izin verilen siteler kullanabilir. Direk erişim ile anketleri göremezsin! Anketi kullanmak istiyorsan benimle iletişime geçebilirsin --> '.$print['email'].''; }else{ 
if(!isset($_GET['id'])){ echo 'Gösterilecek anketin numarası eksik! ID numarası olmadan ankete erişemezsin!'; }else{ $id = intval($_GET['id']); if(isset($_SESSION['referer'])){ $site = parse_url($_SESSION['referer']); }else{ $ty = $_SERVER['HTTP_REFERER']; $_SESSION['referer']="$ty"; $site = parse_url($_SESSION['referer']); }
$kontrol = $db->query("select count(*) from white_list where link='".$site['host']."'")->fetchColumn(); if($kontrol=="0"){ echo 'Sorry dude! Bu iframe adresini bu sitede kullanamazsın! Neden dersen; "'.$site['host'].'" izin verilen siteler listesinde ekli değil. Anketi kullanmak istiyorsan benimle iletişime geçebilirsin --> '.$print['email'].''; }else{
$sorgu = $db->prepare("select * from sorular where sID=?"); $sorgu->execute(array($id)); if($sorgu->rowCount()=="0"){ echo 'Yanlış anket numarası! Doğru anket numarası için bana ulaşabilirsin --> '.$print['email']; }else{ $gelen = $sorgu->fetch(PDO::FETCH_ASSOC); ?>
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

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
<?php $say = $db->query("select count(*) from ip_list where ip='".$ip."' AND sID='".$gelen['sID']."'")->fetchColumn(); if($say>="1"){ ?>
        <h3 class="mt-3"><i class="fas fa-poll-h"></i> <?php echo $gelen['baslik']; ?> <u>Sonuçları</u></h3>
		<div class="alert alert-info"><i class="fas fa-info-circle"></i> Bu ankette daha önce oy kullanmışsınız. IP adresinizi değiştirmediğiniz sürece ankete tekrar katılamazsınız!</div>	
		<ul class="list-group">
<?php foreach($db->query("select * from cevaplar where sID='".$gelen['sID']."'") as $ccc){ $ddd = $db->query("select sum(oy_sayisi) from cevaplar where sID='".$gelen['sID']."'")->fetchColumn(); ?>		
		  <li class="list-group-item">
			<i class="fas fa-asterisk"></i> <?php echo $ccc['baslik']; ?> <small>(<?php echo number_format($ccc['oy_sayisi']); ?> oy)</small>
			<div class="progress">
			  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">%<?php echo round((($ccc['oy_sayisi']/$ddd)*100),2); ?></div>
			</div>	  
		  </li>	 
<?php } ?>		  
		</ul>
<?php }else{ ?>
        <h3 class="mt-3"><i class="far fa-question-circle"></i> <?php echo $gelen['baslik']; ?></h3>
<?php if(isset($_POST['send'])){

if(!isset($_POST['cevap_id'])){ echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Ankete katılmak için seçim yapmanız gerekir!</div>'; }else{ $id = intval($_POST['cevap_id']);

if($id==""){ echo '<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Bir hata oluştu! Lütfen sayfayı yenileyip tekrar deneyin.</div>'; }else{
	
$db->query("update cevaplar set oy_sayisi=oy_sayisi+1 where id='".$id."'"); $db->query("insert into ip_list set ip='".$ip."',sID='".$gelen['sID']."'");

echo '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Seçiminiz kaydedildi! Ankete katıldığınız için teşekkür ederiz. Sayfa yenileniyor...</div>'; 
echo '<meta http-equiv="refresh" content="3">'; } } } ?>
		<div class="list-group">
		<form method="post">
<?php foreach($db->query("select * from cevaplar where sID='".$gelen['sID']."'") as $bbb){ ?>
		  <span class="list-group-item list-group-item-action"><input type="radio" name="cevap_id" value="<?php echo $bbb['id']; ?>"> <?php echo $bbb['baslik']; ?></span>
<?php } ?><br>
			<button type="submit" name="send" class="btn btn-primary"><i class="far fa-hand-point-right"></i> Ankete Katıl</button>
		</form>
		</div>
<?php } ?>
      </div>
    </div>
  </div>
  
  <script src="vendor/jquery/jquery.slim.min.js"></script>
  <script src="vendor/fontawesome/all.min.js"></script>  
  <script>$('.list-group-item').on('click', e => { $('input', e.target).prop('checked', true); });</script>
  
</body>
</html>
<?php } } } } ?>