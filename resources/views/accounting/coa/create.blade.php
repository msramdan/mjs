@extends('layouts.master')
@section('title', 'Create COA')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('coa_create') }}

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Form {{ trans('sidebar.sub_menu.coa') }}</h4>
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
                        <form action="{{ route('akun-coa.store') }}" method="POST">
                            @csrf
                            @method('POST')

                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode" value="{{ old('kode') }}" autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama" value="{{ old('nama') }}" />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="normal">Normal</label>
                                <input class="form-control @error('normal') is-invalid @enderror" type="text" id="normal"
                                    name="normal" placeholder="Normal" value="{{ old('normal') }}" />
                                @error('normal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group mb-3">
                                <label class="form-label" for="remark">Remark</label>
                                <input class="form-control @error('remark') is-invalid @enderror" type="text" id="remark"
                                    name="remark" placeholder="Remark" value="{{ old('remark') }}" />
                                @error('remark')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group mb-3">
                                <label class="form-label" for="account_header_id">Akun Header</label>
                                <select class="form-select @error('account_header_id') is-invalid @enderror"
                                    id="account_header_id" name="account_header_id">
                                    <option value="" disabled selected>-- Pilih --</option>

                                    @foreach ($akunHeader as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('account_header_id') && old('account_header_id') == $item->id ? 'selected' : $item->id }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('account_header_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="reset" class="btn btn-secondary me-1">Reset</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                @include('accounting.coa._treeview')
            </div>
        </div>
    </div>
    </div>
@endsection

@push('css')
    <link href="{{ asset('template/assets/plugins/jstree/dist/themes/default/style.min.css') }}" rel="stylesheet" />
@endpush

@push('js')
    <script src="{{ asset('template/assets/plugins/jstree/dist/jstree.min.js') }}"></script>

    {{-- <script src="{{ asset('template/assets/js/demo/ui-tree.demo.js') }}"></script> --}}

    <script>
        $("#jstree-default").jstree({
            "plugins": ["types"],
            "core": {
                "themes": {
                    "responsive": false
                }
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder text-warning fa-lg"
                },
                "file": {
                    "icon": "fa fa-file text-dark fa-lg"
                }
            }
        });
    </script>
@endpush
