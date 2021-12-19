<div class="col-md-3">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">BAC Terima</h4>
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
                <label class="form-label" for="bac-terima">BAC Terima</label>
                <select class="form-select" id="bac-terima" name="bac_terima" required
                    {{ $show ? 'readonly' : '' }}>
                    @if (!$show)
                        <option value="" disabled selected>-- Pilih --</option>
                    @endif

                    @if ($received)
                        <option value="{{ $received->bac_terima->id }}" selected>{{ $received->bac_terima->kode }}
                        </option>
                    @endif

                    @if (!$show)
                        @forelse ($bacTerimaBT as $item)
                            <option value="{{ $item->id }}"
                                {{ $received && $received->bac_terima_id == $item->id ? 'selected' : '' }}>
                                {{ $item->kode }}
                            </option>
                        @empty
                            <option value="" disabled>Data tidak ditemukan</option>
                        @endforelse
                    @endif
                </select>
            </div>
        </div>
    </div>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Detail BAC Terima</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table" id="tbl-detail-request">
                    <tr>
                        <td width="35">Kode</td>
                        <td>:</td>
                        <td id="kode">{{ $received ? $received->bac_terima->kode : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">User</td>
                        <td>:</td>
                        <td id="user">{{ $received ? $received->bac_terima->user->name : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Tanggal</td>
                        <td>:</td>
                        <td id="tanggal-bac">
                            {{ $received ? $received->bac_terima->tanggal->format('d/m/Y') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="35">Keterangan</td>
                        <td>:</td>
                        <td id="keterangan">{{ $received ? Str::limit($received->bac_terima->keterangan, 200) : '' }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
