<div class="col-md-9">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Invoice</h4>
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
            {{-- header form --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="kode">Kode</label>
                        <input class="form-control" type="text" id="kode" name="kode" placeholder="kode"
                            value="{{ $invoice ? $invoice->kode : '' }}" required readonly />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="tanggal-invoice">Tanggal Invoice</label>
                        <input class="form-control" type="date" id="tanggal-invoice" name="tanggal_invoice"
                            placeholder="tanggal-invoice"
                            value="{{ $invoice ? $invoice->tanggal_invoice->format('Y-m-d') : date('Y-m-d') }}"
                            required {{ $show ? 'disabled' : '' }} />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="attn">Attn.</label>
                        <input class="form-control" type="text" id="attn" name="attn" placeholder="Attn."
                            value="{{ $invoice ? $invoice->attn : '' }}" required {{ $show ? 'disabled' : '' }} />
                    </div>
                </div>

                @if ($invoice)
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="nominal-invoice">Nominal Invoice</label>
                            <input class="form-control" type="text" id="nominal-invoice" name="nominal_invoice"
                                placeholder="Nominal Invoice" value="{{ number_format($invoice->dibayar) }}" required
                                {{ $show ? 'disabled' : 'readonly' }} />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="tanggal-dibayar">Tanggal Dibayar</label>
                            <input class="form-control" type="date" id="tanggal-dibayar" name="tanggal_dibayar"
                                placeholder="Tanggal Dibayar"
                                value="{{ $invoice->tanggal_dibayar ? $invoice->tanggal_dibayar->format('Y-m-d') : null }}"
                                {{ $show ? 'disabled' : '' }} />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="status-invoice">Status Pembayaran</label>
                            <input class="form-control" type="text" id="status-invoice" name="status_invoice"
                                placeholder="Tanggal Dibayar" value="{{ $invoice->status }}"
                                {{ $show ? 'disabled' : 'readonly' }} />

                            {{-- @if ($show)
                                <input class="form-control" type="text" id="status-invoice" name="status_invoice"
                                    placeholder="Tanggal Dibayar" value="{{ $invoice->status }}" readonly />
                            @else
                                <select class="form-select" id="status-invoice" name="status_invoice">
                                    <option value="Unpaid" {{ $invoice->status == 'Unpaid' ? 'selected' : '' }}>
                                        Unpaid
                                    </option>
                                    <option value="Paid" {{ $invoice->status == 'Paid' ? 'selected' : '' }}>Paid
                                    </option>
                                </select>
                            @endif --}}
                        </div>
                    </div>
                @endif
            </div>
            {{-- End of header form --}}

            {{-- cart --}}
            <h5 class="mt-3">Sales</h5>
            <table class="table table-striped table-hover table-bordered mt-3" id="tbl-cart">
                <thead>
                    <tr>
                        <th width="30">#</th>
                        <th>Kode - Nama</th>
                        <th>Unit</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($invoice)
                        @foreach ($invoice->sale->detail_sale as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $detail->item->kode . ' - ' . $detail->item->nama }}
                                    <input type="hidden" class="produk-hidden" name="produk[]"
                                        value="{{ $detail->item_id }}">
                                </td>
                                <td>{{ $detail->item->unit->nama }}</td>
                                <td>
                                    {{ number_format($detail->harga) }}
                                    <input type="hidden" class="harga-hidden" name="harga[]"
                                        value="{{ $detail->harga }}">
                                    <input type="hidden" class="unit-hidden" name="unit[]"
                                        value="{{ $detail->item->unit->nama }}">
                                </td>
                                <td>
                                    {{ number_format($detail->qty) }}
                                    <input type="hidden" class="qty-hidden" name="qty[]"
                                        value="{{ $detail->qty }}">
                                </td>
                                <td>
                                    {{ number_format($detail->sub_total) }}
                                    <input type="hidden" class="subtotal-hidden" name="subtotal[]"
                                        value="{{ $detail->subtotal }}">
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            @include('accounting.invoice.include._total')

            @if ($errors->any())
                <div id="validation" class="text-danger">
                    <ul id="ul-msg">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($show)
                <div class="d-flex justify-content-end mt-2">
                    <a href="{{ route('invoice.print', $invoice->id) }}" class="btn btn-dark me-2">
                        Print
                    </a>

                    <a href="{{ route('invoice.index') }}" class="btn btn-secondary" id="btn-cancel"
                        {{ !$invoice ? 'disabled' : '' }}>Cancel</a>
                </div>
            @endif
        </div>
    </div>
</div>
