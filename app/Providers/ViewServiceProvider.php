<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
    }
}
