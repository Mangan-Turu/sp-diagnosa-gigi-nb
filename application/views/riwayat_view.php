<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Data Riwayat Diagnosa</h2>

                <div class="card-tools">
                    <a href="<?= base_url('riwayat/perhitungan'); ?>" class="btn btn-success btn-sm">
                        Lihat Perhitungan
                    </a>
                </div>
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
                            <th>Probabilitas</th>
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
                                    <td><?= $item['probabilitas']; ?></td>
                                    <td><span class="fst-italic"><?= $item['nama_penyakit']; ?></span></td>
                                    <td width="10%" class="text-end">
                                        <div>
                                            <a href="<?= base_url('riwayat/delete/') . $item['id']; ?>" class="text-danger btn-delete">Delete</a>
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

<script>
    // Konfirmasi sebelum menghapus data, gunakan jquery dan swal2
    $(document).ready(function() {
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>