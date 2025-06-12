<!-- Appointment Section -->
<section id="appointment" class="appointment section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Terimakasih</h2>
        <p>Berikut adalah hasil dari diagnosa kami</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form action="forms/appointment.php" method="post" role="form" class="">
            <div class="row">
                <div class="col-12">
                    <div class="w-50 mx-auto">
                        <table class="table table-bordered table-striped">
                            <?php if ($riwayat) : ?>
                                <tr>
                                    <td>Nama</td>
                                    <td class="text-capitalize"><?= $riwayat->nama; ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td><?= $riwayat->alamat ?? 'Tidak ada'; ?></td>
                                </tr>
                                <tr>
                                    <td width="25%">Jenis Kelamin</td>
                                    <td><?= $riwayat->jenis_kelamin == 'L' ? 'Laki-laki' :  'Perempuan'; ?></td>
                                </tr>
                                <tr>
                                    <td>Umur</td>
                                    <td><?= $riwayat->umur ?? '--'; ?> Tahun</td>
                                </tr>
                                <tr>
                                    <td>No. HP</td>
                                    <td><?= $riwayat->no_hp ?? 'Tidak ada'; ?></td>
                                </tr>
                                <tr>
                                    <td>Hasil</td>
                                    <td class="fst-italic text-danger"><?= $riwayat->nama_penyakit ?? 'Tidak ada' ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center">Tidak Ada Riwayat</td>
                                </tr>
                            <?php endif ?>

                        </table>

                        <div class="text-center">
                            <a href="<?= base_url('/'); ?>" class="btn btn-primary border-0" style="background-color:#3fbbc0;">Kembali ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

</section>
<!-- /Appointment Section -->