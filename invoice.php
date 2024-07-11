<?php
ob_start();
require_once "conn.php";

if (isset($_SESSION['user_id'])) {
    $user_logged = mysqli_fetch_array((mysqli_query($mysqli, "SELECT * FROM user WHERE id='$_SESSION[user_id]'")));
}

// Pastikan parameter id ada dan aman
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID periksa tidak valid.");
}

$data_periksa_id = $_GET['id'];

// Mengambil data periksa
$query_periksa = "SELECT pr.*, p.nama AS nama_pasien, p.alamat AS alamat_pasien, p.no_hp AS no_hp_pasien, 
                        d.nama AS nama_dokter, d.alamat AS alamat_dokter, d.no_hp AS no_hp_dokter 
                  FROM periksa pr 
                  LEFT JOIN pasien p ON pr.id_pasien = p.id 
                  LEFT JOIN dokter d ON pr.id_dokter = d.id 
                  WHERE pr.id = '$data_periksa_id'";
$result_periksa = $mysqli->query($query_periksa);

// Memastikan data periksa ditemukan
if ($result_periksa && $result_periksa->num_rows > 0) {
    $data_periksa = $result_periksa->fetch_assoc();

    // Mengambil data obat
    $obat_list = [];
    if (!empty($data_periksa['obat'])) {
        $obat_ids = explode(',', $data_periksa['obat']);
        foreach ($obat_ids as $id) {
            $result_obat = $mysqli->query("SELECT nama_obat, harga FROM obat WHERE id='$id'");
            if ($result_obat && $result_obat->num_rows > 0) {
                $obat_list[] = $result_obat->fetch_assoc();
            }
        }
    }

    // Jasa dokter
    $jasa_dokter = 150000;

    // Menghitung total harga obat
    $total_obat = array_sum(array_column($obat_list, 'harga'));

    // Menghitung total invoice
    $total_invoice = $jasa_dokter + $total_obat;
} else {
    die("Data periksa tidak ditemukan.");
}
?>

<div style="max-width: 800px; margin: auto; background-color: #fff; padding: 30px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <table cellpadding="0" cellspacing="0" style="width: 100%; text-align: left;">
        <tr style="background-color: #f0f0f0;">
            <td colspan="2">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding-bottom: 20px; text-align: center;">
                            <h2 style="font-size: 24px; color: #333; margin: 0;">Invoice Nota</h2>
                        </td>
                        <td style="text-align: right;">
                            Nomor Periksa: <?php echo isset($data_periksa['id']) ? $data_periksa['id'] : ''; ?><br>
                            Tanggal Periksa: <?php echo isset($data_periksa['tgl_periksa']) ? $data_periksa['tgl_periksa'] : ''; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr style="background-color: #f9f9f9;">
            <td colspan="2">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding-bottom: 20px;">
                            <strong>Nama Pasien:</strong> <?php echo isset($data_periksa['nama_pasien']) ? $data_periksa['nama_pasien'] : ''; ?><br>
                            <strong>Alamat:</strong> <?php echo isset($data_periksa['alamat_pasien']) ? $data_periksa['alamat_pasien'] : ''; ?><br>
                            <strong>No. HP:</strong> <?php echo isset($data_periksa['no_hp_pasien']) ? $data_periksa['no_hp_pasien'] : ''; ?>
                        </td>
                        <td style="padding-bottom: 20px;">
                            <strong>Nama Dokter:</strong> <?php echo isset($data_periksa['nama_dokter']) ? $data_periksa['nama_dokter'] : ''; ?><br>
                            <strong>Alamat:</strong> <?php echo isset($data_periksa['alamat_dokter']) ? $data_periksa['alamat_dokter'] : ''; ?><br>
                            <strong>No. HP:</strong> <?php echo isset($data_periksa['no_hp_dokter']) ? $data_periksa['no_hp_dokter'] : ''; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr style="background-color: #f0f0f0; font-weight: bold;">
            <td style="padding: 10px; border-bottom: 1px solid #ccc;">Deskripsi</td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;">Harga</td>
        </tr>

        <tr style="background-color: #f9f9f9;">
            <td style="padding: 10px; border-bottom: 1px solid #ccc;">Jasa Dokter</td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;">Rp. <?php echo number_format($jasa_dokter, 2, ',', '.'); ?></td>
        </tr>

        <?php foreach ($obat_list as $obat) { ?>
        <tr style="background-color: #f9f9f9;">
            <td style="padding: 10px; border-bottom: 1px solid #ccc;"><?php echo $obat['nama_obat']; ?></td>
            <td style="padding: 10px; border-bottom: 1px solid #ccc;">Rp. <?php echo number_format($obat['harga'], 2, ',', '.'); ?></td>
        </tr>
        <?php } ?>

        <tr style="background-color: #f0f0f0; font-weight: bold;">
            <td style="padding: 10px;">Total:</td>
            <td style="padding: 10px;">Rp. <?php echo number_format($total_invoice, 2, ',', '.'); ?></td>
        </tr>
    </table>
</div>
