<?php
include 'connection.php';
session_start();

if( !isset($_SESSION["username"]) ) {
    header("Location:login.php");
}

$sql = "SELECT * FROM data_peminjam WHERE status_peminjaman = 'aktif' ";
$result = mysqli_query($conn, $sql);

$filter_status_peminjaman = "aktif";

if(isset($_GET["submit_filter"])) {
    $filter_status_peminjaman = htmlspecialchars( $_GET["filter_status_peminjaman"] );
    if($filter_status_peminjaman == "aktif") {
        $sql = "SELECT * FROM data_peminjam WHERE status_peminjaman = 'aktif' ";
        $result = mysqli_query($conn, $sql);
    } else if($filter_status_peminjaman == "selesai") {
        $sql = "SELECT * FROM data_peminjam WHERE status_peminjaman = 'selesai' ";
        $result = mysqli_query($conn, $sql);
    }
}

if(isset($_GET["submit_cari"])) {
    if(empty    ($_GET["cari"])) {
        $error_cari =  "anda belum mengisi pencarian";
    } else {
        $cari = htmlspecialchars( $_GET["cari"] );
        $sql = "SELECT * FROM data_peminjam WHERE status_peminjaman = 'aktif' AND nama LIKE '%$cari%' OR judul_buku LIKE '%$cari%' OR waktu_peminjaman LIKE '%$cari%' OR waktu_pengembalian LIKE '%$cari%' OR jumlah_denda LIKE '%$cari%'  ";
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
        <label for="filter_status_peminjaman">Filter berdasarkan status peminjaman:</label>
        <select name="filter_status_peminjaman">
            <option value="aktif" <?php if(isset($_GET["filter_status_peminjaman"]) && $_GET["filter_status_peminjaman"] == "aktif") echo "selected = 'selected' "; ?> >Aktif</option>
            <option value="selesai" <?php if(isset($_GET["filter_status_peminjaman"]) && $_GET["filter_status_peminjaman"] == "selesai") echo "selected = 'selected' "; ?> >Selesai</option>
        </select>
        <input type="submit" value="filter" name="submit_filter">
    </form>

    <br>

    <form action="" method="GET">
        <input type="text" name="cari" id="" placeholder="Cari data peminjam" style="width: 240px;">
        <input type="submit" value="cari" name="submit_cari">
    </form>
    <p style="color: red;"><?php if(isset($error_cari)) echo $error_cari ?></p>
    
    <br>

    <a href="tambah-peminjam.php" class="tambah-buku">Tambah Data Peminjam</a>

    <br><br><br>

    <?php if($filter_status_peminjaman == "aktif"): ?>
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

            <?php
            // jika waktu pengembalian masih kosong, ubah data yang ditampilkan menjadi -
            if($row["waktu_pengembalian"] == "0000-00-00 00:00:00") {
            $row["waktu_pengembalian"] = "-";
            }
            ?>

            <tr>
                <td><?php echo $row["nama"] ?></td>
                <td><?php echo $row["judul_buku"] ?></td>
                <td><?php echo $row["waktu_peminjaman"] ?></td>
                <td><?php echo $row["waktu_pengembalian"] ?></td>
                <td><?php echo "Rp. " . $row["jumlah_denda"] ?></td>
                <td><?php echo $row["status_peminjaman"] ?></td>
                <td><?php echo $row["jumlah_buku_dipinjam"] ?></td>
                <td><a class="tombol-selesai" href="kembalikan-buku.php?id=<?php echo $row["id"] ?>" onclick="return confirm('Anda yakin ingin mengupdate data?')">selesai</a></td>
            </tr>
            
        <?php endwhile ?>

    </table>
    <?php endif ?>


    <?php if($filter_status_peminjaman == "selesai"): ?>
    <table>
        <tr>
            <th>Nama</th>
            <th>Judul buku</th>
            <th>Waktu peminjaman</th>
            <th>Waktu pengembalian</th>
            <th>Jumlah denda</th>
            <th>Status peminjaman</th>
            <th>Jumlah buku dipinjam</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>

            <?php
            // jika waktu pengembalian masih kosong, ubah data yang ditampilkan menjadi -
            if($row["waktu_pengembalian"] == "0000-00-00 00:00:00") {
            $row["waktu_pengembalian"] = "-";
            }
            ?>

            <tr>
                <td><?php echo $row["nama"] ?></td>
                <td><?php echo $row["judul_buku"] ?></td>
                <td><?php echo $row["waktu_peminjaman"] ?></td>
                <td><?php echo $row["waktu_pengembalian"] ?></td>
                <td><?php echo "Rp. " . $row["jumlah_denda"] ?></td>
                <td><?php echo $row["status_peminjaman"] ?></td>
                <td><?php echo $row["jumlah_buku_dipinjam"] ?></td>
            </tr>
            
        <?php endwhile ?>

    </table>
    <?php endif ?>

</body>
</html>