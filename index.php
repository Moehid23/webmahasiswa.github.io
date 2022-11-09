<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
require 'function.php';
$mahasiswa = query("SELECT * FROM mahasiswa");
// jika tombol cari diklik
if(isset($_POST["cari"])){
    $mahasiswa = cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        .loader{
            width: 100px;
            position: absolute;
            top:121px;
            z-index: -1;
            left: 280px;
            display: none;
        }
        @media print{
            .logout, .tambah, .from-cari, .aksi{
                display: none;
            }

        }
    </style>
    </head>
<body>
    <a href="logout.php" class="logout">Logout </a> | <a href="cetak.php" target="_blank">Cetak</a>
    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php" class="tambah">Tambah data mahasiswa</a>
    <br><br>
    <form action="" method="post" class="from-cari">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukan keyword pencarian" autocomplete="off" id="keyword">
        <button type="submit" name="cari" id="tombol-cari">Cari!</button>
        <img src="img/Loading_icon.gif" class="loader">
    </form>
    <br>
    <div id="container">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th class="aksi">Aksi</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>NRP</th>
            <th>Jurusan</th>
            <th>Email</th>
        </tr>
        <?php $i=1; ?>
        <?php  foreach($mahasiswa as $row):?>
        <tr>
            <td><?php echo $i; ?></td>
            <td class="aksi">
                <a href="ubah.php?id=<?php echo $row["id"];?>">Ubah</a> |
                <a href="hapus.php?id=<?php echo $row["id"];?>" onclick="return confirm('yakin?'); ">Hapus</a>
            </td>
            <td>
                <img src="img/<?php echo $row["gambar"];?>"width="100">
                <td><?php echo $row["nama"]; ?></td>
                <td><?php echo $row["nrp"]; ?></td>
                <td><?php echo $row["jurusan"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
            </td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>

    </table>
<script src="js/jquery-3.6.1.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>