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
                            value="{{ $invoice ? $invoice->kode : '' }}" required {{ $show ? 'disabled' : '' }} />
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
                                {{ $show ? 'disabled' : '' }} />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="tanggal-dibayar">Tanggal Dibayar</label>
                            <input class="form-control" type="date" id="tanggal-dibayar" name="tanggal_dibayar"
                                placeholder="Tanggal Dibayar"
                                value="{{ $invoice->tanggal_dibayar ? $invoice->tanggal_dibayar->format('Y-m-d') : null }}"
                                required {{ $show ? 'disabled' : '' }} />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="status-pembayaran">Status Pembayaran</label>
                            <input class="form-control" type="text" id="status-pembayaran" name="status_pembayaran"
                                placeholder="Tanggal Dibayar" value="{{ $invoice->status }}" required
                                {{ $show ? 'disabled' : '' }} />
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

            {{-- subtotal, diskon, note --}}
            <div class="row mt-4">
                <input type="hidden" id="grand-total-hidden" name="grand_total_hidden"
                    value="{{ $invoice ? $invoice->sale->grand_total : '' }}" />
                <input type="hidden" id="total-hidden" name="total_hidden"
                    value="{{ $invoice ? $invoice->sale->total : '' }}" disabled />
                <input type="hidden" name="sisa_hidden" id="sisa-hidden"
                    value="{{ $invoice ? $invoice->sale->grand_total - $invoice->sale->total_dibayar : '' }}">
                <input type="hidden" id="diskon-hidden" name="diskon_hidden"
                    value="{{ $invoice ? $invoice->sale->diskon : '' }}">
                <input type="hidden" id="telah-dibayar-hidden" name="telah_dibayar_hidden"
                    value="{{ $invoice ? $invoice->sale->total_dibayar : '' }}">

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="total">Total</label>
                        <input class="form-control disabled" type="text" id="total" name="total" placeholder="Total"
                            value="{{ $invoice ? number_format($invoice->sale->total) : '' }}" required disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="diskon">Diskon</label>
                        <input class="form-control" type="text" id="diskon" name="diskon" placeholder="Diskon"
                            value="{{ $invoice ? number_format($invoice->sale->diskon) : '' }}" disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="grand-total">Grand Total</label>
                        <input class="form-control disabled" type="text" id="grand-total" name="grand_total"
                            placeholder="Grand Total"
                            value="{{ $invoice ? number_format($invoice->sale->grand_total) : '' }}" required
                            disabled />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="telah_dibayar">Telah Dibayar</label>
                        <input class="form-control" type="text" id="telah-dibayar" name="telah_dibayar"
                            placeholder="Telah Dibayar"
                            value="{{ $invoice ? number_format($invoice->sale->total_dibayar) : '' }}" disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="sisa">Sisa</label>
                        <input class="form-control" type="text" id="sisa" name="sisa" placeholder="Sisa"
                            value="{{ $invoice ? number_format($invoice->sale->grand_total - $invoice->sale->total_dibayar) : '' }}"
                            disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="bayar">Bayar</label>
                        <input class="form-control" type="number" id="bayar" name="dibayar" placeholder="Bayar"
                            min="1" value="{{ $invoice ? $invoice->sale->total_dibayar : '' }}"
                            {{ $show ? 'disabled' : '' }}
                            {{ $invoice && $invoice->sale->status_pembayaran == 'Paid' ? 'disabled' : '' }} />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="catatan">Catatan Invoice</label>
                        <textarea class="form-control" id="catatan" name="catatan" id="catatan"
                            placeholder="Catatan Invoice" rows="8" required
                            {{ $show ? 'disabled' : '' }}>{{ $invoice ? $invoice->sale->catatan : '' }}</textarea>
                    </div>
                </div>

                @if (!$show)
                    <div class="col-md-12 mt-2">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2" id="btn-save"
                                {{ !$invoice ? 'disabled' : '' }}>
                                @if (!$invoice)
                                    Simpan
                                @else
                                    Update
                                @endif
                            </button>

                            <a href="{{ route('invoice.index') }}" class="btn btn-secondary" id="btn-cancel"
                                {{ !$invoice ? 'disabled' : '' }}>Cancel</a>
                        </div>
                    </div>
                @endif
            </div>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @endif
        </div>
    </div>
</div>
