@extends('layouts.master')
@section('title', trans('sidebar.sub_menu.neraca'))

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('neraca_index') }}

        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Filter {{ trans('sidebar.sub_menu.neraca') }}</h4>
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
                        <form action="{{ route('neraca.index') }}" method="GET">
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

                            <a href="{{ route('neraca.index') }}" class="btn btn-dark mt-2">Reset</a>

                            <button type="submit" class="btn btn-primary mt-2">Search</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ trans('sidebar.sub_menu.neraca') }}</h4>
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
                                                <th>No. Akun</th>
                                                <th>Nama Akun</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @forelse ($neracas as $neraca)
                                                <tr>
                                                    <td>{{ $neraca->tanggal->format('d/m/Y') }}</td>
                                                    <td>{{ $neraca->coa->kode }}</td>
                                                    <td>{{ $neraca->coa->nama }}</td>
                                                    <td>{{ number_format($neraca->debit) }}</td>
                                                    <td>{{ number_format($neraca->kredit) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                                                </tr>
                                            @endforelse --}}
                                        </tbody>
                                    </table>


                                    @dump($neracas)

                                    {{-- {{ $neracas->withQueryString()->links() }} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
