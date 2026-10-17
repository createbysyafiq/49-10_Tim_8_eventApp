<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$judul     = trim($_POST['judul'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$kategori  = $_POST['kategori'] ?? '';
$silabus   = trim($_POST['silabus'] ?? '');
$durasi    = (int) ($_POST['durasi'] ?? 0);

if ($judul === '' || $deskripsi === '' || $silabus === ''
    || !in_array($kategori, ['Teknologi', 'Bisnis'], true) || $durasi < 1) {
    header('Location: index.php?galat=' . urlencode('Semua kolom wajib diisi dengan benar.'));
    exit;
}

$stmt = mysqli_prepare($koneksi,
    "INSERT INTO events (judul, deskripsi, kategori, silabus, durasi) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'ssssi', $judul, $deskripsi, $kategori, $silabus, $durasi);
mysqli_stmt_execute($stmt);

header('Location: index.php?pesan=' . urlencode('Event berhasil disimpan.'));
exit;