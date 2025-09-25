<?php
require_once 'function.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapus_tamu($id) > 0) {
        echo "<script>alert('Data Berhasil Dihapus!')</script>";
        echo "<script>window.location.href='buku-tamu.php'</script>";
    } else {
        echo "<script>alert('Data Gagal di hapus!')</script>";
    }
}
