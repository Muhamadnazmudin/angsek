<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Referensi SNP</h1>

    <div class="card shadow-sm p-4">

        <form action="<?= site_url('ref_snp/update/'.$snp->id) ?>" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
       value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="form-group">
                <label>Kode</label>
                <input type="text" name="kode" class="form-control" value="<?= $snp->kode ?>" required>
            </div>

            <div class="form-group">
                <label>SNP</label>
                <input type="text" name="snp" class="form-control" value="<?= $snp->snp ?>" required>
            </div>

            <div class="form-group">
                <label>Komponen</label>
                <input type="text" name="komponen" class="form-control" value="<?= $snp->komponen ?>" required>
            </div>

            <div class="form-group">
                <label>Uraian Kegiatan</label>
                <textarea name="uraian_kegiatan" class="form-control" required><?= $snp->uraian_kegiatan ?></textarea>
            </div>

            <button class="btn btn-dark">Update</button>
            <a href="<?= site_url('ref_snp') ?>" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>
