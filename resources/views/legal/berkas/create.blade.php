@extends('layouts.master')
@section('title', 'Create Berkas Karyawan')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('berkas_karyawan_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Berkas Karyawan</h4>
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
                @if ($karyawan->berkas_karyawan_count)
                    <form action="{{ route('berkas-karyawan.update', $karyawan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form action="{{ route('berkas-karyawan.store') }}" method="POST" enctype="multipart/form-data">
                            @method('POST')
                @endif

                @csrf

                <input type="hidden" name="karyawan" value="{{ request('karyawan') }}">

                <div class="d-flex justify-content-center">
                    <div class="me-3 mt-2">
                        <h5>Berkas Karyawan:
                            <strong>
                                {{ $karyawan->nama }}
                            </strong>
                        </h5>
                    </div>

                    <div>
                        <button class="btn btn-primary" type="button" id="btn-add">
                            {{-- <i class="fas fa-plus"></i> --}}
                            Add
                        </button>
                    </div>
                </div>

                <div class="table-responsive mt-0">
                    <table class="table table-transparent" id="tbl-file">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawan->berkas_karyawan as $berkas)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control nama" type="text" name="nama[]"
                                                value="{{ $berkas->nama }}" placeholder="Nama File" required />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control file" type="file" name="file[]" />
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('berkas-karyawan.download', $berkas->file) }}" target="_blank"
                                            class="btn btn-info">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @if ($loop->iteration == 1)
                                            <button class="btn btn-danger disabled btn-hapus" type="button" disabled>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-danger btn-hapus" type="button">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control nama" type="text" name="nama[]"
                                                placeholder="Nama File" required />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control file" type="file" name="file[]" required />
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger disabled btn-hapus" type="button" disabled>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <button type="reset" class="btn btn-secondary me-1">Reset</button>
                <button type="submit" class="btn btn-success">
                    @if ($karyawan->berkas_karyawan_count)
                        Update
                    @else
                        Simpan
                    @endif
                </button>
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
    </div>
@endsection

@push('js')
    <script>
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
                    <button class="btn btn-danger btn-hapus" type="button">
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
