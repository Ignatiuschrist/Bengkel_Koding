<?php
if (isset($_POST['simpan'])) {
    $id_pasien = $_POST['pasien'];
    $id_dokter = $_POST['dokter'];
    $tgl_periksa = $_POST['tgl_periksa'];
    $catatan = $_POST['catatan'];
    $obat = $_POST['obat'];

    $obat_string = implode(',', $obat);

    if (!isset($_GET['id'])) {
        $query = "INSERT INTO periksa (id_pasien, id_dokter, tgl_periksa, catatan, obat) VALUES ('$id_pasien', '$id_dokter', '$tgl_periksa', '$catatan', '$obat_string')";
    } else {
        $query = "UPDATE `periksa` SET `id_pasien` = '$id_pasien', `id_dokter` = '$id_dokter', `tgl_periksa` = '$tgl_periksa', `catatan` = '$catatan', `obat` = '$obat' WHERE id='" . $_GET['id'] . "'";
    }
    $result = mysqli_query($mysqli, $query);

    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data Berhasil Disimpan',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'http://localhost:6969/bengkel-koding/index.php?page=periksa';
                }
            });
        </script>";
    } else {
        echo "Terjadi kesalahan saat menambahkan data periksa: " . mysqli_error($mysqli);
    }
}

if (isset($_GET['aksi'])) {
    $query = "DELETE FROM `periksa` WHERE id='" . $_GET['id'] . "'";
    $result = mysqli_query($mysqli, $query);
    
    if ($result) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data Berhasil Dihapus',
                icon: 'success'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'http://localhost:6969/bengkel-koding/index.php?page=periksa';
                }
            });
        </script>";
    } else {
        echo "Terjadi kesalahan saat menghapus data periksa: " . mysqli_error($mysqli);
    }
}
?>

