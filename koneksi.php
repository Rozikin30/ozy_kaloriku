<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_kaloriku"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>