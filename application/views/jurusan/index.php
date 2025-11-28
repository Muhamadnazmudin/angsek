<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Data Jurusan</h1>

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Jurusan</h6>

            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                <i class="fas fa-plus"></i> Tambah Jurusan
            </button>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Kode</th>
                    <th>Nama Jurusan</th>
                    <th width="150">Aksi</th>
                </tr>
                </thead>

                <tbody>
                <?php $no=1; foreach($jurusan as $j): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $j->kode ?></td>
                        <td><?= $j->nama ?></td>
                        <td>
                            <a href="<?= site_url('jurusan/edit/'.$j->id) ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="<?= site_url('jurusan/delete/'.$j->id) ?>"
                               onclick="return confirm('Hapus jurusan ini?')"
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


    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="post" action="<?= site_url('jurusan/add') ?>">

                    <!-- CSRF -->
                    <input type="hidden" 
                           name="<?= $this->security->get_csrf_token_name(); ?>"
                           value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jurusan</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Kode Jurusan</label>
                            <input name="kode" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Nama Jurusan</label>
                            <input name="nama" class="form-control" required>
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
