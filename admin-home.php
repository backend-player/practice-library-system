<?php
include 'connection.php';
session_start();

if( !isset($_SESSION["username"]) ) {
    header("Location:login.php");
}

$sql = "SELECT * FROM buku";
$result = mysqli_query($conn, $sql);

if(isset($_GET["submit_filter"])) {
    $filter_buku = htmlspecialchars( $_GET["filter_buku"] );
    if($filter_buku == "fiksi") {
        $sql = "SELECT * FROM buku WHERE jenis = 'fiksi' ";
        $result = mysqli_query($conn, $sql);
    } else if($filter_buku == "non-fiksi") {
        $sql = "SELECT * FROM buku WHERE jenis = 'non-fiksi' ";
        $result = mysqli_query($conn, $sql);
    } else {
        $sql = "SELECT * FROM buku";
        $result = mysqli_query($conn, $sql);
    }
}

if(isset($_GET["submit_cari"])) {
    if(empty    ($_GET["cari"])) {
        $error_cari =  "anda belum mengisi pencarian";
    } else {
        $cari = htmlspecialchars( $_GET["cari"] );
        $sql = "SELECT * FROM buku WHERE judul LIKE '%$cari%' OR jumlah_halaman LIKE '%$cari%' OR pengarang LIKE '%$cari%' OR penerbit LIKE '%$cari%' OR tahun LIKE '%$cari%' ";
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
        <label for="filter_buku">Filter berdasarkan jenis buku:</label>
        <select name="filter_buku">
            <option value="semua" <?php if(isset($_GET["filter_buku"]) && $_GET["filter_buku"] == "semua") echo "selected = 'selected' "; ?> >Fiksi dan non-fiksi</option>
            <option value="fiksi" <?php if(isset($_GET["filter_buku"]) && $_GET["filter_buku"] == "fiksi") echo "selected = 'selected' "; ?> >Fiksi</option>
            <option value="non-fiksi" <?php if(isset($_GET["filter_buku"]) && $_GET["filter_buku"] == "non-fiksi") echo "selected = 'selected' "; ?> >Non-fiksi</option>
        </select>
        <input type="submit" value="filter" name="submit_filter">
    </form>

    <br>

    <form action="" method="GET">
        <input type="text" name="cari" id="" placeholder="Cari buku" style="width: 240px;">
        <input type="submit" value="cari" name="submit_cari">
    </form>
    <p style="color: red;"><?php if(isset($error_cari)) echo $error_cari ?></p>
    
    <br>

    <a href="tambah-buku.php" class="tambah-buku">Tambah Buku</a>

    <br><br><br>

    <table>
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Jumlah halaman</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Jumlah buku</th>
            <th>Jumlah tersedia</th>
            <th>Jenis buku</th>
            <th>Aksi</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><img src="gambar/<?php echo $row["gambar"] ?>" width="100px"></td>
                <td><?php echo $row["judul"] ?></td>
                <td><?php echo $row["jumlah_halaman"] ?></td>
                <td><?php echo $row["pengarang"] ?></td>
                <td><?php echo $row["penerbit"] ?></td>
                <td><?php echo $row["tahun"] ?></td>
                <td><?php echo $row["jumlah_buku"] ?></td>
                <td><?php echo $row["jumlah_tersedia"] ?></td>
                <td><?php echo $row["jenis"] ?></td>
                
                <td style="white-space: nowrap;">
                    <a class="tombol-aksi" href="edit-buku.php?id=<?php echo $row["id"] ?> ">edit</a>
                    <a class="tombol-aksi" href="hapus-buku.php?id=<?php echo $row["id"] ?>" onclick="return confirm('Anda yakin ingin menghapus data?')">hapus</a>
                </td>
            </tr>
        <?php endwhile ?>

    </table>

</body>
</html>