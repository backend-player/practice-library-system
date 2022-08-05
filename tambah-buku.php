<?php
include 'connection.php';
session_start();

if( !isset($_SESSION["username"]) ) {
    header("Location:login.php");
}

if(isset($_POST["tambah"])) {
    $judul = $_POST["judul"];
    $jumlah_halaman = $_POST["jumlah_halaman"];
    $pengarang = $_POST["pengarang"];
    $penerbit = $_POST["penerbit"];
    $tahun = $_POST["tahun"];
    $jumlah_buku = $_POST["jumlah"];
    $jenis = $_POST["jenis"];

    if(!file_exists ($_FILES["gambarUpload"]["tmp_name"]) ) {
        $pesan_error = "anda belum memilih gambar";
    } else if( empty($judul) || empty($jumlah_halaman) || empty($pengarang) || empty($penerbit) || empty($tahun) || empty($jumlah_buku) ) {
        $pesan_error = "anda belum mengisi semua form";
    } else if(empty($jenis)) {
        $pesan_error = "anda belum mengisi jenis buku";
    } else if(!preg_match('/^[A-Za-z0-9_ -]+$/', $judul)) {
        $pesan_error = "judul hanya dapat menggunakan huruf, angka, dan spasi";
    } else if(!ctype_digit($jumlah_halaman)) {
        $pesan_error = "jumlah halaman harus berupa angka";
    } else if(!preg_match('/^[A-Za-z -]+$/', $pengarang)) {
        $pesan_error = "nama pengarang hanya dapat menggunakan huruf dan spasi";
    } else if(!preg_match('/^[A-Za-z. -]+$/', $penerbit)) {
        $pesan_error = "penerbit hanya dapat menggunakan huruf dan spasi";
    } else if(!ctype_digit($tahun)) {
        $pesan_error = "tahun harus berupa angka";
    } else if(!ctype_digit($jumlah_buku)) {
        $pesan_error = "jumlah buku harus berupa angka";
    } else {
        
    }
}

// upload gambar
if(file_exists ($_FILES["gambarUpload"]["tmp_name"]) ) {
    // upload file
    $folder_tujuan = "../gambar/";
    // folder/file.ekstensi
    $path_gambar = $folder_tujuan . basename($_FILES["gambarUpload"]["name"]);
    $upload_ok = 1;
    $ekstensi_gambar = strtolower(pathinfo($path_gambar, PATHINFO_EXTENSION));

    // mengembalikan nama file dari path $gambar
    $nama_gambar_dan_ekstensi = basename($path_gambar);
    $nama_gambar = pathinfo($path_gambar, PATHINFO_FILENAME);

    // cek apakah file adalah gambar
    $check = @getimagesize($_FILES["gambarUpload"]["tmp_name"]);
    if($check == true) {
        // echo "file adalah gambar";
        $uploadOk = 1;
    } else {
        $update_gambar_gagal = "file bukan gambar";
        $uploadOk = 0;
    }

    // cek ukuran file
    if ($_FILES["gambarUpload"]["size"] > 1000000) {
        $update_gambar_gagal = "file terlalu besar (maksimal 1 Mb)";
        $upload_ok = 0;
    }

    // ekstensi file yang diperbolehkan
    if($ekstensi_gambar != "png" && $ekstensi_gambar != "jpg" && $ekstensi_gambar != "jpeg") {
        $update_gambar_gagal = "Maaf, hanya file PNG, JPG, dan JPEG yang diperbolehkan";
        $upload_ok = 0;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="kotak-buku">
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="gambar">Gambar</label>
            <input type="file" name="gambarUpload" id="gambar" class="form-buku">
            
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" class="form-buku" value="<?php if(isset($judul)) echo $judul ?>">
            
            <label for="jumlah_halaman">Jumlah halaman</label>
            <input type="text" name="jumlah_halaman" id="jumlah_halaman" class="form-buku" value="<?php if(isset($jumlah_halaman)) echo $jumlah_halaman ?>">

            <label for="pengarang">Pengarang</label>
            <input type="text" name="pengarang" id="pengarang" class="form-buku" value="<?php if(isset($pengarang)) echo $pengarang ?>">

            <label for="penerbit">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" class="form-buku" value="<?php if(isset($penerbit)) echo $penerbit ?>">

            <label for="tahun">Tahun</label>
            <input type="text" name="tahun" id="tahun" class="form-buku" value="<?php if(isset($tahun)) echo $tahun ?>">

            <label for="jumlah">Jumlah buku</label>
            <input type="text" name="jumlah" id="jumlah" class="form-buku" value="<?php if(isset($jumlah_buku)) echo $jumlah_buku ?>">

            <label for="jenis">Jenis buku</label>
            <select name="jenis" id="jenis">
                <option value="" hidden selected>Pilih jenis buku</option>
                <option value="fiksi" <?php if(isset($jenis) && $jenis =="fiksi") echo "selected" ?>>Fiksi</option>
                <option value="non-fiksi" <?php if(isset($jenis) && $jenis =="non-fiksi") echo "selected" ?>>Non-fiksi</option>
            </select>

            <br>

            <p style="color: red; text-align: center;"><?php if(isset($pesan_error)) echo $pesan_error ?></p>
            <p style="color: red; text-align: center;"><?php if(isset($update_gambar_gagal)) echo $update_gambar_gagal ?></p>

            <div class="tombol-login">
                <button type="submit" name="tambah">Tambah buku</button>
            </div>

            <br>

            <div class="tombol-login">
                <button type="button" onclick="location.href='admin-home.php'">Kembali</button>
            </div>
        </form>
    </div>
</body>
</html>