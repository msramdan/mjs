@extends('layouts.master')
@section('title', 'Create ' . trans('sidebar.sub_menu.jurnal_umum'))

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('jurnal_umum_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('sidebar.sub_menu.jurnal_umum') }}</h4>
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
                <div class="row form-group">
					<div class="col-md-4 mb-1">
						<label class="form-label" for="start_date">Tanggal Transaksi</label>

						<div class="input-group mb-3">
							<input required="" class="form-control" type="date" id="start_date" name="start_date" placeholder="Tanggal Transaksi">
						</div>
					</div>
					<div class="col-md-4 mb-1">
						<label class="form-label" for="end_date">No. Bukti</label>
						<div class="input-group mb-3">
							<input required="" class="form-control" type="text" id="end_date" name="end_date" placeholder="No. Bukti">
						</div>
					</div>
				</div>
                    <button style="margin-bottom: 10px;" type="button" name="add_berkas" id="add_berkas" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                    <table class="table table-bordered " id="dynamic_field">
                            <tr>
                                <th style="width:20%">Nama Akun </th>
                                <th style="width:35%">Deksripsi</th>
                                <th style="width:20%">Debit</th>
                                <th style="width:20%">Kredit</th>
                                <th style="width:5%">Action</th>
                            </tr>
                    </table>
                    <table class="table " id="dynamic_field">
                        <tr>
                            <td style="width:20%">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> Create</button>
                                <a href="{{ route('jurnal-umum.index') }}" class="btn btn-info"><i class="fas fa-undo"></i> Kembali</a>
                            </td>
                            <td style="width:40%"></td>
                            <td style="width:20%;font-size:14px"> <b>Total Debit :</b> <br> Rp. 1.000.000</td>
                            <td style="width:20%;font-size:14px"> <b>Total Kredit :</b> <br> Rp. 1.000.000</td>
                        </tr>
                </table>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
        var i = 1;
        $('#add_berkas').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
                '"><td><select required name="account_coa_id[]" class="form-control theSelect" style="width: 100%;"><option value=""  style="color:black">-- Pilih -- </option><?php foreach ($coa as $key => $data) { ?><option  style="color:black" value="<?php echo $data->id ?>"><?php echo $data->kode ?> - <?php echo $data->nama ?></option><?php } ?></select></td><td><input type="text" name="deksripsi[]" placeholder="Deksripsi" class="form-control nama_berkas" required="" /></td><td><input type="number" name="debit[]" placeholder="Debit" class="form-control nama_berkas" required="" /></td><td><input type="number" name="kredit[]" placeholder="Kredit" class="form-control nama_berkas" required="" /></td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

});

    </script>
@endpush

