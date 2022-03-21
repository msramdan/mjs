@extends('layouts.master')
@section('title', 'Create Time Sheet')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('time_sheet_create') }}

        <form action="{{ route('time_sheet.store') }}" method="POST" id="form-time-sheet">
            @csrf
            @method('POST')

            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
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
                                        <option value="{{ $item->id }}">{{ $item->kode }}</option>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-inverse">
                        <div class="panel-heading">
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

                <div class="col-md-9">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Time Sheet</h4>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-hover" id="dynamic-field">
                                    <thead>
                                        <tr>
                                            <th width="40">#</th>
                                            <th>Date</th>
                                            <th>Remark</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Description</th>
                                            <th>Is Count</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>
                                                <input type="date" name="date[]" placeholder="Date" class="form-control"
                                                    required />
                                            </td>
                                            <td>
                                                <input type="text" name="remark[]" placeholder="Remark"
                                                    class="form-control" required />
                                            </td>
                                            <td>
                                                <input type="time" name="from[]" placeholder="from"
                                                    class="form-control start-time" required />
                                            </td>
                                            <td>
                                                <input type="time" name="to[]" placeholder="to"
                                                    class="form-control end-time" required />
                                            </td>
                                            <td>
                                                <input type="text" name="keterangan[]" placeholder="Description"
                                                    class="form-control" required />
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input mt-2 form-check-timesheet-input"
                                                    type="checkbox" name="is_count[]" value="null">
                                            </td>
                                            <td style="width:20px">
                                                <button type="button" name="add-berkas" id="add-berkas"
                                                    class="btn btn-success">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div style="float: left">
                                <p style="font-weight: bold; font-size: 14px;">Total Waktu :
                                    <span style="font-size: 14px;color:white; font-weight:normal;"
                                        id="total-waktu-value"></span>
                                </p>
                            </div>
                            <div style="float: right">
                                <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                                <a href="{{ route('time_sheet.index') }}" class="btn btn-info" id="btn-back">Back</a>
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
        const customer = $('#customer')
        const namaKapal = $('#nama-kapal')
        const namaMuatan = $('#nama-muatan')
        const jmlMuatan = $('#jml-muatan')
        const pelabuhanMuat = $('#pelabuhan-muat')
        const pelabuhanBongkar = $('#pelabuhan-bongkar')
        const hargaUnit = $('#harga-unit')

        function calculateTotalTimesheet() {
            let minutes = 0
            let totalChecked = 0

            $('.form-check-timesheet-input').each((i) => {
                if ($('.form-check-timesheet-input').eq(i).is(':checked') &&
                    $('.start-time').eq(i).val() &&
                    $('.end-time').eq(i).val()
                ) {
                    totalChecked++

                    // calculate total hours and minutes on .start-time and .end-time
                    let startTime = $('.start-time').eq(i).val().split(':')
                    let endTime = $('.end-time').eq(i).val().split(':')

                    let startHours = parseInt(startTime[0])
                    let startMinutes = parseInt(startTime[1])

                    let endHours = parseInt(endTime[0])
                    let endMinutes = parseInt(endTime[1])

                    // calculate total minutes
                    let totalMinutes = (endHours * 60 + endMinutes) - (startHours * 60 + startMinutes)

                    // add total minutes to minutes
                    minutes += totalMinutes

                    // calculate total hours
                    let totalHours = Math.floor(minutes / 60)

                    // calculate total minutes
                    let totalMinutesLeft = minutes % 60

                    // // add 0 if minutes less than 10
                    // if (totalMinutesLeft < 10) {
                    //     totalMinutesLeft = '0' + totalMinutesLeft
                    // }

                    // // add 0 if hours less than 10
                    // if (totalHours < 10) {
                    //     totalHours = '0' + totalHours
                    // }

                    // add total hours and minutes to .total-waktu-value
                    // $('#total-waktu-value').text(totalHours + ':' + totalMinutesLeft)

                    // let startTime = $('.start-time').eq(i).val()
                    // let endTime = $('.end-time').eq(i).val()

                    // let startTimeSplit = startTime.split(':')
                    // let endTimeSplit = endTime.split(':')

                    // let startTimeMinutes = parseInt(startTimeSplit[0]) * 60 + parseInt(startTimeSplit[1])
                    // let endTimeMinutes = parseInt(endTimeSplit[0]) * 60 + parseInt(endTimeSplit[1])

                    // minutes += endTimeMinutes - startTimeMinutes

                    // let hours = Math.floor(minutes / 60)
                    // let minutesLeft = minutes % 60

                    hoursToDays(totalHours + '.' + totalMinutesLeft)
                }

                if (totalChecked == 0) {
                    $('#total-waktu-value').text(`0 Hari 0 Jam 0 menit`)
                }
            })
        }

        // function to convert hours and minutes to days, hours, minutes
        function hoursToDays(time) {
            let timeSplit = time.split('.')
            let hours = parseInt(timeSplit[0])
            let minutes = parseInt(timeSplit[1])

            let days = Math.floor(hours / 24)
            let hoursLeft = hours % 24

            // // add 0 if minutes less than 10
            // if (minutes < 10) {
            //     minutes = '0' + minutes
            // }

            // // add 0 if hours less than 10
            // if (hoursLeft < 10) {
            //     hoursLeft = '0' + hoursLeft
            // }

            $('#total-waktu-value').text(`${days} Hari ${hoursLeft} Jam ${minutes} menit`)
        }

        function splitTime(numberOfHours) {
            let days = Math.floor(numberOfHours / 24)
            let remainder = numberOfHours % 24
            let hours = Math.floor(remainder)
            let minutes = Math.floor(60 * (remainder - hours))

            // console.log({
            //     "days": days,
            //     "hours": hours,
            //     "minutes": minutes
            // });

            $('#total-waktu-value').text(`${days} Hari ${hours} Jam ${minutes} menit`)
        }

        $('#add-berkas').click(function() {
            $('#dynamic-field tbody').append(`
            <tr>
                <td>
                    <input class="form-check-input form-check-timesheet-input" type="checkbox" value="">
                </td>
                <td>
                    <input type="date" name="date[]" placeholder="Date" class="form-control" required />
                </td>
                <td>
                    <input type="text" name="remark[]" placeholder="Remark"class="form-control" required />
                </td>
                <td>
                    <input type="time" name="from[]" placeholder="from" class="form-control start-time" required />
                </td>
                <td>
                    <input type="time" name="to[]" placeholder="to" class="form-control end-time" required />
                </td>
                <td>
                    <input type="text" name="keterangan[]" placeholder="Description" class="form-control" required />
                </td>
                <td class="text-center">
                    <input class="form-check-input mt-2 form-check-timesheet-input" type="checkbox" name="is_count[]" value="null">
                </td>
                <td>
                    <button type="button" name="remove" class="btn btn-danger btn-remove">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>`);

            generateNo()
        })

        $(document).on('click', '.btn-remove', function() {
            // parent 1 td, parent 2 tr
            $(this).parent().parent().remove()
            generateNo()
            calculateTotalTimesheet()
        })

        $('#spal').change(function() {
            namaKapal.text('Loading...')
            namaMuatan.text('Loading...')
            jmlMuatan.text('Loading...')
            pelabuhanMuat.text('Loading...')
            pelabuhanBongkar.text('Loading...')
            hargaUnit.text('Loading...')

            $.ajax({
                url: '/sale/spal/get-spal-by-id/' + $(this).val(),
                type: 'GET',
                success: function(res) {
                    setTimeout(() => {
                        namaKapal.text(res.nama_kapal)
                        namaMuatan.text(res.nama_muatan)
                        jmlMuatan.text(res.jml_muatan)
                        pelabuhanMuat.text(res.pelabuhan_muat)
                        pelabuhanBongkar.text(res.pelabuhan_bongkar)
                        hargaUnit.text(thousandFormat(res.harga_unit))
                    }, 500)
                },
            });
        })

        $(document).on('change', '.form-check-timesheet-input', function() {
            calculateTotalTimesheet()
        })

        $(document).on('change', '.start-time', function() {
            calculateTotalTimesheet()
        })

        $(document).on('change', '.end-time', function() {
            calculateTotalTimesheet()
        })

        $('#form-time-sheet').submit(function(e) {
            e.preventDefault()

            $('#btn-save').prop('disabled', true)
            $('#btn-save').text('Loading...')

            $('#btn-back').prop('disabled', true)
            $('#btn-back').text('Loading...')

            // include unchecklist checkbox to be inside form data
            let formData = new FormData()
            $('.form-check-timesheet-input').each((i) => {
                if (!$('.form-check-timesheet-input').eq(i).is(':checked')) {
                    formData.append('is_count[]', 'false')
                } else {
                    formData.append('is_count[]', 'true')
                }
            })

            // serialize data then append to formData
            let data = $(this).serializeArray()
            data.forEach((item) => {
                if (item.name != 'is_count[]') {
                    formData.append(item.name, item.value)
                }
            })

            formData.append('lama_waktu', $('#total-waktu-value').text())

            // delete data with is_count[] == null from formData
            formData.forEach((item, index) => {
                if (item.name === 'is_count[]' && item.value == 'null') {
                    formData.delete(index)
                }
            })

            $.ajax({
                url: '{{ route('time_sheet.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    // console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Simpan data',
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

        function generateNo() {
            let no = 1

            $('#dynamic-field').find('tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        function thousandFormat(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }
    </script>
@endpush
