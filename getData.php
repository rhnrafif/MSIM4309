<?php
// File ini digunakan untuk mengambil data dari tabel kendaraan

// Koneksi ke database (sesuaikan dengan konfigurasi database Anda)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "toko_mobil";

$koneksi = new mysqli($host, $user, $pass, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil data kendaraan
$query = "SELECT * FROM kendaraan";
$result = $koneksi->query($query);

// Fetch data sebagai array asosiatif
$dataKendaraan = [];
while ($row = $result->fetch_assoc()) {
    $dataKendaraan[] = $row;
}

// Tutup koneksi
$koneksi->close();

// Mengembalikan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($dataKendaraan);
?>
