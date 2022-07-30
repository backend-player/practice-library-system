<?php
include 'connection.php';

$sql = "SELECT * FROM buku";
$result = mysqli_query($conn, $sql);

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
    <ul>
        <li><a href="index.php">Daftar Buku</a></li>
        <li style="float: right"><a href="login.php">Login admin</a></li>
    </ul>

    <br>
    <form action="" method="GET">
        <label for="filter">Filter berdasarkan jenis buku:</label>
        <select name="filter" id="">
            <option value="semua">Fiksi dan non-fiksi</option>
            <option value="fiksi">Fiksi</option>
            <option value="non_fiksi">Non-fiksi</option>
        </select>
        <input type="submit" value="filter">
    </form>
    <br>

    <form action="" method="GET">
        <input type="text" name="cari" id="" placeholder="Cari buku" style="width: 240px;">
        <input type="submit" value="cari">
    </form>
    <br>

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
            </tr>
        <?php endwhile ?>

    </table>

</body>
</html>