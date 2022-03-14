<div class="col-md-3">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Spal</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
                        class="fa fa-redo"></i>
                </a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse">
                    <i class="fa fa-minus"></i>
                </a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-group mb-2">
                <label class="form-label" for="spal">Spal</label>
                <select class="form-select @error('spal') is-invalid @enderror" id="spal" name="spal" required
                    {{ $show ? 'readonly' : '' }}>
                    @if (!$show)
                        <option value="" disabled selected>-- Pilih --</option>

                        @forelse ($spal as $item)
                            <option value="{{ $item->id }}"
                                {{ $sale && $sale->spal_id == $item->id ? 'selected' : '' }}>{{ $item->kode }}
                            </option>
                        @empty
                            <option value="" disabled>Data tidak ditemukan</option>
                        @endforelse
                    @else
                        <option value="" disabled selected>{{ $sale->spal->kode }}</option>
                    @endif

                </select>
                @error('spal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Detail Spal</h4>
        </div>
        <div class="panel-body">
            <table class="table" id="tbl-detail-spal">
                <tr>
                    <td width="35">Nama Kapal</td>
                    <td>:</td>
                    <td id="nama-kapal">{{ $sale ? $sale->spal->nama_kapal : '' }}</td>
                </tr>

                <tr>
                    <td width="35">Jumlah Muatan</td>
                    <td>:</td>
                    <td id="jml-muatan">{{ $sale ? $sale->spal->jml_muatan : '' }}</td>
                </tr>

                <tr>
                    <td width="35">Pelabuhan Muat</td>
                    <td>:</td>
                    <td id="pelabuhan-muat">{{ $sale ? $sale->spal->pelabuhan_muat : '' }}</td>
                </tr>

                <tr>
                    <td width="35">Pelabuhan Bongkar</td>
                    <td>:</td>
                    <td id="pelabuhan-bongkar">{{ $sale ? $sale->spal->pelabuhan_bongkar : '' }}</td>
                </tr>

                <tr>
                    <td width="35">Harga Unit</td>
                    <td>:</td>
                    <td id="harga-unit">{{ $sale ? number_format($sale->spal->harga_unit) : '' }}</td>
                </tr>

                <tr>
                    <td width="35">Harga Demorage</td>
                    <td>:</td>
                    <td id="harga-demorage">
                        {{ $sale ? number_format($sale->spal->harga_demorage) : '' }}
                    </td>
                    <input type="hidden" name="lama_waktu_hidden" id="lama-waktu-hidden"
                        value="{{ isset($sale) && isset($sale->spal->time_sheets)? $sale->spal->time_sheets[0]->hari .' Hari, ' .$sale->spal->time_sheets[0]->jam .' Jam, ' .$sale->spal->time_sheets[0]->menit .' Menit': '' }}">
                </tr>
            </table>
        </div>
    </div>
</div>
