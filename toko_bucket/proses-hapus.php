<?php

include 'db.php';

if(isset($_GET['idk'])){
    $delete = mysqli_query($conn, "DELETE FROM tb_categori WHERE categori_id ='".$_GET['idk']."' ");
    echo '<script>window.location="data-kategori.php"</script>';
}

if(isset($_GET['idp'])){
    $produk = mysqli_query($conn, "SELECT product_image FROM tb_product WHERE product_id = '".$_GET['idp']."' ");
    $p = mysqli_fetch_object($produk);
    unlink('./produk/'.$p->product_image);
    $delete = mysqli_query($conn, "DELETE FROM tb_product WHERE product_id ='".$_GET['idp']."' ");
    echo '<script>window.location="data-produk.php"</script>';
}

if(isset($_GET['idpelanggan'])){
    $delete = mysqli_query($conn, "DELETE FROM tb_pelanggan WHERE pelanggan_id ='".$_GET['idpelanggan']."' ");
    echo '<script>window.location="data-pelanggan.php"</script>';
}

if(isset($_GET['idorder'])){
    $delete = mysqli_query($conn, "DELETE FROM tb_order WHERE order_id ='".$_GET['idorder']."' ");
    echo '<script>window.location="data-order.php"</script>';
}

?>