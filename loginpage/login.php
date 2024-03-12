<?php
include "C:/xampp/htdocs/volunet/baglanti.php";
include "login.html";
// POST yöntemiyle form gönderilmiş mi diye kontrol edin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["ekle"])) {
        $tc_kimlik = $_POST["tc_kimlik"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $phone = $_POST["phone"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        // TC kimlik ve kullanıcı adı benzersiz olmalı kontrolü
        $uniqueCheck = $db->prepare("SELECT COUNT(*) FROM users WHERE tc_kimlik = :tc_kimlik OR username = :username OR phone = :phone");
        $uniqueCheck->execute(array(
            ":tc_kimlik" => $tc_kimlik,
            ":username" => $username,
            ":phone" => $phone 
        ));

        $uniqueCount = $uniqueCheck->fetchColumn();

        if (empty($tc_kimlik) || empty($name) || empty($surname) || empty($phone) || empty($username) || empty($password)) {
            $uyari = "Lütfen tüm alanları doldurun.";
        } else if ($uniqueCount > 0) {
            // TC kimlik veya kullanıcı adı daha önce kullanılmışsa
            $uyari = "Bu bilgilerden biri daha önce kullanılmış.";
        } else {
            // TC kimlik ve kullanıcı adı benzersiz, yeni kayıt ekleniyor

            // Kontrolleri ekleyin
            if (strlen($tc_kimlik) !== 11) {
                $uyari = "TC Kimlik numarası 11 karakter olmalıdır.";
            } else if (strlen($name) < 3 || strlen($name) > 50) {
                $uyari = "İsim 3 ila 50 karakter arasında olmalıdır.";
            } else if (strlen($surname) > 50) {
                $uyari = "Soyisim en fazla 50 karakter olmalıdır.";
            } else if (strlen($phone) !== 11) {
                $uyari = "Telefon numarası 11 karakter olmalıdır.";
            } else if (strlen($username) < 4 || strlen($username) > 50) {
                $uyari = "Kullanıcı adı 4 ila 50 karakter arasında olmalıdır.";
            } else if (strlen($password) < 8 || strlen($password) > 20) {
                $uyari = "Şifre 8 ila 20 karakter arasında olmalıdır.";
            } else {
                // TC kimlik ve kullanıcı adı benzersiz, yeni kayıt ekleniyor
                $ekle = $db->prepare("INSERT INTO users (tc_kimlik, name, surname, phone, username, password) 
                VALUES (:tc_kimlik, :name, :surname, :phone, :username, :password)");

                $control = $ekle->execute(array(
                    ":tc_kimlik" => $tc_kimlik,
                    ":name" => $name,
                    ":surname" => $surname,
                    ":phone" => $phone,
                    ":username" => $username,
                    ":password" => $password
                ));

                if ($control) {
                    $uyari = "Kayıt başarıyla tamamlandı. Giriş yapabilirsiniz.";
                } else {
                    $uyari = "Kayıt sırasında bir hata oluştu.";
                }
            }
        }
    } elseif (isset($_POST["giris"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Kullanıcı adı ve şifre güvenlik önlemleri
        $username = htmlspecialchars(trim($username));
        $password = htmlspecialchars(trim($password));

        $sorgu = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $sorgu->execute(array(
            ":username" => $username,
            ":password" => $password
        ));

        if ($sorgu->rowCount() > 0) {
            // Giriş başarılı ise, istediğiniz sayfaya yönlendirebilirsiniz.
            session_start();
            $_SESSION["username"] = $username; // Kullanıcı adını oturum değişkenine atama
            header("Location: /volunet/home/home.php");
            exit;
        } else {
            $uyari = "Hatalı giriş bilgileri. Lütfen tekrar deneyin.";
        }
    }
}
?>
