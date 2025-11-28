<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Kategori Kodering</h1>

    <div class="card shadow">
        <div class="card-body">

            <form method="post" action="<?= site_url('kategori/update/'.$kategori->id) ?>">

                <!-- CSRF -->
                <input type="hidden"
                       name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input name="nama" value="<?= $kategori->nama ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"><?= $kategori->deskripsi ?></textarea>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="<?= site_url('kategori') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>
