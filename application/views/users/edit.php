<div class="container-fluid">
    <h4 class="mb-4">Edit User</h4>

    <form method="post" action="<?= site_url('users/update/'.$user->id); ?>">

        <!-- CSRF -->
        <input type="hidden"
            name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="fullname" class="form-control" value="<?= $user->fullname; ?>" required>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $user->username; ?>" required>
        </div>

        <div class="form-group">
            <label>Email (opsional)</label>
            <input type="email" name="email" class="form-control" value="<?= $user->email; ?>">
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role_id" id="roleSelect" class="form-control" onchange="toggleJurusan()">
                <?php foreach($roles as $r): ?>
                    <option value="<?= $r->id; ?>" <?= ($r->id == $user->role_id ? 'selected' : ''); ?>>
                        <?= $r->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Jurusan dropdown -->
        <div class="form-group" id="jurusan_group" style="<?= ($user->role_id == 3 ? '' : 'display:none'); ?>">
            <label>Pilih Jurusan</label>
            <select name="jurusan_id" class="form-control">
                <option value="">-- pilih jurusan --</option>
                <?php foreach($jurusan as $j): ?>
                    <option value="<?= $j->id; ?>"
                        <?= ($j->id == $user->jurusan_id ? 'selected' : ''); ?>>
                        <?= $j->nama; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <script>
            function toggleJurusan() {
                let role = document.getElementById("roleSelect").value;
                document.getElementById("jurusan_group").style.display = (role == 3 ? "block" : "none");
            }
        </script>

        <div class="form-group">
            <label>Password (kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="<?= site_url('users'); ?>" class="btn btn-secondary mt-3">Kembali</a>

    </form>
</div>
