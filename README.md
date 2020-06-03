# Anket Scripti
Anket oluşturmak için php ile yazılmış bir script. İframe(iframe.php) ile farklı sitelerde anketlerinizi gösterebilirsiniz.
Kullanmak için iframe.php?id=anket_id(id yönetim panelinde yazıyor) biçiminde yazmanız yeterlidir.

## Ekran Görüntüleri

Anket -> https://kisaurl.net/3Ivx

Sonuç -> https://kisaurl.net/ufl9

Yönetim Paneli -> https://kisaurl.net/MQwA

## Veritabanı Ayarları

vendor/config.php dosyasını düzenleyin;
```php
$dbhost = "localhost";
$dbuser = "root"; //Veritabanı Kullanıcı Adı
$dbpass = ""; //Veritabanı Şifresi
$dbdata = "veritabani"; //Veritabanı Adı
```
## Yönetim Paneli Bilgileri
```
Kullanıcı Adı: admin
Şifre: admin
```
## Kurulum

Veritabanı oluşturup, config.php dosyasına bilgileri girdikten sonra ana dizinde yer alan " anket.sql " dosyasını phpMyAdmin ile içeri aktarın.

## Uyarı
Kurulum yaptıktan sonra mutlaka yönetici şifrenizi değiştirin. Ayrıca güvenlik için " yonetim " klasörünün ismini değiştirmeyi unutmayın!
iframe.php direk erişimlere kapalıdır. iFrame dosyasını çalıştıracak adresleri yönetim paneli " Siteler " sayfasından ekleyebilirsiniz.