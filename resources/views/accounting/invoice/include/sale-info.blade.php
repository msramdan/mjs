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
                    {{ isset($show) || isset($invoice) ? 'readonly' : '' }}>
                    {{-- @if (!$show)

                    @endif --}}

                    @isset($invoice)
                        <option value="{{ $invoice->sale->id }}" selected>{{ $invoice->sale->kode }}
                        </option>
                    @endisset

                    @if (empty($show) && empty($invoice))
                        <option value="" disabled selected>-- Pilih --</option>
                        @forelse ($sales as $item)
                            <option value="{{ $item->id }}"
                                {{ isset($invoice) && $invoice->sale_id == $item->id ? 'selected' : '' }}>
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
                        <td id="spal">{{ isset($invoice) ? $invoice->sale->spal->kode : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Attn.</td>
                        <td>:</td>
                        <td id="attn-sale">{{ isset($invoice) ? $invoice->sale->attn : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Tanggal</td>
                        <td>:</td>
                        <td id="tanggal-sale">
                            {{ isset($invoice) ? $invoice->sale->tanggal->format('d/m/Y') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="35">Status</td>
                        <td>:</td>
                        <td id="status">
                            @isset($invoice)
                                {{ $invoice->sale->lunas == 0 ? 'Belum lunas' : 'Lunas' }}
                            @endisset
                        </td>
                    </tr>
                    <tr>
                        <td width="35">Catatan Sale</td>
                        <td>:</td>
                        <td id="catatan-sale">{{ isset($invoice) ? $invoice->sale->catatan : '' }}</td>
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
                        @isset($invoice)
                            @foreach ($invoice->sale->invoices as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->kode }}</td>
                                    <td>{{ $detail->tanggal_invoice->format('d/m/Y') }}</td>
                                    <td>{{ number_format($detail->dibayar) }}</td>
                                    <td>{{ $detail->status }}</td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
