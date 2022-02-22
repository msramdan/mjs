<?php

namespace App\Providers;

use App\Models\Accounting\Coa;
use App\Models\Contact\{Customer, Supplier};
use App\Models\ElectronicDocument\CategoryDocument;
use App\Models\Inventory\{BacPakai, BacTerima, Item};
use App\Models\Master\{Category, CategoryRequest, Divisi, Jabatan, Lokasi, StatusKaryawan, Unit};
use App\Models\Purchase\Purchase;
use App\Models\RequestForm\RequestForm;
use App\Models\Sale\{Sale, Spal};
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
            'purchase.edit',
            'purchase.create',
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

        // list list akunSumber
        View::composer([
            // 'accounting.billing.create',
            'accounting.billing.edit',
            // 'accounting.invoice.create',
            'accounting.invoice.edit',
            // 'accounting.jurnal-umum.create',
            // 'accounting.jurnal-umum.edit',
        ], function ($view) {
            return $view->with(
                'akunSumber',
                Coa::select('id', 'kode', 'nama')->where(['kategori' => 'Detail', 'tipe' => 'Bank'])->orderBy('nama')->get()
            );
        });

        // list list akunBeban
        View::composer([
            // 'accounting.billing.create',
            'accounting.billing.edit',
            // 'accounting.invoice.create',
            // 'accounting.invoice.edit',
            // 'accounting.jurnal-umum.create',
            // 'accounting.jurnal-umum.edit',
        ], function ($view) {
            return $view->with(
                'akunBeban',
                Coa::select('id', 'kode', 'nama')->where(['kategori' => 'Detail', 'tipe' => 'Expense'])->orderBy('nama')->get()
            );
        });

        // list list akun detail
        View::composer([
            'accounting.jurnal-umum.create',
            'accounting.jurnal-umum.edit',
            'accounting.buku-besar.index',
        ], function ($view) {
            return $view->with(
                'akunDetail',
                Coa::select('id', 'kode', 'nama')->where('kategori', 'Detail')->orderBy('kode')->get()
            );
        });

        // list list akunPiutang
        View::composer([
            'accounting.invoice.create',
            'accounting.invoice.edit',
        ], function ($view) {
            return $view->with(
                'akunPiutang',
                Coa::select('id', 'kode', 'nama')->where(['kategori' => 'Detail', 'tipe' => 'Euqity'])->orderBy('nama')->get()
            );
        });

        // list list akunPendapatan
        View::composer([
            'accounting.invoice.create',
            'accounting.invoice.edit',
        ], function ($view) {
            return $view->with(
                'akunPendapatan',
                Coa::select('id', 'kode', 'nama')
                    ->where(['kategori' => 'Detail', 'tipe' => 'Income'])
                    ->orderBy('nama')
                    ->get()
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

        // list coaParents
        View::composer([
            'accounting.coa.create',
            'accounting.coa.edit'
        ], function ($view) {
            return $view->with(
                'coaParents',
                Coa::select('id', 'kode', 'nama')->get()
            );
        });

        // list coaCategories
        View::composer([
            'accounting.coa.create',
            'accounting.coa.edit'
        ], function ($view) {
            return $view->with(
                'coaCategories',
                collect([
                    (object)[
                        'kode' => 'Header',
                        'nama' => 'Header'
                    ],
                    (object)[
                        'kode' => 'Detail',
                        'nama' => 'Detail'
                    ],
                ])
            );
        });

        // list coaTypes
        View::composer([
            'accounting.coa.create',
            'accounting.coa.edit'
        ], function ($view) {
            return $view->with(
                'coaTypes',
                collect([
                    (object)[
                        'kode' => 'Asset',
                        'nama' => 'Asset',
                    ],
                    (object)[
                        'kode' => 'Bank',
                        'nama' => 'Bank'
                    ],
                    (object)[
                        'kode' => 'Account Receivable',
                        'nama' => 'Account Receivable',
                    ],
                    (object)[
                        'kode' => 'Fixed Assets',
                        'nama' => 'Fixed Assets',
                    ],
                    (object)[
                        'kode' => 'Liability',
                        'nama' => 'Liability',
                    ], (object)[
                        'kode' => 'Account Payable',
                        'nama' => 'Account Payable',
                    ],
                    (object)[
                        'kode' => 'Long Term Liability',
                        'nama' => 'Long Term Liability',
                    ],
                    (object)[
                        'kode' => 'Euqity',
                        'nama' => 'Euqity',
                    ],
                    (object)[
                        'kode' =>  'Income',
                        'nama' =>  'Income',
                    ],
                    (object)[
                        'kode' =>  'Expense',
                        'nama' =>  'Expense',
                    ],
                    (object)[
                        'kode' =>  'Other Current Asset',
                        'nama' =>  'Other Current Asset',
                    ],
                    (object)[
                        'kode' =>   'Other Income',
                        'nama' =>   'Other Income',
                    ],
                    (object)[
                        'kode' =>  'Other Expenses',
                        'nama' =>  'Other Expenses'
                    ],
                ])
            );
        });
    }
}
