<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];

if(isset($_POST['simpan'])){

    $umur = $_POST['umur'];
    $berat = $_POST['berat'];
    $tinggi = $_POST['tinggi'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $aktivitas = $_POST['aktivitas'];

    mysqli_query($conn,"
        UPDATE users SET
        umur='$umur',
        berat='$berat',
        tinggi='$tinggi',
        jenis_kelamin='$jenis_kelamin',
        aktivitas='$aktivitas'
        WHERE id='$id'
    ");

    echo "<script>
            alert('Profil berhasil diperbarui');
            window.location='profil.php';
          </script>";
}

$data = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT * FROM users WHERE id='$id'"
    )
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Profil Pengguna</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background:#f4f7fc;
}

.sidebar{
    width:260px;
    height:100vh;
    position:fixed;
    background:linear-gradient(180deg,#22c55e,#15803d);
    color:white;
    padding:25px;
}

.sidebar a{
    color:white;
    text-decoration:none;
    display:block;
    padding:12px;
    border-radius:12px;
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

<a href="profil.php">
<i class="bi bi-person"></i>
Profil Saya
</a>

<a href="logout.php">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

<div class="content">

<div class="card">

<div class="card-header bg-success text-white">
<h5 class="mb-0">Profil Pengguna</h5>
</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
<label>Nama</label>
<input
type="text"
class="form-control"
value="<?= $data['nama']; ?>"
readonly>
</div>

<div class="col-md-6 mb-3">
<label>Email</label>
<input
type="text"
class="form-control"
value="<?= $data['email']; ?>"
readonly>
</div>

<div class="col-md-6 mb-3">
<label>Umur</label>
<input
type="number"
name="umur"
class="form-control"
value="<?= $data['umur']; ?>">
</div>

<div class="col-md-6 mb-3">
<label>Berat Badan (Kg)</label>
<input
type="number"
name="berat"
class="form-control"
value="<?= $data['berat']; ?>">
</div>

<div class="col-md-6 mb-3">
<label>Tinggi Badan (Cm)</label>
<input
type="number"
name="tinggi"
class="form-control"
value="<?= $data['tinggi']; ?>">
</div>

<div class="col-md-6 mb-3">
<label>Jenis Kelamin</label>

<select
name="jenis_kelamin"
class="form-select">

<option value="L"
<?= ($data['jenis_kelamin']=='L') ? 'selected' : ''; ?>>
Laki-laki
</option>

<option value="P"
<?= ($data['jenis_kelamin']=='P') ? 'selected' : ''; ?>>
Perempuan
</option>

</select>

</div>

<div class="col-md-12 mb-3">

<label>Aktivitas Harian</label>

<select
name="aktivitas"
class="form-select">

<option value="Ringan"
<?= ($data['aktivitas']=='Ringan') ? 'selected' : ''; ?>>
Ringan
</option>

<option value="Sedang"
<?= ($data['aktivitas']=='Sedang') ? 'selected' : ''; ?>>
Sedang
</option>

<option value="Berat"
<?= ($data['aktivitas']=='Berat') ? 'selected' : ''; ?>>
Berat
</option>

</select>

</div>

</div>

<button
type="submit"
name="simpan"
class="btn btn-success">

<i class="bi bi-save"></i>
Simpan Profil

</button>

</form>

</div>

</div>

</div>

</body>
</html>