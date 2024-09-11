<?= $this->extend('auth/layout') ?>

<?= $this->section('content') ?>
        <div class="card rzw-box-login">
            <div class="card-body">
                <img src="<?= base_url('asset/img/logo.png') ?>" alt="Login Icon" style="width: 110px; height: auto; margin-top: -10px; margin-bottom: 20px;">
                <h3 style="padding-bottom: 10px; color: #00b4cd;">Login</h4>
                <form action="<?= base_url('/') ?>" method="post">
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="text" class="form-control rzw-input <?= session('input.username') ? 'is-invalid' : '' ?>" name = "username" id="username" placeholder="Username" value="<?= old('username') ?>">
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input"><i class="fas fa-user"></i></span>
                            </div>
                            <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                                <?= session('input.username') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="password" class="form-control rzw-input <?= session('input.password') ? 'is-invalid' : '' ?>" name = "password" id="password" placeholder="Password">
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input"><i class="fas fa-lock"></i></span>
                            </div>
                            <div id="validationServerPasswordFeedback" class="invalid-feedback text-start">
                                <?= session('input.password') ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4 rzw-btn"
                        style="background-color: #00b4cd; border: none;">Login</button>
                </form>
                <div class="text-center mt-2" style="margin-bottom: -20px;">
                    <a href="<?= base_url('daftar') ?>" style="color: #000; text-decoration: none; font-weight: 350; font-size: 15px;">Belum
                        Memiliki Akun</a> | 
                    <a href="<?= base_url('lupa-password') ?>" style="color: #000; text-decoration: none; font-weight: 350; font-size: 15px;">Lupa Password</a>
                </div>
            </div>
        </div>
<?= $this->endSection() ?>