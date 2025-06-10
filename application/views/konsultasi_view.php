<!-- Appointment Section -->
<section id="appointment" class="appointment section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>MAKE AN APPOINTMENT</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form action="<?= base_url('konsultasi/submit'); ?>" method="post" role="form">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-1 w-50 mx-auto">
                        <div class="card-body" style="color: #6c757d;">
                            <div class="row">
                                <!-- Nama -->
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-capitalize" id="nama" name="nama"
                                            placeholder="Masukkan nama lengkap Anda" required
                                            value="<?= set_value('nama', $user->nama ?? '') ?>">
                                        <?= form_error('nama', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="L" <?= set_select('jenis_kelamin', 'L') ?>>Laki-laki</option>
                                            <option value="P" <?= set_select('jenis_kelamin', 'P') ?>>Perempuan</option>
                                        </select>
                                        <?= form_error('jenis_kelamin', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>

                                <!-- Umur -->
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <input type="number" min="0" max="100" class="form-control" id="umur" name="umur"
                                            placeholder="Masukkan usia anda" required
                                            value="<?= set_value('umur') ?>">
                                        <?= form_error('umur', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>

                                <!-- No HP -->
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <input type="number" min="0" class="form-control" id="no_hp" name="no_hp"
                                            placeholder="Masukkan No. Telp" required
                                            value="<?= set_value('no_hp') ?>">
                                        <?= form_error('no_hp', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="alamat" id="alamat"
                                            placeholder="Masukan alamat anda"><?= set_value('alamat') ?></textarea>
                                        <?= form_error('alamat', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gejala -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-1 w-50 mx-auto">
                        <div class="card-body" style="color: #6c757d;">
                            <p>
                                <strong class="pb-2 d-inline-block">
                                    Silakan centang pernyataan yang paling menggambarkan kondisi yang Anda alami akhir-akhir ini.
                                </strong><br>
                                Jawaban Anda akan membantu sistem dalam menganalisis kemungkinan gangguan kecemasan yang Anda alami secara lebih akurat.
                            </p>

                            <?php if (!empty($gejala)) : ?>
                                <?php foreach ($gejala as $item) : ?>
                                    <?php $kode = $item['kode'] ?? ''; ?>
                                    <div class="form-group">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="gejala[]" value="<?= html_escape($item['id']) ?>"
                                                id="<?= html_escape($kode) ?>" <?= set_checkbox('gejala[]', $item['id']) ?>>
                                            <label class="form-check-label" for="<?= html_escape($kode) ?>">
                                                [<?= html_escape($kode) ?>] - <?= html_escape($item['nama'] ?? '') ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php else : ?>
                                <p>Tidak ada gejala yang tersedia.</p>
                            <?php endif; ?>

                            <!-- Submit -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary border-0" style="background-color:#3fbbc0;">Kirim Jawaban</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

</section>
<!-- /Appointment Section -->