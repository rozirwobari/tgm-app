<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-container" style="display: flex;">
    <div class="rzw-box-content" style="flex: 0 0 15%; padding: 1px; border-radius: 10px 0 0 10px;">
        <a href="<?= base_url('/dashboard/qc_air_botol') ?>">
            <h5 style="font-weight: 600; padding-top: 11%;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M15 6l-6 6l6 6" />
                </svg>
            </h5>
        </a>
    </div>
    <div class="rzw-box-content" style="flex: 0 0 85%; padding: 1px; border-radius: 0 10px 10px 0;">
        <h5 class="pt-2" style="font-weight: 600;">QC Air Botol</h5>
    </div>
</div>

<div class="rzw-box-content">
    <div class="card-body">
        <div class="container text-start">
            <h3 class="text-center">Keterangan Fisikokimia</h3>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 10px;">TDS : </p>
                <span class="rzw-keterangan-green">0-5</span>
                <span class="rzw-keterangan-yellow">6-10</span>
                <span class="rzw-keterangan-red">10&lt;</span>
            </div>
            <div style="display: flex; flex-direction: row;" class="mt-2">
                <p style="margin-right: 10px;">PH : </p>
                <span class="rzw-keterangan-green">5.0-7.0</span>
                <span class="rzw-keterangan-yellow">7.1-7.5</span>
                <span class="rzw-keterangan-red">7.5&lt; </span>
            </div>
            <div style="display: flex; flex-direction: row;" class="mt-2">
                <p style="margin-right: 10px;">KERUHAN : </p>
                <span class="rzw-keterangan-green">0-1.0</span>
                <span class="rzw-keterangan-yellow">1.1-1.5</span>
                <span class="rzw-keterangan-red">1.5&lt;</span>
            </div>
        </div>
    </div>
</div>

<div class="rzw-box-content">
    <div class="card-body">
        <div class="container text-start">
            <h3 class="text-center">Keterangan</h3>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 10px;">RASA : </p>
                <span class="rzw-keterangan-green">Normal</span>
                <span class="rzw-keterangan-yellow">Pahit</span>
                <span class="rzw-keterangan-red"> - </span>
            </div>
            <div style="display: flex; flex-direction: row;" class="mt-2">
                <p style="margin-right: 10px;">AROMA : </p>
                <span class="rzw-keterangan-green">Hijau</span>
                <span class="rzw-keterangan-yellow">Kuning</span>
                <span class="rzw-keterangan-red">Merah</span>
            </div>
            <div style="display: flex; flex-direction: row;" class="mt-2">
                <p style="margin-right: 10px;">WARNA : </p>
                <span class="rzw-keterangan-green">Hijau</span>
                <span class="rzw-keterangan-yellow">Kuning</span>
                <span class="rzw-keterangan-red">Merah</span>
            </div>
        </div>
    </div>
</div>

<div class="rzw-box-content">
    <div class="card-body">
        <div class="container text-start">
            <h3 class="text-center">Keterangan</h3>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 10px;">RASA : </p>
                <span class="rzw-keterangan-green">
                    < 1.0 X 10^1</span>
                        <span class="rzw-keterangan-yellow">1.0 X 10^1 - 10^2</span>
                        <span class="rzw-keterangan-red">1.0 x10^2&lt;</span>
            </div>
            <div style="display: flex; flex-direction: row;" class="mt-2">
                <p style="margin-right: 10px;">AROMA : </p>
                <span class="rzw-keterangan-green">Hijau</span>
                <span class="rzw-keterangan-yellow">Kuning</span>
                <span class="rzw-keterangan-red">Merah</span>
            </div>
            <div style="display: flex; flex-direction: row;" class="mt-2">
                <p style="margin-right: 10px;">WARNA : </p>
                <span class="rzw-keterangan-green">Hijau</span>
                <span class="rzw-keterangan-yellow">Kuning</span>
                <span class="rzw-keterangan-red">Merah</span>
            </div>
        </div>
    </div>
</div>


<div class="rzw-box-content">
    <div class="card-body">
        <?php 
            $dates = json_decode($details['date']);
            $update_dates = json_decode($details['update_date']);
            $decode_qc = json_decode($details['data'])->data;
        ?>
        <div class="container text-start">
            <h3 class="text-center">Detail Petugas</h3>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 3px;">Tanggal & Waktu : <span class="p-2"
                        style="font-weight: 600;"><?= $dates->label ?></span></p>
            </div>
            <?php if (!empty($update_dates)) : ?>
                <div style="display: flex; flex-direction: row;">
                    <p style="margin-right: 3px;">Tanggal & Waktu Di Update : <span class="p-2"
                            style="font-weight: 600;"><?= $update_dates->label ?></span></p>
                </div>
            <?php endif; ?>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 3px;">Petugas : <span class="p-2"
                        style="font-weight: 600;"><?= $data_user['nama'] ?></span></p>
            </div>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 3px;">Status : <span class="p-2" style="font-weight: 600; color: <?= $status == 0 ? '#c6a200' : ($status == 1 ? 'green' : 'red') ?>;"><?= $status == 0 ? 'Pending' : ($status == 1 ? 'Approve' : 'Reject') ?></span></p>
            </div>
            <!-- <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 3px;">Shift/Lokasi : <span class="p-2" style="font-weight: 600;"><?= $data_user['nama'] ?></span></p>
            </div> -->
        </div>
    </div>
