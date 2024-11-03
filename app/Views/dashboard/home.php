<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-box-profile">
    <div class="card-body">
        <img src="<?= base_url($user['img']) ?>" alt="Login Icon" class="rzw-profile-img">
        <p style="font-weight: 400; padding-top: 10px;">Hallo, <?= $user['nama'] ?></p>
        <a href="<?= base_url('dashboard/profile') ?>" class="btn btn-primary w-100 rzw-btn" style="background-color: #0049ff; color: #fff;">Edit Profile</a>
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
                <a href="<?= base_url('/dashboard/qc_air_cup') ?>" class="btn btn-primary w-100 rzw-btn-content">QC
                    Air Cup</a>
            </div>
            <div class="col-6 pt-3">
                <a href="<?= base_url('/dashboard/qc_air_galon') ?>" class="btn btn-primary w-100 rzw-btn-content">QC Air Galon</a>
            </div>
            <div class="col-6 pt-3">
                <a href="<?= base_url('/dashboard/qc_air_baku') ?>" class="btn btn-primary w-100 rzw-btn-content">QC Air Baku</a>
            </div>
        </div>
    </div>
</div>

<?php if($user['name'] == 'manager'): ?>
    <div class="rzw-box-content">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <a href="<?= base_url('/manage_account') ?>" class="btn btn-primary w-100 rzw-btn-content" style="background-color: #dad300; color: #000;">
                        Manage Akun
                    </a>
                </div>
                <div class="col-6">
                    <a href="<?= base_url('/export_all_excel') ?>" class="btn btn-primary w-100 rzw-btn-content" style="background-color: green;">
                        Export All Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>