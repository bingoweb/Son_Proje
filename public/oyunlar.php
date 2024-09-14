<?php
// Veritabanı bağlantısını ekliyoruz
include '../config/config.php';

// Oyunları veritabanından çekiyoruz (Kategoriye göre)
$kategoriFiltre = isset($_GET['kategori']) ? $_GET['kategori'] : '';
if ($kategoriFiltre) {
$stmt = $baglanti->prepare("SELECT oyun_adi, kategori, aciklama, oyun_linki, oyun_resim FROM games WHERE kategori = ?");
    $stmt->bind_param("s", $kategoriFiltre);
} else {
    // Eğer kategori seçilmediyse ana sayfaya yönlendirebiliriz (isteğe bağlı)
    header("Location: index.php");
    exit();
}
$stmt->execute();
$sonuc = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyunlar</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome -->
</head>
<body>

    <div class="container">
	
	<!-- Geri Dön İkonu -->
    <a href="index.php" class="geri-don-ikon">
        <i class="fas fa-arrow-left"></i>
    </a>
	
        <h1 class="kategori-baslik"><?php echo htmlspecialchars(ucfirst($kategoriFiltre)); ?> Oyunları</h1>

         <!-- Oyunları listeleme -->
<div class="oyunlar-listesi">
    <?php if ($sonuc->num_rows > 0): ?>
        <?php while ($row = $sonuc->fetch_assoc()): ?>
            <div class="oyun-card">
                <div class="oyun-image">
                    <!-- Oyun için yüklenen resmi gösteriyoruz, yoksa varsayılan resim -->
                    <?php
                 // Veritabanındaki dosya yolunu kontrol ediyoruz
                    $resimYolu = htmlspecialchars($row['oyun_resim']);
                 //   echo "Veritabanındaki dosya yolu: " . $resimYolu . "<br>";
				

                    // Resmin olup olmadığını kontrol ediyoruz
                    if (!empty($resimYolu) && file_exists('../admin/' . $resimYolu)) {
                        // Resmi admin dizininden gösteriyoruz
                        echo '<img src="../admin/' . $resimYolu . '" alt="' . htmlspecialchars($row['oyun_adi']) . '" class="oyun-goruntusu">';
                    } else {
                        // Varsayılan resim, eğer oyun resmi yüklenmemişse
                        echo '<img src="../admin/uploads/default-image.png" alt="Varsayılan Resim" class="oyun-goruntusu">';
                    }
                    ?>
                </div>
                <div class="oyun-info">
                    <h3><?php echo htmlspecialchars($row['oyun_adi']); ?></h3>
                    <p><?php echo htmlspecialchars($row['aciklama']); ?></p>
                    <a href="<?php echo htmlspecialchars($row['oyun_linki']); ?>" target="_blank" class="oyna-buton">Oyna</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Bu kategori için henüz oyun eklenmemiş.</p>
    <?php endif; ?>
</div>



</body>