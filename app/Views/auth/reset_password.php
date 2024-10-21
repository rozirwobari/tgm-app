<?= $this->extend('auth/layout') ?>

<?= $this->section('content') ?>
        <div class="card rzw-box-login">
            <div class="card-body">
                <img src="<?= base_url('asset/img/logo.png') ?>" alt="Login Icon" style="width: 110px; height: auto; margin-top: -10px; margin-bottom: 20px;">
                <h3 style="padding-bottom: 10px; color: red;">Reset Password</h4>
                <form action="<?= base_url('/reset_password') ?>" method="POST">
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="hidden" name="username" value="<?= $username ?>">
                            <input type="text" class="form-control rzw-input <?= session('input.token') ? 'is-invalid' : '' ?>" name = "token" id="token" placeholder="Token" value="<?= $token ?>" disabled>
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input">
                                    <i class="fa-solid fa-key"></i>
                                </span>
                            </div>
                            <div id="validationServerTokenFeedback" class="invalid-feedback text-start">
                                <?= session('input.token') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="password" class="form-control rzw-input <?= session('input.password') ? 'is-invalid' : '' ?>" name = "password" id="password" placeholder="Password Baru">
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                                </span>
                            </div>
                            <div id="validationServerPasswordFeedback" class="invalid-feedback text-start">
                                <?= session('input.password') ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4 rzw-btn"
                        style="background-color: red; border: none;">Reset</button>
                </form>
                <div class="text-center mt-2" style="margin-bottom: -20px;">
                    <a href="<?= base_url('/') ?>" style="color: #000; text-decoration: none; font-weight: 350; font-size: 15px;">Sudah Memiliki Akun</a> | 
                    <a href="<?= base_url('daftar') ?>" style="color: #000; text-decoration: none; font-weight: 350; font-size: 15px;">Belum Memiliki Akun</a>
                </div>
            </div>
        </div>
<?= $this->endSection() ?>