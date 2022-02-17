<?php

namespace App\Providers;

use App\Models\Accounting\AkunCoa;
use App\Models\Accounting\AkunGrup;
use App\Models\Accounting\AkunHeader;
use App\Models\Accounting\Coa;
use App\Models\Contact\Customer;
use App\Models\Contact\Supplier;
use App\Models\ElectronicDocument\CategoryDocument;
use App\Models\Inventory\BacPakai;
use App\Models\Inventory\BacTerima;
use App\Models\Inventory\Item;
use App\Models\Master\Category;
use App\Models\Master\CategoryRequest;
use App\Models\Master\Divisi;
use App\Models\Master\Jabatan;
use App\Models\Master\Lokasi;
use App\Models\Master\StatusKaryawan;
use App\Models\Master\Unit;
use App\Models\Purchase\Purchase;
use App\Models\RequestForm\RequestForm;
use App\Models\Sale\Sale;
use App\Models\Sale\Spal;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // list status
        View::composer([
            'master-data.category.create',
            'master-data.category.edit',
            'master-data.unit.create',
            'master-data.unit.edit',
            'master-data.lokasi.create',
            'master-data.lokasi.edit',
            'master-data.jabatan.create',
            'master-data.jabatan.edit',
            'master-data.status-karyawan.create',
            'master-data.status-karyawan.edit',
            'master-data.divisi.create',
            'master-data.divisi.edit',
            'form-request.form.create',
            'form-request.form.edit',
        ], function ($view) {
            return $view->with(
                'status',
                collect([
                    (object)[
                        'id' => 'Aktif',
                        'nama' => 'Aktif'
                    ],
                    (object)[
                        'id' => 'Non-aktif',
                        'nama' => 'Non-aktif'
                    ],
                ])
            );
        });

        // list jenis kelamin
        View::composer([
            'legal.karyawan.create',
            'legal.karyawan.edit',
        ], function ($view) {
            return $view->with(
                'jenisKelamin',
                collect([
                    (object)[
                        'id' => 'Laki-laki',
                        'nama' => 'Laki-laki'
                    ],
                    (object)[
                        'id' => 'Perempuan',
                        'nama' => 'Perempuan'
                    ],
                ])
            );
        });

        // list status kawin
        View::composer([
            'legal.karyawan.create',
            'legal.karyawan.edit',
        ], function ($view) {
            return $view->with(
                'statusKawin',
                collect([
                    (object)[
                        'id' => 'Menikah',
                        'nama' => 'Menikah'
                    ],
                    (object)[
                        'id' => 'Belum Menikah',
                        'nama' => 'Belum Menikah'
                    ],
                ])
            );
        });

        // list status keaktifan
        View::composer([
            'legal.karyawan.create',
            'legal.karyawan.edit',
        ], function ($view) {
            return $view->with(
                'statusKeaktifan',
                collect([
                    (object)[
                        'id' => 'Masih Bekerja',
                        'nama' => 'Masih Bekerja'
                    ],
                    (object)[
                        'id' => 'Habis Kontrak',
                        'nama' => 'Habis Kontrak'
                    ],
                ])
            );
        });

        // list divisi
        View::composer([
            'legal.karyawan.create',
            'legal.karyawan.edit',
        ], function ($view) {
            return $view->with(
                'divisi',
                Divisi::select('id', 'nama')->where('status', 'Aktif')->get()
            );
        });

        // list jabatan
        View::composer([
            'legal.karyawan.create',
            'legal.karyawan.edit',
        ], function ($view) {
            return $view->with(
                'jabatan',
                Jabatan::select('id', 'nama')->where('status', 'Aktif')->get()
            );
        });

        // list lokasi
        View::composer([
            'legal.karyawan.create',
            'legal.karyawan.edit',
        ], function ($view) {
            return $view->with(
                'lokasi',
                Lokasi::select('id', 'nama')->where('status', 'Aktif')->get()
            );
        });

        // list status karyawan
        View::composer([
            'legal.karyawan.create',
            'legal.karyawan.edit',
        ], function ($view) {
            return $view->with(
                'statusKaryawan',
                StatusKaryawan::select('id', 'nama')->where('status', 'Aktif')->get()
            );
        });

        // list roles
        View::composer([
            'setting.user.create',
            'setting.user.edit'
        ], function ($view) {
            return $view->with(
                'roles',
                Role::select('id', 'name')->get()
            );
        });

        // list permissions
        // View::composer([
        //     'setting.user.create',
        //     'setting.user.edit'
        // ], function ($view) {
        //     return $view->with(
        //         'permissions',
        //         Permission::select('id', 'name')->get()
        //     );
        // });

        // list customer
        View::composer([
            'sale.spal.create',
            'sale.spal.edit',
        ], function ($view) {
            return $view->with(
                'customer',
                Customer::select('id', 'nama')->orderBy('nama')->get()
            );
        });

        // list supplier
        View::composer([
            'purchase.include.cart',
            'inventory.item.create',
            'inventory.item.edit'
        ], function ($view) {
            return $view->with(
                'supplier',
                Supplier::select('id', 'nama')->orderBy('nama')->get()
            );
        });

        // list category
        View::composer([
            'inventory.item.create',
            'inventory.item.edit'
        ], function ($view) {
            return $view->with(
                'category',
                Category::select('id', 'nama')->orderBy('nama')->get()
            );
        });

        // list unit
        View::composer([
            'inventory.item.create',
            'inventory.item.edit'
        ], function ($view) {
            return $view->with(
                'unit',
                Unit::select('id', 'nama')->orderBy('nama')->get()
            );
        });

        // list Category Document
        View::composer([
            'electronic-document.document.create',
            'electronic-document.document.edit',
        ], function ($view) {
            return $view->with(
                'categoryDocument',
                CategoryDocument::select('id', 'nama')->orderBy('nama')->get()
            );
        });

        // list Category Request
        View::composer([
            'form-request.form.create',
            'form-request.form.edit',
        ], function ($view) {
            return $view->with(
                'categoryRequest',
                CategoryRequest::select('id', 'nama')->orderBy('nama')->get()
            );
        });

        // // list Akun Coa
        // View::composer([
        //     'inventory.item.create',
        //     'inventory.item.edit'
        // ], function ($view) {
        //     return $view->with(
        //         'akunCoa',
        //         AkunCoa::select('id', 'kode', 'nama')->orderBy('nama')->get()
        //     );
        // });

        // list spal
        View::composer([
            'sale.sale.create',
            'sale.sale.edit',
        ], function ($view) {
            return $view->with(
                'spal',
                Spal::select('id', 'kode')->orderBy('kode')->get()
            );
        });

        // list produk
        View::composer([
            'sale.sale.create',
            'sale.sale.edit',
        ], function ($view) {
            return $view->with(
                'produk',
                Item::select('id', 'nama', 'kode')->where('type', 'Services')->orderBy('nama')->get()
            );
        });

        // list requestForm
        View::composer([
            'purchase.create',
            'purchase.edit',
        ], function ($view) {
            return $view->with(
                'requestForm',
                RequestForm::with('status_request_forms:id,request_form_id,status')
                    ->whereHas('status_request_forms', function ($q) {
                        $q->where('status', 'Approve');
                    })
                    ->select('id', 'kode')
                    ->orderBy('kode')
                    ->get()
            );
        });

        // list consumable
        View::composer([
            // 'purchase.create',
            // 'purchase.edit',
            // 'inventory.bac-terima.create',
            // 'inventory.bac-terima.edit',
            'inventory.bac-pakai.create',
            'inventory.bac-pakai.edit',
        ], function ($view) {
            return $view->with(
                'consumable',
                Item::select('id', 'nama', 'kode')
                    ->where('type', 'Consumable')
                    ->orderBy('nama')
                    ->get()
            );
        });

        // list bacPakai
        View::composer([
            'inventory.aso.create',
            'inventory.aso.edit',
        ], function ($view) {
            return $view->with(
                'bacPakaiBT',
                BacPakai::select('id', 'kode', 'status')
                    ->where('status', 'Belum Tervalidasi')
                    ->orderByDesc('kode')
                    ->get()
            );
        });

        // list bacTerima
        View::composer([
            'inventory.received.create',
            'inventory.received.edit',
        ], function ($view) {
            return $view->with(
                'bacTerimaBT',
                BacTerima::select('id', 'kode', 'status')
                    ->where('status', 'Belum Tervalidasi')
                    ->orderByDesc('kode')
                    ->get()
            );
        });

        // list sales
        View::composer([
            'accounting.invoice.create',
            'accounting.invoice.edit',
        ], function ($view) {
            return $view->with(
                'sales',
                Sale::select('id', 'kode')
                    ->where('lunas', 0)
                    ->orderBy('id')
                    ->get()
            );
        });

        // list list COA
        View::composer([
            'accounting.billing.create',
            'accounting.billing.edit',
            'accounting.invoice.create',
            'accounting.invoice.edit',
            'accounting.jurnal-umum.create',
            'accounting.jurnal-umum.edit',
        ], function ($view) {
            return $view->with(
                'coas',
                AkunCoa::select('id', 'kode', 'nama')->orderBy('nama')->get()
            );
        });

        // list purchases approve
        View::composer([
            'accounting.billing.create',
            'accounting.billing.edit',
            'inventory.bac-terima.include.purchase-info'
        ], function ($view) {
            return $view->with(
                'purchaseApproves',
                Purchase::select('id', 'kode')
                    ->where('lunas', 0)
                    ->where('approve_by_gm', '!=', null)
                    ->orderBy('id')
                    ->get()
            );
        });

        // // list purchases
        // View::composer([
        //     'inventory.bac-terima.create',
        //     'inventory.bac-terima.edit'
        // ], function ($view) {
        //     return $view->with(
        //         'purchases',
        //         Purchase::select('id', 'kode')
        //             ->where('lunas', 0)
        //             ->orderBy('id')
        //             ->get()
        //     );
        // });

        // list akunGroup
        View::composer([
            'accounting.akun-header.create',
            'accounting.akun-header.edit',
        ], function ($view) {
            return $view->with(
                'akunGroup',
                AkunGrup::select('id', 'nama')->orderBy('nama')->get()
            );
        });

        // list akunHeader
        View::composer([
            'accounting.coa.create',
            'accounting.coa.edit',
        ], function ($view) {
            return $view->with(
                'akunHeader',
                AkunHeader::select('id', 'nama')->orderBy('nama')->get()
            );
        });

        // list treeview
        View::composer([
            'accounting.coa._treeview',
        ], function ($view) {
            return $view->with(
                'treeview',
                AkunGrup::select('id', 'nama', 'report')
                    ->with(
                        'akun_header:id,kode,nama,account_group_id',
                        'akun_header.akun_coa:id,kode,nama,account_header_id'
                    )
                    ->get()
            );
        });

        // list user
        View::composer([
            // 'master-data.category-request.create',
            'master-data.category-request.edit',
        ], function ($view) {
            return $view->with(
                'users',
                User::select('id', 'name')->orderBy('name')->get()
            );
        });
    }
}
