<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Informasi Data Penyakit</h2>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahPenyakit" id="btnTambahPenyakit">Tambah Penyakit</button>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable-pengguna" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($penyakit) > 0) : ?>
                            <?php foreach ($penyakit as $key => $item) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $item['kode']; ?></td>
                                    <td><?= $item['nama']; ?></td>
                                    <td><?= $item['deskripsi']; ?></td>
                                    <td>
                                        <a href="#" class="text-primary btnEditPenyakit"
                                            data-id="<?= $item['id'] ?>"
                                            data-nama="<?= htmlspecialchars($item['nama']) ?>"
                                            data-kode="<?= $item['kode'] ?>"
                                            data-deskripsi="<?= htmlspecialchars($item['deskripsi']) ?>"
                                            data-toggle="modal" data-target="#tambahPenyakit">Edit</a> |
                                        <a href="<?= site_url('penyakit/delete/'.$item['id']) ?>" 
                                            class="text-danger btn-confirm-delete" 
                                            data-url="<?= site_url('penyakit/delete/'.$item['id']) ?>" 
                                            data-message="Yakin ingin menghapus penyakit ini?">
                                            Delete
                                        </a>
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
<?php $this->load->view('modal/modal_penyakit'); ?>
<script>
    $(document).ready(function () {
        $('#btnTambahPenyakit').on('click', function () {
            $('#formPenyakit')[0].reset();
            $('#modalTambahLabel').text('Tambah penyakit');
            $('#formPenyakit').attr('action', '<?= site_url('penyakit/store') ?>');
            $('#mode').val('tambah');
            $('#id').val('');
            $('#kode').val('');
            $('#nama').val('');
            $('#deskripsi').val('');
        });

        $('.btnEditPenyakit').on('click', function () {
            setTimeout(() => {
                $('#modalTambahLabel').text('Edit penyakit');
                $('#formPenyakit').attr('action', '<?= site_url('penyakit/store') ?>');
                $('#mode').val('edit');
                $('#id').val($(this).data('id'));
                $('#kode').val($(this).data('kode'));
                $('#nama').val($(this).data('nama'));
                $('#deskripsi').val($(this).data('deskripsi'));
            }, 100);
        });
    });
</script>