<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content'); ?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/styles/keranjang_display.css">

<div class="container mt-4 mb-4">
    <h3 style="text-align: center;">Detail Histori Transaksi</h3>

    <!-- Button Kembali -->
    <a href="<?= base_url('transaksi') ?>" class="btn btn-primary mb-3">Kembali</a>

    <br>
    <table class="table table-custom table-bordered border-dark border-5">
        <thead class="align-middle">
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>ID Barang</th>
                <th>Jumlah Jual</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $total = 0; ?>
            <?php foreach ($jual as $j) : ?>
                <tr class="align-middle">
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td style="text-align: center;"><?= $j['id_transaksi'] ?></td>
                    <td style="text-align: center;"><?= $j['id_barang'] ?></td>
                    <td style="text-align: center;"><?= $j['jumlah_jual'] ?></td>
                    <td>Rp<?= number_format($j['harga_jual'], 0, ',', '.') ?></td>
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