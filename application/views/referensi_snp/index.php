<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Referensi SNP</h1>

    <!-- Tombol Tambah -->
    <button class="btn btn-dark mb-3" data-toggle="modal" data-target="#addModal">
        <i class="fas fa-plus"></i> Tambah Referensi
    </button>
    <div class="mb-3">
    <a href="<?= site_url('ref_snp/export_excel') ?>" class="btn btn-success btn-sm">
        <i class="fas fa-file-excel"></i> Export Excel
    </a>

    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importModal">
        <i class="fas fa-upload"></i> Import Excel
    </button>
</div>
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

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Kode</th>
                        <th>SNP</th>
                        <th>Komponen</th>
                        <th>Uraian Kegiatan</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($snp as $r): ?>
                    <tr>
                        <td><?= $r->kode ?></td>
                        <td><?= $r->snp ?></td>
                        <td><?= $r->komponen ?></td>
                        <td><?= $r->uraian_kegiatan ?></td>
                        <td>
                            <a href="<?= site_url('ref_snp/edit/'.$r->id) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= site_url('ref_snp/delete/'.$r->id) ?>" 
                               onclick="return confirm('Yakin hapus?')"
                               class="btn btn-danger btn-sm">
                               <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-3">
    <?= $pagination ?>
</div>
        </div>
    </div>
</div>
<!-- modal tambah -->
 <div class="modal fade" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?= site_url('ref_snp/add') ?>" method="post">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
       value="<?= $this->security->get_csrf_hash(); ?>">


        <div class="modal-header">
          <h5 class="modal-title">Tambah Referensi SNP</h5>
        </div>

        <div class="modal-body">
            <div class="form-group">
              <label>Kode</label>
              <input type="text" name="kode" class="form-control" required>
            </div>
            <div class="form-group">
              <label>SNP</label>
              <input type="text" name="snp" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Komponen</label>
              <input type="text" name="komponen" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Uraian Kegiatan</label>
              <textarea name="uraian_kegiatan" class="form-control" required></textarea>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-dark">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>
<!-- modal import excel -->
 <div class="modal fade" id="importModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?= site_url('ref_snp/import_excel') ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" 
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
          <h5 class="modal-title">Import Referensi SNP</h5>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Upload File Excel (.xlsx / .xls)</label>
            <input type="file" name="file_excel" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Import</button>
        </div>

      </form>

    </div>
  </div>
</div>
