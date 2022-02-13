<div id="sidebar" class="app-sidebar">
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <div class="menu">
            <div class="menu-profile">
                <a href="{{ route('profile.index') }}" class="menu-profile-link" data-toggle="app-sidebar-profile"
                    data-target="#appSidebarProfileMenu">
                    <div class="menu-profile-cover with-shadow"></div>
                    <div class="menu-profile-image">
                        @if (auth()->user()->foto != null)
                            <img src="{{ asset('storage/img/user/' . auth()->user()->foto) }}" alt="Foto User"
                                class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=200"
                                alt="Foto User" class="img-fluid rounded-circle"
                                style="width: 40px; height: 40px; object-fit: cover;">
                        @endif
                        {{-- <img src="{{ asset('template/assets/img/user/user-2.jpg') }}" alt="" /> --}}
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

            {{-- request_form --}}
            @canany(['view request form purchase', 'view request form peminjaman'])
                <div class="menu-item has-sub">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fab fa-wpforms"></i>
                        </div>
                        <div class="menu-text">{{ trans('sidebar.word.request_form') }}</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            @can('view request form purchase')
                                <a href="{{ route('request-form.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.rf_purchase') }}</div>
                                </a>
                            @endcan

                            @can('view request form peminjaman')
                                <a href="#" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.rf_loan') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            {{-- Akuntansi --}}
            @canany(['view invoice', 'view billing', 'view account group', 'view account header', 'view coa'])
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
                            @can('view invoice')
                                <a href="{{ route('invoice.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.invoice') }}</div>
                                </a>
                            @endcan

                            @can('view billing')
                                <a href="{{ route('billing.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.billing') }}</div>
                                </a>
                            @endcan
                        </div>

                        @canany(['view account group', 'view account header', 'view coa'])
                            <div class="menu-item has-sub closed">
                                <a href="javascript:;" class="menu-link">
                                    <div class="menu-text">Account</div>
                                    <div class="menu-caret"></div>
                                </a>
                                <div class="menu-submenu" style="display: none;">
                                    @can('view account group')
                                        <div class="menu-item">
                                            <a href="{{ route('akun-grup.index') }}" class="menu-link">
                                                <div class="menu-text">{{ trans('sidebar.sub_menu.akun_grup') }}</div>
                                            </a>
                                        </div>
                                    @endcan

                                    @can('view account header')
                                        <div class="menu-item">
                                            <a href="{{ route('akun-header.index') }}" class="menu-link">
                                                <div class="menu-text">{{ trans('sidebar.sub_menu.akun_header') }}</div>
                                            </a>
                                        </div>
                                    @endcan

                                    @can('view coa')
                                        <div class="menu-item">
                                            <a href="{{ route('akun-coa.index') }}" class="menu-link">
                                                <div class="menu-text">COA</div>
                                            </a>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @endcanany

                        @can('view jurnal umum')
                            <div class="menu-item has-sub closed">
                                <a href="javascript:;" class="menu-link">
                                    <div class="menu-text">Report</div>
                                    <div class="menu-caret"></div>
                                </a>
                                <div class="menu-submenu" style="display: none;">
                                    <div class="menu-item">
                                        <a href="{{ route('jurnal-umum.index') }}" class="menu-link">
                                            <div class="menu-text">{{ trans('sidebar.sub_menu.jurnal_umum') }}</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            @endcanany

            {{-- kontak --}}
            @canany(['view supplier', 'view customer'])
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
                            @can('view supplier')
                                <a href="{{ route('supplier.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.pemasok') }}</div>
                                </a>
                            @endcan

                            @can('view customer')
                                <a href="{{ route('customer.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.pelanggan') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            {{-- penjualan --}}
            @canany(['view spal', 'view sale'])
                <div class="menu-item has-sub">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fa fa-shopping-basket"></i>
                        </div>
                        <div class="menu-text">{{ trans('sidebar.word.penjualan') }}</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            @can('view spal')
                                <a href="{{ route('spal.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.spal') }}</div>
                                </a>
                            @endcan

                            @can('view sale')
                                <a href="{{ route('sale.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.penjualan') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            {{-- pembelian --}}
            @can('view purchase')
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
                            <a href="{{ route('purchase.index') }}" class="menu-link">
                                <div class="menu-text">{{ trans('sidebar.sub_menu.pembelian') }}</div>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- Inventory --}}
            @canany(['view item', 'view bac terima', 'view bac pakai', 'view received', 'view aso'])
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
                            @can('view item')
                                <a href="{{ route('item.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.barang_jasa') }}</div>
                                </a>
                            @endcan

                            @can('view bac terima')
                                <a href="{{ route('bac-terima.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.bac_terima') }}</div>
                                </a>
                            @endcan

                            @can('view bac pakai')
                                <a href="{{ route('bac-pakai.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.bac_pakai') }}</div>
                                </a>
                            @endcan

                            @can('view received')
                                <a href="{{ route('received.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.received') }}</div>
                                </a>
                            @endcan

                            @can('view aso')
                                <a href="{{ route('aso.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.aso') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            {{-- payroll --}}
            @canany(['view benefit', 'view potongan'])
                <div class="menu-item has-sub">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fab fa-paypal"></i>
                        </div>
                        <div class="menu-text">{{ trans('sidebar.word.payroll') }}</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            @can('view potongan')
                                <a href="{{ route('potongan.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.potongan') }}</div>
                                </a>
                            @endcan

                            @can('view benefit')
                                <a href="{{ route('benefit.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.benefit') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            {{-- HR & Legal --}}
            @canany(['view karyawan', 'view dokumen hrga'])
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
                            @can('view karyawan')
                                <a href="{{ route('karyawan.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.karyawan') }}</div>
                                </a>
                            @endcan

                            @can('view dokumen hrga')
                                <a href="{{ route('dokumen-hrga.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.dokumen_hrga') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            {{-- Electronic Document --}}
            @canany(['view dokumen', 'view category dokumen'])
                <div class="menu-item has-sub">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fa fa-file-alt"></i>
                        </div>
                        <div class="menu-text">{{ trans('sidebar.word.elektronik_dokumen') }}</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item">
                            @can('view dokumen')
                                <a href="{{ route('document.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.dokumen') }}</div>
                                </a>
                            @endcan

                            @can('view category dokumen')
                                <a href="{{ route('category-document.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.dokumen_kategori') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            {{-- master data --}}
            @canany([
                'view jabatan',
                'view status karyawan',
                'view divisi',
                'view lokasi',
                'view category',
                'view
                category request',
                'view category potongan',
                'view category benefit',
                'view unit',
                ])
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
                            @can('view jabatan')
                                <a href="{{ route('jabatan.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.jabatan') }}</div>
                                </a>
                            @endcan

                            @can('view status karyawan')
                                <a href="{{ route('status-karyawan.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.status_karyawan') }}</div>
                                </a>
                            @endcan

                            @can('view divisi')
                                <a href="{{ route('divisi.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.divisi') }}</div>
                                </a>
                            @endcan

                            @can('view lokasi')
                                <a href="{{ route('lokasi.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.lokasi_kerja') }}</div>
                                </a>
                            @endcan

                            @can('view category')
                                <a href="{{ route('category.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.kategori') }}</div>
                                </a>
                            @endcan

                            @can('view category request')
                                <a href="{{ route('category-request.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.kategori_request') }}</div>
                                </a>
                            @endcan

                            @can('view category potongan')
                                <a href="{{ route('category-potongan.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.kategori_potongan') }}</div>
                                </a>
                            @endcan

                            @can('view category benefit')
                                <a href="{{ route('category-benefit.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.kategori_benefit') }}</div>
                                </a>
                            @endcan

                            @can('view unit')
                                <a href="{{ route('unit.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.satuan') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            {{-- pengaturan --}}
            @canany(['view user', 'view role', 'setting aplikasi'])
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
                            @can('view user')
                                <a href="{{ route('user.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.user') }}</div>
                                </a>
                            @endcan

                            @can('view role')
                                <a href="{{ route('role.index') }}" class="menu-link">
                                    <div class="menu-text">Role & Permissions</div>
                                </a>
                            @endcan

                            {{-- <a href="{{ route('permission.index') }}" class="menu-link">
                                <div class="menu-text">Permission</div>
                            </a> --}}

                            @can('setting aplikasi')
                                <a href="{{ route('setting_app.index') }}" class="menu-link">
                                    <div class="menu-text">{{ trans('sidebar.sub_menu.pengaturan_app') }}</div>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endcanany

            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </div>
        </div>
    </div>
</div>
