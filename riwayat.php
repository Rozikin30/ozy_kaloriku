<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

$data = mysqli_query($conn,"
SELECT
    konsumsi.id,
    konsumsi.porsi,
    konsumsi.total_kalori,
    konsumsi.tanggal,
    makanan.nama_makanan
FROM konsumsi
JOIN makanan
ON konsumsi.makanan_id = makanan.id
WHERE konsumsi.user_id = '$user_id'
ORDER BY konsumsi.tanggal DESC, konsumsi.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Riwayat Konsumsi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background:#f4f7fc;
}

.sidebar{
    position:fixed;
    left:0;
    top:0;
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
    border-radius:12px;
    margin-bottom:10px;
}

.sidebar a:hover{
    background:rgba(255,255,255,.2);
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

.table th{
    background:#22c55e;
    color:white;
}

</style>

</head>
<body>

<div class="sidebar">

<h3>🥗 KaloriKu</h3>

<hr>

<a href="dashboard.php">
<i class="bi bi-house-door"></i>
Dashboard
</a>

<a href="makanan.php">
<i class="bi bi-egg-fried"></i>
Data Makanan
</a>

<a href="tambah_makanan.php">
<i class="bi bi-plus-circle"></i>
Tambah Makanan
</a>

<a href="konsumsi.php">
<i class="bi bi-cup-hot"></i>
Konsumsi Harian
</a>

<a href="riwayat.php">
<i class="bi bi-clock-history"></i>
Riwayat
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

<h4 class="mb-0">
<i class="bi bi-clock-history"></i>
 Riwayat Konsumsi Makanan
</h4>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>
<th width="60">No</th>
<th>Nama Makanan</th>
<th>Porsi</th>
<th>Total Kalori</th>
<th>Tanggal</th>
</tr>

</thead>

<tbody>

<?php
$no = 1;

if(mysqli_num_rows($data) > 0){

while($row = mysqli_fetch_assoc($data)){
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_makanan']; ?></td>

<td><?= $row['porsi']; ?></td>

<td><?= $row['total_kalori']; ?> kcal</td>

<td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>

</tr>

<?php
}
}else{
?>

<tr>
<td colspan="5" class="text-center">
Belum ada riwayat konsumsi makanan
</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>
</html>