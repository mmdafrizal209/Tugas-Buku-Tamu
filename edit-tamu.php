<?php
require_once 'koneksi.php';
require_once 'function.php';
include_once('templates/header.php');
if (isset($_GET['id'])) {
    $id_tamu = $_GET['id'];
    $data = query("SELECT * FROM buku_tamu WHERE id_Tamu= '$id_tamu'")[0];
}
?>

<h1 class="h3 mb-4 text-gray-800"> Ubah Data</h1>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6>Data Tamu</h6>
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_tamu" id="id_tamu" value="<?= $id_tamu ?>">
            <div class="form-group-row">
                <label for="nama_tamu" class="col-sm-3 col-form-label">Nama Tamu</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama_tamu" name="nama_tamu" value="<?= $data['nama_tamu'] ?>">
                </div>
            </div>
            <div class="form-group-row">
                <label for="nama_tamu" class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="alamat" name="alamat" value="<?= $data['alamat'] ?>"></textarea>
                </div>
            </div>
            <div class="form-group-row">
                <label for="nama_tamu" class="col-sm-3 col-form-label">No. Telepon</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $data['no_hp'] ?>">
                </div>
            </div>
            <div class="form-group-row">
                <label for="nama_tamu" class="col-sm-3 col-form-label">bertemu dg.</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="bertemu" name="bertemu" value="<?= $data['bertemu'] ?>">
                </div>
            </div>
            <div class="form-group-row">
                <label for="nama_tamu" class="col-sm-3 col-form-label">kepentingan</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="kepentingan" name="kepentingan" value="<?= $data['kepentingan'] ?>">
                </div>
            </div>
            <div class="form-group-row">
                <label for="gambar" class="col-sm-3 col-form-label">Gambar Foto</label>
                <div class="col-sm-8">
                    <img src="assets/upload_gambbar/<?= $data['gambar']; ?>" alt="" width="30%">
                    <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
            </div>

            <div class="form-group-row">
                <label for="nama_tamu" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-8 d-flex justify-content-end">
                    <div>
                        <a type="button" class="btn btn-danger btn-icon-split" href="buku-tamu.php">
                            <span class="icon text-white-50">
                                <i class="fas fa-chervron-left"></i>
                            </span>
                            <span class="text">Kembali</span>
                        </a>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<?php
include_once('templates/footer.php');
?>
<?php
if (isset($_POST['simpan'])) {
    if (ubah_tamu($_POST) > 0) {
?>

        <div class="alert alert-succes" role="start">
            Data berhasil Diubah!
        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-danger" role="start">
            Data gagal Diubah!
        </div>
<?php
    }
}

?>