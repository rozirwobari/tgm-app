<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-container" style="display: flex;">
    <div class="rzw-box-content" style="flex: 0 0 15%; padding: 1px; border-radius: 10px 0 0 10px;">
        <a href="<?= base_url() ?>">
            <h5 class="pt-2" style="font-weight: 600;"><i class="fa-solid fa-house"></i></h5>
        </a>
    </div>
    <div class="rzw-box-content" style="flex: 0 0 85%; padding: 1px; border-radius: 0 10px 10px 0;">
        <h5 class="pt-2" style="font-weight: 600;">QC Air Botol</h5>
    </div>
</div>
<div class="rzw-box-content">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <a href="<?= base_url('/dashboard/qc_air_botol/fisikokimia') ?>"
                    class="btn btn-primary w-100 rzw-btn-content">Fisiko Kimia</a>
            </div>
            <div class="col-6">
                <a href="<?= base_url('/dashboard/qc_air_botol/organoleptik') ?>"
                    class="btn btn-primary w-100 rzw-btn-content">Organoleptik</a>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-12">
                <a href="<?= base_url('/dashboard/qc_air_botol/mikrobiologi') ?>"
                    class="btn btn-primary w-100 rzw-btn-content">Mikrobiologi</a>
            </div>
        </div>
    </div>
</div>
<div class="mt-3 overflow-auto" style="max-height: 70vh; scrollbar-width: none;">
    <?php foreach ($qc_air_botol as $value) : ?>
    <div class="rzw-box-content text-start">
        <a href="<?= base_url('/dashboard/qc_air_botol/fisikokimia') ?>">
            <div class="card-body">
                <h5 class="pt-2 fw-bold"><?= json_decode($value['date'])->label ?> [<?= strtoupper($value['type']) ?>]</h5>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Possimus voluptate velit sunt quod ducimus!
                    A ipsa nobis, excepturi quis labore modi alias laborum quae inventore praesentium similique est
                    reiciendis obcaecati!</p>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>