<div class="container">
    <div class="form-periksa">
        <form class="form row" method="POST" action="" name="myForm" onsubmit="return validateForm();">
            <?php
            if (isset($_GET['id'])) {
                $id_periksa = $_GET['id'];

                // Query ke database untuk mendapatkan data periksa berdasarkan ID
                $ambil_data_periksa = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id = '$id_periksa'");
                $data_periksa = mysqli_fetch_assoc($ambil_data_periksa);

                // Pastikan data periksa ada sebelum mencoba mengakses nilai-nilainya
                if ($data_periksa) {
                    $id_pasien2 = $data_periksa['id_pasien'];
                    $id_dokter2 = $data_periksa['id_dokter'];
                    $tgl_periksa2 = $data_periksa['tgl_periksa'];
                    $catatan2 = $data_periksa['catatan'];
                    $obat2 = $data_periksa['obat'];
                } else {
                    $id_pasien2 = '';
                    $id_dokter2 = '';
                    $tgl_periksa2 = '';
                    $catatan2 = '';
                    $obat2 = '';
                }
            ?>
            <input type="hidden" name="id" value="<?php echo $id_periksa ?>">
            <?php
            }
            ?>
            <div class="col mt-3">
                <div class="form-input mt-3">
                    <label for="pasien" class="sr-only fw-bold">Pasien</label>
                    <select class="form-control" name="pasien" id="pasien" required>
                        <option value="" disabled selected>Pilih Pasien</option>
                        <?php
                        $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
                        while ($data = mysqli_fetch_array($pasien)) {
                            if (!isset($_GET['id'])) {
                                $selected = ($data['id'] == $id_pasien) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?>
                        </option>
                        <?php
                            } else {
                                $selected = ($data['id'] == $id_pasien2) ? 'selected="selected"' : '';
                            ?>
                        <option value="<?php echo $id_pasien2 ?>" <?php echo $selected ?>><?php echo $data['nama'] ?>
                        </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-input mt-3">
                    <label for="dokter" class="sr-only fw-bold">Dokter</label>
                    <select class="form-control" name="dokter" id="dokter" required>
                        <option value="" disabled selected>Pilih Dokter</option>
                        <?php
                        $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");
                        while ($data = mysqli_fetch_array($dokter)) {
                            if (!isset($_GET['id'])) {
                                $selected = ($data['id'] == $id_dokter) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?>
                        </option>
                        <?php
                            } else {
                                $selected = ($data['id'] == $id_dokter2) ? 'selected="selected"' : '';
                            ?>
                        <option value="<?php echo $id_dokter2 ?>" <?php echo $selected ?>><?php echo $data['nama'] ?>
                        </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-input mt-3">
                    <label for="tgl_periksa" class="fw-bold">
                        Tanggal Periksa
                    </label>
                    <input type="datetime-local" class="form-control" name="tgl_periksa" id="tgl_periksa"
                        placeholder="Tanggal Periksa" value="<?php echo isset($tgl_periksa2) ? $tgl_periksa2 : ''; ?>"
                        required>
                </div>
                <div class="form-input mt-3">
                    <label for="catatan" class="fw-bold">
                        Catatan
                    </label>
                    <input type="text" class="form-control" name="catatan" id="catatan" placeholder="Catatan"
                        value="<?php echo isset($catatan2) ? $catatan2 : ''; ?>" required>
                </div>
                <div class="form-input mt-3">
                    <label for="obat" class="sr-only fw-bold">Obat</label>
                    <select class="form-control" name="obat[]" id="obat" multiple required>
                        <?php
                        $id_periksa = isset($_GET['id']) ? $_GET['id'] : 0;
                        $selected_obat = [];

                            if ($id_periksa > 0) {
                                $ambil_data_periksa = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id = '$id_periksa'");
                                $data_periksa = mysqli_fetch_assoc($ambil_data_periksa);
                                if ($data_periksa) {
                                    $selected_obat = explode(',', $data_periksa['obat']);
                                }
                            }

                        $obat = mysqli_query($mysqli, "SELECT * FROM obat");
                        while ($data = mysqli_fetch_array($obat)) {
                        $selected = in_array($data['id'], $selected_obat) ? 'selected="selected"' : '';
                        ?>
                        <option value="<?php echo $data['id']; ?>" <?php echo $selected; ?>>
                            <?php echo $data['nama_obat']; ?>
                        </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-3" name="simpan">Simpan</button>
            </div>
        </form>
        <br>
        <hr>
    </div>
</div>

<div class="table-periksa mt-3">
    <table class="table table-responsive">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Pasien</th>
                <th scope="col">Dokter</th>
                <th scope="col">Tanggal Periksa</th>
                <th scope="col">Catatan</th>
                <th scope="col">Obat</th>
                <th class="d-flex justify-content-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
    $result = mysqli_query($mysqli, "SELECT pr.*, d.nama AS 'nama_dokter', p.nama AS 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
    $no = 1;
    while ($data = mysqli_fetch_array($result)) {
        $obat_ids = explode(',', $data['obat']);
        $nama_obat = [];
    
        foreach ($obat_ids as $id) {
            $result_obat = mysqli_query($mysqli, "SELECT nama_obat FROM obat WHERE id='$id'");
            
            if ($result_obat && mysqli_num_rows($result_obat) > 0) {
                $row = mysqli_fetch_assoc($result_obat);
                $nama_obat[] = $row['nama_obat'];
            } else {
                // Handle case where obat with $id is not found
                $nama_obat[] = 'Obat tidak ditemukan';
            }
        }
    
        $nama_obat_string = implode(', ', $nama_obat);
        $nama_obat_string = implode(', ', $nama_obat);
    ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nama_pasien']; ?></td>
                <td><?php echo $data['nama_dokter']; ?></td>
                <td><?php echo $data['tgl_periksa']; ?></td>
                <td><?php echo $data['catatan']; ?></td>
                <td><?php echo $nama_obat_string; ?></td>
                <td class="d-flex justify-content-center gap-1">
                    <a class="btn btn-warning rounded-pill px-3"
                        href="index.php?page=periksa&id=<?php echo $data['id']; ?>">Edit</a>
                    <a class="btn btn-danger rounded-pill px-3"
                        href="index.php?page=periksa&id=<?php echo $data['id']; ?>&aksi=hapus">Hapus</a>
                        <a class="btn btn-success rounded-pill px-3"
                        href="index.php?page=invoice&id=<?php echo $data['id']; ?>">Nota</a>
                </td>
            </tr>
            <?php
    }
    ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $('#obat').select2({
            placeholder: "Pilih Obat",
            allowClear: true
        });
    });
</script>
</div>