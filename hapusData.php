<?php
// File ini digunakan untuk menghapus data dari tabel kendaraan

// Koneksi ke database (sesuaikan dengan konfigurasi database Anda)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "toko_mobil";

$koneksi = new mysqli($host, $user, $pass, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mendapatkan ID yang akan dihapus dari request POST
$idHapus = json_decode(file_get_contents('php://input'), true)['id'];

// Menghapus data dari tabel kendaraan
$query = "DELETE FROM kendaraan WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $idHapus);
$stmt->execute();

// Tutup koneksi
$stmt->close();
$koneksi->close();

// Mengembalikan pesan sukses dalam format JSON
header('Content-Type: application/json');
echo json_encode(['status' => 'sukses']);
?>
