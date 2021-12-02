<div id="sidebar" class="app-sidebar">
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
    <div class="menu">
    <div class="menu-profile">
        <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
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

    <div class="menu-item">
        <a href="{{ route('home') }}" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-home"></i>
            </div>
            <div class="menu-text">Home</div>
        </a>
    </div>
    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-box"></i>
            </div>
            <div class="menu-text">Barang & Jasa</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">Supllier</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Cuctomer</div></a>
            </div>
        </div>
    </div>

    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-address-book"></i>
            </div>
            <div class="menu-text">Kontak</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">Supllier</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Cuctomer</div></a>
            </div>
        </div>
    </div>

    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-list"></i>
            </div>
            <div class="menu-text">Master Data</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">Jabatan</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Status Karyawan</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Divisi</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Lokasi Kerja</div></a>
            </div>
        </div>
    </div>

    <div class="menu-item has-sub">
        <a href="javascript:;" class="menu-link">
            <div class="menu-icon">
                <i class="fa fa-cogs"></i>
            </div>
            <div class="menu-text">Pengaturan</div>
            <div class="menu-caret"></div>
        </a>
        <div class="menu-submenu">
            <div class="menu-item">
                <a href="index.html" class="menu-link"><div class="menu-text">Jabatan</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Status Karyawan</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Divisi</div></a>
                <a href="index.html" class="menu-link"><div class="menu-text">Lokasi Kerja</div></a>
            </div>
        </div>
    </div>
    <div class="menu-item d-flex">
    <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
    </div>
    </div>
    </div>
    </div>
