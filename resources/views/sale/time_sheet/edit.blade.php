@extends('layouts.master')
@section('title', 'Edit Time Sheet')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('time_sheet_edit') }}
        <form action="{{ route('time_sheet.update', $timeSheet->id) }}" method="POST" id="form-time-sheet">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-3 ui-sortable">
                    <div class="panel panel-inverse">
                        <div class="panel-heading ui-sortable-handle">
                            <h4 class="panel-title">Spal</h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload">
                                    <i class="fa fa-redo"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse">
                                    <i class="fa fa-minus"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group mb-2">
                                <label class="form-label" for="spal">Time Sheet</label>
                                <select class="form-select theSelect " id="spal" name="spal" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($spal as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $timeSheet->spal_id ? 'selected' : 'disabled' }}>
                                            {{ $item->kode }}</option>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-inverse">
                        <div class="panel-heading ui-sortable-handle">
                            <h4 class="panel-title">Detail Spal</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table" id="tbl-detail-time_sheet">
                                <tbody>
                                    <tr>
                                        <td width="35">Nama Kapal</td>
                                        <td>:</td>
                                        <td id="nama-kapal"></td>
                                    </tr>

                                    <tr>
                                        <td width="35">Jumlah Muatan</td>
                                        <td>:</td>
                                        <td id="jml-muatan"></td>
                                    </tr>

                                    <tr>
                                        <td width="35">Pelabuhan Muat</td>
                                        <td>:</td>
                                        <td id="pelabuhan-muat"></td>
                                    </tr>

                                    <tr>
                                        <td width="35">Pelabuhan Bongkar</td>
                                        <td>:</td>
                                        <td id="pelabuhan-bongkar"></td>
                                    </tr>

                                    <tr>
                                        <td width="35">Harga Unit</td>
                                        <td>:</td>
                                        <td id="harga-unit"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 ui-sortable">
                    <div class="panel panel-inverse">
                        <div class="panel-heading ui-sortable-handle">
                            <h4 class="panel-title">Time Sheet</h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
                                        class="fa fa-redo"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse">
                                    <i class="fa fa-minus"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body" style="overflow-x: scroll;">
                            <table class="table table-bordered table-sm" id="dynamic_field"
                                style="overflow-x: scroll;width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Remark</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timeSheet->detail_time_sheets as $i => $detail)
                                        <tr>
                                            <td>
                                                <input class="form-check-input form-check-timesheet-input" type="checkbox"
                                                    name="is_count[]" id="flexCheckChecked">
                                            </td>
                                            <td>
                                                <input type="date" name="date[]" placeholder="Date" class="form-control"
                                                    value="{{ $detail->date->format('Y-m-d') }}" required />
                                            </td>
                                            <td>
                                                <input style="width: 210px" type="text" name="remark[]" placeholder="Remark"
                                                    class="form-control" value="{{ $detail->remark }}" required />
                                            </td>
                                            <td>
                                                <input type="time" name="from[]" placeholder="from"
                                                    class="form-control startTime"
                                                    value="{{ date('H:i', strtotime($detail->from)) }}" required />
                                            </td>
                                            <td>
                                                <input type="time" name="to[]" placeholder="to" class="form-control endTime"
                                                    value="{{ date('H:i', strtotime($detail->to)) }}" required />
                                            </td>
                                            <td>
                                                <input style="width: 100px" type="text" name="keterangan[]"
                                                    placeholder="Description" class="form-control"
                                                    value="{{ $detail->keterangan }}" required />
                                            </td>
                                            <td style="width:20px">
                                                @if ($i < 1)
                                                    <button type="button" name="add_berkas" id="add_berkas"
                                                        class="btn btn-success">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>
                                                @else
                                                    <button type="button" name="remove" id="{{ $i }}"
                                                        class="btn btn-danger btn_remove">
                                                        X
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div style="float: left">
                                <p style="font-weight: bold; font-size: 14px;">Total Waktu :
                                    <span style="font-size: 14px;color:white; font-weight:normal;" id="totalWaktuValue">
                                        {{ "$timeSheet->hari Hari, $timeSheet->jam Jam, $timeSheet->menit Menit" }}
                                    </span>
                                </p>
                            </div>
                            <div style="float: right">
                                <button type="submit" class="btn btn-danger" id="btn-update">Update</button>
                                <a href="{{ route('time_sheet.index') }}" class="btn btn-info" id="btn-back"> Back</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        const spal = $('#spal')
        const customer = $('#customer')
        const namaKapal = $('#nama-kapal')
        const namaMuatan = $('#nama-muatan')
        const jmlMuatan = $('#jml-muatan')
        const pelabuhanMuat = $('#pelabuhan-muat')
        const pelabuhanBongkar = $('#pelabuhan-bongkar')
        const hargaUnit = $('#harga-unit')

        getSpal()

        function calculateTimeSheet(startTime, endTime) {
            console.log(startTime + " DAN " + endTime)
            // get total minutes between startime endtime using pure js
            let startTimeMinutes = parseInt(startTime.split(':')[0]) * 60 + parseInt(startTime.split(':')[1]);
            let endTimeMinutes = parseInt(endTime.split(':')[0]) * 60 + parseInt(endTime.split(':')[1]);
            let totalMinutes = endTimeMinutes - startTimeMinutes;

            return totalMinutes
        }

        function calculateTotalTimesheet() {

            let minutes = 0

            $('.form-check-timesheet-input').each((e) => {
                if ($('.form-check-timesheet-input').eq(e).is(':checked')) {
                    let startTime = $('.startTime').eq(e).val()
                    let endTime = $('.endTime').eq(e).val()

                    let startTimeSplit = startTime.split(':')
                    let endTimeSplit = endTime.split(':')

                    let startTimeMinutes = parseInt(startTimeSplit[0]) * 60 + parseInt(startTimeSplit[1])
                    let endTimeMinutes = parseInt(endTimeSplit[0]) * 60 + parseInt(endTimeSplit[1])

                    minutes += endTimeMinutes - startTimeMinutes
                }
            })

            let hours = Math.floor(minutes / 60)
            let minutesLeft = minutes % 60

            $('#totalWaktuValue').text(`${hours} jam ${minutesLeft} menit`)
        }

        $(document).ready(function() {
            var i = 1;
            $('#add_berkas').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><input class="form-check-input form-check-timesheet-input" type="checkbox" value="" id="flexCheckChecked"></td><td><input type="date" name="date[]" placeholder="Date" class="form-control" required /></td><td><input style="width: 210px" type="text" name="remark[]" placeholder="Remark"class="form-control" required /></td><td><input type="time" name="from[]" placeholder="from" class="form-control startTime" required /></td><td><input type="time" name="to[]" placeholder="to" class="form-control endTime" required /></td><td><input style="width: 100px" type="text" name="keterangan[]" placeholder="Description" class="form-control" required /></td><td><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

        });

        spal.change(function() {
            getSpal()
        })

        function getSpal() {
            namaKapal.text('Loading...')
            namaMuatan.text('Loading...')
            jmlMuatan.text('Loading...')
            pelabuhanMuat.text('Loading...')
            pelabuhanBongkar.text('Loading...')
            hargaUnit.text('Loading...')
            $.ajax({
                url: '/sale/spal/get-spal-by-id/' + spal.val(),
                type: 'get',
                success: function(res) {
                    setTimeout(() => {
                        namaKapal.text(res.nama_kapal)
                        namaMuatan.text(res.nama_muatan)
                        jmlMuatan.text(res.jml_muatan)
                        pelabuhanMuat.text(res.pelabuhan_muat)
                        pelabuhanBongkar.text(res.pelabuhan_bongkar)
                        hargaUnit.text(res.harga_unit)
                    }, 500)
                },
            });
        }

        $(document).on('change', '.form-check-timesheet-input', function() {
            calculateTotalTimesheet()
        })

        $(document).on('change', '.startTime', function() {
            calculateTotalTimesheet()
        })

        $(document).on('change', '.endTime', function() {
            calculateTotalTimesheet()
        })

        $('#form-time-sheet').submit(function(e) {
            e.preventDefault()
            $('#btn-update').prop('disabled', true)
            $('#btn-update').text('Loading...')

            $('#btn-back').prop('disabled', true)
            $('#btn-back').text('Loading...')

            $.ajax({
                url: '{{ route('time_sheet.update', $timeSheet->id) }}',
                type: 'PUT',
                data: $('#form-time-sheet').serialize() + '&lama_waktu=' + $('#totalWaktuValue').text(),
                success: function(res) {
                    // console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Update data',
                        text: 'Berhasil'
                    }).then(function() {
                        window.location = '{{ route('time_sheet.index') }}'
                    })
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            });
        })
    </script>
@endpush
