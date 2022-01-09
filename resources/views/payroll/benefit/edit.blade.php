@extends('layouts.master')
@section('title', 'Tambah Data benefit')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('benefit_index') }}
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ trans('benefit.edit.daftar_benefit') }}</h4>
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
                        <form action="{{ route('benefit.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label" for="category_benefit_id">Kategori Benefit</label>
                                <select class="form-select @error('category_benefit_id') is-invalid @enderror "
                                    id="category_benefit_id" name="category_benefit_id">
                                    <option value="" disabled="" selected="">-- Pilih --</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->category_benefit_id }}"
                                            {{ old('category_benefit_id') && old('category_benefit_id') == $item->category_benefit_id ? 'selected' : $item->category_benefit_id }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('category_benefit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="besar_benefit">Besar Benefit</label>
                                <input class="form-control @error('besar_benefit') is-invalid @enderror" type="number"
                                    id="besar_benefit" name="besar_benefit" autocomplete="off" placeholder="Besar Benefit"
                                    value="{{ old('besar_benefit') }}" />
                                @error('besar_benefit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <input class="form-control @error('karyawan_id') is-invalid @enderror" type="hidden"
                                id="karyawan_id" name="karyawan_id" placeholder="Besar benefit"
                                value="{{ $karyawan_id }}" />

                            <button type="reset" class="btn btn-secondary me-1">Reset</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ trans('benefit.edit.ditambahakan') }}</h4>
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
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="data-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kategori Benefit</th>
                                        <th>Besar Benefit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="daftar_benefit"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script type="text/javascript">
        $(document).ready(function() {
            var karyawan_id = $("#karyawan_id").val();

            $.ajax({
                url: '{{ url('payroll/benefit') }}' + '/' + karyawan_id,
                method: "GET",
                data: {},
                success: function(data) {
                    $('#daftar_benefit').html(data);
                }
            })
        });
    </script>
@endpush
