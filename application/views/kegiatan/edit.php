<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Kegiatan</h1>

    <div class="card shadow">
        <div class="card-body">

            <form method="post" action="<?= site_url('kegiatan/update/'.$kegiatan->id) ?>">

                <!-- CSRF -->
                <input type="hidden" 
                       name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="form-group">
                    <label>Jurusan</label>
                    <select name="jurusan_id" class="form-control" required>
                        <?php foreach($jurusan as $j): ?>
                            <option value="<?= $j->id ?>" <?= $kegiatan->jurusan_id==$j->id?'selected':'' ?>>
                                <?= $j->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Kegiatan</label>
                    <input name="nama" value="<?= $kegiatan->nama ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"><?= $kegiatan->deskripsi ?></textarea>
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="<?= site_url('kegiatan') ?>" class="btn btn-secondary">Kembali</a>

            </form>

        </div>
    </div>

</div>
