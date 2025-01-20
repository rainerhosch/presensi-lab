<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scan</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->

        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1>Presensi Laboratorium Komputer SMKN Kiarapedes</h1>
                        </div>

                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card card-primary">
                    <!-- Block Content -->
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="text-center col-md-8 text-center">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($presensi as $key => $value) { ?>

                                            <tr style="<?= $key == 0 ? 'background-color: aquamarine;' : ''; ?>">
                                                <td><?= $key + 1; ?></td>
                                                <td><?= $value['nama']; ?></td>
                                                <td><?= $value['kelas']; ?></td>
                                                <td><?= $value['jurusan']; ?></td>
                                                <td><?= $value['tgl_check_in'] . ' ' . $value['jam_check_in']; ?></td>
                                                <td><?= $value['tgl_check_out'] . ' ' . $value['jam_check_out']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="text-center col-md-4 text-center">
                                <div class="text-center" style="width: 100%" id="reader"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="assets/AdminLTE-3.2.0/dist/js/demo.js"></script> -->

    <!-- <script src="<?= base_url() ?>assets/swal/dist/sweetalert2.all.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/html5-qrcode/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            // stop
            // html5QrcodeScanner.clear();

            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;

                // Handle on success condition with the decoded text or result.
                console.log(`Scan result: ${decodedText}`, decodedResult);
                let nisn = 0;
                if (decodedResult.result.format.formatName == "QR_CODE") {
                    nisn = parseInt(decodedResult.result.text);

                    if (nisn > 0) {

                        console.log(nisn);
                        $.ajax({
                            type: "post",
                            url: "<?= base_url('scan-action') ?>",
                            data: {
                                nisn: nisn
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#modal-id').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                });
                            },

                            success: function(response) {
                                let timerInterval;
                                let table = `<table class="text-left">`;
                                table += `<tr>`;
                                table += `<td>NISN</td>`;
                                table += `<td>: ` + response.nisn + `</td>`;
                                table += `</tr>`;
                                table += `<tr>`;
                                table += `<td>NAMA</td>`;
                                table += `<td>: ` + response.nama + `</td>`;
                                table += `</tr>`;
                                table += `</table>`;
                                Swal.fire({
                                    title: response.notif,
                                    html: table,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const timer = Swal.getPopup().querySelector("b");
                                        timerInterval = setInterval(() => {
                                            timer.textContent = `${Swal.getTimerLeft()}`;
                                        }, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                    }
                                }).then((result) => {
                                    /* Read more about handling dismissals below */
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        console.log("I was closed by the timer");

                                        location.reload();
                                    }
                                });
                            },
                            error: function(e) {
                                $('#modal-id').modal('hide');
                                alert('Error');
                                // location.reload();
                            },
                        });
                    } else {
                        alert('null');
                        location.reload();
                    }
                } else {
                    alert('Bukan QR Code!')
                    location.reload();
                }
            } else {
                console.log('stop');
            }

        }

        function onScanError(errorMessage) {
            // handle on error condition, with error message

        }

        const config = {
            formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            },
            rememberLastUsedCamera: true,
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA, Html5QrcodeScanType.SCAN_TYPE_FILE],
            showTorchButtonIfSupported: false,
            showZoomSliderIfSupported: true,
            defaultZoomValueIfSupported: 1,
        };

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", config);


        // A $( document ).ready() block.
        $(document).ready(function() {
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        });
    </script>
</body>

</html>