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
        <div class="form-group mb-2">
            <label class="form-label" for="purchase">Purchase</label>
            <select class="form-select" id="purchase" name="purchase" required {{ $show ? 'readonly' : '' }}>
                @if (!$show)
                    <option value="" disabled selected>-- Pilih --</option>
                @endif

                @if ($show)
                    <option value="{{ $bacTerima->purchase->id }}" selected>{{ $bacTerima->purchase->kode }}
                    </option>
                @endif

                @if (!$show)
                    @forelse ($purchases as $purchase)
                        <option value="{{ $purchase->id }}"
                            {{ $bacTerima && $bacTerima->purchase_id == $purchase->id ? 'selected' : '' }}>
                            {{ $purchase->kode }}
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
        <h4 class="panel-title">Detail Purchase</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table" id="tbl-detail-request">
                <tr>
                    <td width="35">Request Form</td>
                    <td>:</td>
                    <td id="request-form">{{ $bacTerima ? $bacTerima->purchase->request_form->kode : '' }}</td>
                </tr>
                <tr>
                    <td width="35">Supplier</td>
                    <td>:</td>
                    <td id="supplier">{{ $bacTerima ? $bacTerima->purchase->supplier->nama : '' }}</td>
                </tr>
                <tr>
                    <td width="35">Tanggal</td>
                    <td>:</td>
                    <td id="tanggal-purchase">
                        {{ $bacTerima ? $bacTerima->purchase->tanggal->format('d/m/Y') : '' }}
                    </td>
                </tr>
                <tr>
                    <td width="35">Total</td>
                    <td>:</td>
                    <td id="total-purchase">{{ $bacTerima ? number_format($bacTerima->purchase->total) : '' }}
                    </td>
                </tr>
                <tr>
                    <td width="35">Diskon</td>
                    <td>:</td>
                    <td id="diskon-purchase">{{ $bacTerima ? number_format($bacTerima->purchase->diskon) : '' }}
                    </td>
                </tr>
                <tr>
                    <td width="35">Grand Total</td>
                    <td>:</td>
                    <td id="grand-total-purchase">
                        {{ $bacTerima ? number_format($bacTerima->purchase->grand_total) : '' }}
                    </td>
                </tr>
                <tr>
                    <td width="35">Catatan</td>
                    <td>:</td>
                    <td id="catatan-purchase">{{ $bacTerima ? $bacTerima->purchase->catatan : '' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
