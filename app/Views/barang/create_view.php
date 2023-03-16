<?= $this->extend('barang/sidebar_view'); ?>

<?= $this->section('content') ?>

<!-- Create Form untuk Create Data Barang -->
<div class="container create-container">
    <form action="<?= route_to('barang/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <?php if (session()->getFlashdata('error_message')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error_message') ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="card bg-light border-3 border-info table-card">
                    <div class="card-header">
                        Tambah Barang
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" id="nama_barang" class="form-control <?= isset($validation) && $validation->hasError('nama_barang') ? 'is-invalid' : ''; ?>" name="nama_barang" value="<?= old('nama_barang'); ?>">
                            <?php if (isset($validation) && $validation->hasError('nama_barang')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama_barang'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Harga Barang -->
                        <div class="form-group">
                            <label>Harga Barang</label>
                            <input type="number" class="form-control <?= isset($validation) && $validation->hasError('harga_barang') ? 'is-invalid' : ''; ?>" name="harga_barang" value="<?= old('harga_barang'); ?>">
                            <?php if (isset($validation) && $validation->hasError('harga_barang')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('harga_barang'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Stok Barang -->
                        <div class="form-group">
                            <label>Stok Barang</label>
                            <input type="number" class="form-control <?= isset($validation) && $validation->hasError('stok_barang') ? 'is-invalid' : ''; ?>" name="stok_barang" value="<?= old('stok_barang'); ?>">
                            <?php if (isset($validation) && $validation->hasError('stok_barang')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('stok_barang'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Gambar Barang</label>
                            <input type="file" class="form-control <?= isset($validation) && $validation->hasError('gambar_barang') ? 'is-invalid' : ''; ?>" name="gambar_barang" id="gambar_barang" accept="image/*">
                            <?php if (isset($validation) && $validation->hasError('gambar_barang')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('gambar_barang'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12 mb-2">
                            <img id="preview-image-before-upload" src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/Antu_insert-image.svg/1200px-Antu_insert-image.svg.png" alt="preview image" class="image-preview">
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= site_url('barang'); ?>" class="btn btn-warning ms-3">
                            Batal
                        </a>
                    </div>
                </div>
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
        justify-content: center;
        color: blue;
    }

    .card-footer {
        margin-bottom: 10px !important;
    }

    .image-preview {
        width: 200px;
        height: 200px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }
</style>

<script>
    $(document).ready(function(e) {
        $('#gambar_barang').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-before-upload').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>

<?= $this->endSection(); ?>