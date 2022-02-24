@extends('layouts.master')
@section('title', 'COA')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('coa_index') }}

        @can('create coa')
            <div class="d-flex justify-content-end">
                <a href="{{ route('coa.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus me-1"></i>
                    Create
                </a>
            </div>
        @endcan

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
                        <div class="card bg-dark border-0 text-white">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" id="data-table" width="100%">
                                        <thead>
                                            <tr>
                                                {{-- <th>No</th> --}}
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                @canany(['edit coa', 'delete coa'])
                                                    <th>Action</th>
                                                @endcanany
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($coas as $coa)
                                                <tr>
                                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                                    <td>{{ $coa->kode }}</td>
                                                    <td>{{ $coa->nama }}</td>
                                                    @canany(['edit coa', 'delete coa'])
                                                        <td>
                                                            @can('edit coa')
                                                                <a href="{{ route('coa.edit', $coa->id) }}"
                                                                    class="btn btn-primary btn-xs mb-1">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            @endcan

                                                            @can('delete coa')
                                                                <form action="{{ route('coa.destroy', $coa->id) }}" method="POST"
                                                                    class="d-inline"
                                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                                    @method('DELETE')
                                                                    @csrf

                                                                    <button type="submit" class="btn btn-danger btn-xs mb-1">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        </td>
                                                    @endcanany
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $coas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Tree view</h4>
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
                        <div id="jstree-default">
                            @foreach ($coaHeaders as $header)
                                <ul>
                                    <li data-jstree='{"opened":true}'>
                                        {{ $header->kode . ' - ' . $header->nama }}

                                        @php
                                            $coaSubHeaders = \DB::table('coas')
                                                ->select('id', 'kode', 'nama')
                                                ->where('parent', $header->id)
                                                ->get();
                                        @endphp
                                        @foreach ($coaSubHeaders as $coaSubHeader)
                                            <ul>
                                                <li>
                                                    {{ $coaSubHeader->kode . ' - ' . $coaSubHeader->nama }}

                                                    @php
                                                        $akunCoas = \DB::table('coas')
                                                            ->select('id', 'kode', 'nama')
                                                            ->where('parent', $coaSubHeader->id)
                                                            ->get();
                                                    @endphp
                                                    @foreach ($akunCoas as $akunCoa)
                                                        <ul>
                                                            <li>
                                                                {{ $akunCoa->kode . ' - ' . $akunCoa->nama }}

                                                                @php
                                                                    $subAkunCoas = \DB::table('coas')
                                                                        ->select('id', 'kode', 'nama')
                                                                        ->where('parent', $akunCoa->id)
                                                                        ->get();
                                                                @endphp
                                                                @foreach ($subAkunCoas as $subAkunCoa)
                                                                    <ul>
                                                                        <li>
                                                                            {{ $subAkunCoa->kode . ' - ' . $subAkunCoa->nama }}
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            </li>
                                                        </ul>
                                                    @endforeach
                                                </li>
                                            </ul>
                                        @endforeach
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
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
