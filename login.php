<?php
session_start();
include "koneksi.php";

$error = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($query) > 0){

        $user = mysqli_fetch_assoc($query);

        if(password_verify($password,$user['password'])){

            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];

            header("Location: dashboard.php");
            exit();

        }else{
            $error = "Password yang Anda masukkan salah!";
        }

    }else{
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login - KaloriKu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#22c55e,#16a34a);
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-container{
    width:1000px;
    max-width:95%;
    background:#fff;
    border-radius:30px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.2);
}

.left-side{
    background:linear-gradient(135deg,#22c55e,#15803d);
    color:white;
    padding:60px;
    height:100%;
}

.logo{
    width:100px;
    height:100px;
    background:white;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:30px;
    color:#22c55e;
    font-size:50px;
}

.left-side h1{
    font-weight:700;
}

.left-side p{
    opacity:.9;
    line-height:30px;
}

.right-side{
    padding:60px;
}

.form-control{
    height:55px;
    border-radius:15px;
}

.btn-login{
    background:#22c55e;
    border:none;
    height:55px;
    border-radius:15px;
    font-weight:600;
}

.btn-login:hover{
    background:#16a34a;
}

.social-btn{
    border-radius:15px;
}

.error-box{
    background:#fee2e2;
    color:#dc2626;
    padding:10px;
    border-radius:10px;
    margin-bottom:15px;
}

@media(max-width:768px){

.left-side{
    display:none;
}

.right-side{
    padding:30px;
}

}

</style>
</head>
<body>

<div class="login-container">

<div class="row g-0">

<div class="col-md-6">

<div class="left-side d-flex flex-column justify-content-center">

<div class="logo">
<i class="bi bi-heart-pulse-fill"></i>
</div>

<h1>KaloriKu</h1>

<h4 class="mb-4">
Aplikasi Penghitung Kalori Modern
</h4>

<p>
Pantau kebutuhan kalori harian, kelola pola makan,
dan capai target kesehatan Anda dengan lebih mudah.
</p>

<div class="mt-4">
<i class="bi bi-check-circle-fill"></i> Hitung Kalori Otomatis
<br><br>
<i class="bi bi-check-circle-fill"></i> Statistik Harian
<br><br>
<i class="bi bi-check-circle-fill"></i> Riwayat Konsumsi
</div>

</div>

</div>

<div class="col-md-6">

<div class="right-side">

<h2 class="fw-bold mb-2">
Selamat Datang 👋
</h2>

<p class="text-muted mb-4">
Silakan login ke akun Anda
</p>

<?php if($error != ""){ ?>
<div class="error-box">
<?php echo $error; ?>
</div>
<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Email
</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-envelope"></i>
</span>

<input
type="email"
name="email"
class="form-control"
placeholder="Masukkan Email"
required>

</div>

</div>

<div class="mb-3">

<label class="form-label">
Password
</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-lock"></i>
</span>

<input
type="password"
name="password"
class="form-control"
placeholder="Masukkan Password"
required>

</div>

</div>

<div class="d-flex justify-content-between mb-3">

<div>
<input type="checkbox">
 Ingat Saya
</div>

<a href="#" class="text-success text-decoration-none">
Lupa Password?
</a>

</div>

<button
type="submit"
name="login"
class="btn btn-success btn-login w-100">

Masuk

</button>

</form>

<hr>

<div class="text-center">

<p>
Belum punya akun?
<a href="register.php" class="text-success fw-bold">
Daftar Sekarang
</a>
</p>

</div>

</div>

</div>

</div>

</div>

</body>
</html>