<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content'); ?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/styles/keranjang_display.css">

<div class="container mt-4 mb-4">
    <h3 style="text-align: center;">Histori Transaksi</h3>
    <br>
    <table class="table table-custom table-bordered border-dark border-5">
        <thead class="align-middle">
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Nama</th>
                <th>Nomor HP</th>
                <th>Alamat</th>
                <th>Kecamatan</th>
                <th>Kota</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $total = 0; ?>
            <?php foreach ($transaksi as $t) : ?>
                <tr class="align-middle">
                    <td style="text-align: center; width: 20px;"><?= $no++ ?></td>
                    <td style="text-align: center; width: 50px;"><?= $t['id_transaksi'] ?></td>
                    <td><?= $t['nama'] ?></td>
                    <td><?= $t['hp'] ?></td>
                    <td><?= $t['alamat'] ?></td>
                    <td><?= $t['kecamatan'] ?></td>
                    <td><?= $t['kota'] ?></td>
                    <td>Rp<?= number_format($t['total_transaksi'], 0, ',', '.') ?></td>
                    <td style="text-align: center">
                        <a href="<?= base_url('transaksi/detail/' . $t['id_transaksi']) ?>" class="btn btn-primary">Detail</a>
                        <a href="<?= base_url('transaksi/hapus/' . $t['id_transaksi']) ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
</style>

<script>
</script>

<?= $this->endSection(); ?>