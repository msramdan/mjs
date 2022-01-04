@extends('layouts.master')
@section('title', 'Detail Request Form')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('request_form_show') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Request Form</h4>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label" for="kode">Kode</label>
                            <input class="form-control" type="text" id="kode" name="kode" placeholder="kode"
                                value="{{ $requestForm->kode }}" disabled />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label" for="tanggal">Tanggal</label>
                            <input class="form-control" type="date" id="tanggal" name="tanggal"
                                value="{{ $requestForm->tanggal->format('Y-m-d') }}" disabled />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label class="form-label" for="category_request">Category Request</label>
                            <select class="form-select" id="category_request" name="category_request" readonly>
                                <option value="{{ $requestForm->category_request->id }}" selected>
                                    {{ $requestForm->category_request->nama }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="berita_acara">Berita Acara</label>
                    <textarea class="form-control @error('berita_acara') is-invalid @enderror" id="berita_acara"
                        name="berita_acara" rows="5"
                        disabled>{{ old('berita_acara') ? old('berita_acara') : $requestForm->berita_acara }}</textarea>
                    @error('berita_acara')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between mb-3">
                    <div class="me-3 mt-2">
                        <h5>Attachment File</h5>
                    </div>
                </div>

                <div class="table-responsive mt-0">
                    <table class="table table-bordered" id="tbl-file">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requestForm->detail_request_form as $detail)
                                <tr>
                                    <td>
                                        {{ $detail->nama }}
                                    </td>
                                    <td>
                                        {{ $detail->file }}
                                    </td>
                                    <td>
                                        <a href="{{ route('request-form.download', $detail->file) }}" target="_blank"
                                            class="btn btn-primary btn-download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('request-form.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        @include('form-request.form.include.timeline', ['show' => true])
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
        integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }

        trix-editor,
        trix-toolbar {
            pointer-events: none;
        }

    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"
        integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        })

        document.querySelector("trix-initialize").contentEditable = false
    </script>
@endpush
