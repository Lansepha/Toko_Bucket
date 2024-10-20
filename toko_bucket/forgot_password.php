<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Lupa Kata Sandi | tokoBucket</title>
</head>
<body id="bg-login">
    <div class="box-login">
        <h2>Lupa Kata Sandi</h2>
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Masukkan email Anda" class="input-control" required>
            <input type="submit" name="submit" value="Kirim" class="btn">
        </form>
        <?php
        if(isset($_POST['submit'])){
            include 'db.php';
            
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_email = '".$email."'");
            
            if(mysqli_num_rows($cek) > 0){
                // Proses pengiriman email
                $token = bin2hex(random_bytes(50)); // Membuat token
                $url = "http://yourdomain.com/reset_password.php?token=" . $token;

                // Simpan token ke database
                $d = mysqli_fetch_object($cek);
                mysqli_query($conn, "UPDATE tb_admin SET reset_token = '".$token."' WHERE admin_id = '".$d->admin_id."'");

                // Kirim email ke pengguna
                $subject = "Atur Ulang Kata Sandi Anda";
                $message = "Klik tautan berikut untuk mengatur ulang kata sandi Anda: " . $url;
                $headers = "From: no-reply@yourdomain.com";

                if(mail($email, $subject, $message, $headers)){
                    echo '<script>alert("Email telah dikirim. Silakan cek email Anda.")</script>';
                } else {
                    echo '<script>alert("Gagal mengirim email.")</script>';
                }
            } else {
                echo '<script>alert("Email tidak ditemukan!")</script>';
            }
        }
        ?>
    </div>
</body>
</html>