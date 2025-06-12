<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Perhitungan</h2>

                <div class="card-tools">
                    <a href="<?= base_url('riwayat'); ?>" class="btn btn-danger btn-sm">
                        Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($hasils as $hasil) : ?>
                        <div class="col-12">
                            <hr>
                            <h5><?= $hasil['user_nama']; ?></h5>

                            <h6>1. Menentukan nilai nc pada setiap class</h6>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Penyakit</th>
                                        <th>Gejala</th>
                                        <th>N</th>
                                        <th>m</th>
                                        <th>P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil['perhitungan'] as $key => $perhitungan) : ?>
                                        <tr>
                                            <td><?= $key + 1 ?>.</td>
                                            <td><i><?= $perhitungan['penyakit_nama']; ?></i></td>
                                            <td class="p-0 m-0">
                                                <table class="m-0 p-0">
                                                    <tr>
                                                        <?php foreach ($perhitungan['rules'] as $rle_gejala) : ?>
                                                            <td><?= $rle_gejala['gejala_kode'] . ' (' . $rle_gejala['gejala_selected'] . ')' ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td><?= $perhitungan['penyakit_n']; ?></td>
                                            <td><?= $perhitungan['penyakit_m']; ?></td>
                                            <td><?= $perhitungan['nilai_nc']; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                            <h6>2. Menghitung nilai P(ai|vj) dan menghitung nilai P(vj)</h6>
                            <ol>
                                <?php foreach ($hasil['perhitungan'] as $key => $perhitungan) : ?>
                                    <li>
                                        <h6><?= $perhitungan['penyakit_nama']; ?> (<?= $perhitungan['penyakit_kode']; ?>)</h6>
                                        <table class="m-0 p-0">
                                            <?php foreach ($perhitungan['rules'] as $rule) : ?>
                                                <tr>
                                                    <td>P(<?= $rule['gejala_kode']; ?>|<?= $perhitungan['penyakit_kode']; ?>)</td>
                                                    <td>=</td>
                                                    <td>
                                                        <table class="border-0 m-0 p-0">
                                                            <tr>
                                                                <td class="text-center" style="border-bottom: 1px solid black;"><?= $rule['gejala_selected']; ?> + <?= $perhitungan['penyakit_m']; ?> * <?= $perhitungan['nilai_nc']; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center"><?= $perhitungan['penyakit_n']; ?> + <?= $perhitungan['penyakit_m']; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>=</td>
                                                    <td><?= $rule['nilai_p']; ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </table>
                                    </li>
                                <?php endforeach ?>
                            </ol>

                            <h6>3. Menghitung P(ai|vj) x P(vj) untuk tiap v</h6>
                            <ol>
                                <?php foreach ($hasil['perhitungan'] as $key => $perhitungan) : ?>
                                    <li>
                                        <h6><?= $perhitungan['penyakit_nama']; ?> (<?= $perhitungan['penyakit_kode']; ?>)</h6>
                                        <p class="p-0 m-0">
                                            P(<?= $perhitungan['penyakit_kode']; ?>) x [
                                            <?php foreach ($perhitungan['rules'] as $i => $rule): ?>
                                                P(<?= $rule['gejala_kode']; ?>|<?= $perhitungan['penyakit_kode']; ?>)
                                                <?php if ($i < count($perhitungan['rules']) - 1): ?> x <?php endif; ?>
                                            <?php endforeach; ?>
                                            ]
                                        </p>
                                        <p class="p-0 m-0">= <?= $perhitungan['nilai_nc']; ?> x
                                            <?php foreach ($perhitungan['rules'] as $i => $rule): ?>
                                                <?= $rule['nilai_p']; ?>
                                                <?php if ($i < count($perhitungan['rules']) - 1): ?> x <?php endif; ?>
                                            <?php endforeach; ?>
                                        </p>
                                        <p class="p-0 m-0">= <?= $perhitungan['probabilitas']; ?></p>
                                    </li>
                                <?php endforeach ?>
                            </ol>

                            <h6>4. Ambil Nilai terbesar</h6>
                            <p class="p-0 m-0 text-danger fw-bold"><?= $hasil['user_nama'] ?> || Penyakit: [<?= $hasil['probabilitas']; ?>] <i><?= $hasil['penyakit_nama']; ?></i> (<?= $hasil['penyakit_kode']; ?>)</p>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>