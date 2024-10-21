<?= $this->extend('dashboard/layout') ?>

<?= $this->section('content') ?>
<div class="rzw-container" style="display: flex;">
    <div class="rzw-box-content" style="flex: 0 0 15%; padding: 1px; border-radius: 10px 0 0 10px;">
        <a href="<?= base_url('manage_account') ?>">
            <h5 style="font-weight: 600; padding-top: 11%;">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="22"  height="22"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
            </h5>
        </a>
    </div>
    <div class="rzw-box-content" style="flex: 0 0 85%; padding: 1px; border-radius: 0 10px 10px 0;">
        <h5 class="pt-2" style="font-weight: 600;">Edit User</h5>
    </div>
</div>


<form action="<?= base_url('save_account') ?>" method="post">

    <input type="hidden" name="user_id" value="<?= $account['id'] ?>">
    <div class="rzw-box-content">
        <div class="card-body">
            <label for="username" style="text-align: left;">Username</label>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.username') ? 'is-invalid' : '' ?>"
                    name="username" id="username" placeholder="Username"
                    value="<?= $account['username'] ?>" disabled>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h4" /><path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" /><path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" /></svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.username') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <label for="nama" style="text-align: left;">Nama</label>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.nama') ? 'is-invalid' : '' ?>"
                    name="nama" id="nama" placeholder="Nama"
                    value="<?= $account['nama'] ?>" required>
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
    </div>

    <div class="rzw-box-content">
        <div class="card-body">
            <label for="email" style="text-align: left;">Email</label>
            <div class="input-group my-3">
                <input type="text" class="form-control rzw-input <?= session('input.email') ? 'is-invalid' : '' ?>"
                    name="email" id="email" placeholder="Email"
                    value="<?= $account['email'] ?>" required>
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
    </div>


    <div class="rzw-box-content">
        <div class="card-body">
            <label for="role" style="text-align: left;">Role</label>
            <div class="input-group my-3">
                <select class="form-control rzw-input <?= session('input.role') ? 'is-invalid' : '' ?>"
                    name="role" id="role" required>
                    <option value="">Pilih Role</option>
                    <?php foreach ($roles as $role) : ?>
                        <option value="<?= $role['id'] ?>" <?= $account['role'] == $role['id'] ? 'selected' : '' ?>><?= $role['label'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="input-group-prepend">
                    <span class="rzw-icon-input" style="z-index: 5;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cursor-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h4" /><path d="M9 4a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3" /><path d="M15 4a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3" /></svg>
                    </span>
                </div>
                <div id="validationServerUsernameFeedback" class="invalid-feedback text-start">
                    <?= session('input.role') ?>
                </div>
            </div>
        </div>
    </div>


    <div class="rzw-box-content">
        <div class="row">
            <div class="col-<?= session()->get('id') != $account['id'] ? '6' : '12' ?>">
                <button type="submit" class="btn btn-primary w-100 rzw-btn-content">Simpan</button>
            </div>
            <?php if(session()->get('id') != $account['id']): ?>
                <div class="col-6">
                    <a href="javascript:void(0)" class="btn btn-primary w-100" onclick="DeleteUser(<?= $account['id'] ?>)" style="background-color: #f3e100; border: none; border-radius: 8px; color: black;">Hapus</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</form>

<script>
    function DeleteUser(id) {
        Swal.fire({
            title: "Apakah Kamu Yakin?",
            text: "Data akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus Data!"
        }).then ((result) => {
            if (result.isConfirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "<?= base_url('/delete_account/') ?>" + id, true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        window.location.href = "<?= base_url('manage_account') ?>";
                    }
                };
                xhr.send();
            }
        });
    }
</script>
<?= $this->endSection() ?>