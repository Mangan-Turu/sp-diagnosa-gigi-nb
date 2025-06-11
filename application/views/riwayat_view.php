<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Data Riwayat Diagnosa</h2>
            </div>
            <div class="card-body">
                <table id="datatable-pengguna" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur</th>
                            <th>Gejala</th>
                            <th>Hasil Diagnosa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($riwayat) > 0) : ?>
                            <?php foreach ($riwayat as $key => $item) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $item['nama']; ?></td>
                                    <td><?= $item['alamat']; ?></td>
                                    <td><?= $item['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                    <td><?= $item['umur']; ?> Tahun</td>
                                    <td><?= $item['gejala_kode']; ?></td>
                                    <td><span class="fst-italic"><?= $item['nama_penyakit']; ?></span></td>
                                    <td width="10%" class="text-end">
                                        <div>
                                            <a href="" class="text-primary">Edit</a> || <a href="" class="text-danger">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>