</div>
<form action="<?= base_url('/dashboard/qc_air_botol/update/'.$id) ?>" method="post">

<div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>Shift</h3>
            </div>
            <div class="input-group my-3">
                <select class="form-control rzw-input <?= session('input.shift') ? 'is-invalid' : '' ?>"
                    name="shift" id="shift" <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                    <option value="">Pilih Shift</option>
                    <option value="1" <?= $details['shift'] == '1' ? 'selected' : '' ?> >1</option>
                    <option value="2" <?= $details['shift'] == '2' ? 'selected' : '' ?> >2</option>
                    <option value="3" <?= $details['shift'] == '3' ? 'selected' : '' ?> >3</option>
                </select>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h4" /><path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" /><path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" /></svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.shift') ?>
                </div>
            </div>
        </div>
    </div>

<div class="rzw-box-content" style="padding: 0px; margin-top: 15px;">
    <p class="p-2" style="font-weight: 600;">FISIKOKIMIA</p>
</div>

    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>TDS</h3>
            </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
                    $data = $decode_qc->fisikokimia[($i - 1)]->tds;
                    if($data == null) $data = '';
            ?>
            <div class="input-group my-3">
                <input type="text"
                    class="form-control rzw-input <?= session('input.tds_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="tds_input_<?= $i ?>" id="tds_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>"
                    style="background-color: <?= $data == null ? 'white' : ($data >= 0 && $data <= 5 ? 'green' : ($data >= 6 && $data <= 10 ? '#ecd700' : '#ff0000')) ?>; color: <?= $data == null ? 'black' : ($data >= 0 && $data <= 5 ? 'white' : ($data >= 6 && $data <= 10 ? 'black' : 'white')) ?>;"
                    <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12h4" />
                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                        </svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.tds_input_'.$i) ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>PH</h3>
            </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
                    $data = $decode_qc->fisikokimia[($i - 1)]->ph;
                    if($data == null) $data = '';
            ?>
            <div class="input-group my-3">
                <input type="text"
                    class="form-control rzw-input <?= session('input.ph_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="ph_input_<?= $i ?>" id="ph_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>"
                    style="background-color: <?= $data == null ? 'white' : ($data >= 5.0 && $data <= 7.0 ? 'green' : ($data >= 7.1 && $data <= 7.5 ? '#ecd700' : '#ff0000')) ?>; color: <?= $data == null ? 'black' : ($data >= 5.0 && $data <= 7.0 ? 'white' : ($data >= 7.1 && $data <= 7.5 ? 'black' : 'white')) ?>;"
                    <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12h4" />
                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                        </svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.ph_input_'.$i) ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>KERUHAN</h3>
            </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
                    $data = $decode_qc->fisikokimia[($i - 1)]->keruhan;
            ?>
            <div class="input-group my-3">
                <input type="text"
                    class="form-control rzw-input <?= session('input.keruhan_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="keruhan_input_<?= $i ?>" id="keruhan_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>"
                    style="background-color: <?= $data == null ? 'white' : ($data >= 0 && $data <= 1.0 ? 'green' : ($data >= 1.1 && $data <= 1.5 ? '#ecd700' : '#ff0000')) ?>; color: <?= $data == null ? 'black' : ($data >= 0 && $data <= 1.0 ? 'white' : ($data >= 1.1 && $data <= 1.5 ? 'black' : 'white')) ?>;"
                    <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12h4" />
                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                        </svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.keruhan_input_'.$i) ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <div class="rzw-box-content" style="padding: 0px; margin-top: 35px;">
        <p class="p-2" style="font-weight: 600;">ORGANOLEPTIK</p>
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>RASA</h3>
            </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
                    $data = $decode_qc->organoleptik[($i - 1)]->rasa;
            ?>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.rasa_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="rasa_input_<?= $i ?>" id="rasa_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>"
                    style="background-color: <?= strpos(strtolower($data), 'normal') === 0 ? 'green' : ($data == null ? 'white' : 'red') ?>; color: <?= $data == null ? 'black' : 'white' ?>;"
                    <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12h4" />
                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                        </svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.rasa_input_'.$i) ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>AROMA</h3>
            </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
                    $data = $decode_qc->organoleptik[($i - 1)]->aroma;
            ?>
            <div class="input-group my-3">
                <input type="text"
                    class="form-control rzw-input <?= session('input.aroma_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="aroma_input_<?= $i ?>" id="aroma_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>"
                    style="background-color: <?= strpos(strtolower($data), 'normal') === 0 ? 'green' : ($data == null ? 'white' : 'red') ?>; color: <?= $data == null ? 'black' : 'white' ?>;"
                    <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12h4" />
                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                        </svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.aroma_input_'.$i) ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>WARNA</h3>
            </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
                    $data = $decode_qc->organoleptik[($i - 1)]->warna;
            ?>
            <div class="input-group my-3">
                <input type="text"
                    class="form-control rzw-input <?= session('input.warna_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="warna_input_<?= $i ?>" id="warna_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>"
                    style="background-color: <?= strpos(strtolower($data), 'normal') === 0 ? 'green' : ($data == null ? 'white' : 'red') ?>; color: <?= $data == null ? 'black' : 'white' ?>;"
                    <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12h4" />
                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                        </svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.warna_input_'.$i) ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>


    <div class="rzw-box-content" style="padding: 0px; margin-top: 35px;">
        <p class="p-2" style="font-weight: 600;">MIKROBIOLGI</p>
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>ALT</h3>
            </div>
            <?php
                for ($i=1; $i <= 3; $i++) { 
                    $data = $decode_qc->mikrobiologi[($i - 1)]->alt;
            ?>
            <div class="input-group my-3">
                <input type="text"
                    class="form-control rzw-input <?= session('input.alt_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="alt_input_<?= $i ?>" id="alt_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>"
                    style="background-color: <?= $data == null ? 'white' : ($data >= 0 && $data <= 1.0 ? 'green' : ($data >= 1.1 && $data <= 1.5 ? '#ecd700' : '#ff0000')) ?>; color: <?= $data == null ? 'black' : ($data >= 0 && $data <= 1.0 ? 'white' : ($data >= 1.1 && $data <= 1.5 ? 'black' : 'white')) ?>;"
                    <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12h4" />
                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                        </svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.alt_input_'.$i) ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>EC</h3>
            </div>
            <?php
                for ($i=1; $i <= 2; $i++) { 
                    $data = $decode_qc->mikrobiologi[($i - 1)]->ec;
            ?>
            <div class="input-group my-3">
                <input type="text"
                    class="form-control rzw-input <?= session('input.ec_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="ec_input_<?= $i ?>" id="ec_input_<?= $i ?>" placeholder="Value <?= $i ?>" value="<?= $data ?>"
                    style="background-color: <?= $data == null ? 'white' : ($data >= 0 && $data <= 1.0 ? 'green' : ($data >= 1.1 && $data <= 1.5 ? '#ecd700' : '#ff0000')) ?>; color: <?= $data == null ? 'black' : ($data >= 0 && $data <= 1.0 ? 'white' : ($data >= 1.1 && $data <= 1.5 ? 'black' : 'white')) ?>;"
                    <?= $status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers' ? '' : 'readonly' ?>>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12h4" />
                            <path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" />
                            <path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" />
                        </svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.ec_input_'.$i) ?>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <?php if($status == 0 && $details['user_id'] == $data_user['user_id'] && $data_user['name'] != 'viewers'): ?>
        <div class="rzw-box-content">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100 rzw-btn-content">Simpan</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>

<?php if($status == 0 && $data_user['name'] == "manager"): ?>
    <div class="rzw-box-content">
        <div class="row">
            <div class="col-6">
                <a class="btn btn-primary w-100" href="<?= base_url('dashboard/qc_air_botol/reject/'.$id) ?>"
                    style="background-color: red; border: none; border-radius: 8px; color: black; color: white;">Reject</a>
            </div>
            <div class="col-6">
                <button class="btn btn-primary w-100" onclick="deleteData(<?= $id ?>)"
                    style="background-color: #f3e100; border: none; border-radius: 8px; color: black;">Hapus</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <a class="btn btn-primary w-100" href="<?= base_url('dashboard/qc_air_botol/approve/'.$id) ?>"
                    style="background-color: green; border: none; border-radius: 8px;">Approve</a>
            </div>
        </div>
    </div>
<?php endif; ?>


<script>
    function deleteData(id) {
        Swal.fire({
            title: "Apakah Kamu Yakin?",
            text: "Data akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus Data!"
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('dashboard/qc_air_botol/delete/') ?>" + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>