<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['simpan'])){

    $nama = $_POST['nama_makanan'];
    $kalori = $_POST['kalori'];

    mysqli_query($conn,"
        INSERT INTO makanan(nama_makanan,kalori)
        VALUES('$nama','$kalori')
    ");

    header("Location: makanan.php");
}

if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    mysqli_query($conn,"
        DELETE FROM makanan
        WHERE id='$id'
    ");

    header("Location: makanan.php");
}

$data = mysqli_query($conn,"
    SELECT * FROM makanan
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Data Makanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background:#f4f7fc;
}

.sidebar{
    width:250px;
    height:100vh;
    position:fixed;
    background:#22c55e;
    color:white;
    padding:20px;
}

.sidebar a{
    color:white;
    text-decoration:none;
    display:block;
    padding:10px;
    border-radius:10px;
    margin-bottom:10px;
}

.sidebar a:hover{
    background:rgba(255,255,255,.2);
}

.content{
    margin-left:250px;
    padding:30px;
}

.card{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
}

</style>

</head>
<body>

<div class="sidebar">

<h3>🥗 KaloriKu</h3>

<hr>

<a href="dashboard.php">
<i class="bi bi-house"></i>
Dashboard
</a>

<a href="makanan.php">
<i class="bi bi-plus-circle"></i>
Data Makanan
</a>

<a href="logout.php">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

<div class="content">

<div class="card mb-4">

<div class="card-header bg-success text-white">
Tambah Makanan
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Nama Makanan</label>

<input
type="text"
name="nama_makanan"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Jumlah Kalori</label>

<input
type="number"
name="kalori"
class="form-control"
required>

</div>

<button
type="submit"
name="simpan"
class="btn btn-success">

Simpan

</button>

</form>

</div>

</div>

<div class="card">

<div class="card-header bg-primary text-white">
Daftar Makanan
</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>
<th>No</th>
<th>Nama Makanan</th>
<th>Kalori</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

<?php
$no = 1;
while($row = mysqli_fetch_assoc($data)){
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_makanan']; ?></td>

<td><?= $row['kalori']; ?> kcal</td>

<td>

<a
href="edit_makanan.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="?hapus=<?= $row['id']; ?>"
onclick="return confirm('Yakin hapus?')"
class="btn btn-danger btn-sm">

Hapus

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>