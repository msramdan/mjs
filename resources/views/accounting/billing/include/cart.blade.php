<div class="col-md-9">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Billing</h4>
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
                            value="{{ $billing ? $billing->kode : '' }}" required readonly />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="tanggal-billing">Tanggal billing</label>
                        <input class="form-control" type="date" id="tanggal-billing" name="tanggal_billing"
                            placeholder="tanggal-billing"
                            value="{{ $billing ? $billing->tanggal_billing->format('Y-m-d') : date('Y-m-d') }}"
                            required {{ $show ? 'disabled' : '' }} />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="attn">Attn.</label>
                        <input class="form-control" type="text" id="attn" name="attn" placeholder="Attn."
                            value="{{ $billing ? $billing->attn : '' }}" required {{ $show ? 'disabled' : '' }} />
                    </div>
                </div>


                @if ($billing)
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="nominal-billing">Nominal billing</label>
                            <input class="form-control" type="text" id="nominal-billing" name="nominal_billing"
                                placeholder="Nominal billing" value="{{ number_format($billing->dibayar) }}" required
                                {{ $show ? 'disabled' : 'readonly' }} />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="tanggal-dibayar">Tanggal Dibayar</label>
                            <input class="form-control" type="date" id="tanggal-dibayar" name="tanggal_dibayar"
                                placeholder="Tanggal Dibayar"
                                value="{{ $billing->tanggal_dibayar ? $billing->tanggal_dibayar->format('Y-m-d') : null }}"
                                {{ $show ? 'disabled' : '' }} />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="status-billing">Status Pembayaran</label>
                            <input class="form-control" type="text" id="status-billing" name="status_billing"
                                placeholder="Tanggal Dibayar" value="{{ $billing->status }}"
                                {{ $show ? 'disabled' : 'readonly' }} />

                            {{-- @if ($show)
                                <input class="form-control" type="text" id="status-billing" name="status_billing"
                                    placeholder="Tanggal Dibayar" value="{{ $billing->status }}" readonly />
                            @else
                                <select class="form-select" id="status-billing" name="status_billing">
                                    <option value="Unpaid" {{ $billing->status == 'Unpaid' ? 'selected' : '' }}>
                                        Unpaid
                                    </option>
                                    <option value="Paid" {{ $billing->status == 'Paid' ? 'selected' : '' }}>Paid
                                    </option>
                                </select>
                            @endif --}}
                        </div>
                    </div>
                @endif
            </div>
            {{-- End of header form --}}

            {{-- cart --}}
            <h5 class="mt-3">purchases</h5>
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
                    @if ($billing)
                        @foreach ($billing->purchase->detail_purchase as $detail)
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
                    value="{{ $billing ? $billing->purchase->grand_total : '' }}" />
                <input type="hidden" id="total-hidden" name="total_hidden"
                    value="{{ $billing ? $billing->purchase->total : '' }}" disabled />
                <input type="hidden" name="sisa_hidden" id="sisa-hidden"
                    value="{{ $billing ? $billing->purchase->grand_total - $billing->purchase->total_dibayar : '' }}">
                <input type="hidden" id="diskon-hidden" name="diskon_hidden"
                    value="{{ $billing ? $billing->purchase->diskon : '' }}">
                <input type="hidden" id="telah-dibayar-hidden" name="telah_dibayar_hidden"
                    value="{{ $billing ? $billing->purchase->total_dibayar : '' }}">

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="total">Total</label>
                        <input class="form-control disabled" type="text" id="total" name="total" placeholder="Total"
                            value="{{ $billing ? number_format($billing->purchase->total) : '' }}" required
                            disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="diskon">Diskon</label>
                        <input class="form-control" type="text" id="diskon" name="diskon" placeholder="Diskon"
                            value="{{ $billing ? number_format($billing->purchase->diskon) : '' }}" disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="grand-total">Grand Total</label>
                        <input class="form-control disabled" type="text" id="grand-total" name="grand_total"
                            placeholder="Grand Total"
                            value="{{ $billing ? number_format($billing->purchase->grand_total) : '' }}" required
                            disabled />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="telah_dibayar">Telah Dibayar</label>
                        <input class="form-control" type="text" id="telah-dibayar" name="telah_dibayar"
                            placeholder="Telah Dibayar"
                            value="{{ $billing ? number_format($billing->purchase->total_dibayar) : '' }}"
                            disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="sisa">Sisa</label>
                        <input class="form-control" type="text" id="sisa" name="sisa" placeholder="Sisa"
                            value="{{ $billing ? number_format($billing->purchase->grand_total - $billing->purchase->total_dibayar) : '' }}"
                            disabled />
                    </div>

                    @if (!$billing)
                        <div class="form-group mb-2">
                            <label class="form-label" for="bayar">Bayar <small>(Nominal Billing)</small></label>
                            <input class="form-control" type="{{ $billing ? 'number' : 'text' }}" id="bayar"
                                name="dibayar" placeholder="Bayar" min="1"
                                value="{{ $billing ? number_format($billing->purchase->total_dibayar) : '' }}"
                                {{ $show ? 'disabled' : '' }}
                                {{ $billing && $billing->purchase->status_pembayaran == 'Paid' ? 'disabled' : '' }} />
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="catatan">Catatan billing</label>
                        <textarea class="form-control" id="catatan" name="catatan" id="catatan"
                            placeholder="Catatan billing" rows="8" required
                            {{ $show ? 'disabled' : '' }}>{{ $billing ? $billing->purchase->catatan : '' }}</textarea>
                    </div>
                </div>

                @if (!$show)
                    <div class="col-md-12 mt-2">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2" id="btn-save"
                                {{ !$billing ? 'disabled' : '' }}>
                                @if (!$billing)
                                    Simpan
                                @else
                                    Update
                                @endif
                            </button>

                            <a href="{{ route('billing.index') }}" class="btn btn-secondary" id="btn-cancel"
                                {{ !$billing ? 'disabled' : '' }}>Cancel</a>
                        </div>
                    </div>
                @endif
            </div>

            @if ($errors->any())
                <div id="validation" class="text-danger">
                    <ul id="ul-msg">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
