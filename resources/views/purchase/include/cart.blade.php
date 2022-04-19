<div class="col-md-9">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Purchase</h4>
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
            <div class="row">
                <div class="col-md-{{ !$show ? '6' : '12' }}">
                    <div class="form-group mb-2">
                        <label class="form-label" for="kode">Kode</label>
                        <input class="form-control" type="text" id="kode" name="kode" placeholder="Kode"
                            value="{{ $purchase ? $purchase->kode : '' }}" required
                            {{ $show ? 'disabled' : 'readonly' }} />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="tanggal">Tanggal</label>
                        <input class="form-control" type="date" id="tanggal" name="tanggal" placeholder="tanggal"
                            value="{{ $purchase ? $purchase->tanggal->format('Y-m-d') : date('Y-m-d') }}" required
                            {{ $show ? 'disabled' : '' }} />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="supplier">Supplier</label>
                        <select class="form-select" id="supplier" name="supplier" {{ $show ? 'readonly' : '' }}>
                            @if (!$show)
                                <option value="" disabled selected>-- Pilih --</option>
                                @forelse ($supplier as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $purchase && $purchase->supplier_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @empty
                                    <option value="" disabled>Data tidak ditemukan</option>
                                @endforelse
                            @else
                                <option value="" disabled selected>{{ $purchase->supplier->nama }}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-{{ !$show ? '6' : '12' }}">
                    <div class="form-group mb-2">
                        <label class="form-label" for="attn">Attn.</label>
                        <input class="form-control" type="text" id="attn" name="attn" placeholder="Attn."
                            value="{{ $purchase ? $purchase->attn : '' }}" required
                            {{ $show ? 'disabled' : '' }} />
                    </div>

                    @if (!$show)
                        <input type="hidden" name="stok" id="stok">
                        <input type="hidden" name="kode_produk" id="kode-produk">
                        <input type="hidden" name="unit_produk" id="unit-produk">
                        <input type="hidden" name="index_tr" id="index-tr">

                        <div class="form-group mb-2">
                            <label class="form-label" for="produk">Produk</label>
                            <select class="form-select" id="produk" name="produk">
                                @isset($listProduk)
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($listProduk as $prd)
                                        <option value="{{ $prd->id }}">
                                            {{ $prd->item->kode . ' - ' . $prd->item->nama }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled selected>Pilih supplier terlebih dahulu</option>
                                @endisset
                            </select>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="harga">Harga</label>
                                <input class="form-control" type="number" id="harga" name="Harga" placeholder="Harga"
                                    min="1" />
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label" for="qty">Qty</label>
                                <input class="form-control" type="number" id="qty" name="qty" placeholder="Qty"
                                    min="1" />
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <div class="d-flex justify-content-between my-3">
                <div>
                    <h5 class="pt-2">Items</h5>
                </div>

                @if (!$show)
                    <div>
                        <button type="button" class="btn btn-info" id="btn-update" style="display: none;" title="Save">
                            <i class="fas fa-save me-1"></i>
                            Update
                        </button>

                        <button type="button" class="btn btn-primary" id="btn-add" title="Add to cart">
                            <i class="fas fa-cart-plus me-1"></i>
                            Add
                        </button>
                    </div>
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
                        <th>Qty</th>
                        <th>Subtotal</th>
                        @if (!$show)
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($purchase)
                        @foreach ($purchase->detail_purchase as $detail)
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
                                    {{ $detail->qty }}
                                    <input type="hidden" class="qty-hidden" name="qty[]"
                                        value="{{ $detail->qty }}">
                                    <input type="hidden" class="stok-hidden" name="stok[]"
                                        value="{{ $detail->item->stok }}">
                                </td>
                                <td>
                                    {{ number_format($detail->sub_total) }}
                                    <input type="hidden" class="subtotal-hidden" name="subtotal[]"
                                        value="{{ $detail->sub_total }}">
                                </td>
                                @if (!$show)
                                    <td>
                                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs btn-delete" type="button" title="Delete">
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
                            value="{{ $purchase ? number_format($purchase->total) : '' }}" required disabled />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="diskon">Diskon</label>
                        <input class="form-control" type="{{ $show ? 'text' : 'number' }}" id="diskon"
                            name="diskon" placeholder="Diskon" min="1"
                            value="{{ $show ? number_format($purchase->diskon) : ($purchase ? $purchase->diskon : '') }}"
                            {{ $show ? 'disabled' : '' }} />
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="grand-total">Grand Total</label>
                        <input class="form-control disabled" type="text" id="grand-total" name="grand_total"
                            placeholder="Grand Total"
                            value="{{ $purchase ? number_format($purchase->grand_total) : '' }}" required disabled />

                        <input type="hidden" id="grand-total-hidden" name="grand_total_hidden"
                            value="{{ $purchase ? $purchase->grand_total : '' }}" />
                        <input type="hidden" id="total-hidden" name="total_hidden"
                            value="{{ $purchase ? $purchase->total : '' }}" {{ $show ? 'disabled' : '' }} />
                    </div>
                </div>

                <div class="col-md-{{ !$show ? '6' : '8' }}">
                    <div class="form-group mb-2">
                        <label class="form-label" for="catatan">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" id="catatan" placeholder="Catatan"
                            rows="8"
                            {{ $show ? 'disabled' : '' }}>{{ $purchase ? $purchase->catatan : '' }}</textarea>
                    </div>
                </div>

                @if (!$show)
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label class="form-label" for="button">Button</label>
                            <br>

                            <button type="submit" class="btn btn-success d-block w-100 mb-2" id="btn-save"
                                {{ !$purchase ? 'disabled' : '' }} title="{{ !$purchase ? 'Save' : 'Update' }}">
                                @if (!$purchase)
                                    Simpan
                                @else
                                    Update
                                @endif
                            </button>

                            <a href="{{ route('purchase.index') }}" class="btn btn-secondary d-block w-100"
                                id="btn-cancel" {{ !$purchase ? 'disabled' : '' }} title="Cancel">Cancel</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
