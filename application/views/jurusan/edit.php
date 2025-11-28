<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Jurusan</h1>

    <div class="card shadow">
        <div class="card-body">

            <form method="post" action="<?= site_url('jurusan/update/'.$jurusan->id) ?>">

                <!-- CSRF -->
                <input type="hidden" 
                       name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="form-group">
                    <label>Kode Jurusan</label>
                    <input name="kode" class="form-control" value="<?= $jurusan->kode ?>" required>
                </div>

                <div class="form-group">
                    <label>Nama Jurusan</label>
                    <input name="nama" class="form-control" value="<?= $jurusan->nama ?>" required>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="<?= site_url('jurusan') ?>" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>

</div>
