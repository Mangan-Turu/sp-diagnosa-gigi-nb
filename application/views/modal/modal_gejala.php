<div class="modal fade" id="tambahGejala" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?= site_url('gejala/store') ?>" method="post" id="formGejala">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Gejala</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="kode" id="kode">
                    <input type="hidden" name="mode" id="mode" value="tambah">

                    <div class="form-group">
                        <label for="nama">Nama Gejala</label>
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
