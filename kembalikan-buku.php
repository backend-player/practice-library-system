<?php
include 'connection.php';
session_start();

if( !isset($_SESSION["username"]) ) {
    header("Location:login.php");
}

$id = $_GET["id"];

$timezone = time() + (60 * 60 * 7);
$waktu_pengembalian = gmdate("Y/m/d H:i:s", $timezone);

// ambil judul buku yang dipinjam
$sql = "SELECT judul_buku, waktu_peminjaman FROM data_peminjam WHERE id = '$id' ";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    $judul = $row["judul_buku"];
    $waktu_peminjaman = $row["waktu_peminjaman"];
}

// hitung waktu keterlambatan pengembalian buku
$waktu_awal = strtotime($waktu_peminjaman);
$waktu_akhir = strtotime($waktu_pengembalian);

$perbedaan_hari = $waktu_akhir - $waktu_awal;
$jumlah_hari = $perbedaan_hari / 86400;
$jumlah_hari = round($jumlah_hari);

$denda = $jumlah_hari * 2000;

// ubah status peminjaman menjadi selesai, masukkan waktu pengembalian, kurangi 1 jumlah peminjaman buku
$sql = "UPDATE data_peminjam SET status_peminjaman = 'selesai', waktu_pengembalian = '$waktu_pengembalian',jumlah_denda = '$denda' , jumlah_buku_dipinjam = jumlah_buku_dipinjam - 1 WHERE id = '$id' ";
$result = mysqli_query($conn, $sql);

// tambahkan jumlah buku yang dikembalikan ke jumlah buku yang tersedia
$sql = "UPDATE buku SET jumlah_tersedia = jumlah_tersedia + 1 WHERE judul = '$judul' ";
$result = mysqli_query($conn, $sql);

if($result) {
    echo "<script>
              alert('Data berhasil diupdate'); 
              window.location.href='data-peminjam.php';
            </script>";
    // echo "waktu awal: " . $waktu_awal;
    // echo "<br>";
    // echo "waktu akhir: " . $waktu_akhir;
    // echo "<br>";
    // echo "waktu pengembalian: " . $waktu_pengembalian;
    // echo "<br>";
    // echo "waktu peminjaman: " . $waktu_peminjaman;
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