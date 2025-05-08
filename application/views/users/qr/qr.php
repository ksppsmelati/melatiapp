<style>
    #reader {
        border: 0 !important;
    }

    #reader__dashboard_section_fsr span {
        display: none !important;
    }

    #reader__dashboard_section {
        padding: 0 !important;
    }

    #reader__dashboard_section_swaplink {
        text-decoration: none !important;
        border-radius: 2px;
        margin-top: 1rem;
        color: #fff;
        background-color: #1989fa;
        border: 1px solid #1989fa;
        position: relative;
        display: inline-block;
        box-sizing: border-box;
        height: 2.5rem;
        width: 88%;
        line-height: 2.5rem;
        text-align: center;
        cursor: pointer;
        align-items: center;
        -webkit-appearance: none;
        -webkit-box-pack: center;
    }

    #reader__dashboard_section_csr button {
        text-decoration: none !important;
        border-radius: 2px;
        margin-top: 1rem;
        color: #fff;
        background-color: #f44336;
        border: 1px solid #f44336;
        border-radius: 10px;
        position: relative;
        display: inline-block;
        box-sizing: border-box;
        height: 5rem;
        width: 50% !important;
        line-height: 5rem;
        text-align: center;
        cursor: pointer;
        align-items: center;
        -webkit-appearance: none;
        -webkit-box-pack: center;
    }

    #reader__dashboard_section_csr span {
        margin-right: 0 !important;
    }

    #reader__dashboard_section_fsr input {
        text-decoration: none !important;
        border-radius: 2px;
        margin-top: 1rem;
        color: #fff;
        background-color: #07c160;
        border: 1px solid #07c160;
        position: relative;
        display: inline-block;
        box-sizing: border-box;
        height: 2.5rem;
        width: 88% !important;
        line-height: 2.5rem;
        text-align: center;
        cursor: pointer;
        align-items: center;
        -webkit-appearance: none;
        -webkit-box-pack: center;
    }

    #reader__camera_selection {
        background-color: #fff;
        height: 2.5rem;
        width: 88%;
        line-height: 2.5rem;
        border: 1px solid #1989fa;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
    }

    #result-container {
        padding: 10px;
    }

    #scan-result {
        word-wrap: break-word;
    }

    #copy-button {
        margin-top: 10px;
        padding: 8px;
        cursor: pointer;
        color: #007bff;
        border: none;
        border-radius: 4px;
    }

    #button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
    }


    .scan-again-button {
        padding: 20px;
        font-size: 24px;
        cursor: pointer;
        background-color: transparent;
        border: none;
    }
</style>
<div class="container">
    <div class="content">
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"><i class="fas fa-qrcode"></i> Qr Scanner</h5>
                </div>
                <div class="panel-body">
                    <script src="assets/js/html5-qrcode.min.js"></script>

                    <!-- Step 1: QR Code Scanner -->
                    <div id="step1">
                        <div id="reader"></div>
                    </div>

                    <!-- Step 2: Display Scan Result -->
                    <div id="step2" style="display: none">
                        <div id="result-container">
                            <p id="scan-result"></p>
                            <!-- Menggunakan tag <button> dengan ikon Font Awesome -->
                            <button id="copy-button">
                                <i class="far fa-copy"></i> Copy
                            </button>
                            <!-- Menggunakan tag <button> dengan ikon Font Awesome tanpa latar belakang -->
                            <div id="button-container">
                                <button id="scan-again" class="scan-again-button">
                                    <i class="fas fa-redo" style="color: #f44336;"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                <script async>
                    $(document).ready(function() {
                        // Step 1: QR Code Scanner
                        var scanner = new Html5Qrcode("reader");

                        function onScanSuccess(qrCodeMessage) {
                            // Step 2: Display Scan Result
                            $("#scan-result").text(qrCodeMessage);
                            $("#step1").hide();
                            $("#step2").show();

                            // Automatically open the URL if the scan result is a valid URL
                            // Jika tidak mau otomatis buka hapus kode dibawah ini
                            if (/^(http|https):\/\//.test(qrCodeMessage)) {
                                window.open(qrCodeMessage, '_blank');
                            }
                        }

                        function onScanError(errorMessage) {
                            console.log(errorMessage);
                        }

                        function startScanner() {
                            console.log("start scanner");
                            Html5Qrcode.getCameras()
                                .then(function(cameras) {
                                    console.log(cameras);
                                    if (cameras && cameras.length) {
                                        const config = {
                                            fps: 10,
                                            qrbox: 250,
                                        };
                                        scanner.start({
                                                facingMode: "environment",
                                            },
                                            config,
                                            onScanSuccess
                                        );
                                    } else {
                                        console.log("No cameras found.");
                                    }
                                })
                                .catch(function(error) {
                                    console.log(error);
                                });
                        }
                        startScanner();

                        // Step 2: Scan Again button
                        $("#scan-again").click(function() {
                            // scanner.clear();
                            // scanner.stop();
                            $("#step1").show();
                            $("#step2").hide();
                            // startScanner();
                        });

                        // Copy Button
                        $("#copy-button").click(function() {
                            var scanResult = $("#scan-result").text();
                            navigator.clipboard.writeText(scanResult).then(function() {
                                // Menggunakan SweetAlert untuk menampilkan pesan
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Disalin',
                                });
                            }).catch(function(error) {
                                console.error("Gagal menyalin hasil: ", error);
                                // Menggunakan SweetAlert untuk menampilkan pesan
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menyalin hasil!',
                                });
                            });
                        });

                        // Open link if the result is a valid URL
                        $("#scan-result").click(function() {
                            var scanResult = $("#scan-result").text();
                            if (/^(http|https):\/\//.test(scanResult)) {
                                window.open(scanResult, '_blank');
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>