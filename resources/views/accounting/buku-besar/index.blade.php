@extends('layouts.master')
@section('title', trans('sidebar.sub_menu.buku_besar'))

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('buku_besar_index') }}

        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Filter {{ trans('sidebar.sub_menu.buku_besar') }}</h4>
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
                        <form action="{{ route('buku-besar.index') }}" method="GET">
                            <div class="form-group mb-2">
                                <label for="start-date">Start Date</label>
                                <input type="date" name="start_date" id="start-date" class="form-control"
                                    value="{{ request()->start_date ? date('Y-m-d', strtotime(request()->start_date)) : '' }}"
                                    required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="end-date">End Date</label>
                                <input type="date" name="end_date" id="end-date" class="form-control"
                                    value="{{ request()->end_date ? date('Y-m-d', strtotime(request()->end_date)) : '' }}"
                                    required>
                            </div>

                            <div class="form-group mb-2">
                                <label for="coa">COA</label>
                                <select name="coa" id="coa" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih COA -- </option>
                                    @foreach ($akunDetail as $ad)
                                        <option value="{{ $ad->id }}"
                                            {{ request()->coa == $ad->id ? 'selected' : '' }}>
                                            {{ $ad->kode . ' - ' . $ad->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <a href="{{ route('buku-besar.index') }}" class="btn btn-dark mt-2">Reset</a>

                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ trans('sidebar.sub_menu.buku_besar') }}</h4>
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
                        <div class="card bg-dark border-0 text-white">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" id="data-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>No. Bukti</th>
                                                <th>No. Akun</th>
                                                <th>Nama Akun</th>
                                                <th>Description</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($generalLegders as $generalLegder)
                                                <tr>
                                                    <td>{{ $generalLegder->tanggal->format('d/m/Y') }}</td>
                                                    <td>{{ $generalLegder->no_bukti }}</td>
                                                    <td>{{ $generalLegder->coa->kode }}</td>
                                                    <td>{{ $generalLegder->coa->nama }}</td>
                                                    <td>{{ $generalLegder->deskripsi }}</td>
                                                    <td>{{ number_format($generalLegder->debit) }}</td>
                                                    <td>{{ number_format($generalLegder->kredit) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    {{ $generalLegders->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
