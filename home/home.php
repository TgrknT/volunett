<?php
session_start();

// Kullanıcı adını session'dan alın
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Misafir';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sosyal Medya Anasayfası</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">Volunet</div>
        <nav>
            <ul>
                <li><a href="#">Anasayfa</a></li>
                <li><a href="#">Keşfet</a></li>
                <li><a href="/volunet/profile/profile.php">Profil</a></li>
            </ul>
        </nav>
        <div class="user-info">
            <span><?php echo $username; ?></span>
        </div>
    </header>
    
    <main>
        <section class="post">
            <div class="user-info">
                <img src="photos/users.jpg" alt="Profil Resmi">
                <div class="username"><?php echo $username; ?></div>
            </div>
            <img src="post-image.jpg" alt="Gönderi Resmi">
            <div class="post-description">
                <p>Bu bir gönderi açıklamasıdır.</p>
                <div class="likes">53 Beğenme</div>
                <div class="comments">12 Yorum</div>
            </div>
        </section>
        
        <!-- Diğer gönderiler buraya eklenebilir -->
    </main>
</body>
</html>
