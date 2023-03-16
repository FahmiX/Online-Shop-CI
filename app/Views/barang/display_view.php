<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content'); ?>
<div class="container mt-4 mb-4">
    <div class="row row-cols-md-4 g-5">
        <?php foreach ($barang as $b) : ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= base_url('barang/' . $b['gambar_barang']) ?>" class="img-medium" alt="gambar barang">
                    <div class="card-body">
                        <h4 class="card-title">
                            <span class="badge bg-primary"><?= $b['nama_barang'] ?></span>
                        </h4>
                        <table class="table table-borderless">
                            <tr>
                                <td style="width: 15%">Stok</td>
                                <td>: 
                                    <span class="badge bg-success"><?= $b['stok_barang'] ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Harga</td>
                                <td>:
                                    <span class="badge bg-secondary">Rp<?= $b['harga_barang'] ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .img-medium {
        width: 286px;
        height: 250px;
        object-fit: cover;
    }
</style>
<?= $this->endSection(); ?>