<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Halaman Absensi</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <link href="{{ asset('template/assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/assets/css/transparent/app.min.css') }}" rel="stylesheet" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <div class="app-cover"></div>
    <div id="app" class="app app-header-fixed app-sidebar-fixed app-without-sidebar app-with-top-menu">

        <div id="header" class="app-header">
            <div class="navbar-header">
                <a href="#" class="navbar-brand"><span class="navbar-logo"></span>
                    <span><b>ABSENSI</b></span>&nbsp<span style="color: orange;"> <b>DIGITAL</b></span>&nbsp<span
                        style="color: orange;"><b>PT MJS</b> </span></a>
                <button type="button" class="navbar-mobile-toggler" data-toggle="app-top-menu-mobile">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-nav">
                <div class="navbar-item dropdown">
                    <a href="" class="navbar-link dropdown-toggle icon">
                        <i class="fas fa-lock"></i>
                        Lock Halaman
                    </a>
                </div>
            </div>
        </div>

        <div id="content" class="app-content">
            <div class="row mb-4">
                <div class="col-md-2 ui-sortable">
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-1" data-init="true">

                        <div class="panel-heading ui-sortable-handle">
                            <h1 class="panel-title"> <span><b>WAKTU</b></span>&nbsp<span
                                    style="color: orange;">SERVER</span> </h1>

                        </div>
                        <div class="panel-body">
                            <script type="text/javascript">
                                function tampilkanwaktu() {
                                    var waktu = new Date();
                                    var sh = waktu.getHours() + "";
                                    var sm = waktu.getMinutes() + "";
                                    var ss = waktu.getSeconds() + "";
                                    document.getElementById("clock").innerHTML = (sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ? "0" +
                                        sm : sm) + ":" + (ss.length == 1 ? "0" + ss : ss);
                                }
                            </script>
                            <center>

                                <body onload="tampilkanwaktu();setInterval('tampilkanwaktu()', 1000);">
                                    <?php
                                    $hari = date('l');
                                    if ($hari == 'Sunday') {
                                        echo 'Minggu';
                                    } elseif ($hari == 'Monday') {
                                        echo 'Senin';
                                    } elseif ($hari == 'Tuesday') {
                                        echo 'Selasa';
                                    } elseif ($hari == 'Wednesday') {
                                        echo 'Rabu';
                                    } elseif ($hari == 'Thursday') {
                                        echo 'Kamis';
                                    } elseif ($hari == 'Friday') {
                                        echo "Jum'at";
                                    } elseif ($hari == 'Saturday') {
                                        echo 'Sabtu';
                                    }
                                    ?>,
                                    <?php
                                    $tgl = date('d');
                                    echo $tgl;
                                    $bulan = date('F');
                                    if ($bulan == 'January') {
                                        echo ' Januari ';
                                    } elseif ($bulan == 'February') {
                                        echo ' Februari ';
                                    } elseif ($bulan == 'March') {
                                        echo ' Maret ';
                                    } elseif ($bulan == 'April') {
                                        echo ' April ';
                                    } elseif ($bulan == 'May') {
                                        echo ' Mei ';
                                    } elseif ($bulan == 'June') {
                                        echo ' Juni ';
                                    } elseif ($bulan == 'July') {
                                        echo ' Juli ';
                                    } elseif ($bulan == 'August') {
                                        echo ' Agustus ';
                                    } elseif ($bulan == 'September') {
                                        echo ' September ';
                                    } elseif ($bulan == 'October') {
                                        echo ' Oktober ';
                                    } elseif ($bulan == 'November') {
                                        echo ' November ';
                                    } elseif ($bulan == 'December') {
                                        echo ' Desember ';
                                    }
                                    $tahun = date('Y');
                                    echo $tahun;
                                    ?>
                                    <h1><span id="clock"></span></h1>
                                </body>
                            </center>
                            <form id="form_input_nisnnip">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="hasil_scanan" name="tb_input_kd"
                                        value="" placeholder="KETIK NIP">
                                    <button type="button" class="btn btn-primary"><i
                                            class="fas fa-save"></i></button>
                                </div>
                            </form>
                            <br>
                            <hr>
                            <div class="info-overview-absen">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 ui-sortable">
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-3" data-init="true">

                        <div class="panel-heading ui-sortable-handle">
                            <h1 class="panel-title"><span><b>SCAN UNTUK</b></span><span style="color: orange;">
                                    MASUK</span></h1>
                            <div class="panel-heading-btn">
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="container" id="QR-Code">
                                <div class="panel-body text-center">
                                    <div class="col-md-6">
                                        <div class="well" style="position: relative;display: inline-block;">
                                            <canvas width="100%" height="240" id="webcodecam-canvas"
                                                style="transform: scale(1, 1);"></canvas>
                                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                                        </div>
                                    </div>
                                    <p id="scanned-QR"></p>
                                </div>
                            </div>
                            <div class="input-group">
                                <select class="form-control" id="camera-select"></select>
                                <button title="Play" class="btn btn-success btn-sm" id="play" type="button"
                                    data-toggle="tooltip"><span class="fa fa-play"></span></button>
                                <button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button"
                                    data-toggle="tooltip"><span class="fa fa-pause"></span></button>
                                <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button"
                                    data-toggle="tooltip"><span class="fa fa-stop"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 ui-sortable">


                    <div class="panel panel-inverse" data-sortable-id="form-stuff-3" data-init="true">

                        <div class="panel-heading ui-sortable-handle">
                            <h1 class="panel-title"><span><b>DATA ABSEN MASUK</b></span><span style="color: orange;">
                                    HARI INI</span></h1>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-default"
                                    data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-success"
                                    data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning"
                                    data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger"
                                    data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="note note-primary">
                                <div class="note-icon"><i class="fa fa-info"></i></div>
                                <div class="note-content">
                                    <h4>Selamat Datang!</h4>
                                    <h4>Di Aplikasi absensi PT Marindo Jaya Sejahtera</h4>
                                    Jam Masuk : 09:00 || Jam Pulang : 18:00
                                </div>
                            </div>
                            <div class="box-body">
                                <table
                                    class="table table-bordered table-sm table-hover table-td-valign-middle text-white">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list_data_absen">

                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
            data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timeago.js/2.0.2/timeago.min.js"
        integrity="sha512-sl01o/gVwybF1FNzqO4NDRDNPJDupfN0o2+tMm4K2/nr35FjGlxlvXZ6kK6faa9zhXbnfLIXioHnExuwJdlTMA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
