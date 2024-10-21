<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-container" style="display: flex;">
    <div class="rzw-box-content" style="flex: 0 0 15%; padding: 1px; border-radius: 10px 0 0 10px;">
        <a href="<?= base_url() ?>">
            <h5 style="font-weight: 600; padding-top: 11%;">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="22"  height="22"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-home"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
            </h5>
        </a>
    </div>
    <div class="rzw-box-content" style="flex: 0 0 85%; padding: 1px; border-radius: 0 10px 10px 0;">
        <h5 class="pt-2" style="font-weight: 600;"><?= $title ?></h5>
    </div>
</div>
<?php if ($data_user['name'] != 'viewers') : ?>
<div class="rzw-box-content">
    <div class="card-body">
        <!-- <div class="row">
            <div class="col-6">
                <a href="<?= base_url('/dashboard/qc_air_galon/fisikokimia') ?>"
                    class="btn btn-primary w-100 rzw-btn-content">Fisiko Kimia</a>
            </div>
            <div class="col-6">
                <a href="<?= base_url('/dashboard/qc_air_galon/organoleptik') ?>"
                    class="btn btn-primary w-100 rzw-btn-content">Organoleptik</a>
            </div>
        </div> -->
        <div class="row">
            <div class="col-12">
                <a href="<?= base_url('/dashboard/qc_air_galon/input') ?>"
                    class="btn btn-primary w-100 rzw-btn-content">Input Data</a>
            </div>
            <div class="col-12 pt-3">
                <a href="<?= base_url('/dashboard/qc_air_galon/export') ?>"
                    class="btn btn-primary w-100 rzw-btn-content" style="background-color: green;">Export</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="mt-3 overflow-auto" style="<?= $data_user['name'] != 'viewers' ? 'max-height: 70vh;' : 'max-height: 86vh;'; ?> scrollbar-width: none;">
    <?php foreach ($qc_air_galon as $value) : ?>
    <div class="rzw-box-content text-start">
        <a href="<?= base_url('/dashboard/qc_air_galon/detail/' . $value['id']) ?>">
            <div class="card-body">
                <p class="fw-bold"><?= json_decode($value['date'])->label ?> [<span style="color: <?= $value['status'] == 0 ? '#c6a200' : ($value['status'] == 1 ? 'green' : 'red') ?>"><?= $value['status'] == 0 ? 'Pending' : ($value['status'] == 1 ? 'Approve' : 'Reject') ?></span>]</p>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Possimus voluptate velit sunt quod ducimus!
                    A ipsa nobis, excepturi quis labore modi alias laborum quae inventore praesentium similique est
                    reiciendis obcaecati!</p>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>