<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

/* Hari Ini */
$hari = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total_kalori),0) as total
FROM konsumsi
WHERE user_id='$user_id'
AND tanggal=CURDATE()
"));

/* Minggu Ini */
$minggu = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total_kalori),0) as total
FROM konsumsi
WHERE user_id='$user_id'
AND YEARWEEK(tanggal,1)=YEARWEEK(CURDATE(),1)
"));

/* Bulan Ini */
$bulan = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total_kalori),0) as total
FROM konsumsi
WHERE user_id='$user_id'
AND MONTH(tanggal)=MONTH(CURDATE())
AND YEAR(tanggal)=YEAR(CURDATE())
"));

$label = [];
$dataKalori = [];

for($i=6;$i>=0;$i--){

    $tgl = date(
        'Y-m-d',
        strtotime("-$i day")
    );

    $namaHari = date(
        'd/m',
        strtotime($tgl)
    );

    $q = mysqli_fetch_assoc(
        mysqli_query($conn,"
        SELECT IFNULL(SUM(total_kalori),0) as total
        FROM konsumsi
        WHERE user_id='$user_id'
        AND tanggal='$tgl'
        ")
    );

    $label[] = $namaHari;
    $dataKalori[] = $q['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Statistik Kalori</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

.stat-card{
    text-align:center;
}

.stat-card h2{
    font-weight:bold;
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

<a href="riwayat.php">
<i class="bi bi-clock-history"></i>
Riwayat
</a>

<a href="statistik.php">
<i class="bi bi-bar-chart"></i>
Statistik
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

<h2 class="mb-4">
📊 Statistik Kalori
</h2>

<div class="row g-4">

<div class="col-md-4">

<div class="card stat-card">

<div class="card-body">

<h5>Hari Ini</h5>

<h2>
<?= number_format($hari['total']) ?>
</h2>

<p>kcal</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card stat-card">

<div class="card-body">

<h5>Minggu Ini</h5>

<h2>
<?= number_format($minggu['total']) ?>
</h2>

<p>kcal</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card stat-card">

<div class="card-body">

<h5>Bulan Ini</h5>

<h2>
<?= number_format($bulan['total']) ?>
</h2>

<p>kcal</p>

</div>

</div>

</div>

</div>

<div class="card mt-4">

<div class="card-header bg-success text-white">

Grafik Kalori 7 Hari Terakhir

</div>

<div class="card-body">

<canvas id="grafikKalori"></canvas>

</div>

</div>

</div>

<script>

const ctx =
document.getElementById('grafikKalori');

new Chart(ctx,{

type:'bar',

data:{

labels:
<?= json_encode($label); ?>,

datasets:[{

label:'Kalori',

data:
<?= json_encode($dataKalori); ?>,

borderWidth:1

}]

},

options:{

responsive:true,

plugins:{
legend:{
display:true
}
}

}

});

</script>

</body>
</html>