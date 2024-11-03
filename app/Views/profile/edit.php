<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-container" style="display: flex;">
    <div class="rzw-box-content" style="flex: 0 0 15%; padding: 1px; border-radius: 10px 0 0 10px;">
        <a href="<?= base_url('dashboard/') ?>">
            <h5 style="font-weight: 600; padding-top: 11%;">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="22"  height="22"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
            </h5>
        </a>
    </div>
    <div class="rzw-box-content" style="flex: 0 0 85%; padding: 1px; border-radius: 0 10px 10px 0;">
        <h5 class="pt-2" style="font-weight: 600;">Edit Profile</h5>
    </div>
</div>

<form action="<?= base_url('dashboard/profile') ?>" method="post" enctype="multipart/form-data" id="profileForm">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">
    <div class="rzw-box-profile" style="margin-top: 10%;">
        <div class="card-body">
            <label for="nama" class="text-start">Nama</label>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.nama') ? 'is-invalid' : '' ?>" name="nama" id="nama" placeholder="Value" value="<?= $user['nama'] ?>">
                <div class="input-group-prepend">
                <span class="rzw-icon-input" style="z-index: 5;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h4" /><path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" /><path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" /></svg>
                </span>
            </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.nama') ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <label for="nama" class="text-start">Email</label>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.email') ? 'is-invalid' : '' ?>" name="email" id="email" placeholder="Email" value="<?= $user['email'] ?>">
                <div class="input-group-prepend">
                <span class="rzw-icon-input" style="z-index: 5;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h4" /><path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" /><path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" /></svg>
                </span>
            </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.email') ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <label for="nama" class="text-start">Password Lama</label>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.password_lama') ? 'is-invalid' : '' ?>" name="password_lama" id="password_lama" placeholder="Password Lama">
                <div class="input-group-prepend">
                <span class="rzw-icon-input" style="z-index: 5;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h4" /><path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" /><path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" /></svg>
                </span>
            </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.password_lama') ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <label for="nama" class="text-start">Password Baru</label>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.password_baru') ? 'is-invalid' : '' ?>" name="password_baru" id="password_baru" placeholder="Password Baru">
                <div class="input-group-prepend">
                <span class="rzw-icon-input" style="z-index: 5;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h4" /><path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" /><path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" /></svg>
                </span>
            </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.password_baru') ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <label for="nama" class="text-start">Profile Picture</label>
            <div class="input-group my-3">
                <input type="file" class="form-control <?= session('input.foto_profile') ? 'is-invalid' : '' ?>" name="foto_profile" id="foto_profile" placeholder="Profile Picture" onchange="readURL(this);">
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.foto_profile') ?>
                </div>
            </div>

            <div class="text-center">
                <img src="<?= base_url($user['img']) ?>" alt="Login Icon" class="rzw-profile-img" id="profileImg">
            </div>
        </div>

        <div class="py-3">
            <button type="submit" class="btn btn-primary w-100" style="background-color: #00b4cd; border: none; border-radius: 8px;">Submit</button>
        </div>
    </div>
</form>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#profileImg')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?= $this->endSection() ?>