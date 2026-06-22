<?php
include "koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($conn,"
SELECT * FROM makanan
WHERE id='$id'
");

$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nama = $_POST['nama_makanan'];
    $kalori = $_POST['kalori'];

    mysqli_query($conn,"
        UPDATE makanan
        SET
        nama_makanan='$nama',
        kalori='$kalori'
        WHERE id='$id'
    ");

    header("Location: makanan.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Makanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="container mt-5">

<h3>Edit Makanan</h3>

<form method="POST">

<div class="mb-3">

<label>Nama Makanan</label>

<input
type="text"
name="nama_makanan"
class="form-control"
value="<?= $row['nama_makanan']; ?>">

</div>

<div class="mb-3">

<label>Kalori</label>

<input
type="number"
name="kalori"
class="form-control"
value="<?= $row['kalori']; ?>">

</div>

<button
name="update"
class="btn btn-success">

Update

</button>

<a
href="makanan.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</body>
</html>