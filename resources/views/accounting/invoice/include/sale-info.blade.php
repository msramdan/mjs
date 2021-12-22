<div class="col-md-3">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Sale</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload">
                    <i class="fa fa-redo"></i>
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
                <label class="form-label" for="sale">Sale</label>
                <select class="form-select" id="sale" name="sale" required
                    {{ $show || $invoice ? 'readonly' : '' }}>
                    @if (!$show)
                        <option value="" disabled selected>-- Pilih --</option>
                    @endif

                    @if ($invoice)
                        <option value="{{ $invoice->sale->id }}" selected>{{ $invoice->sale->kode }}
                        </option>
                    @endif

                    @if (!$show && !$invoice)
                        @forelse ($sales as $item)
                            <option value="{{ $item->id }}"
                                {{ $invoice && $invoice->sale_id == $item->id ? 'selected' : '' }}>
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
            <h4 class="panel-title">Detail Sale</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table" id="tbl-detail-request">
                    <tr>
                        <td width="35">Spal</td>
                        <td>:</td>
                        <td id="spal">{{ $invoice ? $invoice->sale->spal->kode : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Attn.</td>
                        <td>:</td>
                        <td id="attn-sale">{{ $invoice ? $invoice->sale->attn : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Tanggal</td>
                        <td>:</td>
                        <td id="tanggal-sale">
                            {{ $invoice ? $invoice->sale->tanggal->format('d/m/Y') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="35">Status</td>
                        <td>:</td>
                        <td id="status">{{ $invoice && $invoice->sale->lunas == 0 ? 'Belum LUnas' : 'Lunas' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Catatan Sale</td>
                        <td>:</td>
                        <td id="catatan-sale">{{ $invoice ? $invoice->sale->catatan : '' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Daftar Pembayaran</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tbl-payment">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Bayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($invoice)
                            @foreach ($invoice->sale->invoices as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->kode }}</td>
                                    <td>{{ $detail->tanggal_invoice->format('d/m/Y') }}</td>
                                    <td>{{ number_format($detail->dibayar) }}</td>
                                    <td>{{ $detail->status }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
