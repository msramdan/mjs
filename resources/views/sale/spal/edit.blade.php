@extends('layouts.master')
@section('title', 'Edit Spal')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('spal_edit') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
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
                <form action="{{ route('spal.update', $spal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode" value="{{ old('kode') ? old('kode') : $spal->kode }}"
                                    required autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama_kapal">Nama Kapal</label>
                                <input class="form-control @error('nama_kapal') is-invalid @enderror" type="text"
                                    id="nama_kapal" name="nama_kapal" placeholder="Nama Kapal"
                                    value="{{ old('nama_kapal') ? old('nama_kapal') : $spal->nama_kapal }}" required />
                                @error('nama_kapal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="nama_muatan">Nama Muatan</label>
                                        <input class="form-control @error('nama_muatan') is-invalid @enderror" type="text"
                                            id="nama_muatan" name="nama_muatan" placeholder="Nama Muatan"
                                            value="{{ old('nama_muatan') ? old('nama_muatan') : $spal->nama_muatan }}"
                                            required />
                                        @error('nama_muatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="jml_muatan">Jumlah Muatan</label>
                                        <input class="form-control @error('jml_muatan') is-invalid @enderror" type="text"
                                            id="jml_muatan" name="jml_muatan" placeholder="Jumlah Muatan"
                                            value="{{ old('jml_muatan') ? old('jml_muatan') : $spal->jml_muatan }}"
                                            required />
                                        @error('jml_muatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="customer">Customer</label>
                                <select class="form-select @error('customer') is-invalid @enderror" id="customer"
                                    name="customer" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($customer as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $spal->customer_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="harga_unit">Harga/Unit</label>
                                        <input class="form-control @error('harga_unit') is-invalid @enderror" type="text"
                                            id="harga_unit" name="harga_unit" placeholder="Harga/Unit"
                                            value="{{ old('harga_unit') ? old('harga_unit') : $spal->harga_unit }}"
                                            required />
                                        @error('harga_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="harga_demorage">Harga Demorage</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input class="form-control @error('harga_demorage') is-invalid @enderror"
                                                type="text" id="harga_demorage" name="harga_demorage"
                                                placeholder="Harga Demorage"
                                                value="{{ old('harga_demorage') ? old('harga_demorage') : $spal->harga_demorage }}" />
                                            @error('harga_demorage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="pelabuhan_muat">Pelabuhan Muat</label>
                                    <input class="form-control @error('pelabuhan_muat') is-invalid @enderror" type="text"
                                        id="pelabuhan_muat" name="pelabuhan_muat" placeholder="Pelabuhan Muat"
                                        value="{{ old('pelabuhan_muat') ? old('pelabuhan_muat') : $spal->pelabuhan_muat }}"
                                        required />
                                    @error('pelabuhan_muat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="pelabuhan_bongkar">Pelabuhan Bongkar</label>
                                    <input class="form-control @error('pelabuhan_bongkar') is-invalid @enderror" type="text"
                                        id="pelabuhan_bongkar" name="pelabuhan_bongkar" placeholder="Pelabuhan Bongkar"
                                        value="{{ old('pelabuhan_bongkar') ? old('pelabuhan_bongkar') : $spal->pelabuhan_bongkar }}"
                                        required />
                                    @error('pelabuhan_bongkar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div id="file-attc">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="pt-3">Attachment File</h5>
                            </div>

                            <div>
                                <button class="btn btn-primary" type="button" id="btn-add-file">
                                    <i class="fas fa-file me-1"></i>
                                    Add
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive mt-0">
                            <table class="table table-striped table-hover table-bordered mt-2" id="tbl-file">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spal->file_spal as $detail)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <input class="form-control @error('nama') is-invalid @enderror nama"
                                                        type="text" name="nama_file[]" id="nama" placeholder="Nama File"
                                                        value="{{ $detail->nama }}" required />
                                                    @error('nama')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input class="form-control @error('file') is-invalid @enderror file"
                                                        type="file" name="file[]" id="file" />
                                                    @error('file')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-danger btn-delete-file{{ $loop->iteration == 1 ? ' disabled' : '' }}"
                                                    type="button" {{ $loop->iteration == 1 ? 'disabled' : '' }}>
                                                    <i class="fas fa-times"></i>
                                                </button>

                                                <a href="{{ route('spal.download', $detail->file) }}" target="_blank"
                                                    class="btn btn-primary btn-download ms-1">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="reset" class="btn btn-secondary me-1">Reset</button>
                        <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"
        integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const config = {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        };

        const jml_muatan = new Cleave("#jml_muatan", config)
        const harga_unit = new Cleave("#harga_unit", config);
        const harga_demorage = new Cleave("#harga_demorage", config);

        const tableFile = $('#tbl-file tbody')

        $('#btn-add-file').click(function() {
            let tr = ` <tr>
                <td>
                    <div class="form-group">
                    <input class="form-control" type="text" name="nama_file[]" placeholder="Nama File" required />
                    </div>
                </td>
                <td>
                    <div class="form-group">
                    <input class="form-control" type="file" name="file[]" required />
                    </div>
                </td>
                <td>
                    <button class="btn btn-danger btn-delete-file" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>`

            tableFile.append(tr)
        })

        $(document).on('click', '.btn-delete-file', function() {
            if (tableFile.find('tr').length > 1) {
                $(this).parent().parent().remove()
            }
        })
    </script>
@endpush
