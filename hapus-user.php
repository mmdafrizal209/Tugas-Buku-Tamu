<?php
require_once 'function.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (hapus_user($id) > 0) {
        echo "<script>alert('Data Berhasil Dihapus!')</script>";
        echo "<script>window.location.href='user.php'</script>";
    } else {
        echo "<script>alert('Data Gagal di hapus!')</script>";
        echo "<script>window.location.href='user.php'</script>";
    }
}
