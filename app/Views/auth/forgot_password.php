<?= $this->extend('auth/layout') ?>

<?= $this->section('content') ?>
        <div class="card rzw-box-login">
            <div class="card-body">
                <img src="<?= base_url('asset/img/logo.png') ?>" alt="Login Icon" style="width: 110px; height: auto; margin-top: -10px; margin-bottom: 20px;">
                <h3 style="padding-bottom: 10px; color: #00b4cd;">Reset Password</h4>
                <form action="<?= base_url('/') ?>" method="post">
                    <div class="form-group pt-3">
                        <div class="input-group">
                            <input type="text" class="form-control rzw-input <?= session('input.username') ? 'is-invalid' : '' ?>" name = "username" id="username" placeholder="Username/Email Terdaftar" value="<?= old('username') ?>">
                            <div class="input-group-prepend">
                                <span class="rzw-icon-input">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-exclamation"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4c.348 0 .686 .045 1.008 .128" /><path d="M19 16v3" /><path d="M19 22v.01" /></svg>
                                </span>
                            </div>
                            <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                                <?= session('input.username') ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4 rzw-btn"
                        style="background-color: red; border: none;">Reset Password</button>
                </form>
                <div class="text-center mt-2" style="margin-bottom: -20px;">
                    <a href="<?= base_url('/') ?>" style="color: #000; text-decoration: none; font-weight: 350; font-size: 15px;">Sudah Memiliki Akun</a> | 
                    <a href="<?= base_url('daftar') ?>" style="color: #000; text-decoration: none; font-weight: 350; font-size: 15px;">Belum Memiliki Akun</a>
                </div>
            </div>
        </div>
<?= $this->endSection() ?>