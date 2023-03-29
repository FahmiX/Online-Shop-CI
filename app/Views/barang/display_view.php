<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content'); ?>
<div class="container mt-4 mb-4">
    <div class="row row-cols-md-4 g-5">
        <?php foreach ($barang as $b) : ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= base_url('barang/' . $b['gambar_barang']) ?>" class="img-medium" alt="gambar barang">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span class="badge bg-primary"><?= $b['nama_barang'] ?></span>
                        </h5>
                        <table class="table table-borderless">
                            <tr>
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
                        <div class="input-group mt-3">
                            <span class="input-group-text" style="max-width: 60px; font-size: 12px; justify-content: center;">Jumlah</span>
                            <input type="number" name="jumlah" class="form-control" style="max-width: 70px; font-size: 12px;" value="1" min="1" max="<?= $b['stok_barang'] ?>">
                        </div>
                        <a href="<?= base_url('keranjang/tambah/' . $b['id_barang']) ?>?jumlah=" class="btn btn-primary btn-tambah float-end" style="max-width: 60px; font-size: 12px">Add</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .img-medium {
        width: 286px;
        height: 150px;
        object-fit: cover;
        max-width: 100%;
    }
</style>

<script>
    $(document).ready(function() {
        $('.btn-tambah').click(function(event) {
            event.preventDefault();
            var jumlah = $(this).closest('.card-body').find('input[name="jumlah"]').val();
            var href = $(this).attr('href');
            $(this).attr('href', href + jumlah);
            window.location.href = href + jumlah;
        });
    });
</script>
<?= $this->endSection(); ?>
