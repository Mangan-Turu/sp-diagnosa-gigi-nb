<!-- Appointment Section -->
<section id="appointment" class="appointment section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>MAKE AN APPOINTMENT</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form action="forms/appointment.php" method="post" role="form" class="">
            <div class="row">
                <div class="col-12">
                    <div class="card border-1 w-50 mx-auto">
                        <div class="card-body" style="color: #6c757d;">
                            <p>
                                <strong class="pb-2 d-inline-block">Silakan centang pernyataan yang paling menggambarkan kondisi yang Anda alami akhir-akhir ini.</strong><br>
                                Jawaban Anda akan membantu sistem dalam menganalisis kemungkinan gangguan kecemasan yang Anda alami secara lebih akurat.
                            </p>

                            <?php if (isset($gejala) && is_array($gejala) && count($gejala) > 0) : ?>
                                <?php foreach ($gejala as $item) : ?>
                                    <div class="form-group">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="gejala[]" value="<?= isset($item['kode']) ? html_escape($item['kode']) : ''; ?>" id="<?= isset($item['kode']) ? html_escape($item['kode']) : ''; ?>">
                                            <label class="form-check-label" for="<?= isset($item['kode']) ? html_escape($item['kode']) : ''; ?>">
                                                [<?= isset($item['kode']) ? html_escape($item['kode']) : ''; ?>] - <?= isset($item['nama']) ? html_escape($item['nama']) : ''; ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php else : ?>
                                <p>Tidak ada gejala yang tersedia.</p>
                            <?php endif; ?>

                            <!-- button sbmit -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary border-0" style="background-color:#3fbbc0;">Kirim Jawaban</button>
                            </div>
                            <!-- end button sbmit -->
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

</section>
<!-- /Appointment Section -->