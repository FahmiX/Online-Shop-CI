<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content'); ?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/styles/keranjang_display.css">

<div class="container mt-4 mb-4">
    <h3 style="text-align: center;">Keranjang Belanja</h3>
    <br>

    <?php if (session()->getFlashdata('error_message')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error_message') ?>
        </div>
    <?php endif; ?>

    <table class="table table-custom table-bordered border-dark border-5">
        <thead class="align-middle">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Berat</th>
                <th>Harga Satuan</th>
                <th>Subtotal Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            $total = 0; ?>
            <?php foreach ($keranjang as $k) : ?>
                <tr class="align-middle">
                    <!-- No -->
                    <td style="text-align: center; width: 50px;"><?= $no++ ?></td>
                    <!-- Gambar Barang -->
                    <td style="width: 150px">
                        <img src="<?= base_url('barang/' . $k['gambar_barang']) ?>" class="img-medium" alt="gambar barang">
                    </td>
                    <!-- Nama Barang -->
                    <td><?= $k['nama_barang'] ?></td>
                    <!-- Jumlah Barang -->
                    <td style="width: 180px">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary btn-kurang" type="button" data-id="<?= $k['id_barang'] ?>" data-action="kurang">-</button>
                            <input style="text-align: center;" type="number" name="jumlah" class="form-control" value="<?= $k['jumlah'] ?>" min="1" data-id="<?= $k['id_barang'] ?>" disabled>
                            <button class="btn btn-outline-secondary btn-tambah" type="button" data-id="<?= $k['id_barang'] ?>" data-action="tambah">+</button>
                        </div>
                    </td>
                    <!-- Berat Barang (berat * jumlah)-->
                    <td id="berat<?= $k['id_barang'] ?>"><?= $k['berat_barang'] * $k['jumlah'] ?> gram</td>
                    <!-- Harga Satuan -->
                    <td>Rp<?= number_format($k['harga_barang'], 0, ',', '.') ?></td>
                    <!-- Subtotal Harga -->
                    <td id="subtotal-harga-<?= $k['id_barang'] ?>">Rp<?= number_format($k['jumlah'] * $k['harga_barang'], 0, ',', '.') ?></td>
                    <td style="width: 50px">
                        <a href="<?= base_url('keranjang/hapus/' . $k['id_barang']) ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php $total += $k['jumlah'] * $k['harga_barang']; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="checkout-container mt-4">
        <div class="total-container">
            <p>Total Harga:</p>
            <h4><strong>Rp<span id="total-harga"><?= number_format($total, 0, ',', '.') ?></span></strong></h4>
        </div>
        <div class="button-container">
            <a href="<?= base_url('keranjang/checkout') ?>" class="btn btn-success btn-lg">Checkout</a>
        </div>
    </div>
</div>

<style>
    .checkout-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border: 1px solid #000;
        border-radius: 10px;
    }

    .total-container {
        flex-grow: 1;
    }

    .total-container p {
        font-size: 16px;
        margin: 0 0 5px 0;
    }

    .total-container h4 {
        font-size: 28px;
        margin: 0;
    }

    .button-container {
        margin-left: 20px;
    }
</style>

<script>
    $(document).ready(function() {
        $('.btn-kurang, .btn-tambah').on('click', function() {
            var id = $(this).data('id');
            var action = $(this).data('action');

            $.ajax({
                url: '<?= base_url('keranjang/ubah/') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    action: action,
                },
                success: function(response) {
                    // Update tampilan jumlah, total berat keranjang, dan subtotal harga
                    $('input[name="jumlah"][data-id="' + id + '"]').val(response.jumlah);
                    $('#subtotal-harga-' + id).html('Rp' + response.subtotal);
                    $('#berat' + id).html(response.berat + ' gram');
                    $('#total-harga').text(response.total);
                },
                error: function(xhr, status, error) {
                    // Tampilkan pesan error
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>