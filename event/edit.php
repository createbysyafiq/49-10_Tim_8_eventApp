<?php
require_once '../koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($koneksi, "SELECT * FROM events WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$event = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$event) {
    header('Location: index.php?galat=' . urlencode('Event tidak ditemukan.'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Event</h1>

        <div class="panel">
            <form action="proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?= (int) $event['id'] ?>">

                <div class="form-group">
                    <label for="judul">Judul Event</label>
                    <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($event['judul']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required><?= htmlspecialchars($event['deskripsi']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required>
                        <?php foreach (['Teknologi', 'Bisnis'] as $pilihan): ?>
                            <option value="<?= $pilihan ?>" <?= $event['kategori'] === $pilihan ? 'selected' : '' ?>>
                                <?= $pilihan ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="silabus">Silabus</label>
                    <textarea id="silabus" name="silabus" rows="4" required><?= htmlspecialchars($event['silabus']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="durasi">Durasi Sesi (menit)</label>
                    <input type="number" id="durasi" name="durasi" min="1" value="<?= (int) $event['durasi'] ?>" required>
                    <p class="hint">Durasi dalam satuan menit.</p>
                </div>

                <button type="submit">Perbarui Event</button>
                <a href="index.php" class="btn-batal">Batal</a>
            </form>

            <form action="hapus.php" method="POST"
                  onsubmit="return confirm('Hapus event ini? Data tidak bisa dikembalikan.')">
                <input type="hidden" name="id" value="<?= (int) $event['id'] ?>">
                <button type="submit" class="btn-hapus">Hapus Event</button>
            </form>
        </div>
    </div>
</body>
</html>