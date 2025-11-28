<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Data Kodering</h1>
    <?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $this->session->flashdata('success'); ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $this->session->flashdata('error'); ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>


    <div class="card shadow mb-4">

        <div class="card-header d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kodering</h6>

            <div>
                <!-- PERBAIKAN: panggil controller, bukan base_url statis -->
                <a href="<?= site_url('kodering/download_template') ?>"
                   class="btn btn-success btn-sm">
                   <i class="fas fa-download"></i> Download Template
                </a>

                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-upload"></i> Import Kodering
                </button>

                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                    <i class="fas fa-plus"></i> Tambah Kodering
                </button>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Kode</th>
                    <th>Nama Kodering</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th width="150">Aksi</th>
                </tr>
                </thead>
                <tbody>

                <?php $no=1; foreach($kodering as $k): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= html_escape($k->kode) ?></td>
                        <td><?= html_escape($k->nama) ?></td>
                        <td><?= html_escape($k->kategori_nama) ?></td>
                        <td><?= html_escape($k->deskripsi) ?></td>

                        <td>
                            <a href="<?= site_url('kodering/edit/'.$k->id) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="<?= site_url('kodering/delete/'.$k->id) ?>"
                               onclick="return confirm('Hapus kodering ini?')"
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

                <form method="post" action="<?= site_url('kodering/add') ?>">

                    <!-- CSRF -->
                    <input type="hidden"
                           name="<?= $this->security->get_csrf_token_name(); ?>"
                           value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kodering</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode</label>
                            <input name="kode" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Nama Kodering</label>
                            <input name="nama" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori_id" class="form-control" required>
                                <?php foreach($kategori as $cat): ?>
                                    <option value="<?= $cat->id ?>"><?= html_escape($cat->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
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

    <!-- Modal Import -->
    <div class="modal fade" id="importModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="post" enctype="multipart/form-data"
                      action="<?= site_url('kodering/import') ?>">

                    <input type="hidden"
                           name="<?= $this->security->get_csrf_token_name(); ?>"
                           value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Kodering</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Upload File Excel (.xlsx)</label>
                            <input type="file" name="file_excel" class="form-control" accept=".xls,.xlsx" required>
                        </div>

                        <p class="text-muted small">
                            Gunakan template resmi agar format kolom sesuai. Lihat sheet "Kategori" di template untuk ID kategori.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Import</button>
                    </div>
                </form>
<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>

            </div>
        </div>
    </div>

</div>
