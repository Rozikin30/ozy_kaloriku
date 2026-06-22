<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['simpan'])){

    $nama_makanan = mysqli_real_escape_string(
        $conn,
        $_POST['nama_makanan']
    );

    $kalori = $_POST['kalori'];

    mysqli_query(
        $conn,
        "INSERT INTO makanan(
            nama_makanan,
            kalori
        ) VALUES(
            '$nama_makanan',
            '$kalori'
        )"
    );

    echo "
    <script>
        alert('Makanan berhasil ditambahkan');
        window.location='makanan.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Tambah Makanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background:#f4f7fc;
}

.sidebar{
    position:fixed;
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#22c55e,#15803d);
    color:white;
    padding:25px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:10px;
    margin-bottom:10px;
}

.sidebar a:hover{
    background:rgba(255,255,255,.15);
}

.content{
    margin-left:260px;
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
<i class="bi bi-egg-fried"></i>
Data Makanan
</a>

<a href="konsumsi.php">
<i class="bi bi-cup-hot"></i>
Konsumsi Harian
</a>

<a href="profil.php">
<i class="bi bi-person"></i>
Profil
</a>

<a href="logout.php">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

<div class="content">

<div class="card">

<div class="card-header bg-success text-white">

<h5 class="mb-0">
<i class="bi bi-plus-circle"></i>
Tambah Makanan
</h5>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label class="form-label">
Nama Makanan
</label>

<input
type="text"
name="nama_makanan"
class="form-control"
placeholder="Contoh: Nasi Putih"
required>

</div>

<div class="mb-3">

<label class="form-label">
Jumlah Kalori
</label>

<input
type="number"
name="kalori"
class="form-control"
placeholder="Contoh: 130"
required>

</div>

<button
type="submit"
name="simpan"
class="btn btn-success">

<i class="bi bi-save"></i>
 Simpan

</button>

<a
href="makanan.php"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>
 Kembali

</a>

</form>

</div>

</div>

</div>

</body>
</html>