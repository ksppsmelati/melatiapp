<style>
    /* CSS untuk membuat tabel responsif */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    th {
        background-color: #ff5722;
        color: white;
    }
</style>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="panel panel-flat">
                <?php
                echo $this->session->flashdata('msg');
                ?>
                <div class="panel-body">
                    <fieldset class="content-group">
                        <!-- Content for Syarat dan Ketentuan Simpanan -->
                        <h2>SYARAT DAN KETENTUAN SIMPANAN</h2>
                        <p>
                            <strong>UMUM</strong>
                        </p>
                        <ul>
                            <li>Setiap data, keterangan, tanda tangan yang tercantum dalam dokumen pembukaan rekening simpanan dan dokumen lain yang terikat dengan simpanan dan kuasa yang diberikan anggota kepada pihak ketiga (jika ada) adalah benar dan sah mengikat.</li>
                            <li>Simpanan tidak boleh dijaminkan dalam bentuk dan dengan cara apapun kepada pihak lain, kecuali dengan persetujuan KSPPS MELATI.</li>
                            <li>Anggota wajib segera memberitahukan KSPPS MELATI secara tertulis terhadap perubahan identitas diri, namun tidak terbatas dengan nama, alamat, no telepon, NPWP, tanda tangan dan hal lain yang menyimpang/berbeda dari data/keterangan yang pernah diberikan.</li>
                            <li>Anggota dengan ini menyatakan bahwa sumber dana tidak berasal dari sesuatu yang dilarang oleh syariah dan atau peraturan perundang undangan yang berlaku.</li>
                            <li>Anggota dan KSPPS MELATI sepakat untuk melaksanakan ketentuan dan persyaratan ini, berikut penambahan dan perubahanya.</li>
                        </ul>

                        <p>
                            <strong>PENGEMBALIAN</strong>
                        </p>
                        <ul>
                            <li>KSPPS MELATI berjanji dan dengan ini mengikatkan diri untuk mengembalikan kepada anggota seluruh jumlah dana simpanan yang menjadi hak anggota sesuai saldo dalam buku tabungan.</li>
                            <li>Setiap pembayaran kembali oleh KSPPS MELATI kepada anggota atas simpanan yang diberikan oleh anggota dilakukan di kantor KSPPS MELATI atau ditempat lain yang ditunjuk KSPPS MELATI, atau dilakukan melalui rekening yang dibuka oleh dan atas Nama Anggota KSPPS MELATI.</li>
                        </ul>

                        <p>
                            <strong>BIAYA ADMINISTRASI DAN ATAU POTONGAN PAJAK</strong>
                        </p>
                        <ul>
                            <li>Anggota berjanji dan bersedia menanggung biaya administrasi yang diperlakukan berkenaaan dengan pelaksanaan simpanan ini sesuai ketentuan di KSPPS Melati.</li>
                            <li>KSPPS MELATI tidak berkewajiban dan atau bertanggung jawab kepada anggota atas setiap pengurangan karena pajak/bea dan atau kewajiban-kewajiban dan atau biaya-biaya yang ditetapkan pemerintah atau penyusutan nilai atau penyitaan yang bersifat apapun dan/atau sebab-sebab lainnya diluar kekuasaan KSPPS MELATI.</li>
                        </ul>

                        <p>
                            <strong>NISBAH BAGI HASIL</strong>
                        </p>
                        <div style="overflow-x:auto;">
                            <table border="1" cellspacing="0" cellpadding="5">
                                <tr>
                                    <th>PRODUK</th>
                                    <th>ANGGOTA (%)</th>
                                    <th>KSPPS (%)</th>
                                </tr>
                                <tr>
                                    <td>SIMPATI</td>
                                    <td>1</td>
                                    <td>99</td>
                                </tr>
                                <tr>
                                    <td>SIMASYA</td>
                                    <td>5</td>
                                    <td>95</td>
                                </tr>
                                <tr>
                                    <td>SIMAYA</td>
                                    <td>5</td>
                                    <td>95</td>
                                </tr>
                                <tr>
                                    <td>SIMPEL</td>
                                    <td>5</td>
                                    <td>95</td>
                                </tr>
                                <tr>
                                    <td>SIMATANG 2th</td>
                                    <td>10</td>
                                    <td>90</td>
                                </tr>
                                <tr>
                                    <td>SIMATANG 5th</td>
                                    <td>22</td>
                                    <td>78</td>
                                </tr>
                                <tr>
                                    <td>SIMATANG 10th</td>
                                    <td>23</td>
                                    <td>77</td>
                                </tr>
                                <tr>
                                    <td>SIMAROH</td>
                                    <td>22</td>
                                    <td>78</td>
                                </tr>
                                <tr>
                                    <td>SIMMKA 1 Bulan</td>
                                    <td>20</td>
                                    <td>80</td>
                                </tr>
                                <tr>
                                    <td>SIMMKA 3 Bulan</td>
                                    <td>30</td>
                                    <td>70</td>
                                </tr>
                                <tr>
                                    <td>SIMMKA 6 Bulan</td>
                                    <td>40</td>
                                    <td>60</td>
                                </tr>
                                <tr>
                                    <td>SIMMKA 9 Bulan</td>
                                    <td>50</td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <td>SIMMKA 12 Bulan</td>
                                    <td>57</td>
                                    <td>43</td>
                                </tr>
                            </table>
                        </div>

                        <br>
                        <p>
                            <strong>PENYELESAIAN PERSELISIHAN</strong>
                        </p>
                        <ul>
                            <li>Dalam hal terjadi perbedaan pendapat atau penafsiran atas hal yang tercantum di dalam surat perjanjian ini atau terjadi perselisihan atau sengketa dalam pelaksanaanya. Maka para pihak sepakat terlebih dahulu mengutamakan untuk menyelesaikan secara musyawarah untuk mufakat, mediasi, secara kekeluargaan.</li>
                            <li>Mengenai akad kerjasama dengan segala akibatnya dan pelaksanaanya para pihak sepakat memilih tempat kediaman hukumnya yang tetap dan tidak berubah di kantor pengadilan Agama di kota/kabupaten setempat.</li>
                        </ul>

                        <p>
                            <strong>PENUTUP</strong>
                        </p>
                        <ul>
                            <li>Apabila ada hal-hal yang belum diatur atau belum cukup diatur dalam persyaratan dan ketentuan ini maka anggota dan KSPPS MELATI akan mengaturnya bersama secara musyawarah untuk mufakat dalam suatu kesepakatan.</li>
                            <li>Tiap kesepakatan dari perjanjian ini merupakan satu kesatuan yang tidak terpisahkan dari perjanjian ini.</li>
                        </ul>
                        <br>
                        <div>
                            *) Demikian ketentuan & persyaratan simpanan ini dibuat secara musyawarah & mufakat.
                        </div>

                        <!-- Tombol Setuju -->
                        <div>
                            <input type="checkbox" name="setuju" value="setuju" id="btSetuju">
                            Saya setuju dengan syarat dan ketentuan tersebut di atas.
                        </div>
                        <div class="col-md-6 text-center">
                            <button name="proses" type="button" id="btProses" class="btn btn-sm btn-warning" disabled onclick="redirectToRekening()">Buka Rekening</button>
                        </div>

                        <script>
                            // Fungsi ini akan dipanggil saat checkbox diubah (dicentang/dicentang)
                            function toggleButtonStatus() {
                                var checkbox = document.getElementById('btSetuju');
                                var button = document.getElementById('btProses');

                                if (checkbox.checked) {
                                    button.disabled = false;
                                } else {
                                    button.disabled = true;
                                }
                            }

                            // Fungsi ini akan memicu pengalihan ke halaman rekening saat tombol diklik
                            function redirectToRekening() {
                                window.location.href = '<?= base_url('users/produk/form_simpanan'); ?>';
                            }


                            // Memanggil fungsi toggleButtonStatus() saat checkbox diubah
                            document.getElementById('btSetuju').addEventListener('change', toggleButtonStatus);
                        </script>

                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>