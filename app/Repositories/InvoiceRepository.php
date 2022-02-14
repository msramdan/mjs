<?php

namespace App\Repositories;

use App\Models\Accounting\AkunCoa;
use App\Models\Accounting\Invoice;
use App\Models\Sale\Sale;
use App\Models\Setting\SettingApp;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class InvoiceRepository
{
    /**
     * Get all invoice from database and used datatable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $query = Invoice::with('sale:id,kode', 'user:id,name');

        return DataTables::of($query)
            ->addColumn('sale', function ($row) {
                return $row->sale->kode;
            })
            ->addColumn('user', function ($row) {
                return $row->user->name;
            })
            ->addColumn('tanggal_invoice', function ($row) {
                return $row->tanggal_invoice->format('d M Y');
            })
            ->addColumn('tanggal_dibayar', function ($row) {
                return $row->tanggal_dibayar ? $row->tanggal_dibayar->format('d M Y') : '-';
            })
            ->addColumn('action', 'accounting.invoice._action')
            ->toJson();
    }

    /**
     * Insert newly created invoice to the database.
     *
     * @param array $request
     * @return void
     */
    public function insert(array $request)
    {
        $attr = $request;
        $attr['sale_id'] = $request['sale'];
        $attr['user_id'] = auth()->id();

        Invoice::create($attr);
    }

    /**
     * Load the relations of invoice for edit and show view.
     *
     * @param App\Models\Accounting\Invoice $invoice
     * @return $invoice
     */
    public function loadRelations($invoice)
    {
        return $invoice->load(
            'sale.spal:id,kode',
            'sale.detail_sale:id,sale_id,item_id,harga,qty,sub_total',
            'sale.detail_sale.item:id,kode,nama,unit_id',
            'sale.detail_sale.item.unit:id,nama',
            'sale.invoices:sale_id,id,kode,tanggal_dibayar,tanggal_invoice,dibayar,status'
        );
    }

    /**
     * Update the specified invoice from database.
     *
     * @param array $request
     * @param App\Models\Accounting\Invoice $invoice
     * @return void
     */
    public function update(array $request, $invoice)
    {
        $sale = Sale::findOrFail($request['sale']);

        // remove coma
        $dibayar = intval(str_replace(',', '', $request['nominal_invoice']));

        // kalo ada tanggal_dibayar dan $invoice belum paid maka ubah total_dibayar pada sales dengan $request['nominal_invoice'] + $sale->total_dibayar
        if ($request['tanggal_dibayar'] && $invoice->status != 'Paid') {
            // dump('1');

            // kalo jumlah yg dibayarkan lebih dari grand total
            if (($sale->total_dibayar + $dibayar) > $sale->grand_total) {
                // Nominal invoice lebih besar daripada sisa
                Alert::toast('Update data gagal', 'error');

                return redirect()->route('invoice.index');
                // dump('2');
            }

            if ($sale->total_dibayar + $dibayar == $sale->grand_total) {
                $sale->update([
                    'lunas' => 1,
                ]);
                // dump('3');
            }

            $sale->update([
                'total_dibayar' => $sale->total_dibayar + $dibayar
            ]);
        } elseif (!$request['tanggal_dibayar'] && $invoice->status == 'Paid') {
            // kalo dari paid diubah ke unpaid
            $sale->update([
                'total_dibayar' => $sale->total_dibayar - $dibayar,
                'lunas' => 0,
            ]);

            // dump('4');
        }

        $invoice->update([
            'kode' => $request['kode'],
            'attn' => $request['attn'],
            'tanggal_invoice' => $request['tanggal_invoice'],
            'tanggal_dibayar' => $request['tanggal_dibayar'],
            'catatan' => $request['catatan'],
            'status' => $request['status_invoice'],
        ]);

        if ($request['tanggal_dibayar'] && $request['status_invoice'] == 'Paid') {
            // dump('5');

            // sekarang masih static dulu
            $noBukti = 'BKK-001';
            $akunBeban = AkunCoa::select('id', 'kode')->where('id', $request['akun_beban'])->first();

            DB::table('jurnal_umum')->insert([
                [
                    'tanggal' => now()->toDateString(),
                    'no_bukti' => $noBukti,
                    'account_coa_id' => $request['akun_beban'],
                    'deskripsi' => 'Pembayaran akun beban ' . $akunBeban->kode . ' untuk no.ref ' . $invoice->kode,
                    'debit' => $dibayar,
                    'kredit' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'tanggal' => now()->toDateString(),
                    'no_bukti' => $noBukti,
                    'account_coa_id' => $request['akun_sumber'],
                    'deskripsi' => 'lorem',
                    'debit' => 0,
                    'kredit' => $dibayar,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        } else {
            // dump('8');
        }

        // dd('end');
    }

    /**
     *  Remove the specified invoice from database.
     *
     * @param App\Models\Accounting\Invoice $invoice
     * @return void
     */
    public function delete($invoice)
    {
        $sale = Sale::findOrFail($invoice->sale_id);

        if ($invoice->status == 'Paid') {
            $sale->update([
                'total_dibayar' => $sale->total_dibayar - $invoice->dibayar,
                'lunas' => 0,
            ]);
        }

        $invoice->delete();
    }

    /**
     * Generate a new code by date for invoice.
     *
     * @param string $tanggal
     * @return string $code
     */
    public function generateCode(string $tanggal)
    {
        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $hari = date('d', strtotime($tanggal));

        $code = 'INV-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = Invoice::select('id', 'tanggal_invoice', 'kode')
            ->whereYear('tanggal_invoice', $tahun)
            ->whereMonth('tanggal_invoice', $bulan)
            ->whereDay('tanggal_invoice', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $code = $code . '0001';
        } else {
            // hapus "INV-XXXX-XX-XX-" dan ambil angka buat ditambahin
            // $onlyNumberKode = intval(Str::after($checkLatestKode->kode, $code));
            $onlyNumberKode = intval(substr($checkLatestKode->kode, -4));

            if ($onlyNumberKode < 100) {
                $code = $code . '000' . ($onlyNumberKode + 1);
            } elseif ($onlyNumberKode >= 100 && $onlyNumberKode < 1000) {
                $code =  $code . '0' . ($onlyNumberKode + 1);
            } else {
                $code = $code . ($onlyNumberKode + 1);
            }
        }

        return $code;
    }

    /**
     * Select some field on invoice table, load the relations, and get data about the company(PT).
     *
     * @param int $id
     * @return array
     */
    public function print(int $id)
    {
        $invoice = Invoice::select('id', 'sale_id', 'kode', 'tanggal_invoice', 'status', 'catatan')->with(
            'sale:id,spal_id,kode,diskon,grand_total',
            'sale.spal:id,kode,customer_id',
            'sale.spal.customer:id,kode,nama,email,alamat,telp',
            'sale.detail_sale:id,sale_id,item_id,harga,qty,sub_total',
            'sale.detail_sale.item:id,kode,nama',
            'user:id,name'
        )->findOrFail($id);

        $perusahaan = SettingApp::first();

        return [
            'invoice' => $invoice,
            'perusahaan' => $perusahaan
        ];
    }
}
