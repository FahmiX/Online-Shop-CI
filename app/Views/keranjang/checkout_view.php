<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content') ?>

<!-- Create Form untuk pengisian Identitas Pembeli -->
<div class="container create-container">
    <form action="<?= route_to('keranjang/checkout/validasi') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <?php if (session()->getFlashdata('error_message')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error_message') ?>
            </div>
        <?php endif; ?>

        <div class="card bg-light border-dark">
            <div class="card-header">
                Identitas Pembeli
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('nama') ? 'is-invalid' : ''; ?>" name="nama" value="<?= old('nama'); ?>" required>
                    <?php if (isset($validation) && $validation->hasError('nama')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- HP -->
                <div class="form-group">
                    <label>HP</label>
                    <input type="number" class="form-control <?= isset($validation) && $validation->hasError('hp') ? 'is-invalid' : ''; ?>" name="hp" value="<?= old('hp'); ?>" required>
                    <?php if (isset($validation) && $validation->hasError('hp')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('hp'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('alamat') ? 'is-invalid' : ''; ?>" name="alamat" value="<?= old('alamat'); ?>" required>
                    <?php if (isset($validation) && $validation->hasError('alamat')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('alamat'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Kecamatan -->
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('kecamatan') ? 'is-invalid' : ''; ?>" name="kecamatan" value="<?= old('kecamatan'); ?>" required>
                    <?php if (isset($validation) && $validation->hasError('kecamatan')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('kecamatan'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Kota -->
                <div class="form-group">
                    <label>Kota</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('kota') ? 'is-invalid' : ''; ?>" name="kota" value="<?= old('kota'); ?>" required>
                    <?php if (isset($validation) && $validation->hasError('kota')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('kota'); ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <div class="card-footer">
                <a href="<?= site_url('keranjang'); ?>" class="btn btn-warning btn-lg btnn-kembali">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary btn-lg">Lanjutkan</button>
            </div>
        </div>
    </form>
</div>

<style>
    .create-container {
        padding-top: 80px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 0px;
    }


    .card-header {
        font-weight: 600;
        font-size: 20px;
        color: dark;
        text-align: center;
    }

    .card-footer {
        padding-top: 20px;
        padding-bottom: 20px;
        text-align: right;
    }

    .image-preview {
        width: 200px;
        height: 200px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }

    .btnn-kembali {
        margin-right: 10px;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<?= $this->endSection(); ?>