<?php
include 'connection.php';
session_start();

if( !isset($_SESSION["username"]) ) {
    header("Location:login.php");
}

if(isset($_POST["tambah"])) {
    $judul = htmlspecialchars($_POST["judul"]);
    $nama = htmlspecialchars($_POST["nama"]);

    $timezone = time() + (60 * 60 * 7);
    $waktu_peminjaman = gmdate("Y/m/d H:i:sa", $timezone);
    
    if( empty($judul) || empty($nama) ) {
        $pesan_error = "anda belum mengisi semua form";
    } else if(!preg_match('/^[A-Za-z0-9_ -]+$/', $judul)) {
        $pesan_error = "judul hanya dapat menggunakan huruf, angka, dan spasi";
    } else if(!preg_match('/^[A-Za-z -]+$/', $nama)) {
        $pesan_error = "nama hanya dapat menggunakan huruf dan spasi";
    } else {
        // cek apakah buku ada dan tersedia di database
        $sql = "SELECT judul FROM buku WHERE judul = '$judul' ";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) < 1) {
            $pesan_error = "buku tidak tersedia";
        } else {
            // cek apakah data peminjam (status peminjaman = aktif) sudah ada di database
            $sql = "SELECT * FROM data_peminjam WHERE nama = '$nama'  && status_peminjaman = 'aktif' ";
            $result = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($result) > 0) {
                // jika datanya ada, tambah data peminjam ke database, dan update jumlah buku dipinjam
                
                $sql = "SELECT jumlah_buku_dipinjam FROM data_peminjam WHERE nama = '$nama'  && status_peminjaman = 'aktif'  ";
                $result = mysqli_query($conn, $sql);
    
                // ambil value jumlah_buku_dipinjam dari database
                while($row = mysqli_fetch_assoc($result)) {
                    $jumlah_buku_dipinjam = $row["jumlah_buku_dipinjam"];
                }
    
                $sql = "INSERT INTO data_peminjam (nama, judul_buku, waktu_peminjaman, status_peminjaman, jumlah_buku_dipinjam) 
                VALUES ('$nama', '$judul', '$waktu_peminjaman','aktif', '$jumlah_buku_dipinjam' + 1 )";
        
                if(mysqli_query($conn, $sql)){
                    $pesan_success = "Buku berhasil ditambahkan";
                } else {
                    $pesan_error = "Update gagal";
                };

                // update jumlah buku tersedia
                $sql = "UPDATE buku SET jumlah_tersedia = jumlah_tersedia - 1 WHERE judul = '$judul' ";
                $result = mysqli_query($conn, $sql);
                
            } else {
                // jika datanya belum ada, tambah data peminjam ke database
                $sql = "INSERT INTO data_peminjam (nama, judul_buku, waktu_peminjaman, status_peminjaman, jumlah_buku_dipinjam) 
                VALUES ('$nama', '$judul', '$waktu_peminjaman','aktif', '1')";
        
                if(mysqli_query($conn, $sql)){
                    $pesan_success = "Buku berhasil ditambahkan";
                } else {
                    $pesan_error = "Update gagal";
                };

                // update jumlah buku tersedia
                $sql = "UPDATE buku SET jumlah_tersedia = jumlah_tersedia - 1 WHERE judul = '$judul' ";
                $result = mysqli_query($conn, $sql);
            }
        }

    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjam</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="kotak-peminjam">
        <form action="" method="POST">
            <label for="nama">Nama peminjam</label>
            <input type="text" name="nama" id="nama" class="form-peminjam" value="<?php if(isset($nama)) echo $nama ?>">
            
            <label for="judul">Judul buku</label>
            <input type="text" name="judul" id="judul" class="form-peminjam" value="<?php if(isset($judul)) echo $judul ?>">



            <p style="color: red; text-align: center;"><?php if(isset($pesan_error)) echo $pesan_error ?></p>
            <p style="color: green; text-align: center;"><?php if(isset($pesan_success)) echo $pesan_success ?></p>
            <p style="color: red; text-align: center;"><?php if(isset($update_gambar_gagal)) echo $update_gambar_gagal ?></p>

            <div class="tombol-login">
                <button type="submit" name="tambah">Tambah peminjam</button>
            </div>

            <br>

            <div class="tombol-login">
                <button type="button" onclick="location.href='data-peminjam.php'">Kembali</button>
            </div>
        </form>
    </div>
</body>
</html>