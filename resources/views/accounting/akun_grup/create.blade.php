@extends('layouts.master')
@section('title', 'Create Akun Grup')

@section('content')
    <div id="content" class="app-content">
        {{ Breadcrumbs::render('grup_create') }}
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Akun Grup</h4>
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
                <form action="{{ route('akun_grup.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="row">
                            <div class="form-group mb-3">
                                <label class="form-label" for="account_group">Akun Grup</label>
                                <input class="form-control @error('account_group') is-invalid @enderror" type="text" id="code_account_group"
                                    name="account_group" placeholder="Akun Grup" value="{{ old('account_group') }}"   />
                                @error('account_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="report">Report</label>
                                <select class="form-select @error('report') is-invalid @enderror" id="report"
                                name="report">
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="Balance Sheet" {{ old('report') == 'Balance Sheet'? 'selected' : '' }}
                                        >Balance Sheet
                                    </option>
                                    <option value="Income Statment" {{ old('report') == 'Income Statment' ? 'selected' : '' }}
                                        >Income Statment
                                    </option>
                                </select>
                                @error('report')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    </div>
                    <button type="reset" class="btn btn-secondary me-1">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
