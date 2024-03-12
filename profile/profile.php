<?php
session_start();
include 'C:/xampp/htdocs/volunet/baglanti.php';

// Kullanıcı adını al
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Misafir';

// Kullanıcının profil fotoğrafı varsa, profil fotoğrafını al
$profile_photo = isset($_SESSION['profile_photo']) ? $_SESSION['profile_photo'] : 'default_profile_photo.jpg';

// Profil fotoğrafını yükle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile-photo']) && $_FILES['profile-photo']['size'] > 0) {
    $file_name = $_FILES['profile-photo']['name'];
    $file_tmp = $_FILES['profile-photo']['tmp_name'];
    $file_path = 'photos/' . $file_name;

    // Fotoğrafı belirtilen yola taşı
    move_uploaded_file($file_tmp, $file_path);

    // Veritabanına kullanıcı adı ve profil fotoğrafı adını kaydet
    $sql = "UPDATE users SET profile_photo = '$file_name' WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['profile_photo'] = $file_name; // Session'da profil fotoğrafını güncelle
        header("Location: profile.php");
        exit();
    } else {
        echo "Hata oluştu: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $username; ?> Profili</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">Volunet</div>
        <nav>
            <ul>
                <li><a href="#">Anasayfa</a></li>
                <li><a href="#">Keşfet</a></li>
                <li><a href="#">Profil</a></li>
            </ul>
        </nav>
        <div class="user-info">
            <span><?php echo $username; ?></span>
        </div>
    </header>
    
    <main>
        <section class="profile">
            <div class="profile-info">
                <img src="photos/<?php echo $profile_photo; ?>" alt="Profil Resmi">
                <h2><?php echo $username; ?></h2>
                
                <!-- Profil fotoğrafı yükleme formu -->
                <form action="profile.php" method="post" enctype="multipart/form-data">
                    <label for="profile-photo" class="upload-label">Profil Fotoğrafı Yükle</label>
                    <input type="file" name="profile-photo" id="profile-photo" class="hidden">
                    <input type="submit" value="Yükle">
                </form>
            </div>
        </section>
    </main>

    <script>
        // Profil fotoğrafı yükleme butonunu tıklamak için bir JavaScript kodu
        document.querySelector('.upload-label').addEventListener('click', function() {
            document.getElementById('profile-photo').click();
        });
    </script>
</body>
</html>
