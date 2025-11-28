<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Pengguna</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>

            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </button>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="120">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $no=1; foreach($users as $u): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $u->fullname ?></td>
                        <td><?= $u->username ?></td>
                        <td><?= $u->email ?></td>
                        <td><?= $u->role_name ?></td>
                        <td>
                            <a href="<?= site_url('pengguna/edit/'.$u->id) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a onclick="return confirm('Hapus pengguna ini?')" 
                               href="<?= site_url('pengguna/delete/'.$u->id) ?>" 
                               class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="addUserModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="post" action="<?= site_url('pengguna/add') ?>">

    <input type="hidden" 
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>" />


                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input name="fullname" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select name="role_id" class="form-control" required>
                                <?php foreach($roles as $r): ?>
                                    <option value="<?= $r->id ?>"><?= $r->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
