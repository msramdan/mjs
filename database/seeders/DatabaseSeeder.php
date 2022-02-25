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
            UnitSeeder::class,
            LokasiSeeder::class,
            JabatanSeeder::class,
            StatusKaryawanSeeder::class,
            DivisiSeeder::class,
            KaryawanSeeder::class,
            CategoryRequestSeeder::class,
            CategoryPotonganSeeder::class,
            CategoryBenefitSeeder::class,
            RoleAndPermissionSeeder::class,
            CategoryDocumentSeeder::class,
            DataPotonganSeeder::class,
            DataBenefitSeeder::class,
            SettingAppSeeder::class,
            // AkunGrupSeeder::class,
            // AkunHeaderSeeder::class,
            // AkunCoaSeeder::class,
            ItemSeeder::class,
            SettingCategoryRequestSeeder::class,
            RequestFormSeeder::class,
            SpalSeeder::class,
            PurchaseSeeder::class,
            CoaSeeder::class,
            SaleSeeder::class,
        ]);
    }
}
