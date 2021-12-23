<input type="hidden" id="grand-total-hidden" name="grand_total_hidden"
    value="{{ $invoice ? $invoice->sale->grand_total : '' }}" />
<input type="hidden" id="total-hidden" name="total_hidden" value="{{ $invoice ? $invoice->sale->total : '' }}"
    disabled />
<input type="hidden" name="sisa_hidden" id="sisa-hidden"
    value="{{ $invoice ? $invoice->sale->grand_total - $invoice->sale->total_dibayar : '' }}">
<input type="hidden" id="diskon-hidden" name="diskon_hidden" value="{{ $invoice ? $invoice->sale->diskon : '' }}">
<input type="hidden" id="telah-dibayar-hidden" name="telah_dibayar_hidden"
    value="{{ $invoice ? $invoice->sale->total_dibayar : '' }}">

<div class="row mt-4">
    @if (!$invoice)
        <div class="col-md-4">
            <div class="form-group mb-2">
                <label class="form-label" for="total">Total</label>
                <input class="form-control disabled" type="text" id="total" name="total" placeholder="Total" required
                    disabled />
            </div>

            <div class="form-group mb-2">
                <label class="form-label" for="diskon">Diskon</label>
                <input class="form-control" type="text" id="diskon" name="diskon" placeholder="Diskon" disabled />
            </div>

            <div class="form-group mb-2">
                <label class="form-label" for="grand-total">Grand Total</label>
                <input class="form-control disabled" type="text" id="grand-total" name="grand_total"
                    placeholder="Grand Total" required disabled />
            </div>

        </div>
        {{-- end of col-md-4 --}}

        <div class="col-md-4">
            <div class="form-group mb-2">
                <label class="form-label" for="telah_dibayar">Telah Dibayar</label>
                <input class="form-control" type="text" id="telah-dibayar" name="telah_dibayar"
                    placeholder="Telah Dibayar" disabled />
            </div>

            <div class="form-group mb-2">
                <label class="form-label" for="sisa">Sisa</label>
                <input class="form-control" type="text" id="sisa" name="sisa" placeholder="Sisa" disabled />
            </div>

            <div class="form-group mb-2">
                <label class="form-label" for="bayar">Bayar <small>(Nominal Invoice)</small></label>
                <input class="form-control" type="number" id="bayar" name="dibayar" placeholder="Bayar" min="1" />
            </div>
        </div>
        {{-- end of col-md-4 --}}

        <div class="col-md-4">
            <div class="form-group mb-2">
                <label class="form-label" for="catatan">Catatan Invoice</label>
                <textarea class="form-control" id="catatan" name="catatan" id="catatan" placeholder="Catatan Invoice"
                    rows="8" required></textarea>
            </div>
        </div>
        {{-- end of col-md-4 --}}
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="form-label" for="total">Total</label>
                            <input class="form-control disabled" type="text" id="total" name="total" placeholder="Total"
                                value="{{ number_format($invoice->sale->total) }}" required disabled />
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label" for="diskon">Diskon</label>
                            <input class="form-control" type="text" id="diskon" name="diskon" placeholder="Diskon"
                                value="{{ number_format($invoice->sale->diskon) }}" disabled />
                        </div>
                    </div>
                    {{-- end of col-md-6 --}}

                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="form-label" for="telah_dibayar">Telah Dibayar</label>
                            <input class="form-control" type="text" id="telah-dibayar" name="telah_dibayar"
                                placeholder="Telah Dibayar" value="{{ number_format($invoice->sale->total_dibayar) }}"
                                disabled />
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label" for="sisa">Sisa</label>
                            <input class="form-control" type="text" id="sisa" name="sisa" placeholder="Sisa"
                                value="{{ number_format($invoice->sale->grand_total - $invoice->sale->total_dibayar) }}"
                                disabled />
                        </div>
                    </div>
                    {{-- end of col-md-6 --}}

                    <div class="col-md-12">
                        <div class="form-group mb-2">
                            <label class="form-label" for="grand-total">Grand Total</label>
                            <input class="form-control disabled" type="text" id="grand-total" name="grand_total"
                                placeholder="Grand Total" value="{{ number_format($invoice->sale->grand_total) }}"
                                required disabled />
                        </div>
                    </div>
                    {{-- end of col-md-12 --}}
                </div>
            </div>
            {{-- end of col-md-8 --}}

            <div class="col-md-4">
                <div class="form-group mb-2">
                    <label class="form-label" for="catatan">Catatan Invoice</label>
                    <textarea class="form-control" id="catatan" name="catatan" id="catatan"
                        placeholder="Catatan Invoice" rows="8" required
                        {{ $show ? 'disabled' : '' }}>{{ $invoice->sale->catatan }}</textarea>
                </div>
            </div>
            {{-- end of col-md-4 --}}
        </div>
        {{-- end of row --}}
    @endif

    @if (!$show)
        <div class="col-md-12 mt-2">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2" id="btn-save" {{ !$invoice ? 'disabled' : '' }}>
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
