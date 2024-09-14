<?php
session_start();

// Veritabanı bağlantısı
include '../config/config.php';

$hataMesaji = "";

// Giriş formu gönderildiğinde çalışacak kod
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $sifre = $_POST['sifre'];

    // Admin kullanıcı kontrolü
    $stmt = $baglanti->prepare("SELECT id, sifre FROM users WHERE email = ? AND admin = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($sifre, $hashed_password)) {
            // Giriş başarılı
            $_SESSION['admin_id'] = $id;
            header("Location: index.php");
            exit;
        } else {
            $hataMesaji = "Şifre hatalı!";
        }
    } else {
        $hataMesaji = "Kullanıcı bulunamadı!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Admin</b>Paneli</a>
        </div>
        <!-- Giriş formu -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Oturum açmak için giriş yapın</p>

                <?php if ($hataMesaji != ""): ?>
                    <p style="color:red;"><?php echo $hataMesaji; ?></p>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="E-posta" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="sifre" class="form-control" placeholder="Şifre" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Giriş Yap</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
