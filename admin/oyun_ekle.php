<?php
// Veritabanı bağlantısını ekliyoruz
include '../config/config.php';

// Hata mesajı için değişken tanımlıyoruz
$hataMesaji = "";

// Form gönderildiğinde çalışacak kod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oyunAdi = $_POST['oyun_adi'];
    $kategori = $_POST['kategori'];
    $aciklama = $_POST['aciklama'];
    $oyunLinki = $_POST['oyun_linki'];

    // Oyun ekleme kısmında dosyanın nereye kaydedildiğini kontrol edelim
    if (isset($_FILES['oyun_resim']) && $_FILES['oyun_resim']['error'] === UPLOAD_ERR_OK) {
        $dosyaAdi = basename($_FILES['oyun_resim']['name']);
        $dosyaYolu = 'uploads/' . $dosyaAdi;
        $dosyaTipi = strtolower(pathinfo($dosyaAdi, PATHINFO_EXTENSION));

        // Yüklenen dosyanın kaydedildiği yeri ekrana yazdıralım
        echo "Dosya yolu: " . $dosyaYolu . "<br>";

        if (move_uploaded_file($_FILES['oyun_resim']['tmp_name'], $dosyaYolu)) {
            echo "Dosya başarıyla yüklendi: " . $dosyaYolu . "<br>";
            // Veritabanına kaydet
            $stmt = $baglanti->prepare("INSERT INTO games (oyun_adi, kategori, aciklama, oyun_linki, oyun_resim) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $oyunAdi, $kategori, $aciklama, $oyunLinki, $dosyaYolu);
            $stmt->execute();
        } else {
            $hataMesaji = "Dosya yüklenirken hata oluştu.";
        }
    } else {
        $hataMesaji = "Lütfen bir resim yükleyin.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyun Ekle</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Yeni Oyun Ekle</h2>

    <?php if ($hataMesaji != ""): ?>
        <p style="color:red;"><?php echo $hataMesaji; ?></p>
    <?php endif; ?>

    <form method="POST" action="oyun_ekle.php" enctype="multipart/form-data">
        <label for="oyun_adi">Oyun Adı:</label><br>
        <input type="text" id="oyun_adi" name="oyun_adi" required><br><br>

        <label for="kategori">Kategori:</label><br>
        <select id="kategori" name="kategori" required>
            <option value="eğitici">Eğitici</option>
            <option value="bulmaca">Bulmaca</option>
            <option value="eğlenceli">Eğlenceli</option>
        </select><br><br>

        <label for="aciklama">Açıklama:</label><br>
        <textarea id="aciklama" name="aciklama" rows="4" cols="50"></textarea><br><br>

        <label for="oyun_linki">Oyun Linki:</label><br>
        <input type="url" id="oyun_linki" name="oyun_linki" required><br><br>

        <!-- Resim yükleme alanı -->
        <label for="oyun_resim">Oyun Resmi:</label><br>
        <input type="file" id="oyun_resim" name="oyun_resim" required><br><br>

        <input type="submit" value="Oyun Ekle">
    </form>
</body>
</html>
