<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-container" style="display: flex;">
    <div class="rzw-box-content" style="flex: 0 0 15%; padding: 1px; border-radius: 10px 0 0 10px;">
        <a href="<?= base_url('/dashboard/qc_air_botol') ?>">
            <h5 style="font-weight: 600; padding-top: 7px;">
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

<div class="rzw-box-content" style="padding: 0px; margin-top: 15px;">
    <p class="p-2" style="font-weight: 600;"><?= strtoupper($details['type']) ?></p>
</div>
<div class="rzw-box-content">
    <div class="card-body">
        <div class="container text-start">
            <h3 class="text-center">Keterangan</h3>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 10px;">TDS : </p>
                <span style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px; margin-right: 10px;">0-5</span>
                <span style="background-color: #ecd700; color: black; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px; margin-right: 10px;">6-10</span>
                <span style="background-color: red; color: white; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px;">10<</span>
            </div>
            <div style="display: flex; flex-direction: row;" class="mt-2">
                <p style="margin-right: 10px;">PH : </p>
                <span style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px; margin-right: 10px;">5.0-7.0</span>
                <span style="background-color: #ecd700; color: black; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px; margin-right: 10px;">7.1-7.5</span>
                <span style="background-color: red; color: white; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px;">1.5<</span>
            </div>
            <div style="display: flex; flex-direction: row;" class="mt-2">
                <p style="margin-right: 10px;">KERUHAN : </p>
                <span style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px; margin-right: 10px;">0-1.0</span>
                <span style="background-color: #ecd700; color: black; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px; margin-right: 10px;">1.1-1.5</span>
                <span style="background-color: red; color: white; padding-left: 5px; padding-right: 5px; padding-top: 6px; padding-bottom: 2px; border-radius: 5px;">7.5<</span>
            </div>
        </div>
    </div>
</div>
<div class="rzw-box-content">
    <div class="card-body">
        <?php 
            $dates = json_decode($details['date']);
            $datas = json_decode($details['data'])->data;
        ?>
        <div class="container text-start">
            <h3 class="text-center">Detail Petugas</h3>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 3px;">Tanggal & Waktu : <span class="p-2" style="font-weight: 600;"><?= $dates->label ?></span></p>
            </div>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 3px;">Petugas : <span class="p-2" style="font-weight: 600;"><?= $data_user['nama'] ?></span></p>
            </div>
            <div style="display: flex; flex-direction: row;">
                <p style="margin-right: 3px;">Shift/Lokasi : <span class="p-2" style="font-weight: 600;"><?= $data_user['nama'] ?></span></p>
            </div>
        </div>
    </div>
</div>
<div class="rzw-box-content">
    <div class="card-body">
        <div class="container text-center">
            <h3>TDS</h3>
        </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
                    $data = $datas[($i - 1)]->tds;
            ?>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.tds_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="tds_input_<?= $i ?>" id="tds_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>" style="background-color: <?= $data >= 0 && $data <= 5 ? 'green' : ($data >= 6 && $data <= 10 ? '#ecd700' : '#ff0000') ?>; color: <?= $data >= 0 && $data <= 5 ? 'white' : "black" ?>;">
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
                    $data = $datas[($i - 1)]->ph;
            ?>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.tds_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="tds_input_<?= $i ?>" id="tds_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>" style="background-color: <?= $data >= 5.0 && $data <= 7.0 ? 'green' : ($data >= 7.1 && $data <= 7.5 ? '#ecd700' : '#ff0000') ?>; color: <?= $data >= 5.0 && $data <= 7.0 ? 'white' : "black" ?>;">
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
            <h3>KERUHAN</h3>
        </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
                    $data = $datas[($i - 1)]->keruhan;
            ?>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.tds_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="tds_input_<?= $i ?>" id="tds_input_<?= $i ?>" placeholder="Value <?= $i ?>"
                    value="<?= $data ?>" style="background-color: <?= $data >= 0 && $data <= 1.0 ? 'green' : ($data >= 1.1 && $data <= 1.5 ? '#ecd700' : '#ff0000') ?>; color: <?= $data >= 0 && $data <= 1.0 ? 'white' : "black" ?>;">
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
<?= $this->endSection() ?>