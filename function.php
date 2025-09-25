<?php
require_once('koneksi.php');

function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah_tamu($data)
{
    global $koneksi;

    // ambil ID terakhir
    $result = mysqli_query($koneksi, "SELECT * FROM bukutamu ORDER BY id_tamu DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $lastId = $row['id_tamu']; // contoh: zt006
        $num = (int) substr($lastId, 2) + 1;
        $kode = "zt" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $kode = "zt001";
    }

    $tanggal = date("Y-m-d");
    $nama_tamu = htmlspecialchars($data['nama_tamu']);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_hp = htmlspecialchars($data["no_hp"]);
    $bertemu = htmlspecialchars($data["bertemu"]);
    $kepentingan = htmlspecialchars($data["kepentingan"]);

    $gambar = upload_gambar();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO bukutamu 
              (id_tamu, tanggal, nama_tamu, alamat, no_hp, bertemu, kepentingan)
              VALUES ('$kode', '$tanggal', '$nama_tamu', '$alamat', '$no_hp','$bertemu', '$kepentingan')";
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    return mysqli_affected_rows($koneksi);
}

function ubah_tamu($data)
{
    global $koneksi;
    $id = htmlspecialchars($data['id_tamu']);
    $nama_tamu = htmlspecialchars($data['nama_tamu']);
    $alamat = htmlspecialchars($data['alamat']);
    $no_hp = htmlspecialchars($data['no_hp']);
    $bertemu = htmlspecialchars($data['bertemu']);
    $kepentingan = htmlspecialchars($data['kepentingan']);
    $gambarLama = htmlspecialchars($data['gambarLama']);

    if ($_FILES['gambar']['error'] == 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload_gambar();
        if (!$gambar) {
            return false;
        }
    }

    $query = "UPDATE bukutamu 
              SET nama_tamu= '$nama_tamu', alamat= '$alamat', no_hp= '$no_hp', 
                  bertemu='$bertemu', kepentingan= '$kepentingan', gambar = '$gambar' 
              WHERE id_tamu ='$id'";
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    return mysqli_affected_rows($koneksi);
}

function hapus_tamu($id)
{
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM bukutamu WHERE id_tamu = '$id'") or die(mysqli_error($koneksi));
    return mysqli_affected_rows($koneksi);
}

function tambah_user($data)
{
    global $koneksi;

    // ambil id terakhir
    $result = mysqli_query($koneksi, "SELECT id_user FROM users ORDER BY id_user DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $lastId = $row['id_user']; // contoh: U005
        $num = (int) substr($lastId, 1) + 1;
        $kode = "U" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $kode = "U001";
    }

    $username = htmlspecialchars($data['username']);
    $password = htmlspecialchars($data['password']);
    $user_role = htmlspecialchars($data['user_role']);

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (id_user, username, password, user_role) 
              VALUES ('$kode', '$username', '$password_hash', '$user_role')";
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    return mysqli_affected_rows($koneksi);
}

function ubah_user($data)
{
    global $koneksi;
    $kode = htmlspecialchars($data['id_user']);
    $username = htmlspecialchars($data['username']);
    $user_role = htmlspecialchars($data['user_role']);

    $query = "UPDATE users 
              SET username= '$username', user_role= '$user_role' 
              WHERE id_user ='$kode'";
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    return mysqli_affected_rows($koneksi);
}

function hapus_user($id)
{
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM users WHERE id_user = '$id'") or die(mysqli_error($koneksi));
    return mysqli_affected_rows($koneksi);
}

function ganti_password($data)
{
    global $koneksi;
    $kode = htmlspecialchars($data['id_user']);
    $password = htmlspecialchars($data['password']);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users 
              SET password= '$password_hash' 
              WHERE id_user ='$kode'";
    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    return mysqli_affected_rows($koneksi);
}

function upload_gambar()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang anda upload bukan gambar!');</script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>alert('Ukuran gambar terlalu besar!');</script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    move_uploaded_file($tmpName, 'assets/upload_gambar/' . $namaFileBaru);

    return $namaFileBaru;
}
