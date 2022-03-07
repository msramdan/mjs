@extends('layouts.master')
@section('title', trans('sidebar.sub_menu.neraca'))
@section('content')
    <style>
        .treegrid-indent {
            width: 0px;
            height: 16px;
            display: inline-block;
            position: relative;
        }

        .treegrid-expander {
            width: 0px;
            height: 16px;
            display: inline-block;
            position: relative;
            left: -17px;
            cursor: pointer;
        }

    </style>
    <div id="content" class="app-content">
        {{ Breadcrumbs::render('neraca_index') }}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">Laporan Neraca</h4>
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
                            <table id="tree-table" class="table table-hover table-bordered">
                                <tbody>
                                    <th>Akun COA</th>
                                    <th>Neraca</th>
                                    @foreach ($coaHeaders as $header)
                                        {{-- 1 debit kredit parent --}}

                                        @php
                                            $coaSubHeaders = \DB::table('coas')
                                                ->select('id', 'kode', 'nama')
                                                ->where('parent', $header->id)
                                                ->orderBy('kode', 'asc')
                                                ->get();
                                        @endphp
                                        @foreach ($coaSubHeaders as $coaSubHeader)
                                            @php
                                                $cek_list = \DB::table('coas')
                                                    ->select('id', 'kode', 'nama')
                                                    ->where('parent', $coaSubHeader->id)
                                                    ->orderBy('kode', 'asc')
                                                    ->get();
                                            @endphp
                                            @foreach ($cek_list as $list_coa)
                                                @php
                                                    $akunCoas = \DB::table('coas')
                                                        ->select('id', 'kode', 'nama')
                                                        ->where('parent', $list_coa->id)
                                                        ->orderBy('kode', 'asc')
                                                        ->get();
                                                @endphp
                                                @foreach ($akunCoas as $akunCoa)
                                                    @php
                                                        // 1
                                                        $list[] = $akunCoa->id;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                        @php
                                            $debit_parent = DB::table('jurnal_umum')
                                                ->join('coas', 'jurnal_umum.coa_id', '=', 'coas.id')
                                                ->whereIn('coa_id', $list)
                                                ->select('jurnal_umum.debit', 'coas.parent')
                                                ->sum('debit');

                                            $kredit_parent = DB::table('jurnal_umum')
                                                ->join('coas', 'jurnal_umum.coa_id', '=', 'coas.id')
                                                ->whereIn('coa_id', $list)
                                                ->select('jurnal_umum.kredit', 'coas.parent')
                                                ->sum('kredit');
                                            $list = [];
                                        @endphp

                                        <tr data-id="{{ $header->id }}" data-parent="0" data-level="1">
                                            <td data-column="name">{{ $header->kode . ' - ' . $header->nama }}</td>
                                            <td>{{ \Myhelper::indo_currency($debit_parent - $kredit_parent) }}
                                            </td>
                                        </tr>
                                        @php
                                            $coaSubHeaders = \DB::table('coas')
                                                ->select('id', 'kode', 'nama')
                                                ->where('parent', $header->id)
                                                ->orderBy('kode', 'asc')
                                                ->get();
                                        @endphp
                                        @foreach ($coaSubHeaders as $coaSubHeader)
                                            {{-- 2 ini untuk cek list under coa header --}}
                                            @php
                                                $cek_list = \DB::table('coas')
                                                    ->select('id', 'kode', 'nama')
                                                    ->where('parent', $coaSubHeader->id)
                                                    ->orderBy('kode', 'asc')
                                                    ->get();
                                            @endphp
                                            @foreach ($cek_list as $list_coa)
                                                @php
                                                    $akunCoas = \DB::table('coas')
                                                        ->select('id', 'kode', 'nama')
                                                        ->where('parent', $list_coa->id)
                                                        ->orderBy('kode', 'asc')
                                                        ->get();
                                                @endphp
                                                @foreach ($akunCoas as $akunCoa)
                                                    @php
                                                        // 2
                                                        $list[] = $akunCoa->id;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            @php
                                                $debit_grup = DB::table('jurnal_umum')
                                                    ->join('coas', 'jurnal_umum.coa_id', '=', 'coas.id')
                                                    ->whereIn('coa_id', $list)
                                                    ->select('jurnal_umum.debit', 'coas.parent')
                                                    ->sum('debit');

                                                $kredit_grup = DB::table('jurnal_umum')
                                                    ->join('coas', 'jurnal_umum.coa_id', '=', 'coas.id')
                                                    ->whereIn('coa_id', $list)
                                                    ->select('jurnal_umum.kredit', 'coas.parent')
                                                    ->sum('kredit');
                                                $list = [];
                                            @endphp
                                            <tr data-id="{{ $coaSubHeader->id }}" data-parent="{{ $header->id }}"
                                                data-level="2">
                                                <td data-column="name">
                                                    {{ $coaSubHeader->kode . ' - ' . $coaSubHeader->nama }}</td>
                                                <td>{{ \Myhelper::indo_currency($debit_grup - $kredit_grup) }}
                                                </td>
                                            </tr>
                                            @php
                                                $akunCoas = \DB::table('coas')
                                                    ->select('id', 'kode', 'nama')
                                                    ->where('parent', $coaSubHeader->id)
                                                    ->orderBy('kode', 'asc')
                                                    ->get();
                                            @endphp
                                            @foreach ($akunCoas as $akunCoa)
                                                {{-- debit kredit header kas dan bank --}}
                                                @php
                                                    $debit_header = DB::table('jurnal_umum')
                                                        ->join('coas', 'jurnal_umum.coa_id', '=', 'coas.id')
                                                        ->where('parent', $akunCoa->id)
                                                        ->select('jurnal_umum.debit', 'coas.parent')
                                                        ->sum('debit');

                                                    $kredit_header = DB::table('jurnal_umum')
                                                        ->join('coas', 'jurnal_umum.coa_id', '=', 'coas.id')
                                                        ->where('parent', $akunCoa->id)
                                                        ->select('jurnal_umum.kredit', 'coas.parent')
                                                        ->sum('kredit');
                                                @endphp

                                                <tr data-id="{{ $akunCoa->id }}" data-parent="{{ $coaSubHeader->id }}"
                                                    data-level="3">
                                                    <td data-column="name">
                                                        {{ $akunCoa->kode . ' - ' . $akunCoa->nama }}</td>
                                                    <td>{{ \Myhelper::indo_currency($debit_header - $kredit_header) }}
                                                    </td>
                                                </tr>
                                                @php
                                                    $subAkunCoas = \DB::table('coas')
                                                        ->select('id', 'kode', 'nama')
                                                        ->where('parent', $akunCoa->id)
                                                        ->orderBy('kode', 'asc')
                                                        ->get();
                                                @endphp
                                                @foreach ($subAkunCoas as $subAkunCoa)
                                                    {{-- debit kredit coa terkecil --}}
                                                    @php
                                                        $debit = DB::table('jurnal_umum')
                                                            ->where('coa_id', $subAkunCoa->id)
                                                            ->sum('debit');

                                                        $kredit = DB::table('jurnal_umum')
                                                            ->where('coa_id', $subAkunCoa->id)
                                                            ->sum('kredit');
                                                    @endphp
                                                    <tr data-id="{{ $subAkunCoa->id }}"
                                                        data-parent="{{ $akunCoa->id }}" data-level="4">
                                                        <td data-column="name">
                                                            {{ $subAkunCoa->kode . ' - ' . $subAkunCoa->nama }}</td>
                                                        <td>{{ \Myhelper::indo_currency($debit - $kredit) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
