<div class="container-fluid">
    <h4 class="mb-4">Tambah User</h4>

    <form method="post" action="<?= site_url('users/save'); ?>">

    <input type="hidden"
        name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password (default)</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role_id" id="role_id" class="form-control" required onchange="toggleJurusan()">
                <?php foreach($roles as $r): ?>
                    <option value="<?= $r->id; ?>"><?= $r->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group" id="jurusan_group" style="display:none;">
            <label>Pilih Jurusan</label>
            <select name="jurusan_id" class="form-control">
                <option value="">-- pilih --</option>
                <?php foreach($jurusan as $j): ?>
                    <option value="<?= $j->id; ?>"><?= $j->nama; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <script>
            function toggleJurusan() {
                let role = document.getElementById('role_id').value;
                document.getElementById('jurusan_group').style.display = (role == 3 ? 'block' : 'none');
            }
        </script>

        <button type="submit" class="btn btn-success mt-3">Simpan</button>
        <a href="<?= site_url('users'); ?>" class="btn btn-secondary mt-3">Batal</a>

    </form>
</div>
