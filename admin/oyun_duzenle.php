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

// Oyun bilgilerini veritabanından alıyoruz
$stmt = $baglanti->prepare("SELECT * FROM games WHERE id = ?");
$stmt->bind_param("i", $oyun_id);
$stmt->execute();
$sonuc = $stmt->get_result();
$oyun = $sonuc->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oyunAdi = $_POST['oyun_adi'];
    $kategori = $_POST['kategori'];
    $aciklama = $_POST['aciklama'];
    $oyunLinki = $_POST['oyun_linki'];

    // Oyunu güncelleme sorgusu
    $stmt = $baglanti->prepare("UPDATE games SET oyun_adi = ?, kategori = ?, aciklama = ?, oyun_linki = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $oyunAdi, $kategori, $aciklama, $oyunLinki, $oyun_id);

    if ($stmt->execute()) {
        header("Location: oyun_yonetimi.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyun Düzenle</title>
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
                        <h1>Oyun Düzenle</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="oyun_adi">Oyun Adı</label>
                        <input type="text" class="form-control" id="oyun_adi" name="oyun_adi" value="<?php echo htmlspecialchars($oyun['oyun_adi']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" id="kategori" name="kategori">
                            <option value="eğitici" <?php if ($oyun['kategori'] == 'eğitici') echo 'selected'; ?>>Eğitici</option>
                            <option value="bulmaca" <?php if ($oyun['kategori'] == 'bulmaca') echo 'selected'; ?>>Bulmaca</option>
                            <option value="eğlenceli" <?php if ($oyun['kategori'] == 'eğlenceli') echo 'selected'; ?>>Eğlenceli</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="aciklama">Açıklama</label>
                        <textarea class="form-control" id="aciklama" name="aciklama" rows="4"><?php echo htmlspecialchars($oyun['aciklama']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="oyun_linki">Oyun Linki</label>
                        <input type="url" class="form-control" id="oyun_linki" name="oyun_linki" value="<?php echo htmlspecialchars($oyun['oyun_linki']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </form>
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
