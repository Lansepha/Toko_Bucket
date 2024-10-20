<?php
session_start();
include 'db.php'; // Memastikan file koneksi database benar

// Periksa status login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo '<p>Anda harus login terlebih dahulu untuk mengakses halaman ini. <a href="login.php">Silahkan login di sini.</a></p>';
    exit;
}

$id = $_GET['id'];
$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '$id'");
$p = mysqli_fetch_object($produk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>FlowerlyBucket</title>
    <!-- khusus logo -->
    <style>
        .header-logo {
            display: flex;
            align-items: center;
        }
        .header-logo img {
            height: 50px;
            width: 50px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .header-logo a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <h1 class="header-logo">
                <a href="dashboard.php">
                    <img src="img/logo.png" alt="FlowerlyBucket Logo">
                    FlowerlyBucket
                </a>
            </h1> 
            <ul>
                <li><a href="produk.php">Produk</a></li>
            </ul>
        </div> 
    </header>

    <!-- search -->
    <div class="search">
        <div class="container">
            <form action="produk.php" method="GET">
                <input type="text" name="search" placeholder="Cari Produk" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
                <input type="submit" name="cari" value="Cari Produk">
            </form>
        </div>
    </div>

   <!-- product detail -->
    <div class="section">
        <div class="container">
            <h2>Detail Produk</h2>
            <div class="box-detail-produk">
                <div class="col-2">
                    <img src="produk/<?php echo $p->product_image; ?>" alt="<?php echo $p->product_name; ?>" class="product-image">
                    </div>
                <div class="col-2 detail-produk">
                    <h3><?php echo $p->product_name; ?></h3>
                    <p>
                        Deskripsi :<br>
                        <?php echo $p->product_description; ?>
                    </p>
                    <h4>Harga: Rp<?php echo number_format($p->product_price, 0, ',', '.'); ?></h4>
                    <a href="https://api.whatsapp.com/send?phone=62895330191783&text=Hai,%20saya%20tertarik%20dengan%20produk%20anda." target="_blank">Hubungi via WhatsApp</a>
                    <br><br>
                    <a href="https://www.instagram.com/flowerlybucket" target="_blank">Hubungi via Instagram</a>
                    <br><br>
                    <a href="https://www.facebook.com/profile.php?id=61559603363216" target="_blank">Hubungi via Facebook</a>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="footer">
            <div class="container">
                <div class="footer-section">
                    <h4>Alamat</h4>
                    <p>Perum Cengkong Persada, Blok A No. 5, Karawang, Jawa Barat</p>
                </div>
                
                <div class="footer-section">
                    <h4>Email</h4>
                    <p>info@flowerlybucket.com</p>
                </div>
                
                <div class="footer-section">
                    <h4>No. Hp</h4>
                    <p>+62895330191783</p>
                </div>
                
                <div class="footer-section social-media">
                    <h4>Ikuti Kami</h4>
                    <a href="https://www.facebook.com/profile.php?id=61559603363216" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="https://www.instagram.com/flowerlybucket" target="_blank"><i class="fab fa-instagram"></i> Instagram</a>
                    <a href="https://www.twitter.com/flowerlybucket" target="_blank"><i class="fab fa-twitter"></i> Twitter</a>
                </div>
            </div>
            
            <div class="footer-bottom">
                <small>&copy; 2024 - FlowerlyBucket. All Rights Reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Include Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>