<div class="col-md-9">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Received</h4>
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
                @if (!$show)
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="form-label" for="tanggal">Tanggal</label>
                            <input class="form-control" type="date" id="tanggal" name="tanggal" placeholder="tanggal"
                                value="{{ $received ? $received->tanggal_validasi->format('Y-m-d') : date('Y-m-d') }}"
                                required {{ $show ? 'disabled' : '' }} />
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label" for="validasi_oleh">Validasi Oleh</label>
                            <input class="form-control" type="text" id="validasi_oleh" name="validasi_oleh"
                                placeholder="validasi_oleh" value="{{ auth()->user()->name }}" disabled />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <input type="hidden" name="stok" id="stok">
                        <input type="hidden" name="qty" id="qty">
                        <input type="hidden" name="qty_terima" id="qty-terima">
                        <input type="hidden" name="kode_produk" id="kode-produk">
                        <input type="hidden" name="unit_produk" id="unit-produk">
                        <input type="hidden" name="index_tr" id="index-tr">

                        <div class="form-group mb-2">
                            <label class="form-label" for="produk">Produk</label>
                            <input class="form-control" type="text" id="produk" name="produk" placeholder="Produk"
                                readonly />
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label" for="qty-validasi">Qty Validasi</label>
                            <input class="form-control" type="number" id="qty-validasi" min="1" name="qty_validasi"
                                placeholder="Qty Validasi" />
                        </div>

                        <button id="btn-update" class="btn btn-info float-end mt-2 disabled" disabled>Update</button>
                    </div>
                @else
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="form-label" for="tanggal">Tanggal</label>
                            <input class="form-control" type="date" id="tanggal" name="tanggal" placeholder="tanggal"
                                value="{{ $received ? $received->tanggal_validasi->format('Y-m-d') : date('Y-m-d') }}"
                                required {{ $show ? 'disabled' : '' }} />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="form-label" for="validasi_oleh">Validasi Oleh</label>
                            <input class="form-control" type="text" id="validasi_oleh" name="validasi_oleh"
                                placeholder="validasi_oleh" value="{{ auth()->user()->name }}" disabled />
                        </div>
                    </div>
                @endif
            </div>

            <h5>Items</h5>
            {{-- cart --}}
            <table class="table table-striped table-hover table-bordered mt-3" id="tbl-cart">
                <thead>
                    <tr>
                        <th width="30">#</th>
                        <th>Kode - Nama</th>
                        <th>Unit</th>
                        <th>Qty Terima</th>
                        <th>Qty Validasi</th>
                        @if (!$show)
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($received)
                        @foreach ($received->new_bac_terima->new_detail_bac_terima as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $detail->item->kode . ' - ' . $detail->item->nama }}
                                    <input type="hidden" class="produk-hidden" name="produk[]"
                                        value="{{ $detail->item->kode . ' - ' . $detail->item->nama }}">
                                </td>
                                <td>
                                    {{ $detail->item->unit->nama }}
                                    <input type="hidden" class="unit-hidden"
                                        value="{{ $detail->item->unit->nama }}">
                                </td>
                                <td>
                                    {{ $detail->qty_terima }}
                                    <input type="hidden" class="qty-terima-hidden" name="qty_terima[]"
                                        value="{{ $detail->qty_terima }}">
                                </td>
                                <td>
                                    {{ $detail->qty_validasi }}
                                    <input type="hidden" class="qty-validasi-hidden" name="qty_validasi[]"
                                        value="{{ $detail->qty_validasi }}">
                                </td>
                                @if (!$show)
                                    <td>
                                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>


            <h5 class="mt-2">Files</h5>
            <div id="file-attc">
                <div class="table-responsive mt-0">
                    <table class="table table-striped table-hover table-bordered mt-2" id="tbl-file">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($received)
                                @foreach ($received->new_bac_terima->new_file_bac_terima as $detail)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control nama" type="text" name="nama[]" id="nama"
                                                    placeholder="Nama File" value="{{ $detail->nama }}" disabled />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="file[]" id="file"
                                                    placeholder="file File" value="{{ $detail->file }}" disabled />
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('bac-terima.download', $detail->file) }}"
                                                target="_blank" class="btn btn-primary btn-download ms-1">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- button save & cancel --}}
                @if (!$show)
                    <div class="d-flex justify-content-between" id="area-button">
                        <div id="validation" class="text-danger">
                            <h5 id="p-msg" class="mb-1"></h5>
                            <ul id="ul-msg">
                            </ul>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-success me-2" id="btn-save"
                                {{ !$received ? 'disabled' : '' }}>
                                @if (!$received)
                                    Simpan
                                @else
                                    Update
                                @endif
                            </button>

                            <a href="{{ route('received.index') }}" class="btn btn-secondary" id="btn-cancel"
                                {{ !$received ? 'disabled' : '' }}>Cancel</a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('bac-terima.index') }}" class="btn btn-secondary float-end">Back</a>
                @endif
            </div>

        </div>
    </div>
</div>
