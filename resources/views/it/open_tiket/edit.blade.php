@extends('layouts.master')
@section('title', 'Create Category')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('open_tiket_edit') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Tiket Helpdesk IT</h4>
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
                <form action=" {{ route('open_tiket.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="judul">Judul</label>
                                <input class="form-control @error('judul') is-invalid @enderror" type="text" id="judul"
                                    name="judul" placeholder="Judul"
                                    value="{{ old('judul') ? old('judul') : $data->judul }}" autofocus />
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="Pesan">Pesan</label>
                                <textarea class="form-control @error('pesan') is-invalid @enderror" name="pesan" id="" cols=" 30"
                                    rows="10">{{ old('pesan') ? old('pesan') : $data->pesan }}</textarea>
                                @error('pesan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                @if ($data->photo != '' || $data->photo != null)
                                    <img src="{{ Storage::url('public/it/open_tiket/') . $data->photo }}" class=""
                                        style="width: 150px">
                                    <p style="color: red">*Silahkan pilih file attachment jika ingin merubahnya</p>
                                @endif

                                <label class="form-label" for="nama">File Attachment</label>
                                <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo"
                                    name="photo" placeholder="photo" value="{{ old('photo') }}" />
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (Auth::user()->id==1)
                            <div class="form-group mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Open" {{ $data->status == 'Open' ? 'selected' : '' }}>Open</option>
                                    <option value="On Progress" {{ $data->status == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                                    <option value="Closed" {{ $data->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                            @endif

                        </div>

                    </div>

                    <button type="reset" class="btn btn-secondary me-1">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
