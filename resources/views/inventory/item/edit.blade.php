@extends('layouts.master')
@section('title', 'Edit Item')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('item_edit') }}

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
                <form action="{{ route('item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode" value="{{ old('kode') ? old('kode') : $item->kode }}"
                                    required autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama" value="{{ old('nama') ? old('nama') : $item->nama }}"
                                    required />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                    name="deskripsi" placeholder="Deskripsi" rows="9"
                                    required>{{ old('deskripsi') ? old('deskripsi') : $item->deskripsi }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="category">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category"
                                    name="category" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($category as $ctg)
                                        <option value="{{ $ctg->id }}"
                                            {{ $item->category_id == $ctg->id ? 'selected' : '' }}>{{ $ctg->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="unit">Unit</label>
                                <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit"
                                    required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($unit as $ut)
                                        <option value="{{ $ut->id }}"
                                            {{ $item->unit_id == $ut->id ? 'selected' : '' }}>{{ $ut->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="akun_coa">Akun COA</label>
                                <select class="form-select @error('akun_coa') is-invalid @enderror" id="akun_coa"
                                    name="akun_coa" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($akunCoa as $coa)
                                        <option value="{{ $coa->id }}"
                                            {{ $item->akun_coa_id == $coa->id ? 'selected' : '' }}>{{ $coa->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('akun_coa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ asset('storage/img/item/' . $item->foto) }}" alt="Foto item"
                                        class="img-fluid rounded"
                                        style="width: 150px; height: 120px; object-fit: cover; border-radius: 3px;">
                                </div>

                                <div class="col-md-8">
                                    <label class="mb-2">Type</label>
                                    <br>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="type" id="consumable"
                                            value="Consumable" {{ $item->type == 'Consumable' ? 'checked' : '' }} />
                                        <label class="form-check-label" for="consumable">Consumable</label>
                                    </div>
                                    <div class="form-check form-check-inline mb-3">
                                        <input class="form-check-input" type="radio" name="type" id="services"
                                            value="Services" {{ $item->type == 'Services' ? 'checked' : '' }} />
                                        <label class="form-check-label" for="services">Services</label>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label" for="foto">Foto <small>(biarkan kosong jika tidak
                                                ingin
                                                diganti)</small></label>
                                        <input class="form-control @error('foto') is-invalid @enderror" type="file"
                                            id="foto" name="foto" placeholder="Foto" />
                                        @error('foto')
                                            <div class=" invalid-feedback">{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="reset" class="btn btn-secondary me-1">Reset</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        const kode = $('#kode')

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
