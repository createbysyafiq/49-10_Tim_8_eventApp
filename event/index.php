<?php
require_once '../koneksi.php';

$hasil = mysqli_query($koneksi, "SELECT id, judul, kategori, durasi FROM events ORDER BY id DESC");
$pesan = $_GET['pesan'] ?? '';
$galat = $_GET['galat'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Master Event</h1>

        <?php if ($pesan !== ''): ?>
            <p class="status ok"><?= htmlspecialchars($pesan) ?></p>
        <?php endif; ?>
        <?php if ($galat !== ''): ?>
            <p class="status err"><?= htmlspecialchars($galat) ?></p>
        <?php endif; ?>

        <div class="panel">
            <form action="proses_tambah.php" method="POST">
                <div class="form-group">
                    <label for="judul">Judul Event</label>
                    <input type="text" id="judul" name="judul" placeholder="Masukkan judul event" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi event" required></textarea>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required>
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="Teknologi">Teknologi</option>
                        <option value="Bisnis">Bisnis</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="silabus">Silabus</label>
                    <textarea id="silabus" name="silabus" rows="4" placeholder="Masukkan silabus/materi event" required></textarea>
                </div>

                <div class="form-group">
                    <label for="durasi">Durasi Sesi (menit)</label>
                    <input type="number" id="durasi" name="durasi" min="1" placeholder="Contoh: 90" required>
                    <p class="hint">Durasi dalam satuan menit.</p>
                </div>

                <button type="submit">Simpan Event</button>
            </form>
        </div>

        <div class="daftar">
            <h2>Daftar Event</h2>
            <div class="tabel-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Durasi (menit)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($baris = mysqli_fetch_assoc($hasil)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($baris['judul']) ?></td>
                                <td><?= htmlspecialchars($baris['kategori']) ?></td>
                                <td><?= (int) $baris['durasi'] ?></td>
                                <td class="aksi">
                                    <a href="edit.php?id=<?= (int) $baris['id'] ?>" class="btn-kecil">Edit</a>
                                    <form action="hapus.php" method="POST" class="form-hapus"
                                          onsubmit="return confirm('Hapus event ini?')">
                                        <input type="hidden" name="id" value="<?= (int) $baris['id'] ?>">
                                        <button type="submit" class="btn-kecil btn-hapus">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php if ($no === 1): ?>
                            <tr><td colspan="5" class="kosong">Belum ada event.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>