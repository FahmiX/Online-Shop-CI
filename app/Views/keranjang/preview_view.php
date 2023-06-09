<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content'); ?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/styles/keranjang_display.css">

<div class="container mt-4 mb-4">
    <h3>Keranjang Belanja</h3>


    <div class="card border border-dark border-3">
        <div class="card-body">
            <span class="badge bg-primary">Nama</span></h1>
            <span class="border border-2 border-dark bg-light"><?= $pembeli['nama'] ?></span>
        </div>

        <div class="card-body">
            <span class="badge bg-primary">Nomor HP</span></h1>
            <span class="border border-2 border-dark bg-light"><?= $pembeli['hp'] ?></span>
        </div>

        <div class="card-body">
            <span class="badge bg-primary">Alamat</span></h1>
            <span class="border border-2 border-dark bg-light"><?= $pembeli['alamat'] ?></span>
        </div>

        <div class="card-body">
            <span class="badge bg-primary">Kecamatan</span></h1>
            <span class="border border-2 border-dark bg-light"><?= $pembeli['kecamatan'] ?></span>
        </div>

        <div class="card-body">
            <span class="badge bg-primary">Kota</span></h1>
            <span class="border border-2 border-dark bg-light"><?= $pembeli['kota'] ?></span>
        </div>

        <div class="card-body">
            <span class="badge bg-primary">Kode Pos</span></h1>
            <span class="border border-2 border-dark bg-light"><?= $pembeli['kode_pos'] ?></span>
        </div>

        <!-- Keranjang Belanja -->
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Produk
                    </button>
                </h2>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#keranjangAccordion">
                    <div class="card-body overflow-auto">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($keranjang as $k) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $k['nama_barang'] ?></td>
                                        <td>Rp<?= number_format($k['harga_barang'], 0, ',', '.') ?></td>
                                        <td><?= $k['jumlah'] ?></td>
                                        <td><?= $k['berat_barang'] ?> gram</td>
                                        <td>Rp<?= number_format($k['jumlah'] * $k['harga_barang'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <span class="badge bg-success">Jumlah Berat</span></h1>
                        <span class="border border-2 border-1 bg-light"><?= $jumlah_berat ?> gram</span>
                        <br>
                        <span class="badge bg-success">Ongkos Kirim Per Kg</span></h1>
                        <span class="border border-2 border-1 bg-light">Rp<?= number_format($ongkir, 0, ',', '.') ?></span>
                        <br>
                        <span class="badge bg-success">Total Biaya Ongkos Kirim</span></h1>
                        <span class="border border-2 border-1 bg-light">Rp<?= number_format($total_ongkir, 0, ',', '.') ?></span>
                        <br>
                        <span class="badge bg-success">Total Biaya Produk</span></h1>
                        <span class="border border-2 border-1 bg-light">Rp<?= number_format($total_harga_barang, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-container mt-4">
        <div class="total-container">
            <p>Total Harga:</p>
            <h4><strong>Rp<span id="total-harga"><?= number_format($total_seluruh, 0, ',', '.') ?></span></strong></h4>
        </div>

        <div class="button-container">
            <a href="<?= base_url('keranjang/checkout') ?>" class="btn btn-secondary btn-lg">Kembali</a>
            <a href="<?= base_url('keranjang/checkout/bayar') ?>" class="btn btn-success btn-lg" id="btn-bayar">Bayar</a>
        </div>
    </div>
</div>

<style>
    .card {
        margin-top: 20px;
    }

    .card-header {
        font-size: 25px;
        font-weight: 600;
        justify-content: center;
    }

    .badge {
        font-size: 14px !important;
    }

    .border {
        font-size: 14px !important;
        margin-top: 10px;
        padding: 5px;
        display: block;
    }

    .back {
        font-size: 18px;
        margin-top: 10px;
    }

    .accordion {
        margin-top: 20px;
        margin-bottom: 20px;
        margin-right: 15px;
        justify-content: center;
        padding-left: 16px;
    }

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
    // Tambahkan event listener pada tombol Bayar
    document.querySelector('#btn-bayar').addEventListener('click', function(event) {
        event.preventDefault();

        // Tampilkan Sweet Alert dengan opsi Yes dan No
        Swal.fire({
            title: 'Apakah Anda yakin ingin melanjutkan pembayaran?',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            // Jika pengguna mengklik tombol Ya
            if (result.isConfirmed) {
                // Lakukan pengalihan ke halaman pembayaran
                window.location.href = "<?= base_url('keranjang/checkout/bayar') ?>";
            }
        });
    });
</script>

<?= $this->endSection(); ?>