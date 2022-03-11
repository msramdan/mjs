@extends('layouts.master')
@section('title', 'Create Spal')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('time_sheet_create') }}
        <form action="{{ route('spal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-3 ui-sortable">
                    <div class="panel panel-inverse">
                        <div class="panel-heading ui-sortable-handle">
                            <h4 class="panel-title">Spal</h4>
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
                        <div class="panel-body">
                            <div class="form-group mb-2">
                                <label class="form-label" for="spal">Spal</label>
                                <select class="form-select theSelect " id="spal_id" name="spal_id" required="">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($data as $item)
                                        <option value="{{ $item->id }}">{{ $item->kode }}</option>
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
                            <table class="table" id="tbl-detail-spal">
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
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Remark</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    </td>
                                    <td>
                                        <input type="date" name="date[]" placeholder="Date" class="form-control nama_berkas"
                                            required="" />
                                    </td>
                                    <td>
                                        <input style="width: 210px" type="text" name="remark[]" placeholder="Remark"
                                            class="form-control nama_berkas" required="" />
                                    </td>
                                    <td>
                                        <input type="time" name="from[]" placeholder="from" class="form-control nama_berkas"
                                            required="" />
                                    </td>
                                    <td>
                                        <input type="time" name="to[]" placeholder="to" class="form-control nama_berkas"
                                            required="" />
                                    </td>
                                    <td>
                                        <input style="width: 100px" type="text" name="keterangan[]"
                                            placeholder="Description" class="form-control nama_berkas" required="" />
                                    </td>
                                    <td style="width:20px">
                                        <button type="button" name="add_berkas" id="add_berkas" class="btn btn-success"><i
                                                class="fa fa-plus" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            </table>
                            <div style="float: left">
                                <b><span style="font-size: 14px;color:white"> Total Waktu : </span></b>
                            </div>
                            <div style="float: right">
                                <button type="submit" class="btn btn-danger"> Simpan</button>
                                <a href="{{ route('time_sheet.index') }}" class="btn btn-info"> Back</a>
                            </div>
                        </div>
                    </div>

                </div>
        </form>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"></td><td><input type="date" name="date[]" placeholder="Date" class="form-control nama_berkas" required="" /></td><td><input style="width: 210px" type="text" name="remark[]" placeholder="Remark"class="form-control nama_berkas" required="" /></td><td><input type="time" name="from[]" placeholder="from" class="form-control nama_berkas" required="" /></td><td><input type="time" name="to[]" placeholder="to" class="form-control nama_berkas" required="" /></td><td><input style="width: 100px" type="text" name="keterangan[]" placeholder="Description" class="form-control nama_berkas" required="" /></td><td><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

        });

        const spal_id = $('#spal_id')
        const customer = $('#customer')
        const namaKapal = $('#nama-kapal')
        const namaMuatan = $('#nama-muatan')
        const jmlMuatan = $('#jml-muatan')
        const pelabuhanMuat = $('#pelabuhan-muat')
        const pelabuhanBongkar = $('#pelabuhan-bongkar')
        const hargaUnit = $('#harga-unit')

        spal_id.change(function() {
            namaKapal.text('Loading...')
            namaMuatan.text('Loading...')
            jmlMuatan.text('Loading...')
            pelabuhanMuat.text('Loading...')
            pelabuhanBongkar.text('Loading...')
            hargaUnit.text('Loading...')
            $.ajax({
                url: '/sale/spal/get-spal-by-id/' + $(this).val(),
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
        })
    </script>
@endpush
