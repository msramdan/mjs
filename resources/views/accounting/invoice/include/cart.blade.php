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
                            value="{{ isset($invoice) ? $invoice->kode : '' }}" required readonly />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="tanggal-invoice">Tanggal Invoice</label>
                        <input class="form-control" type="date" id="tanggal-invoice" name="tanggal_invoice"
                            placeholder="tanggal-invoice"
                            value="{{ isset($invoice) ? $invoice->tanggal_invoice->format('Y-m-d') : date('Y-m-d') }}"
                            required {{ isset($show) ? 'disabled' : '' }} />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="form-label" for="attn">Attn.</label>
                        <input class="form-control" type="text" id="attn" name="attn" placeholder="Attn."
                            value="{{ isset($invoice) ? $invoice->attn : '' }}" required
                            {{ isset($show) ? 'disabled' : '' }} />
                    </div>
                </div>
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
                    @isset($invoice)
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
                                    <input type="hidden" class="qty-hidden" name="qty[]" value="{{ $detail->qty }}">
                                </td>
                                <td>
                                    {{ number_format($detail->sub_total) }}
                                    <input type="hidden" class="subtotal-hidden" name="subtotal[]"
                                        value="{{ $detail->subtotal }}">
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>

            @include('accounting.invoice.include._total')

            {{-- ketika edit --}}
            @if (isset($invoice) && empty($show))
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="nominal-invoice">Nominal invoice</label>
                            <input class="form-control" type="text" id="nominal-invoice" name="nominal_invoice"
                                placeholder="Nominal invoice" value="{{ number_format($invoice->dibayar) }}" required
                                {{ isset($show) && $show ? 'disabled' : 'readonly' }} />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="tanggal-dibayar">Tanggal Dibayar</label>
                            <input class="form-control" type="date" id="tanggal-dibayar" name="tanggal_dibayar"
                                placeholder="Tanggal Dibayar"
                                value="{{ isset($invoice) && $invoice->tanggal_dibayar ? $invoice->tanggal_dibayar->format('Y-m-d') : null }}"
                                {{ isset($show) && $show ? 'disabled' : '' }} />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label" for="status-invoice">Status Pembayaran</label>
                            <input class="form-control" type="text" id="status-invoice" name="status_invoice"
                                placeholder="Tanggal Dibayar" value="{{ isset($invoice) ? $invoice->status : '' }}"
                                {{ isset($show) && $show ? 'disabled' : 'readonly' }} />
                        </div>
                    </div>
                </div>
            @endif

            {{-- coas --}}
            <div class="row">
                <div class="col-md-6 mb-2" id="col-akun-piutang">
                    <div class="form-group">
                        <label for="akun-piutang">Akun Piutang</label>
                        <select name="akun_piutang" id="akun-piutang"
                            class="form-select{{ isset($invoice) ? ' bg-secondary' : '' }}"
                            {{ isset($invoice) ? 'disabled' : '' }}>
                            @foreach ($akunPiutang as $apiu)
                                <option value="{{ $apiu->id }}" @php
                                    if (isset($invoice)) {
                                        foreach ($invoice->jurnals as $jurnal) {
                                            if ($jurnal->coa_id == $apiu->id) {
                                                echo 'selected ';
                                            }
                                        }
                                    }
                                @endphp>
                                    {{ $apiu->kode . ' - ' . $apiu->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-2" id="col-akun-pendapatan">
                    <div class="form-group">
                        <label for="akun-pendapatan">Akun Pendapatan</label>
                        <select name="akun_pendapatan" id="akun-pendapatan"
                            class="form-select{{ isset($invoice) ? ' bg-secondary' : '' }}"
                            {{ isset($invoice) ? 'disabled' : '' }}>
                            @foreach ($akunPendapatan as $apndpt)
                                <option value="{{ $apndpt->id }}" @php
                                    if (isset($invoice)) {
                                        foreach ($invoice->jurnals as $jurnal) {
                                            if ($jurnal->coa_id == $apndpt->id) {
                                                echo 'selected';
                                            }
                                        }
                                    }
                                @endphp>
                                    {{ $apndpt->kode . ' - ' . $apndpt->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- akun sumber & beban --}}
                @isset($invoice)
                    <div class="col-md-6" id="col-akun-sumber">
                        <div class="form-group">
                            <label for="akun-sumber">Akun Sumber</label>
                            <select name="akun_sumber" id="akun-sumber" class="form-select">
                                @foreach ($akunSumber as $as)
                                    <option value="{{ $as->id }}" @php
                                        foreach ($invoice->jurnals as $jurnal) {
                                            if ($jurnal->coa_id == $as->id) {
                                                echo 'selected';
                                            }
                                        }
                                    @endphp>
                                        {{ $as->kode . ' - ' . $as->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="col-akun-beban">
                        <div class="form-group">
                            <label for="akun-beban">Akun Beban</label>
                            <select name="akun_beban" id="akun-beban" class="form-select">
                                @foreach ($akunPiutang as $apiu)
                                    <option value="{{ $apiu->id }}" @php
                                        foreach ($invoice->jurnals as $jurnal) {
                                            if ($jurnal->coa_id == $apiu->id) {
                                                echo 'selected ';
                                            }
                                        }
                                    @endphp>
                                        {{ $apiu->kode . ' - ' . $apiu->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endisset
            </div>

            @empty($show)
                <div class="col-md-12 mt-2">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2" id="btn-save"
                            {{ empty($invoice) ? 'disabled' : '' }}>
                            {{ empty($invoice) ? 'Simpan' : 'Update' }}
                        </button>

                        {{-- <a href="{{ route('invoice.print', $invoice->id) }}" class="btn btn-dark me-2">
                        Print
                    </a> --}}

                        <a href="{{ route('invoice.index') }}" class="btn btn-secondary" id="btn-cancel"
                            {{ empty($invoice) ? 'disabled' : '' }}>Cancel</a>
                    </div>
                </div>
            @else
                <div class="d-flex justify-content-end mt-2">
                    <a href="{{ route('invoice.print', $invoice->id) }}" class="btn btn-dark me-2">
                        Print
                    </a>

                    <a href="{{ route('invoice.index') }}" class="btn btn-secondary" id="btn-cancel"
                        {{ empty($invoice) ? 'disabled' : '' }}>Cancel</a>
                </div>
            @endempty

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
