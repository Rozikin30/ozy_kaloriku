<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];


$target_kalori = 2000;

$qKalori = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT IFNULL(SUM(total_kalori),0) AS total
         FROM konsumsi
         WHERE user_id='$user_id'
         AND tanggal=CURDATE()"
    )
);

$kalori_hari_ini = $qKalori['total'];

$sisa_kalori = $target_kalori - $kalori_hari_ini;

if($sisa_kalori < 0){
    $sisa_kalori = 0;
}

$persentase = ($kalori_hari_ini / $target_kalori) * 100;

if($persentase > 100){
    $persentase = 100;
}
$grafik = [];

for($i=6;$i>=0;$i--){

    $tanggal = date(
        "Y-m-d",
        strtotime("-$i day")
    );

    $dataKalori = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT IFNULL(SUM(total_kalori),0) AS total
             FROM konsumsi
             WHERE user_id='$user_id'
             AND tanggal='$tanggal'"
        )
    );

    $grafik[] = $dataKalori['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard KaloriKu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

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

.logo{
    font-size:28px;
    font-weight:700;
    margin-bottom:30px;
}

.user-card{
    background:rgba(255,255,255,.15);
    padding:15px;
    border-radius:15px;
    margin-bottom:25px;
}

.menu a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:12px;
    margin-bottom:10px;
    transition:0.3s;
}

.menu a:hover{
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

.stat-card h2{
    font-weight:700;
}

.welcome{
    background:linear-gradient(135deg,#22c55e,#16a34a);
    color:white;
}

.progress{
    height:20px;
    border-radius:30px;
}

.food-item{
    padding:12px 0;
    border-bottom:1px solid #eee;
}

.food-item:last-child{
    border-bottom:none;
}

</style>

</head>
<body>

<div class="sidebar">

<div class="logo">
🥗 KaloriKu
</div>

<div class="user-card">

<h6 class="mb-1">
<?php echo $_SESSION['nama']; ?>
</h6>

<small>Pengguna Aktif</small>

</div>

<div class="menu">

<a href="dashboard.php">
<i class="bi bi-house-door"></i>
Dashboard


<a href="konsumsi.php">
    <i class="bi bi-cup-hot"></i>
    Konsumsi Harian
</a>

<a href="profil.php">
    <i class="bi bi-person"></i>
    Profil Saya
</a>

<a href="makanan.php">
    <i class="bi bi-egg-fried"></i>
    Data Makanan
</a>

</a>

<a href="tambah_makanan.php">
<i class="bi bi-plus-circle"></i>
Tambah Makanan
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

</div>

<div class="content">

<div class="card welcome mb-4">
<div class="card-body">

<h3>Selamat Datang 👋</h3>

<p class="mb-0">
Pantau kebutuhan kalori dan capai target kesehatanmu setiap hari.
</p>

</div>
</div>

<div class="row g-4">

<div class="col-md-4">

<div class="card stat-card">
<div class="card-body">

<h6>Target Kalori</h6>
<h2><?= $target_kalori ?> kcal</h2>

</div>
</div>

</div>

<div class="col-md-4">

<div class="card stat-card">
<div class="card-body">

<h6>Kalori Hari Ini</h6>
<h2><?= $kalori_hari_ini ?> kcal</h2>

</div>
</div>

</div>

<div class="col-md-4">

<div class="card stat-card">
<div class="card-body">

<h6>Sisa Kalori</h6>
<h2><?= $sisa_kalori ?> kcal</h2>

</div>
</div>

</div>

</div>

<div class="card mt-4">
<div class="card-body">

<h5>Progress Harian</h5>

<div class="progress mt-3">

<div
class="progress-bar bg-success"
style="width:<?php echo $persentase; ?>%">

<?php echo round($persentase); ?>%

</div>

</div>

</div>
</div>

<div class="row mt-4">

<div class="col-lg-8">

<div class="card">
<div class="card-body">

<h5>Grafik Kalori Mingguan</h5>

<canvas id="kaloriChart"></canvas>

</div>
</div>

</div>

<div class="col-lg-4">

<div class="card">
<div class="card-body">

<h5>Makanan Hari Ini</h5>

<div class="food-item">
🍚 Nasi Putih - 130 kcal
</div>

<div class="food-item">
🍗 Ayam Bakar - 280 kcal
</div>

<div class="food-item">
🍌 Pisang - 90 kcal
</div>

<div class="food-item">
🥛 Susu - 120 kcal
</div>

<div class="food-item">
🥚 Telur Rebus - 80 kcal
</div>

</div>
</div>

</div>

</div>

</div>

<script>

const ctx = document.getElementById('kaloriChart');

new Chart(ctx, {

type: 'line',

data: {

labels: [
'Sen',
'Sel',
'Rab',
'Kam',
'Jum',
'Sab',
'Min'
],

datasets: [{

label: 'Kalori',

data: <?= json_encode($grafik); ?>,

fill: true,
tension: 0.4

}]

}

});

</script>

</body>
</html>