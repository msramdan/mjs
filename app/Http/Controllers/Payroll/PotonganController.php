<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\StorePotonganRequest;
use App\Models\Legal\Karyawan;
use App\Models\Payroll\Potongan;
use Yajra\DataTables\Facades\DataTables;

class PotonganController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view potongan')->only('index');
        // $this->middleware('permission:create potongan')->only('create');
        $this->middleware('permission:edit potongan')->only('edit', 'update');
        $this->middleware('permission:delete potongan')->only('delete');
    }

    public function index()
    {
        if (request()->ajax()) {
            $query = Karyawan::query();

            return Datatables::of($query)
                ->addColumn('foto', function ($row) {
                    if ($row->foto != null) {
                        return asset('storage/img/karyawan/' . $row->foto);
                    } else {
                        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($row->email))) . "&s=100";
                    }
                })

                ->addColumn('action', 'payroll.potongan._action')
                ->toJson();
        }

        return view('payroll.potongan.index');
    }

    public function store(StorePotonganRequest $request)
    {
        Potongan::create($request->validated());

        toast('' . trans('notif.pesan_berhasil.ditambahkan') . '', 'success');

        return redirect()->route('potongan.edit', $request->karyawan_id);
    }

    public function show($karyawan_id)
    {
        $output = '';
        $list = \DB::select("SELECT category_potongan.nama,data_potongan.id,data_potongan.besar_potongan FROM data_potongan join category_potongan on category_potongan.id =data_potongan.category_potongan_id where karyawan_id='$karyawan_id' ");

        foreach ($list as $a) {
            $output .= "<tr>
                            <td>" . $a->nama . "</td>
                                <td>" . $a->besar_potongan . "</td>
                            <td>
                                <form action='" . route('potongan.destroy', $a->id) . "' method='post' class='d-inline'
                                    onsubmit='return confirm('Yakin ingin menghapus data ini?')'>
                                    <input name='_token' type='hidden' value='" . csrf_token() . "'/>
                                    " . method_field('delete') . "
                                    <button class='btn btn-danger btn-xs mb-1'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>";
        }

        return $output;
    }

    public function edit($karyawan_id)
    {
        $CategoryPotongan = \DB::select("SELECT category_potongan.id as category_potongan_id ,category_potongan.nama, data_potongan.id,data_potongan.karyawan_id FROM category_potongan LEFT join data_potongan on data_potongan.category_potongan_id =category_potongan.id and karyawan_id='$karyawan_id' WHERE data_potongan.id IS NULL;");

        return view('payroll.potongan.edit')->with([
            'kategori' => $CategoryPotongan,
            'karyawan_id' => $karyawan_id
        ]);
    }

    public function destroy(Potongan $potongan)
    {
        try {
            $potongan->delete();
            toast('' . trans('notif.pesan_berhasil.dihapus') . '', 'success');
            return redirect()->route('potongan.edit', $potongan->karyawan_id);
        } catch (\Throwable $th) {
            toast('' . trans('notif.pesan_gagal.dihapus') . '', 'error');
            return redirect()->route('potongan.edit', $potongan->karyawan_id);
        }
    }
}
