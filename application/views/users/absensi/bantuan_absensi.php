<!-- Main content -->
<div class="content-wrapper">
  <!-- Content area -->
  <div class="content">
    <br><br>
    <div class="container">
            <!-- Dashboard content -->
            <div class="row">
                <div class="col-md-1"></div>
                <div class="panel panel-flat col-md-9">
                    <?php
                    echo $this->session->flashdata('msg');
                    ?>
                    <div class="panel-body">
                    <div class="navigation-buttons text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li><a href="users/absensi/check_absen"><i class="fa fa-fingerprint"></i> Absen</a></li>
                                    <li><a href="users/absensi/detail_absensi"><i class="fa fa-file-text"></i> Rekap</a></li>
                                    <li><a href="users/absensi/bantuan_absensi"><i class="fa fa-info-circle"></i> Bantuan</a></li>
                                </ul>
                            </div>
                        </div>
                        <fieldset class="content-group">
                            <legend><i class="fas fa-info-circle"></i> </legend>

                            <h5>
                                Peraturan dan prosedur absensi yang harus diikuti oleh semua karyawan KSPPS MELATI:
                            </h5>

                            <ol>
                                <li>
                                <strong>Tombol Absen</strong>
                                    <ul>
                                        <li> Absen karyawan dilakukan dengan menekan tombol absen yang tersedia di menu Absensi di aplikasi Melati-App dengan cara tekan dan tahan tombol absen selama <b>±1.5 detik </b>maka akan muncul popup Konfirmasi untuk absen Masuk / Pulang jika ingin melakukan absen klik OK jika tidak tekan Batal. Pastikan untuk menekan tombol sesuai dengan jenis absen yang ingin dilakukan (Masuk/Pulang).</li>
                                    </ul>
                                    
                                </li><br>
                                <li>
                                     <strong>Wilayah Absensi</strong> 
                                     <ul>
                                        <li>Absensi karyawan terbatas pada seluruh area kantor KSPPS Melati dengan batasan jarak maksimal <b>± 20 meter</b> dari lokasi kantor apabila indikator jarak absen hijau <i class="fa fa-compass text-success"></i> berarti anda bisa melakukan absensi pada jarak tersebut akan tetapi jika indikator jarak absen berwarna merah <i class="fa fa-compass text-danger"></i> maka anda belum bisa melakukan absensi kecuali untuk karyawan bagian pemasaran(marketing) absensi bisa dilakukan diluar kantor.</li>
                                     </ul><br>
                                     <ul>
                                        <li>Pastikan <b>GPS</b> dari perangkat aktif untuk mendapatkan lokasi yang akurat</li>
                                     </ul><br>
                                     <ul>
                                        <li>Apabila lokasi absen belum sesuai atau tidak muncul silahkan klik tombol refresh   <i class="fa fa-refresh" aria-hidden="true" style="color: #808080; font-size: 12px;"></i> yang berada di bawah tombol absen.</li> 
                                     </ul>
                                </li><br>
                                <li>
                                    <strong>Keterangan Absen</strong> 
                                    <ul>
                                        <li>Tombol absen masih berwarna <span style="color: orange;">orange</span> dan keterangan masih <b>Belum Absen</b> <i class="fa fa-1x fa-exclamation-triangle text-warning"></i> berarti Anda belum melakukan absensi.</li><br>
                                        <li>Tombol berwarna <span style="color: green;">hijau</span> dan keterangan <b>Sudah Absen Masuk</b> <i class="fa fa-1x fa-check-circle text-success"></i> maka anda sudah absen masuk sehingga selanjutnya tinggal melakukan absen pulang pada jam pulang.</li><br>
                                        <li>Jika anda sudah melakukan absen masuk dan pulang maka keterangan adalah <b>Sudah Absen Pulang</b> <i class="fa fa-1x fa-check-circle text-success"></i> dan ada status<i>"Anda sudah melakukan absensi masuk dan pulang hari ini."</i> yang berarti absen kerja di hari itu sudah lengkap.</li><br>
                                        <li>Apabila hari libur kerja Sabtu dan Minggu maka keterangan <b>Tidak perlu absen</b> dan karyawan tidak perlu melakukan absensi di hari tersebut.</li>
                                    </ul>
                                </li><br>
                        
                                <li>
                                    <strong>Jam Absen Masuk dan Pulang</strong> 
                                    <ul>
                                        <li>Setiap karyawan hanya diperbolehkan melakukan absen masuk dan pulang satu kali dalam sehari. Pastikan untuk melakukan absen dengan benar sesuai dengan jadwal kerja yang berlaku.</li>
                                        <li>Untuk tombol absen masuk bisa dilakukan di waktu kapan saja jika lokasi sesuai</li>
                                        <li>Untuk tombol absensi pulang hanya akan tampil di jam 12.00 - 13.00 siang dan jam 16.00-20.00 di jam pulang karyawan</li>
                                        <li>Untuk Satpam Tombol absensi untuk pulang akan tampil di jam 08.00-09.00 pagi</li>
                                    </ul>
                                    
                                </li><br>

                                <li>
                                    <strong>Penekanan Tombol</strong> 
                                    <ul>
                                        <li>Pastikan untuk menekan tombol absen dengan tepat pada waktu yang ditentukan. Jika terjadi kesalahan, segera hubungi bagian HR atau administrator sistem.</li>
                                    </ul>
                                    
                                </li><br>
                            
                                <li>
                                    <strong>Ketepatan Waktu</strong> 
                                    <ul>
                                        <li>Absen harus dilakukan sesuai dengan jadwal kerja yang berlaku. Keterlambatan atau keluar lebih awal tanpa alasan yang sah dapat dikenakan sanksi sesuai dengan kebijakan perusahaan.</li>
                                    </ul>
                                    
                                </li><br>

                                <li>
                                    <strong>Kelalaian dan Manipulasi</strong> 
                                    <ul>
                                        <li>Setiap bentuk kelalaian atau manipulasi dalam melakukan absen akan dianggap pelanggaran. Karyawan yang terlibat dalam tindakan tersebut akan dikenakan sanksi sesuai dengan kebijakan perusahaan.</li>
                                    </ul>
                                    
                                </li><br>

                                <li>
                                    <strong>Kontak Dukungan</strong> 
                                    <ul>
                                        <li>Jika mengalami kendala teknis atau memiliki pertanyaan terkait absensi digital di Melati-App, silakan hubungi bagian HRD atau tim IT KSPPS MELATI untuk laporan kendala teknis.</li>
                                    </ul>
                                    
                                </li>
                            </ol>

                            <p>
                                Dengan mengikuti peraturan dan prosedur diatas, kita dapat memastikan keakuratan dan keandalan data absensi digital. Terima kasih atas kerjasama Anda.
                            </p>
                        </fieldset>
                    </div>


                </div>
            </div>
            <!-- /dashboard content -->
        </div>
        <div class="container">
            <!-- Dashboard content -->
            <div class="row">
                <div class="col-md-1"></div>
                <div class="panel panel-flat col-md-9">
                    <?php
                    echo $this->session->flashdata('msg');
                    ?>
                    <div class="panel-body">
                        <fieldset class="content-group">
                            <legend><i class="fas fa-calendar"></i> Opsi Izin</legend>

                            <!-- Button for Izin -->
                            <button id="btnIzin" onclick="requestPermission('izin')" class="btn btn-info">Izin</button>

                            <!-- Button for Sakit -->
                            <button id="btnSakit" onclick="requestPermission('sakit')" class="btn btn-warning">Sakit</button>

                            <!-- Button for Cuti -->
                            <button id="btnCuti" onclick="requestPermission('cuti')" class="btn btn-success">Cuti</button>
                        </fieldset>

                        <script>
                            function requestPermission(type) {
                                // Implement your logic for handling the button click based on the permission type (izin, sakit, cuti)
                                // For example, you can send a request to the server or perform some client-side action.
                                console.log(`Requesting ${type} permission.`);
                            }
                        </script>

                    </div>

                </div>
            </div>
            <!-- /dashboard content -->
        </div>
  </div>