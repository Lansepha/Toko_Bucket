<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Atur Ulang Kata Sandi | tokoBucket</title>
</head>
<body id="bg-login">
    <div class="box-login">
        <h2>Atur Ulang Kata Sandi</h2>
        <form action="" method="POST">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <input type="password" name="new_password" placeholder="Kata sandi baru" class="input-control" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi kata sandi baru" class="input-control" required>
            <input type="submit" name="submit" value="Atur Ulang" class="btn">
        </form>
        <?php
        if(isset($_POST['submit'])){
            include 'db.php';
            
            $token = mysqli_real_escape_string($conn, $_POST['token']);
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

            if($new_password == $confirm_password){
                $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE reset_token = '".$token."'");
                
                if(mysqli_num_rows($cek) > 0){
                    $new_password_hashed = MD5($new_password);
                    $d = mysqli_fetch_object($cek);
                    mysqli_query($conn, "UPDATE tb_admin SET password = '".$new_password_hashed."', reset_token = NULL WHERE admin_id = '".$d->admin_id."'");
                    echo '<script>alert("Kata sandi berhasil diatur ulang.")</script>';
                    echo '<script>window.location="login.php"</script>';
                } else {
                    echo '<script>alert("Token tidak valid!")</script>';
                }
            } else {
                echo '<script>alert("Kata sandi tidak cocok!")</script>';
            }
        }
        ?>
    </div>
</body>
</html>