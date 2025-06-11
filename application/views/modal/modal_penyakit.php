<div class="modal fade" id="tambahPenyakit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?= site_url('penyakit/store') ?>" method="post" id="formPenyakit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Penyakit</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="kode" id="kode">
                    <input type="hidden" name="mode" id="mode" value="tambah">

                    <div class="form-group">
                        <label for="nama">Nama Penyakit</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Simpan</button>
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
