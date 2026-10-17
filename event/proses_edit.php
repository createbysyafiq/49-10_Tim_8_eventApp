<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id        = (int) ($_POST['id'] ?? 0);
$judul     = trim($_POST['judul'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$kategori  = $_POST['kategori'] ?? '';
$silabus   = trim($_POST['silabus'] ?? '');
$durasi    = (int) ($_POST['durasi'] ?? 0);

if ($id < 1 || $judul === '' || $deskripsi === '' || $silabus === ''
    || !in_array($kategori, ['Teknologi', 'Bisnis'], true) || $durasi < 1) {
    header('Location: index.php?galat=' . urlencode('Data tidak valid, perubahan tidak disimpan.'));
    exit;
}

$stmt = mysqli_prepare($koneksi,
    "UPDATE events SET judul = ?, deskripsi = ?, kategori = ?, silabus = ?, durasi = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'ssssii', $judul, $deskripsi, $kategori, $silabus, $durasi, $id);
mysqli_stmt_execute($stmt);

header('Location: index.php?pesan=' . urlencode('Event berhasil diperbarui.'));
exit;