<?php
// Veritabanı bağlantısını ekliyoruz
include '../config/config.php';

// Hata mesajı için değişken tanımlıyoruz
$hataMesaji = "";

// Form gönderildiğinde çalışacak kod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $email = $_POST['email'];
    $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT); // Şifreyi güvenli hale getiriyoruz

    // E-posta benzersiz mi kontrol ediyoruz
    $emailKontrol = $baglanti->prepare("SELECT id FROM users WHERE email = ?");
    $emailKontrol->bind_param("s", $email);
    $emailKontrol->execute();
    $emailKontrol->store_result();

    if ($emailKontrol->num_rows > 0) {
        $hataMesaji = "Bu e-posta adresi zaten kayıtlı!";
    } else {
        // Kullanıcıyı veritabanına ekliyoruz
        $stmt = $baglanti->prepare("INSERT INTO users (ad, soyad, email, sifre) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $ad, $soyad, $email, $sifre);

        if ($stmt->execute()) {
            echo "Kayıt başarılı!";
        } else {
            $hataMesaji = "Kayıt başarısız. Lütfen tekrar deneyin.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Kayıt Ol</h2>

    <?php if ($hataMesaji != ""): ?>
        <p style="color:red;"><?php echo $hataMesaji; ?></p>
    <?php endif; ?>

    <form method="POST" action="kayit.php">
        <label for="ad">Ad:</label><br>
        <input type="text" id="ad" name="ad" required><br><br>

        <label for="soyad">Soyad:</label><br>
        <input type="text" id="soyad" name="soyad" required><br><br>

        <label for="email">E-posta:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="sifre">Şifre:</label><br>
        <input type="password" id="sifre" name="sifre" required><br><br>

        <input type="submit" value="Kayıt Ol">
    </form>
</body>
</html>
