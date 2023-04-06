<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content'); ?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/styles/barang_display.css">

<div class="container mt-4 mb-4">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="row row-cols-md-4 g-5">
        <?php foreach ($barang as $b) : ?>
            <div class="col">
                <div class="card card-container">
                    <img src="<?= base_url('barang/' . $b['gambar_barang']) ?>" class="img-medium card-img-top " alt="gambar barang">
                    <div class="card-header">
                        <span class="badge bg-primary"><?= $b['nama_barang'] ?></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr class="align-middle">
                                <td style="width: 10%; font-size:14px">Stok</td>
                                <td>:
                                    <span class="badge bg-success"><?= $b['stok_barang'] ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 10%; font-size:14px">Harga</td>
                                <td>:
                                    <span class="badge bg-secondary">Rp<?= $b['harga_barang'] ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('keranjang/tambah/' . $b['id_barang']) ?>?jumlah=" class="btn btn-info float-end" style="max-width: 60px; font-size: 20px">
                            <i class='bx bxs-cart-add'></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection(); ?>