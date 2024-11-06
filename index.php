<?php
// Nyambung menyang config.php
include 'migrate.php';
include 'config.php';
$sukses = "";

// Tambah Item
if (isset($_POST['add'])) {
    $jeneng_item = $_POST['nama_item'];
    $rega = $_POST['harga'];

    $stmt = $conn->prepare("INSERT INTO biaya_items (nama_item, harga) VALUES (?, ?)");
    $stmt->execute([$jeneng_item, $rega]);
    $sukses = "tambah";
    header("Location: ?sukses=tambah");
    exit();
}

// Hapus Item
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM biaya_items WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ?sukses=hapus");
    exit();
}

// Nganyari Item
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $jeneng_item = $_POST['nama_item'];
    $rega = $_POST['harga'];

    $stmt = $conn->prepare("UPDATE biaya_items SET nama_item = ?, harga = ? WHERE id = ?");
    $stmt->execute([$jeneng_item, $rega, $id]);
    header("Location: ?sukses=nganyari");
    exit();
}

// Ngeculake Data Item
$stmt = $conn->prepare("SELECT * FROM biaya_items");
$stmt->execute();
$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nglakoni Total Rega
$total_re = array_sum(array_column($barang, 'harga'));

// Ambil nilai sukses dari parameter URL jika ada
$sukses = $_GET['sukses'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Biaya Pasang Biled Scoopy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Lebokne Jeneng Lan Rego</h2>
        <form action="" method="POST" class="d-flex mb-3">
            <input type="text" name="nama_item" placeholder="Jeneng Item" class="form-control me-2" required autocomplete="off">
            <input type="number" name="harga" placeholder="Rego Item" class="form-control me-2" required autocomplete="off">
            <button type="submit" name="add" class="btn btn-success">+</button>
        </form>

        <h3 class="text-center">Biaya Pasang Biled Scoopy</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jeneng Item</th>
                    <th>Rega</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($barang)): ?>
                    <tr>
                        <td colspan="3" class="text-center">Data ora ditemokake</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($barang as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama_item']) ?></td>
                            <td>RP <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td class="d-flex justify-content-between">
                                <button class="btn btn-warning btn-sm" onclick="showEditModal(<?= $item['id'] ?>, '<?= htmlspecialchars($item['nama_item']) ?>', <?= $item['harga'] ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $item['id'] ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-center fw-bold">Total Rega: Rp <?= number_format($total_re, 0, ',', '.') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Sunting -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Sunting Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-nama-item" class="form-label">Jeneng Item</label>
                            <input type="text" name="nama_item" id="edit-nama-item" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-harga" class="form-label">Rego</label>
                            <input type="number" name="harga" id="edit-harga" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Rasido</button>
                        <button type="submit" name="update" class="btn btn-primary">Simpen Ganti</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Fungsi kanggo nampilake modal sunting
        function showEditModal(id, namaItem, harga) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama-item').value = namaItem;
            document.getElementById('edit-harga').value = harga;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        // Konfirmasi kanggo mbusak item
        function confirmDelete(id) {
            Swal.fire({
                title: 'Panjenengan yakin?',
                text: "Item bakal dihapus saklawase!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Njeh, hapus!',
                cancelButtonText: 'Rasido'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?delete=" + id;
                }
            });
        }

        // Pesen Sukses
        <?php if ($sukses == "tambah"): ?>
            Swal.fire('Sukses', 'Item kasil ditambah!', 'success');
        <?php elseif ($sukses == "hapus"): ?>
            Swal.fire('Sukses', 'Item kasil dihapus!', 'success');
        <?php elseif ($sukses == "nganyari"): ?>
            Swal.fire('Sukses', 'Item kasil diubah!', 'success');
        <?php endif; ?>
    </script>
</body>
</html>
