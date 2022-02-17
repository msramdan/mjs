<?php

namespace Database\Seeders;

use App\Models\Purchase\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchase = Purchase::create([
            'request_form_id' => 1,
            'supplier_id' => 1,
            'kode' => 'PO-' . date('Y-m-d') . '-0001',
            'tanggal' => date('Y-m-d'),
            'attn' => 'Bruno',
            'total' => 81000000,
            'diskon' => 0,
            'catatan' => '',
            'grand_total' => 81000000,
            'total_dibayar' => 0,
            'lunas' => 0,
            'approve_by_gm' => 2,
            'approve_by_direktur' => 3,
        ]);

        $purchase->detail_purchase()->create([
            'item_id' => 2,
            'harga' => 90000,
            'qty' => 900,
            'sub_total' => 81000000
        ]);
    }
}
