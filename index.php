<?php
session_start(); 

if( !isset($_SESSION["login"]) ) { 
	header("Location: login.php");
	exit;
} 

require 'functions.php';

// pagination
// konfigurasi
$jumlahDataPerHalaman = 30;
$jumlahData = count(query("SELECT * FROM databuku"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
$awalData = ( $jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$databuku = query("SELECT * FROM databuku LIMIT $awalData, $jumlahDataPerHalaman");

// tombol cari ditekan
if(isset($_POST["cari"]) ) {
	$databuku = cari($_POST["keyword"]);
 }
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>
</head>
<body>

	<a href="logout.php">Logout</a>

	<h1>Daftar data buku</h1>

	<a href="tambah.php">Tambah data buku</a>
	<br><br>

	<form action="" method="post">
		<input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencarian.." autocomplete="off">
		<button type="submit" name="cari">Cari</button>
	</form>
<br><br>

<!-- navigasi -->
<?php if( $halamanAktif > 1 ) : ?>
<a href="?halaman= <?= $halamanAktif - 1; ?>">&laquo;</a>
<?php endif; ?>

<?php for($i = 1; $i <=$jumlahHalaman; $i++) : ?>
	<?php if( $i == $halamanAktif ) : ?>
    <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"><?= $i; ?></a>
    <?php else : ?>
         <a href="?halaman=<?= $i ?>"><?= $i ?></a>
    <?php endif ?>
<?php endfor; ?>

<?php if( $halamanAktif < $jumlahHalaman ) : ?>
<a href="?halaman= <?= $halamanAktif + 1; ?>">&raquo;</a>
<?php endif; ?>

	<br>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>No.</th>
		<th>Aksi</th>
		<th>Gambar</th>
		<th>Kode buku</th>
		<th>Category</th>
		<th>Nama buku</th>
		<th>Deskripsi</th>
		</tr>

		<?php $i = 1; ?>

		<?php foreach( $databuku as $row ) : ?>

		<tr>
			<td><?= $i; ?></td>
			<td>
				<a href="ubah.php?id=<?= $row["id"]; ?>">Edit</a> |
				<a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">Delete</a>
			</td>
			<td><img src="img/<?= $row["gambar"]; ?>" width="50"></td>
			<td><?= $row["kode_buku"]; ?></td>
		    <td><?= $row["category"]; ?></td>
		    <td><?= $row["nama_buku"]; ?></td>
		    <td><?= $row["deskripsi"]; ?></td>
		</tr>
		<?php $i++; ?>
	<?php endforeach; ?>

	</table>

</body>
</html>