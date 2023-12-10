<?php
// File ini digunakan untuk menambah data ke dalam tabel kendaraan

// Koneksi ke database (sesuaikan dengan konfigurasi database Anda)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "toko_mobil";

$koneksi = new mysqli($host, $user, $pass, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mendapatkan data dari request POST
$dataBaru = json_decode(file_get_contents('php://input'), true);

// Menyimpan data ke dalam tabel kendaraan
$query = "INSERT INTO kendaraan (nama_mobil, merk, warna, nopol, harga) VALUES (?, ?, ?, ?, ?)";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("ssssi", $dataBaru['nama_mobil'], $dataBaru['merk'], $dataBaru['warna'], $dataBaru['nopol'], $dataBaru['harga']);
$stmt->execute();
$idBaru = $stmt->insert_id;

// Tutup koneksi
$stmt->close();
$koneksi->close();

// Mengembalikan ID data baru dalam format JSON
header('Content-Type: application/json');
echo json_encode(['id' => $idBaru]);
?>
