<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">List {{ trans('sidebar.sub_menu.coa') }}</h4>
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
            @foreach ($treeview as $grup)
                <ul>
                    <li data-jstree='{"opened":true}'>
                        {{ $grup->report . ' - ' . $grup->nama }}

                        @foreach ($grup->akun_header as $header)
                            <ul>
                                <li>
                                    {{ $header->kode . ' - ' . $header->nama }}

                                    @foreach ($header->akun_coa as $coa)
                                        <ul>
                                            <li>
                                                {{ $coa->kode . ' - ' . $coa->nama }}
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
