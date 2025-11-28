<div class="container-fluid">

    <!-- TITLE -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <!-- FILTER CARD -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan RKAS</h6>

            <!-- EXPORT BUTTON -->
            <a href="<?= site_url('laporan_rkas/export_excel?' . http_build_query($_GET)) ?>" 
               class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>

        <div class="card-body">
            <form method="GET" action="<?= site_url('laporan_rkas') ?>">

                <div class="row">

                    <!-- FILTER JURUSAN -->
<div class="col-md-4 mb-3">
    <label><b>Jurusan</b></label>

    <?php 
    $role_id    = $this->session->userdata('role_id');
    $jurusan_id = $this->session->userdata('jurusan_id');
    ?>

    <?php if ($role_id == 3): ?>

        <!-- Jurusan hanya melihat jurusan sendiri -->
        <input type="text" class="form-control" 
               value="<?= $this->session->userdata('jurusan_nama') ?>" 
               disabled>

        <input type="hidden" name="filter_jurusan" value="<?= $jurusan_id ?>">

    <?php else: ?>

        <!-- Admin / operator: boleh pilih -->
        <select name="filter_jurusan" class="form-control">
            <option value="">-- Semua Jurusan --</option>
            <?php foreach ($jurusan as $j): ?>
                <option value="<?= $j->id ?>"
                    <?= isset($_GET['filter_jurusan']) && $_GET['filter_jurusan'] == $j->id ? 'selected' : '' ?>>
                    <?= $j->nama ?>
                </option>
            <?php endforeach; ?>
        </select>

    <?php endif; ?>
</div>

                    <!-- FILTER KATEGORI -->
                    <div class="col-md-4 mb-3">
                        <label><b>Jenis Belanja</b></label>
                        <select name="filter_kategori" class="form-control">
                            <option value="">-- Semua Jenis Belanja --</option>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k->id ?>"
                                    <?= isset($_GET['filter_kategori']) && $_GET['filter_kategori'] == $k->id ? 'selected' : '' ?>>
                                    <?= $k->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- FILTER KODERING -->
                    <div class="col-md-4 mb-3">
                        <label><b>Kodering</b></label>
                        <select name="filter_kodering" class="form-control">
                            <option value="">-- Semua Kodering --</option>
                            <?php foreach ($kodering as $kd): ?>
                                <option value="<?= $kd->id ?>"
                                    <?= isset($_GET['filter_kodering']) && $_GET['filter_kodering'] == $kd->id ? 'selected' : '' ?>>
                                    <?= $kd->kode ?> - <?= $kd->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <button class="btn btn-primary"><i class="fas fa-filter"></i> Terapkan Filter</button>
            </form>
        </div>
    </div>


    <!-- RESULT TABLE -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data RKAS</h6>
        </div>

        <div class="card-body">

            <div class="table-responsive" style="max-height:550px; overflow-y:auto;">
                <table class="table table-bordered table-striped" style="min-width:1600px;">
                    <thead class="thead-light">
                    <tr class="text-center">
                        <th>Jurusan</th>
                        <th>Kegiatan</th>
                        <th>Kode</th>
                        <!-- <th>Nama Kodering</th> -->
                        <th>Jenis Belanja</th>
                        <th>Uraian</th>
                        <th>Vol</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>Mei</th><th>Jun</th>
                        <th>Jul</th><th>Agu</th><th>Sep</th><th>Okt</th><th>Nov</th><th>Des</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if (!empty($rkas)): ?>
                        <?php foreach ($rkas as $r): ?>
                            <tr>
                                <td><?= $r->jurusan_nama ?></td>
                                <td><?= $r->kegiatan_nama ?></td>
                                <td><?= $r->kode_rka ?></td>
                                <!-- <td><?= $r->nama_rka ?></td> -->
                                <td><?= $r->jenis_belanja ?></td>
                                <td><?= $r->uraian ?></td>

                                <td class="text-right"><?= $r->volume ?></td>
                                <td><?= $r->satuan ?></td>
                                <td class="text-right"><?= number_format($r->harga_satuan, 0, ',', '.') ?></td>
                                <td class="text-right"><?= number_format($r->volume * $r->harga_satuan, 0, ',', '.') ?></td>

                                <td class="text-right"><?= $r->jan ?></td>
                                <td class="text-right"><?= $r->feb ?></td>
                                <td class="text-right"><?= $r->mar ?></td>
                                <td class="text-right"><?= $r->apr ?></td>
                                <td class="text-right"><?= $r->mei ?></td>
                                <td class="text-right"><?= $r->jun ?></td>
                                <td class="text-right"><?= $r->jul ?></td>
                                <td class="text-right"><?= $r->agu ?></td>
                                <td class="text-right"><?= $r->sep ?></td>
                                <td class="text-right"><?= $r->okt ?></td>
                                <td class="text-right"><?= $r->nov ?></td>
                                <td class="text-right"><?= $r->des ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="22" class="text-center">Tidak ada data ditemukan</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
