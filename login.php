<?php
// login
try {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        // cocokin dengan db, mencari datanya ada atau ga
        $cekdatabase = mysqli_query($mysqli, "SELECT * FROM user where username='$username' and password='$password'");
        //hitung jumlah data
        $hitung = mysqli_num_rows($cekdatabase);
        if ($hitung > 0) {
            $_SESSION['log'] = 'True';
            $data = mysqli_fetch_array($cekdatabase);
            $_SESSION['user_id'] = $data['id'];
            header('location:index.php?success=true');
        } else {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Username atau Password salah!!!",
                        timer: 2000
                    })
                </script>';
        }
    };

    if (!isset($_SESSION['log'])) {
    } else {
        header('index.php?page=login');
    }
} catch (\Throwable $th) {
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "Username atau Password salah!!!",
                timer: 2000
            })
        </script>';
}
?>
<div class="container mt-5">
    <form method="post">
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
        </div>
        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <input type="submit" name="login" class="btn btn-primary btn-lg btn-block w-100">
        <p class="mt-3 text-secondary text-center">Dont have an account? <a href="index.php?page=register" class="text-primary">Register</a></p>
    </form>
</div>

<script>
    <?php
    if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    ?>
        Swal.fire({
            icon: "success",
            title: "Berhasil Logout!!",
            timer: 2000
        });
    <?php
    }
    ?>
</script>