<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">Kategori Kodering</h1>

<div class="card shadow mb-4">

    <div class="card-header d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th width="50">#</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th width="150">Aksi</th>
            </tr>
            </thead>

            <tbody>
            <?php $no=1; foreach($kategori as $k): ?>
                <tr>
                    <td><?= $k->id ?></td>
                    <td><?= $k->nama ?></td>
                    <td><?= $k->deskripsi ?></td>
                    <td>
                        <a href="<?= site_url('kategori/edit/'.$k->id) ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= site_url('kategori/delete/'.$k->id) ?>"
                           onclick="return confirm('Hapus kategori ini?')"
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

            <form method="post" action="<?= site_url('kategori/add') ?>">
                <input type="hidden"
                       name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input name="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
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
