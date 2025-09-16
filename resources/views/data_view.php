<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Data List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-4">

    <h1>Data List</h1>

    <!-- Tabel Data -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Nama</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($allData as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td>
                    <a href="/data/edit/<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/data/delete/<?= $row['id'] ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('Yakin hapus data?');">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Form tambah data sederhana -->
    <form action="/data/save" method="post" class="mb-5">
        <input type="text" name="nama" placeholder="Nama baru" required />
        <button class="btn btn-primary">Tambah Data</button>
    </form>

</div>

<!-- Notifikasi Toast -->
<?php $notif = session()->getFlashdata('notification'); ?>
<?php if ($notif): ?>
<div aria-live="polite" aria-atomic="true" class="position-relative">
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-<?= esc($notif['status']) ?> text-white">
        <strong class="me-auto">Notifikasi</strong>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        <?= esc($notif['message']) ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('liveToast');
    if(toastEl) {
      var toast = new bootstrap.Toast(toastEl);
      toast.show();
    }
  });
</script>

</body>
</html>
