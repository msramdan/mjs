@extends('layouts.master')
@section('title','Tambah Data Potongan' )

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('potongan_index') }}
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ trans('potongan.edit.daftar_potongan') }}</h4>
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
                        <form action="{{route('potongan.store')}}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label" for="category_potongan_id">Kategori Potongan</label>
                                <select class="form-select @error('category_potongan_id') is-invalid @enderror " id="category_potongan_id" name="category_potongan_id" >
                                    <option value="" disabled="" selected="">-- Pilih --</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->category_potongan_id }}" {{ old('category_potongan_id') && old('category_potongan_id') == $item->category_potongan_id ? 'selected' : $item->category_potongan_id }}>{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @error('category_potongan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="besar_potongan">Besar Potongan</label>
                                <input class="form-control @error('besar_potongan') is-invalid @enderror" type="number" id="besar_potongan"
                                    name="besar_potongan" autocomplete="off" placeholder="Besar Potongan" value="{{ old('besar_potongan') }}"
                                     />
                                @error('besar_potongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                <input class="form-control @error('karyawan_id') is-invalid @enderror" type="hidden" id="karyawan_id"
                                    name="karyawan_id" placeholder="Besar Potongan" value="{{$karyawan_id}}"
                                     />

                            <button type="reset" class="btn btn-secondary me-1">Reset</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ trans('potongan.edit.ditambahakan') }}</h4>
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
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="data-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Kategori Potongan</th>
                                        <th>Besar Potongan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="daftar_potongan"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

<script type="text/javascript">
    $(document).ready(function(){
      var karyawan_id = $("#karyawan_id").val();

      $.ajax({
             url:'{{url("payroll/potongan")}}' + '/' + karyawan_id,
             method:"GET",
             data:{},
             success:function(data){
              $('#daftar_potongan').html(data);
             }
            })
    });
  </script>
@endpush


