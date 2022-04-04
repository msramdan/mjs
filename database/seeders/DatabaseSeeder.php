<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
<<<<<<< HEAD
            UnitSeeder::class,
            // LokSeeder::class,
            // StatusKaryawanasiSeeder::class,
            JabatanSeeder::class,
            DivisiSeeder::class,
=======
            // UnitSeeder::class,
            // LokasiSeeder::class,
            // StatusKaryawanSeeder::class,
            // JabatanSeeder::class,
            // DivisiSeeder::class,
>>>>>>> bda86c969d737b92412c169fffa480c638853a63
            // KaryawanSeeder::class,
            CategoryRequestSeeder::class,
            CategoryPotonganSeeder::class,
            CategoryBenefitSeeder::class,
            RoleAndPermissionSeeder::class,
            CategoryDocumentSeeder::class,
            // DataPotonganSeeder::class,
            // DataBenefitSeeder::class,
            SettingAppSeeder::class,
            AkunGrupSeeder::class,
            AkunHeaderSeeder::class,
            AkunCoaSeeder::class,
            ItemSeeder::class,
            SettingCategoryRequestSeeder::class,
            RequestFormSeeder::class,
            SpalSeeder::class,
            PurchaseSeeder::class,
            CoaSeeder::class,
            SaleSeeder::class,
            TimeSheetSeeder::class,
        ]);
    }
}
