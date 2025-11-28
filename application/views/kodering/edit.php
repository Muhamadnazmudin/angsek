<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">Edit Kodering</h1>

<div class="card shadow">
    <div class="card-body">

        <form method="post" action="<?= site_url('kodering/update/'.$kodering->id) ?>">

            <!-- CSRF -->
            <input type="hidden" 
                   name="<?= $this->security->get_csrf_token_name(); ?>"
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="form-group">
                <label>Kode</label>
                <input name="kode" value="<?= $kodering->kode ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nama Kodering</label>
                <input name="nama" value="<?= $kodering->nama ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <?php foreach($kategori as $cat): ?>
                        <option value="<?= $cat->id ?>" 
                            <?= ($kodering->kategori_id == $cat->id) ? 'selected' : '' ?>>
                            <?= $cat->nama ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control"><?= $kodering->deskripsi ?></textarea>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="<?= site_url('kodering') ?>" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

</div>
