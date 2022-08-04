<?php
include 'connection.php';
session_start();

if( !isset($_SESSION["username"]) ) {
    header("Location:login.php");
}

$sql = "SELECT * FROM data_peminjam";
$result = mysqli_query($conn, $sql);

if(isset($_GET["submit_cari"])) {
    if(empty    ($_GET["cari"])) {
        $error_cari =  "anda belum mengisi pencarian";
    } else {
        $cari = htmlspecialchars( $_GET["cari"] );
        $sql = "SELECT * FROM data_peminjam WHERE judul LIKE '%$cari%' OR jumlah_halaman LIKE '%$cari%' OR pengarang LIKE '%$cari%' OR penerbit LIKE '%$cari%' OR tahun LIKE '%$cari%' ";
        $result = mysqli_query($conn, $sql);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <ul class="ul-admin">
        <li><a href="admin-home.php">Daftar Buku</a></li>
        <li><a href="data-peminjam.php">Data Peminjam</a></li>
        <li style="float: right"><a href="logout.php">Logout</a></li>
    </ul>

    <br>

    <form action="" method="GET">
        <input type="text" name="cari" id="" placeholder="Cari data peminjam" style="width: 240px;">
        <input type="submit" value="cari" name="submit_cari">
    </form>
    <p style="color: red;"><?php if(isset($error_cari)) echo $error_cari ?></p>
    
    <br>

    <a href="tambah-peminjam.php" class="tambah-buku">Tambah Data Peminjam</a>

    <br><br><br>

    <table>
        <tr>
            <th>Nama</th>
            <th>Judul buku</th>
            <th>Waktu peminjaman</th>
            <th>Waktu pengembalian</th>
            <th>Jumlah denda</th>
            <th>Status peminjaman</th>
            <th>Jumlah buku dipinjam</th>
            <th>Aksi</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row["nama"] ?></td>
                <td><?php echo $row["judul"] ?></td>
                <td><?php echo $row["waktu_peminjaman"] ?></td>
                <td><?php echo $row["waktu_pengembalian"] ?></td>
                <td><?php echo $row["jumlah_denda"] ?></td>
                <td><?php echo $row["status_peminjaman"] ?></td>
                <td><?php echo $row["jumlah_buku_dipinjam"] ?></td>
                <td><a href="">selesai</a></td>
            </tr>
        <?php endwhile ?>

    </table>

</body>
</html>