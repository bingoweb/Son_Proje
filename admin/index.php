<?php
session_start();

// Eğer admin girişi yapılmamışsa login sayfasına yönlendirme
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
include '../config/config.php';

// Toplam oyun sayısını al
$oyunSayisi = $baglanti->query("SELECT COUNT(*) AS toplam FROM games")->fetch_assoc()['toplam'];

// Eğer kategori tablosu varsa, toplam kategori sayısını al
$kategoriSayisi = $baglanti->query("SELECT COUNT(DISTINCT kategori) AS toplam FROM games")->fetch_assoc()['toplam'];

include 'header.php';
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <!-- İçerik -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Toplam Oyun Sayısı -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $oyunSayisi; ?></h3>
                                <p>Toplam Oyun</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-gamepad"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Toplam Kategori Sayısı -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $kategoriSayisi; ?></h3>
                                <p>Toplam Kategori</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <p>Burada admin paneli istatistikleri ve kontrol panelleri yer alacak.</p>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
