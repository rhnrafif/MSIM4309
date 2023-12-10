<?php
header('Content-Type: application/json');

// Koneksi ke database (sesuaikan dengan konfigurasi database Anda)
$host = "http://localhost/phpmyadmin/index.php?route=/database/structure&db=toko_car";
$user = "root";
$pass = "";
$dbname = "toko_car";

$koneksi = new mysqli($host, $user, $pass, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Fungsi untuk mendapatkan data kendaraan
function getDataKendaraan($koneksi) {
    $query = "SELECT * FROM kendaraan";
    $result = $koneksi->query($query);

    $dataKendaraan = [];
    while ($row = $result->fetch_assoc()) {
        $dataKendaraan[] = $row;
    }

    return $dataKendaraan;
}

// Fungsi untuk menambah data kendaraan
function tambahDataKendaraan($koneksi, $data) {
    $query = "INSERT INTO kendaraan (nama_mobil, merk, warna, nopol, harga) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssssi", $data['nama_mobil'], $data['merk'], $data['warna'], $data['nopol'], $data['harga']);
    $stmt->execute();
    $idBaru = $stmt->insert_id;

    $stmt->close();

    return $idBaru;
}

// Fungsi untuk menghapus data kendaraan
function hapusDataKendaraan($koneksi, $id) {
    $query = "DELETE FROM kendaraan WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
}

// Handler untuk mendapatkan data kendaraan
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $dataKendaraan = getDataKendaraan($koneksi);
    echo json_encode($dataKendaraan);
}

// Handler untuk menambah data kendaraan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataBaru = json_decode(file_get_contents('php://input'), true);
    $idBaru = tambahDataKendaraan($koneksi, $dataBaru);
    echo json_encode(['id' => $idBaru]);
}

// Handler untuk menghapus data kendaraan
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $idHapus = json_decode(file_get_contents('php://input'), true)['id'];
    hapusDataKendaraan($koneksi, $idHapus);
    echo json_encode(['status' => 'sukses']);
}

$koneksi->close();
?>
