<?php

namespace Database\Seeders;

use App\Models\Inventory\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item1 = Item::create([
            'category_id' => 1,
            'unit_id' => 1,
            'kode' => 'IT-MJS-001',
            'nama' => 'Product 1',
            'type' => 'Consumable',
            'deskripsi' => 'tes',
            'stok' => 0,
            'foto' => '1644558359.png',
            'harga_estimasi' => 200000
        ]);

        $item1->detail_items()->create([
            'supplier_id' => 1,
            'harga_beli' => 170000
        ]);

        $item1->detail_items()->create([
            'supplier_id' => 2,
            'harga_beli' => 190000
        ]);

        $item2 = Item::create([
            'category_id' => 2,
            'unit_id' => 2,
            'kode' => 'IT-MJS-002',
            'nama' => 'Product 2',
            'type' => 'Services',
            'deskripsi' => 'lorem',
            'stok' => 0,
            'foto' => '1644558491.png',
            'harga_estimasi' => 90000
        ]);

        $item2->detail_items()->create([
            'supplier_id' => 3,
            'harga_beli' => 50000
        ]);

        $item2->detail_items()->create([
            'supplier_id' => 5,
            'harga_beli' => 90000
        ]);
    }
}
