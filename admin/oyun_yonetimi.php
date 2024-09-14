<?php
session_start();

// Eğer admin girişi yapılmamışsa login sayfasına yönlendirme
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
include '../config/config.php';

// Oyunları veritabanından çekiyoruz
$sonuc = $baglanti->query("SELECT * FROM games");

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyun Yönetimi</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include 'header.php'; ?>

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- İçerik -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Oyun Yönetimi</h1>
                    </div>
                    <div class="col-sm-6">
                        <a href="oyun_ekle.php" class="btn btn-primary float-sm-right">Yeni Oyun Ekle</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Oyun Adı</th>
                            <th>Kategori</th>
                            <th>Açıklama</th>
                            <th>Oyun Linki</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $sonuc->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['oyun_adi']); ?></td>
                                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                                <td><?php echo htmlspecialchars($row['aciklama']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($row['oyun_linki']); ?>" target="_blank">Oyna</a></td>
                                <td>
                                    <a href="oyun_duzenle.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Düzenle</a>
                                    <a href="oyun_sil.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu oyunu silmek istediğinize emin misiniz?');">Sil</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
