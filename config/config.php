<?php
$sunucuAdi = "localhost"; // Yerel sunucu adı
$kullaniciAdi = "root"; // MySQL kullanıcı adı
$sifre = "181076"; // MySQL şifresi (varsayılan boş)
$veritabani = "cocuk_oyunlari"; // Veritabanı adı

// Veritabanı bağlantısını kurma
$baglanti = new mysqli($sunucuAdi, $kullaniciAdi, $sifre, $veritabani);

// Bağlantı hatası kontrolü
if ($baglanti->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $baglanti->connect_error);
}

// Türkçe karakter desteği için UTF-8 ayarı
$baglanti->set_charset("utf8");
?>
