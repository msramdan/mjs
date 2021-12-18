<div class="col-md-3">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">BAC Pakai</h4>
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
                <label class="form-label" for="bac-pakai">BAC Pakai</label>
                <select class="form-select" id="bac-pakai" name="bac_pakai" required {{ $show ? 'readonly' : '' }}>
                    @if (!$show)
                        <option value="" disabled selected>-- Pilih --</option>

                        @forelse ($bacPakaiBT as $item)
                            <option value="{{ $item->id }}"
                                {{ $aso && $aso->bac_pakai_id == $item->id ? 'selected' : '' }}>
                                {{ $item->kode }}
                            </option>
                        @empty
                            <option value="" disabled>Data tidak ditemukan</option>
                        @endforelse
                    @else
                        <option value="" disabled selected>{{ $aso->bac_pakai->kode }}</option>
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Detail BAC Pakai</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table" id="tbl-detail-request">
                    <tr>
                        <td width="35">Kode</td>
                        <td>:</td>
                        <td id="kode">{{ $aso ? $aso->bac_pakai->kode : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">User</td>
                        <td>:</td>
                        <td id="user">{{ $aso ? $aso->bac_pakai->user->name : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Tanggal</td>
                        <td>:</td>
                        <td id="tanggal-bac">
                            {{ $aso ? $aso->bac_pakai->tanggal->format('d/m/Y') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="35">Keterangan</td>
                        <td>:</td>
                        <td id="keterangan">{{ $aso ? $aso->keterangan : '' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
