<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-box-profile">
    <div class="card-body">
        <img src="<?= base_url($user['img']) ?>" alt="Login Icon"
            class="rzw-profile-img">
        <p style="font-weight: 400; padding-top: 10px;">Hallo, <?= $user['nama'] ?></p>
        <a href="<?= base_url('logout') ?>" class="btn btn-primary w-100 rzw-btn">Keluar</a>
    </div>
</div>
<div class="rzw-box-content">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <a href="<?= base_url('/dashboard/qc_air_botol') ?>" class="btn btn-primary w-100 rzw-btn-content">QC
                    Air Botol</a>
            </div>
            <div class="col-6">
                <a href="<?= base_url('logout') ?>" class="btn btn-primary w-100 rzw-btn-content">QC Air Cup</a>
            </div>
            <div class="col-6 pt-3">
                <a href="<?= base_url('logout') ?>" class="btn btn-primary w-100 rzw-btn-content">QC Air Galon</a>
            </div>
            <div class="col-6 pt-3">
                <a href="<?= base_url('logout') ?>" class="btn btn-primary w-100 rzw-btn-content">QC Air Baku</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>