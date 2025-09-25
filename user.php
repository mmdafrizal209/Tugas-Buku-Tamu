<?php
include_once('templates/header.php');
require_once('function.php');

// pengecekan user role bukan admin maka tidak boleh mengakses halaman 4

// // if (($_SESSION['role']) != 'admin') {

//     echo "<script>alert('anda tidak memiliki akses')</script>";
//     echo "<script>window.location.href='index.php'</script>";
// }

?>


<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Users</h1>

    <?php
    // Tambah user
    if (isset($_POST['simpan'])) {
        if (tambah_user($_POST) > 0) {
            echo '<div class="alert alert-success">Data berhasil disimpan!</div>';
        } else {
            echo '<div class="alert alert-danger">Data gagal disimpan!</div>';
        }
    }

    // Ganti password
    if (isset($_POST['ganti_password'])) {
        if (ganti_password($_POST) > 0) {
            echo '<div class="alert alert-success">Password berhasil diubah!</div>';
        } else {
            echo '<div class="alert alert-danger">Password gagal diubah!</div>';
        }
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary btn-icon-split"
                data-toggle="modal" data-target="#tambahModal">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah User</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>User Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $users = query("SELECT * FROM users");
                        foreach ($users as $user): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['user_role'] ?></td>
                                <td>
                                    <a class="btn btn-success" href="edit-user.php?id=<?= $user['id_user'] ?>">Ubah</a>
                                    <a onclick="return confirm('Yakin hapus?')"
                                        class="btn btn-danger"
                                        href="hapus-user.php?id=<?= $user['id_user'] ?>">Hapus</a>
                                    <!-- tombol buka modal ganti password -->
                                    <button type="button"
                                        class="btn btn-warning"
                                        data-toggle="modal"
                                        data-target="#gantipassword<?= $user['id_user'] ?>">
                                        Ganti Password
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal ganti password untuk user ini -->
                            <div class="modal fade" id="gantipassword<?= $user['id_user'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ganti Password (<?= $user['username'] ?>)</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                                <div class="form-group">
                                                    <label>Password Baru</label>
                                                    <input type="password" class="form-control" name="password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                                <button type="submit" name="ganti_password" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>User Role</label>
                        <select name="user_role" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('templates/footer.php'); ?>