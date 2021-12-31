<div class="col-md-3">
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
                <select class="form-select" id="purchase" name="purchase" required
                    {{ $show || $billing ? 'readonly' : '' }}>
                    {{-- @if (!$show)

                    @endif --}}

                    @if ($billing)
                        <option value="{{ $billing->purchase->id }}" selected>{{ $billing->purchase->kode }}
                        </option>
                    @endif

                    @if (!$show && !$billing)
                        <option value="" disabled selected>-- Pilih --</option>
                        @forelse ($purchaseApproves as $item)
                            <option value="{{ $item->id }}"
                                {{ $billing && $billing->purchase_id == $item->id ? 'selected' : '' }}>
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
            <h4 class="panel-title">Detail Purchase</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table" id="tbl-detail-request">
                    <tr>
                        <td width="35">Request Form</td>
                        <td>:</td>
                        <td id="request-form">{{ $billing ? $billing->purchase->request_form->kode : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Attn.</td>
                        <td>:</td>
                        <td id="attn-purchase">{{ $billing ? $billing->purchase->attn : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Tanggal</td>
                        <td>:</td>
                        <td id="tanggal-purchase">
                            {{ $billing ? $billing->purchase->tanggal->format('d/m/Y') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="35">Status</td>
                        <td>:</td>
                        <td id="status">
                            @if ($billing)
                                {{ $billing->purchase->lunas == 0 ? 'Belum lunas' : 'Lunas' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="35">Catatan Purchase</td>
                        <td>:</td>
                        <td id="catatan-purchase">
                            {{ $billing && $billing->purchase->catatan ? $billing->purchase->catatan : '-' }}</td>
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
                        @if ($billing)
                            @foreach ($billing->purchase->billings as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->kode }}</td>
                                    <td>{{ $detail->tanggal_billing->format('d/m/Y') }}</td>
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
