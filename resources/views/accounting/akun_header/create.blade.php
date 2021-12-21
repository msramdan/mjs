@extends('layouts.master')
@section('title', 'Create Category')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('category_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Akun Header</h4>
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
                <form action="{{ route('akun_header.store') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="row">
                            <div class="form-group mb-3">
                                <label class="form-label" for="code_account_header">Kode Akun Header</label>
                                <input class="form-control @error('code_account_header') is-invalid @enderror" type="text" id="code_account_header"
                                    name="code_account_header" placeholder="Kode Akun Header" value="{{ old('code_account_header') }}"  autofocus />
                                @error('code_account_header')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="account_header">Akun Header</label>
                                <input class="form-control @error('account_header') is-invalid @enderror" type="text" id="code_account_header"
                                    name="account_header" placeholder="Akun Header" value="{{ old('account_header') }}"   />
                                @error('account_header')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="account_group_id ">Status</label>
                                <select class="form-select @error('account_group_id ') is-invalid @enderror" id="account_group_id " name="account_group_id"
                                    >
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($AkunGrup as $item)
                                        <option value="{{ $item->id }}" {{ old('account_group_id') && old('account_group_id') == $item->id ? 'selected' : $item->id }}>{{ $item->account_group }}</option>
                                    @endforeach
                                </select>
                                @error('account_group_id ')
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
