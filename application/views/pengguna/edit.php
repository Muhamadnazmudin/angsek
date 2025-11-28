<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Pengguna</h1>

    <div class="card shadow">
        <div class="card-body">

            <form method="post" action="<?= site_url('pengguna/update/'.$user->id) ?>">
                <input type="hidden" 
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>" />

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input name="fullname" value="<?= $user->fullname ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input name="username" value="<?= $user->username ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Password Baru (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input name="email" value="<?= $user->email ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role_id" class="form-control">
                        <?php foreach($roles as $r): ?>
                            <option value="<?= $r->id ?>" <?= $user->role_id==$r->id?'selected':'' ?>>
                                <?= $r->name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="<?= site_url('pengguna') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>
