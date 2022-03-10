<?php

namespace App\Repositories;

use App\Models\Accounting\{Invoice, JurnalUmum};
use App\Models\Sale\{Spal, Sale};
use App\Models\Setting\SettingApp;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

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
        $dibayar = $this->removeComma($request['dibayar']);
        $q = DB::select("SELECT MAX(RIGHT(no_bukti,4)) AS kd_max FROM jurnal_umum where SUBSTR(no_bukti,1,3)='INV'");

        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else if (count($q) == null) {
            $kd = "0001";
        } else if (count($q) == 0) {
            $kd = "0001";
        }

        $invoice = Invoice::create($attr);
        $noBukti = 'INV-' . $kd;
        // $akunPiutang = Coa::select('id', 'kode')->findOrFail($request['akun_piutang']);

        $jurnals = [];

        $jurnals[] = new JurnalUmum([
            'tanggal' => now()->toDateString(),
            'no_bukti' => $noBukti,
            'coa_id' => $request['akun_piutang'],
            'deskripsi' => 'Invoice No. ' . $attr['kode'],
            'debit' => $dibayar,
            'kredit' => 0,
        ]);

        $jurnals[] = new JurnalUmum([
            'tanggal' => now()->toDateString(),
            'no_bukti' => $noBukti,
            'coa_id' => $request['akun_pendapatan'],
            'deskripsi' => 'Invoice No. ' . $attr['kode'],
            'debit' => 0,
            'kredit' => $dibayar,
        ]);

        $invoice->jurnals()->saveMany($jurnals);
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
            'sale:id,kode,spal_id,attn,tanggal,lunas,catatan',
            'sale.spal:id,kode',
            'sale.detail_sale:id,sale_id,item_id,harga,qty,sub_total',
            'sale.detail_sale.item:id,kode,nama,unit_id',
            'sale.detail_sale.item.unit:id,nama',
            'sale.invoices:sale_id,id,kode,tanggal_dibayar,tanggal_invoice,dibayar,status',
            'jurnals:id,coa_id,ref_type,ref_id',
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
        $spal = Spal::with('customer:id,nama')->find($sale['spal_id']);
        // remove coma
        $dibayar = $this->removeComma($request['nominal_invoice']);

        // kalo ada tanggal_dibayar dan $invoice belum paid maka ubah total_dibayar pada sales dengan $request['nominal_invoice'] + $sale->total_dibayar
        if ($request['tanggal_dibayar'] && $invoice->status != 'Paid') {

            // kalo jumlah yg dibayarkan lebih dari grand total
            if (($sale->total_dibayar + $dibayar) > $sale->grand_total) {
                // Nominal invoice lebih besar daripada sisa
                Alert::toast('Update data gagal', 'error');

                return redirect()->route('invoice.index');
            }

            if ($sale->total_dibayar + $dibayar == $sale->grand_total) {
                $sale->update([
                    'lunas' => 1,
                ]);
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

            $q = DB::select("SELECT MAX(RIGHT(no_bukti,4)) AS kd_max FROM jurnal_umum where SUBSTR(no_bukti,1,3)='BBM'");
            if (count($q) > 0) {
                foreach ($q as $k) {
                    $tmp = ((int)$k->kd_max) + 1;
                    $kd = sprintf("%04s", $tmp);
                }
            } else if (count($q) == null) {
                $kd = "0001";
            } else if (count($q) == 0) {
                $kd = "0001";
            }

            $noBukti = 'BBM-' . $kd;
            // $akunBeban = Coa::select('id', 'kode')->where('id', $request['akun_beban'])->first();

            $jurnals = [];

            $jurnals[] = new JurnalUmum(
                [
                    'tanggal' => now()->toDateString(),
                    'no_bukti' => $noBukti,
                    'coa_id' => $request['akun_sumber'],
                    'deskripsi' => 'Pembayaran ' . $invoice['kode'] . ' ' . $spal->customer->nama,
                    'debit' => $dibayar,
                    'kredit' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $jurnals[] = new JurnalUmum(
                [
                    'tanggal' => now()->toDateString(),
                    'no_bukti' => $noBukti,
                    'coa_id' => $request['akun_beban'],
                    'deskripsi' => 'Pembayaran ' . $invoice['kode'] . ' ' . $spal->customer->nama,
                    'debit' => 0,
                    'kredit' => $dibayar,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $invoice->jurnals()->saveMany($jurnals);
        }
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

        $invoice->jurnals()->delete();

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

        $checkLatestCode = Invoice::select('id', 'tanggal_invoice', 'kode')
            ->whereYear('tanggal_invoice', $tahun)
            ->whereMonth('tanggal_invoice', $bulan)
            ->whereDay('tanggal_invoice', $hari)
            ->latest()
            ->first();

        if ($checkLatestCode == null) {
            $code = $code . '0001';
        } else {
            // hapus "INV-XXXX-XX-XX-" dan ambil angka buat ditambahin
            // $onlyNumberKode = intval(Str::after($checkLatestCode->kode, $code));
            $onlyNumberKode = intval(substr($checkLatestCode->kode, -4));

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
     * @param int $invoiceId
     * @return array
     */
    public function print(int $invoiceId)
    {
        $invoice = Invoice::print()->findOrFail($invoiceId);

        $relatedInvoices = Sale::relatedInvoice($invoiceId)->get();


        $jml = DB::table("invoices")
       ->where('sale_id', '=', $invoice->sale_id)
       ->where('status', '=', 'Paid')
       ->count();



        $perusahaan = SettingApp::first();

        return [
            'invoice' => $invoice,
            'jml_invoce_terkait' => $jml,
            'perusahaan' => $perusahaan,
            'related_invoices' => $relatedInvoices
        ];
    }

    /**
     * Remove comma from string and convert to int
     *
     * @param string $string
     * @return int
     */
    private function removeComma(string $string)
    {
        return intval(str_replace(',', '', $string));
    }
}
