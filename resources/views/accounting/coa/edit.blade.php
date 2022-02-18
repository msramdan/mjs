@extends('layouts.master')
@section('title', 'Edit COA')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('coa_edit') }}

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Form Coa</h4>
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
                        <form action="{{ route('coa.update', $coa->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode" value="{{ $coa->kode ?? old('kode') }}" autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama" value="{{ $coa->nama ?? old('nama') }}" />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="tipe">Tipe</label>
                                <select class="form-select @error('tipe') is-invalid @enderror" name="tipe" id="tipe">
                                    @foreach ($coaTypes as $tipe)
                                        <option value="{{ $tipe->kode }}"
                                            {{ $coa->tipe == $tipe->kode ? 'selected' : '' }}>
                                            {{ $tipe->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="parent">Parent</label>
                                <select class="form-select @error('parent') is-invalid @enderror" name="parent" id="parent">
                                    <option value="" selected disabled>-- Pilih parent -- </option>
                                    <option value="" {{ $coa->parent == null ? 'selected' : '' }}>No Parent</option>
                                    @foreach ($coaParents as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ $coa->parent == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->kode . ' - ' . $parent->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="reset" class="btn btn-secondary me-1">Reset</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
