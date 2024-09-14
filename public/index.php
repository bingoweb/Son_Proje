<?php
include '../config/config.php'; // Eğer index.php 'public' dizininde ise doğru yol
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Çocuk Oyunları</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>"> <!-- Her seferinde farklı bir zaman damgası eklenir -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome -->
</head>
<header class="header">
    <h1>Hoş Geldiniz!</h1>
    <p>En eğlenceli oyunlar burada!</p>
    <div class="site-title">
        <h2>Çocuk Oyunları Dünyası</h2> <!-- Site Başlığı -->
    </div>
</header>



    <main>
        <section class="kategori-secim">
            <h2>Oyun Kategorilerini Keşfet</h2>
            <div class="kategoriler">
                <a href="oyunlar.php?kategori=eğitici" class="kategori buton egitici">
                    <i class="fas fa-graduation-cap"></i> Eğitici Oyunlar
                </a>
                <a href="oyunlar.php?kategori=bulmaca" class="kategori buton bulmaca">
                    <i class="fas fa-puzzle-piece"></i> Bulmaca Oyunları
                </a>
                <a href="oyunlar.php?kategori=eğlenceli" class="kategori buton eglenceli">
                    <i class="fas fa-smile"></i> Eğlenceli Oyunlar
                </a>
            </div>
        </section>
    </main>

    <!-- Footer'ı include ediyoruz -->
    <?php include '../includes/footer.php'; ?>

</body>
</html>
