<?php

namespace App\Repositories;

use App\Models\Accounting\{Billing, JurnalUmum};
use App\Models\Purchase\Purchase;
use App\Models\Setting\SettingApp;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BillingRepository
{
    /**
     * Get all billing from database and used datatable.
     *
     * @return string
     */
    public function getAll()
    {
        $query = Billing::with('purchase:id,kode', 'user:id,name');

        return DataTables::of($query)
            ->addColumn('purchase', function ($row) {
                return $row->purchase->kode;
            })
            ->addColumn('user', function ($row) {
                return $row->user->name;
            })
            ->addColumn('tanggal_billing', function ($row) {
                return $row->tanggal_billing->format('d M Y');
            })
            ->addColumn('tanggal_dibayar', function ($row) {
                return $row->tanggal_dibayar ? $row->tanggal_dibayar->format('d M Y') : '-';
            })
            ->addColumn('action', 'accounting.billing._action')
            ->toJson();
    }

    /**
     * Insert newly created billing to database.
     *
     * @param array $request
     * @return void
     */
    public function insert(array $request)
    {
        $attributes = $request;
        $attributes['purchase_id'] = $request['purchase'];
        $attributes['user_id'] = auth()->id();

        Billing::create($attributes);
    }

    /**
     * Load the relations for edit and show view.
     *
     * @param App\Models\Accounting\Billing $billing
     * @return $billing
     */
    public function loadRelations($billing)
    {
        return $billing->load(
            'purchase.request_form:id,kode',
            'purchase.detail_purchase:id,purchase_id,item_id,harga,qty,sub_total',
            'purchase.detail_purchase.item:id,kode,nama,unit_id',
            'purchase.detail_purchase.item.unit:id,nama',
            'purchase.billings:purchase_id,id,kode,tanggal_dibayar,tanggal_billing,dibayar,status'
        );
    }

    /**
     * Update the specified billing from database.
     *
     * @param array $request
     * @param App\Models\Accounting\Billing $billing
     * @return void
     */
    public function update(array $request, $billing)
    {

        DB::transaction(function () use ($request, $billing) {
            $purchase = Purchase::with(
                'detail_purchase',
                'detail_purchase.item:id,kode,nama'
            )->findOrFail($request['purchase']);

            // remove coma
            $dibayar = intval(str_replace(',', '', $request['nominal_billing']));

            // kalo ada tanggal_dibayar dan $billing belum paid maka ubah total_dibayar pada purchases dengan $request['nominal_billing'] + $purchase->total_dibayar
            if ($request['tanggal_dibayar'] && $billing->status != 'Paid') {

                // kalo jumlah yg dibayarkan lebih dari grand total
                if (($purchase->total_dibayar + $dibayar) > $purchase->grand_total) {
                    // Nominal billing lebih besar daripada sisa
                    Alert::toast('Update data gagal', 'error');

                    return redirect()->route('billing.index');
                }

                if ($purchase->total_dibayar + $dibayar == $purchase->grand_total) {
                    $purchase->update([
                        'lunas' => 1,
                    ]);
                }

                $purchase->update([
                    'total_dibayar' => $purchase->total_dibayar + $dibayar
                ]);
            } elseif (!$request['tanggal_dibayar'] && $billing->status == 'Paid') {
                // kalo dari paid diubah ke unpaid
                $purchase->update([
                    'total_dibayar' => $purchase->total_dibayar - $dibayar,
                    'lunas' => 0,
                ]);
            }

            $billing->update([
                'kode' => $request['kode'],
                'attn' => $request['attn'],
                'tanggal_billing' => $request['tanggal_billing'],
                'tanggal_dibayar' => $request['tanggal_dibayar'],
                'catatan' => $request['catatan'],
                'status' => $request['status_billing'],
            ]);

            if ($request['tanggal_dibayar'] && $request['status_billing'] == 'Paid') {
                if ($request['akun_sumber']==4) {
                    $q = DB::select("SELECT MAX(RIGHT(no_bukti,4)) AS kd_max FROM jurnal_umum where SUBSTR(no_bukti,1,3)='BKK'");
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
                    $noBukti = 'BKK-' . $kd;
                } else {
                    $q = DB::select("SELECT MAX(RIGHT(no_bukti,4)) AS kd_max FROM jurnal_umum where SUBSTR(no_bukti,1,3)='BBK'");
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
                    $noBukti = 'BBK-' . $kd;
                }
                $jurnals = [];
                foreach ($purchase->detail_purchase as $dp) {
                    $jurnals[] = new JurnalUmum([
                        'tanggal' => now()->toDateString(),
                        'no_bukti' => $noBukti,
                        'coa_id' => $request['akun_beban'],
                        'deskripsi' => 'Pembelian ' . $dp->item->nama,
                        'debit' => $dp->sub_total,
                        'kredit' => 0
                    ]);
                }

                $jurnals[] = new JurnalUmum([
                    'tanggal' => now()->toDateString(),
                    'no_bukti' => $noBukti,
                    'coa_id' => $request['akun_sumber'],
                    'deskripsi' => 'Pembayaran untuk ' . $billing->kode,
                    'debit' => 0,
                    'kredit' => $purchase->total
                ]);

                // fee bank
                if (isset($request['TextFeeBank'])) {
                    // debit
                    $jurnals[] = new JurnalUmum([
                        'tanggal' => now()->toDateString(),
                        'no_bukti' => $noBukti,
                        'coa_id' => 17,
                        'deskripsi' => 'Bea Transafer',
                        'debit' => $request['TextFeeBank'],
                        'kredit' => 0
                    ]);

                    // kredit
                    $jurnals[] = new JurnalUmum([
                        'tanggal' => now()->toDateString(),
                        'no_bukti' => $noBukti,
                        'coa_id' => $request['akun_sumber'],
                        'deskripsi' => 'Bea Transafer',
                        'debit' => 0,
                        'kredit' => $request['TextFeeBank']
                    ]);
                }

                $billing->jurnals()->saveMany($jurnals);
            }
        });
    }

    /**
     *  Remove the specified billing from database.
     *
     * @param App\Models\Accounting\Billing $billing
     * @return void
     */
    public function delete($billing)
    {
        $purchase = Purchase::findOrFail($billing->purchase_id);

        if ($billing->status == 'Paid') {
            $purchase->update([
                'total_dibayar' => $purchase->total_dibayar - $billing->dibayar,
                'lunas' => 0,
            ]);
        }

        $billing->delete();
    }

    /**
     * Generate a new code by date for billing.
     *
     * @param string $tanggal
     * @return string $code
     */
    public function generateCode(string $tanggal)
    {
        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $hari = date('d', strtotime($tanggal));

        $code = 'BILL-' . $tahun . '-' . $bulan . '-' . $hari  . '-';

        $checkLatestKode = Billing::select('id', 'tanggal_billing', 'kode')
            ->whereYear('tanggal_billing', $tahun)
            ->whereMonth('tanggal_billing', $bulan)
            ->whereDay('tanggal_billing', $hari)
            ->latest()
            ->first();

        if ($checkLatestKode == null) {
            $code = $code . '0001';
        } else {
            // hapus "BILL-YYYY-MM-DD-" dan ambil angka buat ditambahin
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
     * Select some field on billing table, load the relations, and get data about the company(PT).
     *
     * @param int $id
     * @return array
     */
    public function print(int $id)
    {
        $billing = Billing::select(
            'id',
            'purchase_id',
            'kode',
            'tanggal_billing',
            'status',
            'catatan'
        )->with(
            'purchase:id,request_form_id,supplier_id,kode,diskon,grand_total',
            'purchase.request_form:id,kode',
            'purchase.supplier:id,kode,nama,email,alamat,telp',
            'purchase.detail_purchase:id,purchase_id,item_id,harga,qty,sub_total',
            'purchase.detail_purchase.item:id,kode,nama',
            'user:id,name'
        )->findOrFail($id);

        $perusahaan = SettingApp::first();

        return [
            'billing' => $billing,
            'perusahaan' => $perusahaan
        ];
    }
}
