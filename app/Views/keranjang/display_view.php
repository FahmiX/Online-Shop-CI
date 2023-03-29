<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content'); ?>
<div class="container mt-4 mb-4">
    <h3>Keranjang Belanja</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $total = 0; ?>
            <?php foreach ($keranjang as $k) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $k['nama_barang'] ?></td>
                    <td><?= $k['jumlah'] ?></td>
                    <td>Rp<?= number_format($k['harga_barang'], 0, ',', '.') ?></td>
                    <td>Rp<?= number_format($k['jumlah'] * $k['harga_barang'], 0, ',', '.') ?></td>
                    <td>
                        <a href="<?= base_url('keranjang/hapus/' . $k['id_barang']) ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php $total += $k['jumlah'] * $k['harga_barang']; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" align="right">Total</td>
                <td colspan="2"><strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
