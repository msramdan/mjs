<div class="col-md-9">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Sale</h4>
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
            <div class="row">
                <div class="col-md-{{ !$show ? '6' : '12' }}">
                    <div class="form-group mb-2">
                        <label class="form-label" for="tanggal">Tanggal</label>
                        <input class="form-control" type="date" id="tanggal" name="tanggal" placeholder="tanggal"
                            value="{{ $sale ? $sale->tanggal->format('Y-m-d') : '' }}" required
                            {{ $show ? 'disabled' : '' }} />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="customer">Customer</label>
                        <input class="form-control" type="text" id="customer" name="customer" placeholder="Customer"
                            value="{{ $sale ? $sale->spal->customer->nama : '' }}" required disabled />
                    </div>
                </div>

                @if (!$show)
                    <div class="col-md-6">
                        <input type="hidden" name="stok" id="stok">
                        <input type="hidden" name="kode_produk" id="kode-produk">
                        <input type="hidden" name="unit_produk" id="unit-produk">
                        <input type="hidden" name="index_tr" id="index-tr">

                        <div class="form-group mb-2">
                            <label class="form-label" for="produk">Produk</label>
                            <select class="form-select" id="produk" name="produk">
                                <option value="" disabled selected>-- Pilih --</option>
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id }}">{{ $item->kode . ' - ' . $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label" for="harga">Harga</label>
                            <input class="form-control" type="number" id="harga" name="Harga" placeholder="Harga" />
                        </div>

                        {{-- <div class="form-group mb-2">
                            <label class="form-label" for="qty">Qty</label>
                            <input class="form-control" type="number" id="qty" name="qty" placeholder="Qty" />
                        </div> --}}
                    </div>
                @endif
            </div>

            <div class="form-group mb-2">
                <label class="form-label" for="attn">Attn.</label>
                <input class="form-control" type="text" id="attn" name="attn" placeholder="Attn."
                    value="{{ $sale ? $sale->attn : '' }}" required {{ $show ? 'disabled' : '' }} />
            </div>

            <div class="d-flex justify-content-end my-3">
                @if (!$show)
                    <button type="button" class="btn btn-info" id="btn-update" style="display: none;">
                        <i class="fas fa-save me-1"></i>
                        Update
                    </button>

                    <button type="button" class="btn btn-primary" id="btn-add">
                        <i class="fas fa-cart-plus me-1"></i>
                        Add
                    </button>
                @endif
            </div>

            {{-- cart --}}
            <table class="table table-striped table-hover table-bordered mt-3" id="tbl-cart">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode - Nama</th>
                        <th>Unit</th>
                        <th>Harga</th>
                        @if (!$show)
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($sale)
                        @foreach ($sale->detail_sale as $detail)
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
                                </td>
                                {{-- <td>
                                    {{ $detail->qty }}
                                    <input type="hidden" class="qty-hidden" name="qty[]"
                                        value=" {{ $detail->qty }}">
                                    <input type="hidden" class="stok-hidden" name="stok[]"
                                        value=" {{ $detail->stok }}">
                                    <input type="hidden" class="unit-hidden" name="unit[]"
                                        value="{{ $detail->item->unit->nama }}">
                                </td>
                                <td>
                                    {{ number_format($detail->sub_total) }}
                                    <input type="hidden" class="harga-hidden" name="subtotal[]"
                                        value="{{ $detail->sub_total }}">
                                </td> --}}
                                @if (!$show)
                                    <td>

                                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs btn-delete" type="button">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{-- subtotal, diskon, note --}}
            <div class="row mt-4">
                <div class="col-md-{{ !$show ? '4' : '4' }}">
                    <div class="form-group mb-2">
                        <label class="form-label" for="total">Total</label>
                        <input class="form-control disabled" type="text" id="total" name="total" placeholder="Total"
                            value="{{ $sale ? number_format($sale->total) : '' }}" required disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="diskon">Diskon</label>
                        <input class="form-control" type="number" id="diskon" name="diskon" placeholder="Diskon"
                            value="{{ $sale ? $sale->diskon : '' }}" {{ $show ? 'disabled' : '' }} />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="grand-total">Grand Total</label>
                        <input class="form-control disabled" type="text" id="grand-total" name="grand_total"
                            placeholder="Grand Total" value="{{ $sale ? number_format($sale->grand_total) : '' }}"
                            required disabled />

                        <input type="hidden" id="grand-total-hidden" name="grand_total_hidden"
                            value="{{ $sale ? $sale->grand_total : '' }}" />
                        <input type="hidden" id="total-hidden" name="total_hidden"
                            value="{{ $sale ? $sale->total : '' }}" {{ $show ? 'disabled' : '' }} />
                    </div>
                </div>

                <div class="col-md-{{ !$show ? '6' : '8' }}">
                    <div class="form-group mb-2">
                        <label class="form-label" for="catatan">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" id="catatan" placeholder="Catatan"
                            rows="8" {{ $show ? 'disabled' : '' }}>{{ $sale ? $sale->catatan : '' }}</textarea>
                    </div>
                </div>

                @if (!$show)
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label class="form-label" for="button">Button</label>
                            <br>

                            <button type="submit" class="btn btn-success d-block w-100 mb-2" id="btn-save"
                                {{ !$sale ? 'disabled' : '' }}>
                                @if (!$sale)
                                    Simpan
                                @else
                                    Update
                                @endif
                            </button>

                            <a href="{{ route('sale.index') }}" class="btn btn-secondary d-block w-100"
                                id="btn-cancel" {{ !$sale ? 'disabled' : '' }}>Cancel</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
