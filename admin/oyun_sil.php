<?php
session_start();

// Eğer admin girişi yapılmamışsa login sayfasına yönlendirme
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
include '../config/config.php';

$oyun_id = $_GET['id'];

// Oyun silme sorgusu
$stmt = $baglanti->prepare("DELETE FROM games WHERE id = ?");
$stmt->bind_param("i", $oyun_id);

if ($stmt->execute()) {
    header("Location: oyun_yonetimi.php");
    exit;
} else {
    echo "Bir hata oluştu.";
}
?>
