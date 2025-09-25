<?php
require_once('function.php');
include_once('koneksi.php');
include_once('templates/header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Buku Tamu</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tamu</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Tamu</th>
                            <th>Alamat</th>
                            <th>No. Telp/HP</th>
                            <th>Bertemu Dengan</th>
                            <th>Kepentingan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $buku_tamu = query("SELECT * FROM buku_tamu ORDER BY tanggal DESC");
                        foreach ($buku_tamu as $tamu) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $tamu['tanggal']; ?></td>
                                <td><?= $tamu['nama_tamu']; ?></td>
                                <td><?= $tamu['alamat']; ?></td>
                                <td><?= $tamu['no_hp']; ?></td>
                                <td><?= $tamu['bertemu']; ?></td>
                                <td><?= $tamu['kepentingan']; ?></td>
                                <td>
                                    <a href="ubah-tamu.php?id=<?= $tamu['id_tamu']; ?>" class="btn btn-success btn-sm">Ubah</a>
                                    <a href="hapus-tamu.php?id=<?= $tamu['id_tamu']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include_once('templates/footer.php'); 
?>