<?php
if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    if (!isset($_GET['id'])) {
        $query = "INSERT INTO dokter (nama, alamat, no_hp) VALUES ('$nama', '$alamat', '$no_hp')";
    } else {
        $query = "UPDATE `dokter` SET `nama` = '$nama', `alamat` = '$alamat', `no_hp` = '$no_hp' WHERE id='" . $_GET['id'] . "'";
    }
    $result = mysqli_query($mysqli, $query);

    if ($result) {
<<<<<<< HEAD
        echo "<script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data dokter berhasil disimpan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location = 'http://localhost:6969/bengkel-koding/index.php?page=dokter';
                    });
                };
              </script>";
=======
        header("Location: http://poliklinik.test/index.php?page=dokter");
        exit;
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
    } else {
        echo "Terjadi kesalahan saat menambahkan data dokter: " . mysqli_error($mysqli);
    }
}

if (isset($_GET['aksi'])) {
    $query = "DELETE FROM `dokter` WHERE id='" . $_GET['id'] . "'";
    $result = mysqli_query($mysqli, $query);
<<<<<<< HEAD
    header("Location: http://localhost:6969/bengkel-koding/index.php?page=dokter");
=======
    header("Location: http://poliklinik.test/index.php?page=dokter");
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
}
?>

<div class="container">
    <div class="form-dokter">
        <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
            <?php
            $nama = '';
            $alamat = '';
            $no_hp = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $nama = $row['nama'];
                    $alamat = $row['alamat'];
                    $no_hp = $row['no_hp'];
                }
            ?>
<<<<<<< HEAD
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
=======
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
            <?php
            }
            ?>
            <div class="col mt-3">
                <div class="form-input mt-3">
                    <label for="nama" class="fw-bold">
                        Nama
                    </label>
<<<<<<< HEAD
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama"
                        value="<?php echo $nama ?>" required>
=======
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama ?>">
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
                </div>
                <div class="form-input mt-3">
                    <label for="alamat" class="fw-bold">
                        Alamat
                    </label>
<<<<<<< HEAD
                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat"
                        value="<?php echo $alamat ?>" required>
=======
                    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat ?>">
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
                </div>
                <div class="form-input mt-3">
                    <label for="no_hp" class="fw-bold">
                        No HP
                    </label>
<<<<<<< HEAD
                    <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No HP"
                        value="<?php echo $no_hp ?>" required>
=======
                    <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No HP" value="<?php echo $no_hp ?>">
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
                </div>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-3" name="simpan">Simpan</button>
            </div>
        </form>
        <br>
        <hr>
    </div>

    <div class="table-dokter mt-3">
        <table class="table table-responsive">
            <thead class="thead-dark">
                <tr>
<<<<<<< HEAD
                    <th scope="col">No.</th>
=======
                    <th scope="col">#</th>
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No HP</th>
                    <th class="d-flex justify-content-center">Action</th>
                </tr>
            </thead>
            <tbody>
<<<<<<< HEAD
    <?php
    $result = mysqli_query($mysqli, "SELECT * FROM dokter");
    $no = 1;
    while ($data = mysqli_fetch_array($result)) {
    ?>
    <tr>
        <td><?php echo $no++ ?></td>
        <td><?php echo $data['nama'] ?></td>
        <td><?php echo $data['alamat'] ?></td>
        <td><?php echo $data['no_hp'] ?></td>
        <td class="d-flex justify-content-center">
            <a class="btn btn-success rounded-pill px-3"
                href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
            <a id="deleteButton_<?php echo $data['id'] ?>" class="btn btn-danger rounded-pill px-3"
                href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
        </td>
    </tr>
    <script>
        document.getElementById('deleteButton_<?php echo $data['id'] ?>').addEventListener('click', function (event) {
            event.preventDefault();

            const url = this.href;

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan bisa mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    </script>
    <?php
    }
    ?>
</tbody>
=======
                <?php
                $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $data['nama'] ?></td>
                        <td><?php echo $data['alamat'] ?></td>
                        <td><?php echo $data['no_hp'] ?></td>
                        <td class="d-flex justify-content-center">
                            <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                            <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
>>>>>>> cad1485504fc1fed50a4d1a638f317c5988ad22a
        </table>
    </div>
</div>