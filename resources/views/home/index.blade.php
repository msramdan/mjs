@extends('layouts.master')
@section('title', 'Home')

@section('content')
    <div id="content" class="app-content">
        {{-- breadcrumb --}}
        {{-- {{ Breadcrumbs::render('home') }} --}}
        {{-- <h1 class="page-header">Blank Page <small>header small text goes here...</small></h1> --}}
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Home</h4>
                <div class="panel-heading-btn">
                    {{-- <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a> --}}
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
                            class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i
                            class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i
                            class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">

                    <div class="col-xl-3 col-md-6">
                        <div class="widget widget-stats bg-gradient-cyan-blue">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">WAITING REQUEST FORM </div>
                                <div class="stats-number">1 DATA</div>
                                <div class="stats-progress progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6">
                        <div class="widget widget-stats bg-gradient-indigo">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">WAITING PURCHASE ORDER </div>
                                <div class="stats-number">1 DATA</div>
                                <div class="stats-progress progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6">
                        <div class="widget widget-stats bg-gradient-orange-red">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-archive fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">SALE ORDER</div>
                                <div class="stats-number">1 DATA</div>
                                <div class="stats-progress progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6">
                        <div class="widget widget-stats bg-gradient-green">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">SPAL</div>
                                <div class="stats-number">1 DATA</div>
                                <div class="stats-progress progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-xl-3 col-md-6">
                        <div class="widget widget-stats bg-gradient-cyan-blue">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">Jumlah Karyawan</div>
                                <div class="stats-number">1 DATA</div>
                                <div class="stats-progress progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-3 col-md-6">
                        <div class="widget widget-stats bg-gradient-indigo">
                            <div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
                            <div class="stats-content">
                                <div class="stats-title">TIKET OPEN</div>
                                <div class="stats-number">1 DATA</div>
                                <div class="stats-progress progress">
                                    <div class="progress-bar" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
@endsection
