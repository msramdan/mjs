@extends('layouts.master')
@section('title', 'Create Item')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('item_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Item</h4>
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
                <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode" value="{{ old('kode') }}" required autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama" value="{{ old('nama') }}" required />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="harga_estimasi">Harga Estimasi</label>
                                    <input class="form-control @error('harga_estimasi') is-invalid @enderror" type="number"
                                        id="harga_estimasi" name="harga_estimasi" placeholder="Harga Estimasi"
                                        value="{{ old('harga_estimasi') }}" />
                                    @error('harga_estimasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="soh">SOH</label>
                                    <input class="form-control @error('soh') is-invalid @enderror" type="number" id="soh"
                                        name="soh" placeholder="SOH" value="{{ old('soh') ? old('soh') : 0 }}" readonly />
                                    @error('soh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="category">Category</label>
                                        <select class="form-select @error('category') is-invalid @enderror" id="category"
                                            name="category" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($category as $each)
                                                <option value="{{ $each->id }}">{{ $each->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="unit">Unit</label>
                                        <select class="form-select @error('unit') is-invalid @enderror" id="unit"
                                            name="unit" required>
                                            <option value="" disabled selected>-- Pilih --</option>
                                            @foreach ($unit as $each)
                                                <option value="{{ $each->id }}">{{ $each->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group mb-3">
                                <label class="form-label" for="akun_coa">Akun COA</label>
                                <select class="form-select @error('akun_coa') is-invalid @enderror" id="akun_coa"
                                    name="akun_coa" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($akunCoa as $each)
                                        <option value="{{ $each->id }}">{{ $each->nama }}</option>
                                    @endforeach
                                </select>
                                @error('akun_coa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <label class="mb-2">Type</label>
                            <br>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" name="type" id="consumable" value="Consumable"
                                    required />
                                <label class="form-check-label" for="consumable">Consumable</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" name="type" id="services" value="Services"
                                    required />
                                <label class="form-check-label" for="services">Services</label>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="foto">Foto</label>
                                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto"
                                    name="foto" placeholder="Foto" required />
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                    name="deskripsi" placeholder="Deskripsi" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                <label class="form-label" for="supplier">Supplier</label>
                                <select class="form-select @error('supplier') is-invalid @enderror" id="supplier"
                                    name="supplier">
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($supplier as $each)
                                        <option value="{{ $each->id }}">{{ $each->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label" for="harga-beli">Harga Beli</label>
                                <input class="form-control @error('harga_beli') is-invalid @enderror" type="number"
                                    id="harga-beli" name="harga_beli" placeholder="Harga Beli" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label class="form-label" for="btn-add"></label>
                                <button class="btn btn-primary form-control" type="button" id="btn-add">
                                    <i class="fas fa-plus me-1"></i> Add
                                </button>

                                <button class="btn btn-info form-control" type="button" id="btn-update"
                                    style="display: none;">
                                    <i class="fas fa-plus me-1"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="index_tr" id="index-tr">

                    <h5>Detail Item</h5>

                    <table class="table table-hover table-striped table-bordered" id="tbl-detail-item">
                        <thead>
                            <tr>
                                <th width="40">#</th>
                                <th>Supplier</th>
                                <th>Harga Beli</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <button type="reset" class="btn btn-secondary me-1" id="btn-reset">Reset</button>
                    <button type="submit" class="btn btn-success" id="btn-save">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        const kode = $('#kode')

        const supplier = $('#supplier')
        const hargaBeli = $('#harga-beli')
        const tblDetailItem = $('#tbl-detail-item')

        const btnAdd = $('#btn-add')
        const btnSave = $('#btn-save')
        const btnUpdate = $('#btn-update')
        const btnReset = $('#btn-reset')

        const indexTr = $('#index-tr')

        getKode()

        btnAdd.click(function() {
            if (!supplier.val()) {
                supplier.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Supplier tidak boleh kosong'
                })
            } else if (!hargaBeli.val()) {
                hargaBeli.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'harga beli tidak boleh kosong'
                })
            } else if (hargaBeli.val() < 1) {
                hargaBeli.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'harga beli minimal 1 tidak boleh kosong'
                })
            } else {
                // cek duplikasi supplier
                $('input[name="supplier[]"]').each(function() {
                    // cari index tr ke berapa
                    let index = $(this).parent().parent().index()

                    if ($(this).val() == supplier.val()) {
                        // hapus tr berdasarkan index
                        tblDetailItem.find('tbody tr:eq(' + index + ')').remove()

                        generateNo()
                    }
                })

                tblDetailItem.find('tbody').append(`
                    <tr>
                        <td>${tblDetailItem.find('tbody tr').length + 1}</td>
                        <td>
                            ${supplier.find('option:selected').text()}
                            <input type="hidden" class="supplier-hidden" name="supplier[]" value="${supplier.val()}">
                        </td>
                        <td>
                            ${formatRibuan(hargaBeli.val())}
                            <input type="hidden" class="harga-beli-hidden" name="harga_beli[]" value="${hargaBeli.val()}">
                        </td>
                        <td>
                            <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-danger btn-xs btn-delete" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                `)

                clearForm()

                supplier.focus()
            }
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            supplier.val($('.supplier-hidden:eq(' + index + ')').val())
            hargaBeli.val($('.harga-beli-hidden:eq(' + index + ')').val())

            indexTr.val(index)

            btnAdd.hide()
            btnUpdate.show()
        })

        btnUpdate.click(function() {
            let index = indexTr.val()

            if (!supplier.val()) {
                supplier.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Supplier tidak boleh kosong'
                })
            } else if (!hargaBeli.val()) {
                hargaBeli.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'harga beli tidak boleh kosong'
                })
            } else if (hargaBeli.val() < 1) {
                hargaBeli.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'harga beli minimal 1 tidak boleh kosong'
                })
            } else {
                // cek duplikasi pas update
                $('input[name="supplier[]"]').each(function(i) {
                    // i = index each
                    if ($(this).val() == supplier.val() && i != index) {
                        tblDetailItem.find('tbody tr:eq(' + i + ')').remove()
                    }
                })

                $('#tbl-detail-item tbody tr:eq(' + index + ')').html(`
                    <td></td>
                    <td>
                        ${supplier.find('option:selected').text()}
                        <input type="hidden" class="supplier-hidden" name="supplier[]" value="${supplier.val()}">
                    </td>
                    <td>
                        ${formatRibuan(hargaBeli.val())}
                        <input type="hidden" class="harga-beli-hidden" name="harga_beli[]" value="${hargaBeli.val()}">
                    </td>
                    <td>
                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                            <i class="fas fa-edit"></i>
                        </button>

                        <button class="btn btn-danger btn-xs btn-delete" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                `)

                clearForm()
                generateNo()

                btnUpdate.hide()
                btnAdd.show()
            }
        })

        $(document).on('click', '.btn-delete', function(e) {
            $(this).parent().parent().remove()

            generateNo()
            cekTableLength()
        })

        function cekTableLength() {
            let cek = tblDetailItem.find('tbody tr').length

            if (cek > 0) {
                btnSave.prop('disabled', false)
                btnReset.prop('disabled', false)
            } else {
                btnSave.prop('disabled', true)
                btnReset.prop('disabled', true)
            }
        }

        function clearForm() {
            supplier.val('')
            hargaBeli.val('')
        }

        function formatRibuan(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function generateNo() {
            let no = 1

            tblDetailItem.find('tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        function getKode() {
            kode.prop('disabled', true)
            kode.val('Loading...')

            $.ajax({
                url: '/inventory/item/generate-kode/',
                method: 'GET',
                success: function(res) {
                    setTimeout(() => {
                        kode.val(res.kode)
                        kode.prop('disabled', false)
                    }, 500)
                }
            })
        }
    </script>
@endpush
