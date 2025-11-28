<div class="container-fluid">
    <h4 class="mb-3">Data Users</h4>

    <a href="<?= site_url('users/add'); ?>" class="btn btn-primary btn-sm mb-3">
        <i class="fas fa-user-plus"></i> Tambah User
    </a>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Jurusan</th>
                <th>Email</th>
                <th width="120">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach($users as $u): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $u->fullname; ?></td>
                <td><?= $u->username; ?></td>
                <td><?= $u->role_name; ?></td>
                <td><?= $u->jurusan_id ? $u->jurusan_id : '-'; ?></td>
                <td><?= $u->email; ?></td>
                <td>
                    <a href="<?= site_url('users/edit/'.$u->id); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= site_url('users/delete/'.$u->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
