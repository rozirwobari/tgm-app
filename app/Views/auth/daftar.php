<?= $this->extend('auth/layout') ?>

<?= $this->section('content') ?>
        <div class="card rzw-box-login">
            <div class="card-body">
                <img src="<?= base_url('asset/img/logo.png') ?>" alt="Login Icon" style="width: 110px; height: auto; margin-top: -10px; margin-bottom: 20px;">
                <h3 style="padding-bottom: 10px; color: #00b4cd;">Daftar</h4>
                <form autocomplete="off" action="<?= base_url('daftar') ?>" method="post">
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="text" name="nama_lengkap" class="form-control rzw-input <?= session('input.nama_lengkap') ? 'is-invalid' : '' ?>" id="nama_lengkap" placeholder="Nama Lengkap" value="<?= old('nama_lengkap') ?>">
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input"><i class="fa-solid fa-user"></i></span>
                            </div>
                            <div id="validationServerNamaLengkapFeedback" class="invalid-feedback text-start">
                                <?= session('input.nama_lengkap') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="text" name="username" class="form-control rzw-input <?= session('input.username') ? 'is-invalid' : '' ?>" id="username" placeholder="Username" value="<?= old('username') ?>">
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input"><i class="fa-solid fa-circle-user"></i></span>
                            </div>
                            <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                                <?= session('input.username') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="email" name="email" class="form-control rzw-input <?= session('input.email') ? 'is-invalid' : '' ?>" id="email" placeholder="Email" value="<?= old('email') ?>">
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input"><i class="fa-regular fa-envelope"></i></span>
                            </div>
                            <div id="validationServerEmailFeedback" class="invalid-feedback text-start">
                                <?= session('input.email') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="password" name="password" class="form-control rzw-input <?= session('input.password') ? 'is-invalid' : '' ?>" id="password" placeholder="Password">
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input"><i class="fas fa-lock"></i></span>
                            </div>
                            <div id="validationServerPasswordFeedback" class="invalid-feedback text-start">
                                <?= session('input.password') ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4 rzw-btn"
                        style="background-color: #00b4cd; border: none;">Daftar</button>
                </form>
                <div class="text-center mt-2" style="margin-bottom: -20px;">
                    <a href="<?= base_url() ?>" style="color: #000; text-decoration: none; font-weight: 350; font-size: 15px;">Sudah Memiliki Akun</a>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>