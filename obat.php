<?php
if (isset($_POST['simpan'])) {

    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'];
    $harga = $_POST['harga'];

    if (!isset($_GET['id'])) {
        $query = "INSERT INTO obat (nama_obat, kemasan, harga) VALUES ('$nama_obat', '$kemasan', '$harga')";
    } else {
        $query = "UPDATE `obat` SET `nama_obat` = '$nama_obat', `kemasan` = '$kemasan', `harga` = '$harga' WHERE id='" . $_GET['id'] . "'";
    }
    $result = mysqli_query($mysqli, $query);

    if ($result) {
<<<<<<< HEAD
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data Obat Berhasil Disimpan',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    window.location.href = 'http://localhost:6969/bengkel-koding/index.php?page=obat';
                }
            });
        </script>";
=======
        header("Location: http://poliklinik.test/index.php?page=obat");
        exit;
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
    } else {
        echo "Terjadi kesalahan saat menambahkan data obat: " . mysqli_error($mysqli);
    }
}

if (isset($_GET['aksi'])) {
    $query = "DELETE FROM `obat` WHERE id='" . $_GET['id'] . "'";
    $result = mysqli_query($mysqli, $query);
<<<<<<< HEAD
    
    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data Obat Berhasil Dihapus',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed || result.isDismissed) {
                    window.location.href = 'http://localhost:6969/bengkel-koding/index.php?page=obat';
                }
            });
        </script>";
    } else {
        echo "Terjadi kesalahan saat menghapus data obat: " . mysqli_error($mysqli);
    }
}
?>


=======
    header("Location: http://poliklinik.test/index.php?page=obat");
}
?>

>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
<div class="container">
    <div class="form-obat">
        <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
            <?php
            $nama_obat = '';
            $kemasan = '';
            $harga = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM obat WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $nama_obat = $row['nama_obat'];
                    $kemasan = $row['kemasan'];
                    $harga = $row['harga'];
                }
            ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php
            }
            ?>
            <div class="col mt-3">
                <div class="form-input mt-3">
                    <label for="nama_obat" class="fw-bold">
                        Nama Obat
                    </label>
                    <input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" value="<?php echo $nama_obat ?>">
                </div>
                <div class="form-input mt-3">
                    <label for="kemasan" class="fw-bold">
                        Kemasan
                    </label>
                    <input type="text" class="form-control" name="kemasan" id="kemasan" placeholder="Kemasan" value="<?php echo $kemasan ?>">
                </div>
                <div class="form-input mt-3">
                    <label for="harga" class="fw-bold">
                        Harga
                    </label>
                    <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga ?>" required>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-3" name="simpan">Simpan</button>
            </div>
        </form>
        <br>
        <hr>
    </div>

    <div class="table-obat mt-3">
        <table class="table table-responsive">
            <thead class="thead-dark">
                <tr>
<<<<<<< HEAD
                    <th scope="col">No.</th>
=======
                    <th scope="col">#</th>
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
                    <th scope="col">Nama Obat</th>
                    <th scope="col">Kemasan</th>
                    <th scope="col">Harga</th>
                    <th class="d-flex justify-content-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($mysqli, "SELECT * FROM obat");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $data['nama_obat'] ?></td>
                        <td><?php echo $data['kemasan'] ?></td>
                        <td><?php echo $data['harga'] ?></td>
                        <td class="d-flex justify-content-center">
                            <a class="btn btn-success rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>">Ubah</a>
                            <a class="btn btn-danger rounded-pill px-3" href="index.php?page=obat&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>