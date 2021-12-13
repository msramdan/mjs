<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\StoreBenefitRequest;
use App\Models\Legal\Karyawan;
use App\Models\Payroll\Benefit;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class BenefitController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Karyawan::latest('updated_at');

            return Datatables::of($query)
            ->addColumn('foto', function ($row) {
                if ($row->foto != null) {
                    return asset('storage/img/karyawan/' . $row->foto);
                } else {
                    return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($row->email))) . "&s=100";
                }
            })
                ->addColumn('action', 'payroll.benefit._action')
                ->toJson();
        }

        return view('payroll.benefit.index');
    }

    public function store(StoreBenefitRequest $request)
    {
        Benefit::create($request->validated());
        Alert::success('Tambah Data', 'Berhasil');
        return redirect()->route('benefit.edit' , $request->karyawan_id);
    }

    public function show($karyawan_id){
        $output = '';
        $list = \DB::select("SELECT category_benefit.nama,data_benefit.id,data_benefit.besar_benefit FROM data_benefit join category_benefit on category_benefit.id =data_benefit.category_benefit_id where karyawan_id='$karyawan_id' ");
        foreach ($list as $a) {
            $output .= "<tr>
                            <td>".$a->nama."</td>
                                <td>".$a->besar_benefit."</td>
                            <td>
                                <form action='" .route('benefit.destroy', $a->id)."' method='post' class='d-inline'
                                    onsubmit='return confirm('Yakin ingin menghapus data ini?')'>
                                    <input name='_token' type='hidden' value='".csrf_token()."'/>
                                    ".method_field('delete')."
                                    <button class='btn btn-danger btn-xs mb-1'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>";
        }
        echo $output;
    }

    public function edit($karyawan_id)
    {
        $CategoryBenefit = \DB::select("SELECT category_benefit.id as category_benefit_id,category_benefit.nama, data_benefit.id,data_benefit.karyawan_id FROM category_benefit LEFT join data_benefit on data_benefit.category_benefit_id =category_benefit.id and karyawan_id='$karyawan_id' WHERE data_benefit.id IS NULL;");
        return view('payroll.benefit.edit')->with([
            'kategori' => $CategoryBenefit,
            'karyawan_id' => $karyawan_id
        ]);
    }

    public function destroy(Benefit $benefit)
    {
        try {
            $benefit->delete();
            Alert::success('Hapus Data', 'Berhasil');
            return redirect()->route('benefit.edit' , $benefit->karyawan_id);
        } catch (\Throwable $th) {
            Alert::error('Hapus Data', 'Gagal');
            return redirect()->route('benefit.edit' , $benefit->karyawan_id);
        }

    }
}
