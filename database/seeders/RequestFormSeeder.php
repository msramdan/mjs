<?php

namespace Database\Seeders;

use App\Models\RequestForm\RequestForm;
use Illuminate\Database\Seeder;

class RequestFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $requestForm = RequestForm::create([
            'category_request_id' => 1,
            'user_id' => 1,
            'kode' => 'RF-' . date('y-m-d'),
            'tanggal' => date('y-m-d'),
            'berita_acara' => 'Nulla porttitor accumsan tincidunt. Curabitur aliquet quam id dui posuere blandit. Cras ultricies ligula sed magna dictum porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);

        $requestForm->detail_request_form()->create([
            'request_form_id' => 1,
            'nama' => 'sadfd',
            'file' => 'sadfd-1644574811.png'
        ]);

        $requestForm->status_request_forms()->create(
            [
                'request_form_id' => 1,
                'setting_category_request_form_id' => 1,
                'status' => 'Approve',
            ]
        );

        $requestForm->status_request_forms()->create(
            [
                'request_form_id' => 1,
                'setting_category_request_form_id' => 2,
                'status' => 'Approve',
            ]
        );
    }
}
