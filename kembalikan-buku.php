<?php
include 'connection.php';
session_start();

if( !isset($_SESSION["username"]) ) {
    header("Location:login.php");
}

$id = $_GET["id"];

$timezone = time() + (60 * 60 * 7);
$waktu_pengembalian = gmdate("Y/m/d H:i:sa", $timezone);

// ambil judul buku yang dipinjam
$sql = "SELECT judul_buku FROM data_peminjam WHERE id = '$id' ";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    $judul = $row["judul_buku"];
}


// ubah status peminjaman menjadi selesai, masukkan waktu pengembalian, kurangi 1 jumlah peminjaman buku
$sql = "UPDATE data_peminjam SET status_peminjaman = 'selesai', waktu_pengembalian = '$waktu_pengembalian', jumlah_buku_dipinjam = jumlah_buku_dipinjam - 1 WHERE id = '$id' ";
$result = mysqli_query($conn, $sql);

// tambahkan jumlah buku yang dikembalikan ke jumlah buku yang tersedia
$sql = "UPDATE buku SET jumlah_tersedia = jumlah_tersedia + 1 WHERE judul = '$judul' ";
$result = mysqli_query($conn, $sql);

if($result) {
    echo "<script>
              alert('Data berhasil diupdate'); 
              window.location.href='data-peminjam.php';
            </script>";
  } else {
    echo "<script>
            alert('Data gagal diupdate'); 
            window.location.href='data-peminjam.php';
          </script>";
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kembalikan buku</title>
</head>
<body>
    
</body>
</html>