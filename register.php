<?php
include "koneksi.php";

if(isset($_POST['daftar'])){

    $nama = $_POST['nama'];
    $email = $_POST['email'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    mysqli_query($conn,
        "INSERT INTO users(nama,email,password)
        VALUES('$nama','$email','$password')"
    );

    echo "<script>
            alert('Registrasi Berhasil');
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
</head>
<body>

<h2>Register KaloriKu</h2>

<form method="POST">

<input type="text" name="nama" placeholder="Nama" required><br><br>

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<button name="daftar">
Daftar
</button>

</form>

</body>
</html>