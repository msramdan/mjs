<?php

namespace App\Providers;

use App\Models\Contact\Customer;
use App\Models\ElectronicDocument\CategoryDocument;
use App\Models\Master\Category;
use App\Models\Master\Divisi;
use App\Models\Master\Jabatan;
use App\Models\Master\Lokasi;
use App\Models\Master\StatusKaryawan;
use App\Models\Master\Unit;
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
        View::composer([
            'setting.user.create',
            'setting.user.edit'
        ], function ($view) {
            return $view->with(
                'permissions',
                Permission::select('id', 'name')->get()
            );
        });

        // list customer
        View::composer([
            'sale.spal.create',
            'sale.spal.edit'
        ], function ($view) {
            return $view->with(
                'customer',
                Customer::select('id', 'nama')->orderBy('nama')->get()
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
    }
}
