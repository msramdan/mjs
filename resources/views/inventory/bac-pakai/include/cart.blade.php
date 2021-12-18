<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">BAC Pakai</h4>
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
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label class="form-label" for="kode">Kode</label>
                    <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode" name="kode"
                        placeholder="Kode" value="{{ $bacPakai ? $bacPakai->kode : 'Loading...' }}" required
                        {{ $show ? 'disabled' : 'readonly' }} />
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-2">
                    <label class="form-label" for="tanggal">Tanggal</label>
                    <input class="form-control @error('tanggal') is-invalid @enderror" type="date" id="tanggal"
                        name="tanggal" placeholder="Tanggal"
                        value="{{ $bacPakai ? $bacPakai->tanggal->format('Y-m-d') : date('Y-m-d') }}" required
                        {{ $show ? 'disabled' : '' }} />
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                            @foreach ($consumable as $item)
                                <option value="{{ $item->id }}">{{ $item->kode . ' - ' . $item->nama }}
                                </option>
                            @endforeach
                            @error('produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="qty">Qty</label>
                        <input class="form-control  @error('qty') is-invalid @enderror" type="number" id="qty"
                            name="qty" placeholder="Qty" />
                        @error('qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endif

            <div class="col-md-{{ !$show ? '12' : '6' }}">
                <div class="form-group mb-2">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                        name="keterangan" placeholder="Keterangan" rows="5" required
                        {{ $show ? 'disabled' : '' }}>{{ $bacPakai ? $bacPakai->keterangan : '' }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between my-3">
            <div>
                <h5 class="pt-2">Items</h5>
            </div>

            @if (!$show)
                <div>
                    <button type="button" class="btn btn-info" id="btn-update" style="display: none;">
                        <i class="fas fa-save me-1"></i>
                        Update
                    </button>

                    <button type="button" class="btn btn-primary" id="btn-add">
                        <i class="fas fa-cart-plus me-1"></i>
                        Add
                    </button>
                </div>
            @endif
        </div>

        <div id="items">
            {{-- cart --}}
            <table class="table table-striped table-hover table-bordered mt-3" id="tbl-cart">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Kode - Nama</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        @if (!$show)
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($bacPakai)
                        @foreach ($bacPakai->detail_bac_pakai as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $detail->item->kode . ' - ' . $detail->item->nama }}
                                    <input type="hidden" class="produk-hidden" name="produk[]"
                                        value="{{ $detail->item_id }}">
                                </td>
                                <td>
                                    {{ $detail->item->unit->nama }}
                                    <input type="hidden" class="unit-hidden" name="unit[]"
                                        value="{{ $detail->item->unit->nama }}">
                                </td>
                                <td>
                                    {{ $detail->qty }}
                                    <input type="hidden" class="qty-hidden" name="qty[]"
                                        value="{{ $detail->qty }}">
                                </td>
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
        </div>

        <hr class="mt-5 mb-4">

        <div id="file-attc">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="pt-3">Attachment File</h5>
                </div>

                <div>
                    @if (!$show)
                        <button class="btn btn-primary" type="button" id="btn-add-file">
                            <i class="fas fa-file me-1"></i>
                            Add
                        </button>
                    @endif
                </div>
            </div>

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
                        @if ($bacPakai)
                            @foreach ($bacPakai->file_bac_pakai as $detail)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input class="form-control @error('nama') is-invalid @enderror nama"
                                                type="text" name="nama[]" id="nama" placeholder="Nama File"
                                                value="{{ $detail->nama }}" required
                                                {{ $show ? 'disabled' : '' }} />
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        @if (!$show)
                                            <div class="form-group">
                                                <input class="form-control @error('file') is-invalid @enderror file"
                                                    type="file" name="file[]" id="file" />
                                                @error('file')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="file[]" id="file"
                                                    placeholder="file File" value="{{ $detail->file }}" disabled />
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$show)
                                            <button
                                                class="btn btn-danger btn-delete-file{{ $loop->iteration == 1 ? ' disabled' : '' }}"
                                                type="button" {{ $loop->iteration == 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif

                                        <a href="{{ route('bac-pakai.download', $detail->file) }}" target="_blank"
                                            class="btn btn-primary btn-download ms-1">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control @error('nama') is-invalid @enderror nama" type="text"
                                            name="nama[]" id="nama" placeholder="Nama File" required />
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control @error('file') is-invalid @enderror file" type="file"
                                            name="file[]" id="file" required />
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-danger disabled btn-delete-file" type="button" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- button save & cancel --}}
            @if (!$show)
                <div class="d-flex justify-content-between" id="area-button">
                    <div>
                        <small class="fw-bold">Note: file hanya boleh jpg/png/jpeg/doc/docx/pdf, dan size max
                            1MB.</small>
                    </div>

                    <div class="form-group">
                        {{-- <label class="form-label" for="button">Button</label>
                    <br> --}}

                        <button type="submit" class="btn btn-success" id="btn-save"
                            {{ !$bacPakai ? 'disabled' : '' }}>
                            @if (!$bacPakai)
                                Simpan
                            @else
                                Update
                            @endif
                        </button>

                        <a href="{{ route('bac-pakai.index') }}" class="btn btn-secondary" id="btn-cancel"
                            {{ !$bacPakai ? 'disabled' : '' }}>Cancel</a>
                    </div>
                </div>
            @else
                <a href="{{ route('bac-pakai.index') }}" class="btn btn-secondary float-end">Back</a>
            @endif
        </div>

        <div id="validation" class="text-danger">
            <h5 id="p-msg" class="mb-1"></h5>
            <ul id="ul-msg"></ul>
        </div>
    </div>
</div>
