<?php
session_start();
require 'koneksi.php';

// kalau tombol login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            // simpan session
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['user_role'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - Buku Tamu</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card shadow-lg my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Login</h1>
                        </div>
                        <form method="post" class="user">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-user"
                                    placeholder="Masukkan Username..." required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user"
                                    placeholder="Masukkan Password..." required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>