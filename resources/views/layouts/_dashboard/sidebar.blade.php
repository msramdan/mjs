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
            <div class="menu-item">
                <a href="{{ route('request-form.index') }}" class="menu-link">
                    <div class="menu-icon">
                        <i class="fab fa-wpforms"></i>
                    </div>
                    <div class="menu-text">{{ trans('sidebar.word.request_form') }}</div>
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
                        <a href="index.html" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.invoice') }}</div>
                        </a>
                        <a href="index.html" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.billing') }}</div>
                        </a>
                        <a href="{{ route('coa.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.coa') }}</div>
                        </a>
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
                        <a href="{{ route('supplier.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.pemasok') }}</div>
                        </a>
                        <a href="{{ route('customer.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.pelanggan') }}</div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- penjualan --}}
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
                        <a href="{{ route('spal.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.spal') }}</div>
                        </a>
                        <a href="{{ route('sale.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.penjualan') }}</div>
                        </a>
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
                        <a href="{{ route('purchase.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.pembelian') }}</div>
                        </a>
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
                        <a href="{{ route('item.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.barang_jasa') }}</div>
                        </a>

                        <a href="{{ route('bac-terima.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.bac_terima') }}</div>
                        </a>

                        <a href="{{ route('bac-pakai.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.bac_pakai') }}</div>
                        </a>

                        <a href="{{ route('aso.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.aso') }}</div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- payroll --}}
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
                        <a href="{{ route('potongan.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.potongan') }}</div>
                        </a>
                        <a href="{{ route('benefit.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.benefit') }}</div>
                        </a>
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
                        <a href="{{ route('karyawan.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.karyawan') }}</div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Electronic Document --}}
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
                        <a href="{{ route('document.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.dokumen') }}</div>
                        </a>

                        <a href="{{ route('category-document.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.dokumen_kategori') }}</div>
                        </a>
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
                        <a href="{{ route('jabatan.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.jabatan') }}</div>
                        </a>
                        <a href="{{ route('status-karyawan.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.status_karyawan') }}</div>
                        </a>
                        <a href="{{ route('divisi.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.divisi') }}</div>
                        </a>
                        <a href="{{ route('lokasi.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.lokasi_kerja') }}</div>
                        </a>
                        <a href="{{ route('category.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.kategori') }}</div>
                        </a>
                        <a href="{{ route('category-request.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.kategori_request') }}</div>
                        </a>
                        <a href="{{ route('category-potongan.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.kategori_potongan') }}</div>
                        </a>
                        <a href="{{ route('category-benefit.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.kategori_benefit') }}</div>
                        </a>
                        <a href="{{ route('unit.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.satuan') }}</div>
                        </a>
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
                        <a href="{{ route('user.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.user') }}</div>
                        </a>

                        <a href="{{ route('role.index') }}" class="menu-link">
                            <div class="menu-text">Role</div>
                        </a>

                        <a href="{{ route('permission.index') }}" class="menu-link">
                            <div class="menu-text">Permission</div>
                        </a>

                        <a href="{{ route('setting_app.index') }}" class="menu-link">
                            <div class="menu-text">{{ trans('sidebar.sub_menu.pengaturan_app') }}</div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i
                        class="fa fa-angle-double-left"></i></a>
            </div>
        </div>
    </div>
</div>
