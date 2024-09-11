<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-container" style="display: flex;">
    <div class="rzw-box-content" style="flex: 0 0 15%; padding: 1px; border-radius: 10px 0 0 10px;">
        <a href="<?= base_url('/dashboard/qc_air_botol') ?>">
            <h5 class="pt-2" style="font-weight: 600;"><i class="fa-solid fa-chevron-left"></i></h5>
        </a>
    </div>
    <div class="rzw-box-content" style="flex: 0 0 85%; padding: 1px; border-radius: 0 10px 10px 0;">
        <h5 class="pt-2" style="font-weight: 600;">QC Air Botol</h5>
    </div>
</div>
<div class="rzw-box-content" style="padding: 0px; margin-top: 15px;">
    <p class="p-2" style="font-weight: 600;">Organoleptik</p>
</div>
<form action="<?= base_url('/dashboard/qc_air_botol/qc_air_botol_organoleptik') ?>" method="post">
    <div class="rzw-box-content">
        <div class="card-body">
            <div class="container text-center">
                <h3>RASA</h3>
            </div>
            <?php
                for ($i=1; $i <= 5; $i++) { 
            ?>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.rasa_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="rasa_input_<?= $i ?>" id="rasa_input_<?= $i ?>" placeholder="Value <?= $i ?>" value="<?= old('rasa_input_'.$i) ?>">
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;"><i class="fa-solid fa-note-sticky"></i></span>
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
            ?>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.aroma_input_'.$i) ? 'is-invalid' : '' ?>"
                    name="aroma_input_<?= $i ?>" id="aroma_input_<?= $i ?>" placeholder="Value <?= $i ?>" value="<?= old('aroma_input_'.$i) ?>">
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;"><i class="fa-solid fa-note-sticky"></i></span>
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
        <button type="submit" class="btn btn-primary w-100"
            style="background-color: #00b4cd; border: none; border-radius: 8px;">Submit</button>
        </div>
</form>
<?= $this->endSection() ?>