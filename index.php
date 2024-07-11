<?php
ob_start();
require_once "conn.php";
session_start();

if (isset($_SESSION['user_id'])) {
    $user_logged = mysqli_fetch_array((mysqli_query($mysqli, "SELECT * FROM user WHERE id='$_SESSION[user_id]'")));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Poliklinik</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="py-5">
    <header>
        <nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
            <div class="container container-fluid">
                <a class="navbar-brand" href="#">
                    Sistem Informasi Poliklinik
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?= (!isset($_GET['page'])) ? 'active' : '' ?>" aria-current="page" href="index.php">
                                Home
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?= (isset($_GET['page']) && ($_GET['page'] == 'pasien' || $_GET['page'] == 'dokter')) ? 'active' : '' ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Data Master
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="index.php?page=dokter">
                                        Dokter
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="index.php?page=pasien">
                                        Pasien
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="index.php?page=obat">
                                        Obat
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= (isset($_GET['page']) && $_GET['page'] == 'periksa') ? 'active' : '' ?>" href="index.php?page=periksa">
                                Periksa
                            </a>
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (!isset($_SESSION['log'])) { ?>
                        <li class="nav-item"><a class="nav-link <?= (isset($_GET['page']) && $_GET['page'] == 'register') ? 'active' : '' ?>" href="index.php?page=register"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                                </svg> Sign Up</a></li>
                        <li class="nav-item"><a class="nav-link <?= (isset($_GET['page']) && $_GET['page'] == 'login') ? 'active' : '' ?>" href="index.php?page=login"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                                </svg> Login</a></li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <span class="nav-link">Hallo, <?= $user_logged['username'] ?></span>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>



    <main role="main" class="container">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];

            if (isset($_SESSION['log'])) {
        ?>
                <h2 class="text-primary mt-5 d-flex justify-content-center"><?php echo ucwords($_GET['page']) ?></h2>
                <?php
                include($page . ".php");
            } else {
                if ($page === 'login' || $page === 'register') {
                ?>
                    <h2 class="text-primary mt-5 d-flex justify-content-center"><?php echo ucwords($_GET['page']) ?></h2>
                <?php
                    include($page . ".php");
                } else {
                ?>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Akses dilarang, Silahkan Login!!!",
                            showConfirmButton: true
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php?page=login';
                            }
                        });
                    </script>
        <?php
                    exit;
                }
            }
        } else {
            echo "Selamat Datang di Sistem Informasi Poliklinik";
        }
        ?>
    </main>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        <?php
        if (isset($_GET['success']) && $_GET['success'] == 'true') {
        ?>
            Swal.fire({
                icon: "success",
                title: "Berhasil Login!!",
                text: "Selamat Datang di Sistem Informasi Poliklinik",
                timer: 2000
            });
        <?php
        }
        ?>
    </script>
</body>

</html>