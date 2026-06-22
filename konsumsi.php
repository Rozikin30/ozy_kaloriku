<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['simpan'])){

    $user_id = $_SESSION['id'];
    $makanan_id = $_POST['makanan_id'];
    $porsi = $_POST['porsi'];

    $makanan = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT * FROM makanan WHERE id='$makanan_id'"
        )
    );

    $total_kalori =
        $makanan['kalori'] * $porsi;

    mysqli_query($conn,"
        INSERT INTO konsumsi(
            user_id,
            makanan_id,
            porsi,
            total_kalori,
            tanggal
        )
        VALUES(
            '$user_id',
            '$makanan_id',
            '$porsi',
            '$total_kalori',
            CURDATE()
        )
    ");

    echo "
    <script>
        alert('Data berhasil disimpan');
        window.location='konsumsi.php';
    </script>
    ";
}

$makanan = mysqli_query(
$conn,
"SELECT * FROM makanan ORDER BY nama_makanan ASC"
);

$data = mysqli_query($conn,"
SELECT
konsumsi.*,
makanan.nama_makanan
FROM konsumsi
JOIN makanan
ON konsumsi.makanan_id=makanan.id
WHERE konsumsi.user_id='".$_SESSION['id']."'
ORDER BY konsumsi.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Konsumsi Harian</title>

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
background:#22c55e;
padding:20px;
color:white;
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

</style>

</head>
<body>

<div class="sidebar">

<h3>🥗 KaloriKu</h3>

<hr>

<a href="dashboard.php">
Dashboard
</a>

<a href="makanan.php">
Data Makanan
</a>

<a href="konsumsi.php">
Konsumsi Harian
</a>

<a href="profil.php">
Profil
</a>

<a href="logout.php">
Logout
</a>

</div>

<div class="content">

<div class="card mb-4">

<div class="card-header bg-success text-white">
Tambah Konsumsi
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Makanan</label>

<select
name="makanan_id"
class="form-control"
required>

<option value="">
Pilih Makanan
</option>

<?php while($m=mysqli_fetch_assoc($makanan)){ ?>

<option value="<?= $m['id']; ?>">

<?= $m['nama_makanan']; ?>

(<?= $m['kalori']; ?> kcal)

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Jumlah Porsi</label>

<input
type="number"
name="porsi"
class="form-control"
required>

</div>

<button
name="simpan"
class="btn btn-success">

Simpan

</button>

</form>

</div>

</div>

<div class="card">

<div class="card-header bg-primary text-white">

Riwayat Konsumsi

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>No</th>
<th>Makanan</th>
<th>Porsi</th>
<th>Total Kalori</th>
<th>Tanggal</th>

</tr>

<?php

$no=1;

while($row=mysqli_fetch_assoc($data)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_makanan']; ?></td>

<td><?= $row['porsi']; ?></td>

<td><?= $row['total_kalori']; ?> kcal</td>

<td><?= $row['tanggal']; ?></td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</body>
</html>