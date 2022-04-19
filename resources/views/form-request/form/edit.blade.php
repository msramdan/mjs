@extends('layouts.master')
@section('title', 'Edit Request Form')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('request_form_edit') }}

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
                <form action="{{ route('request-form.update', $requestForm->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="kode"
                                    value="{{ old('kode') ? old('kode') : $requestForm->kode }}" required readonly />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="tanggal">Tanggal</label>
                                <input class="form-control @error('tanggal') is-invalid @enderror" type="date" id="tanggal"
                                    name="tanggal"
                                    value="{{ old('tanggal') ? old('tanggal') : $requestForm->tanggal->format('Y-m-d') }}"
                                    required />
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="lokasi_id">Lokasi</label>
                                <select class="form-select @error('lokasi_id') is-invalid @enderror" id="lokasi_id"
                                    name="lokasi_id" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($lokasi as $row)
                                        <option value="{{ $row->id }}"  {{ $requestForm->lokasi_id == $row->id ? 'selected' : '' }}>{{ $row->nama }}</option>
                                    @endforeach
                                </select>
                                @error('lokasi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="category_request">Category Request</label>
                                <select class="form-select @error('category_request') is-invalid @enderror"
                                    id="category_request" name="category_request" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @forelse ($categoryRequest as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $requestForm->category_request_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @empty
                                        <option value="" disabled>Data tidak ditemukan</option>
                                    @endforelse
                                </select>
                                @error('category_request')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="berita_acara">Berita Acara</label>
                        <textarea class="form-control @error('berita_acara') is-invalid @enderror" id="berita_acara"
                            name="berita_acara" rows="5"
                            required>{{ old('berita_acara') ? old('berita_acara') : $requestForm->berita_acara }}</textarea>
                        @error('berita_acara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between mb-3">
                        <div class="me-3 mt-2">
                            <h5>Attachment File</h5>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="button" id="btn-add" title="Add new file">
                                {{-- <i class="fas fa-plus"></i> --}}
                                Add
                            </button>
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
                                            <div class="form-group">
                                                <input class="form-control nama" type="text" name="nama[]"
                                                    value="{{ $detail->nama }}" placeholder="Nama File" required />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control file" type="file" name="file[]" />
                                            </div>
                                        </td>
                                        <td>
                                            @if ($loop->iteration > 1)
                                                <button class="btn btn-danger me-1 btn-hapus" type="button" title="Delete">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-danger me-1 disabled btn-hapus" type="button" title="Delete"
                                                    disabled>
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route('request-form.download', $detail->file) }}" target="_blank"
                                                class="btn btn-primary btn-download" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="reset" class="btn btn-secondary me-1" title="Reset">Reset</button>
                    <button type="submit" class="btn btn-success" title="Save">Simpan</button>
                </form>

                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        @include('form-request.form.include.timeline')
    </div>
@endsection

@push('js')
    <script>
        const tanggal = $('#tanggal')
        const kode = $('#kode')

        tanggal.change(function() {
            getKode()
        })

        function getKode() {
            kode.val('Loading...')

            $.ajax({
                url: '/request-form/generate-kode/' + tanggal.val(),
                method: 'GET',
                success: function(res) {
                    setTimeout(() => {
                        kode.val(res.kode)
                    }, 500)
                }
            })
        }

        $('#btn-add').click(function() {
            let table = $('#tbl-file tbody')

            let tr = ` <tr>
                <td>
                    <div class="form-group">
                    <input class="form-control nama" type="text" name="nama[]" placeholder="Nama File" required />
                    </div>
                </td>
                <td>
                    <div class="form-group">
                    <input class="form-control file" type="file" name="file[]" required />
                    </div>
                </td>
                <td>
                    <button class="btn btn-danger btn-hapus" type="button" title="Delete">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>`

            table.append(tr)
        })

        $(document).on('click', '.btn-hapus', function() {
            let table = $('#tbl-file tbody tr')

            if (table.length > 1) {
                $(this).parent().parent().remove()
            }
        })
    </script>
@endpush
