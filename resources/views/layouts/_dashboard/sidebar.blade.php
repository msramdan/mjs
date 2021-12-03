<div id="sidebar" class="app-sidebar">
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <div class="menu">
            <div class="menu-profile">
                <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile"
                    data-target="#appSidebarProfileMenu">
                    <div class="menu-profile-cover with-shadow"></div>
                    <div class="menu-profile-image">
                        <img src="{{ asset('template/assets/img/user/user-2.jpg') }}" alt="" />
                    </div>
                    <div class="menu-profile-info">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">{{ Auth::user()->name }}</div>
                        </div>
                        <small>{{ Auth::user()->email }}</small>
                    </div>
                </a>
            </div>
    <div class="menu-header">Navigation</div>
    {{-- home --}}
    <div class="menu-item">
        <a href="{{ route('home') }}" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-home"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.home') }}</div>
        </a>
    </div>
    {{-- Akuntansi --}}
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-book"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.akuntansi') }}</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.invoice') }}</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.billing') }}</div></a>

            </div>
        </div>
    </div>
    {{-- kontak --}}
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-address-book"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.kontak') }}</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="{{ route('supplier.index') }}" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.pemasok') }}</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.pelanggan') }}</div></a>
            </div>
        </div>
    </div>
    {{-- penjualan --}}
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.penjualan') }}</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.spal') }}</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.penjualan') }}</div></a>
            </div>
        </div>
    </div>
    {{-- pembelian --}}
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.pembelian') }}</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.pembelian') }}</div></a>
            </div>
        </div>
    </div>
    {{-- Inventory --}}
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-cube"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.gudang') }}</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.barang_jasa') }}</div></a>
            </div>
        </div>
    </div>
    {{-- HR & Legal --}}
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.hr') }}</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.karyawan') }}</div></a>
            </div>
        </div>
    </div>
    {{-- master data --}}
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-list"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.master_data') }}</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">Jabatan</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Status Karyawan</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Divisi</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Lokasi Kerja</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.kategori') }}</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">{{ trans('sidebar.sub_menu.satuan') }}</div></a>
            </div>
        </div>
    </div>
    {{-- pengaturan --}}
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-cogs"></i>
            </div>
            <div class="menu-text">{{ trans('sidebar.word.pengaturan') }}</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="" class="menu-link"><div class="menu-text">User</div></a>
                <a href="" class="menu-link"><div class="menu-text">Pengaturan Aplikasi</div></a>
            </div>
        </div>
    </div>
</div>
