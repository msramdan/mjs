<?php

namespace Database\Seeders;

use App\Models\Sale\Sale;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sale = Sale::create([
            'kode' => 'SO-2022-02-22-0001',
            'spal_id' => 1,
            'tanggal' => now()->toDateString(),
            'attn' => 'Giorno',
            'total' => 900_000,
            'diskon' => null,
            'catatan' => 'Quisque velit nisi, pretium ut lacinia in, elementum id enim.',
            'grand_total' => 900_000,
            'total_dibayar' => 0,
            'lunas' => 0,
        ]);

        $sale->detail_sale()->create([
            'sale_id' => 1,
            'item_id' => 2,
            'harga' => 100_000,
            'qty' => 9,
            'sub_total' => 900_000,
        ]);
    }
}
