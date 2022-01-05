@extends('layouts.master')
@section('title', 'Edit Category Request')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('category_request_edit') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Category Request</h4>
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
                <form action="{{ route('category-request.update', $categoryRequest->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input class="form-control @error('kode') is-invalid @enderror" type="text" id="kode"
                                    name="kode" placeholder="Kode"
                                    value="{{ old('kode') ? old('kode') : $categoryRequest->kode }}" required autofocus />
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama"
                                    name="nama" placeholder="Nama"
                                    value="{{ old('nama') ? old('nama') : $categoryRequest->nama }}" required autofocus />
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="mt-4">
                    <input type="hidden" name="index_tr" id="index-tr">
                    <input type="hidden" id="step">


                    <div class="row mb-4">
                        <div class="col-md-4">
                            {{-- <h5 class="mt-2">Setting Category Request</h5> --}}

                            <div class="form-group">
                                <label for="user">User</label>
                                <select name="user" id="user" class="form-select">
                                    <option value="" disabled selected>-- Pilih --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="btn-add"></label>
                                <button type="button" class="btn btn-primary form-control" id="btn-add">
                                    <i class="fas fa-plus"></i> Add
                                </button>

                                <button type="button" class="btn btn-info form-control" id="btn-update"
                                    style="display: none;">
                                    <i class="fas fa-save"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table table-striped table-hover table-bordered table-sm" id="tbl-item">
                            <thead>
                                <tr>
                                    <th width="80">Step</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($categoryRequest->setting_category_requests as $scr)
                                    <tr>
                                        <td>
                                            {{ $scr->step }}
                                            <input type="hidden" name="step[]" class="step"
                                                value="{{ $scr->step }}">
                                        </td>
                                        <td>
                                            {{ $scr->user->name }}
                                            <input type="hidden" name="user[]" class="user"
                                                value="{{ $scr->user_id }}">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-xs me-1 btn-edit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" class="btn btn-danger btn-xs  btn-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="reset" class="btn btn-secondary me-1">Reset</button>
                    <button type="submit" class="btn btn-success" id="btn-save">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        const btnAdd = $('#btn-add')
        const user = $('#user')
        const step = $('#step')

        const btnUpdate = $('#btn-update')
        const btnSave = $('#btn-save')

        const tblItem = $('#tbl-item')

        btnAdd.click(function() {
            if (!user.val()) {
                user.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'User tidak boleh kosong'
                })
            } else {
                // cek duplikasi user
                $('input[name="user[]"]').each(function() {
                    // cari index tr ke berapa
                    let index = $(this).parent().parent().index()

                    if ($(this).val() == user.val()) {
                        // hapus tr berdasarkan index
                        tblItem.find('tbody tr:eq(' + index + ')').remove()

                        generateNo()
                    }
                })

                let step = tblItem.find('tbody tr').length + 1

                tblItem.find('tbody').append(`
                    <tr>
                        <td>
                            ${step}
                            <input type="hidden" name="step[]" class="step" value="${step}">
                        </td>
                        <td>
                            ${user.find('option:selected').text()}
                            <input type="hidden" name="user[]" class="user" value="${user.val()}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-xs me-1 btn-edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button type="button" class="btn btn-danger btn-xs  btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `)

                user.val('')
                user.focus()

                cekTableLength()
            }
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            btnAdd.hide()

            btnUpdate.show()

            user.val($('.user:eq(' + index + ')').val())
            step.val($('.step:eq(' + index + ')').val())

            $('#index-tr').val(index)
        })

        $(document).on('click', '.btn-delete', function(e) {
            $(this).parent().parent().remove()

            generateNo()
            cekTableLength()
        })

        function cekTableLength() {
            let cek = tblItem.find('tbody tr').length

            if (cek > 0) {
                btnSave.prop('disabled', false)
                btnCancel.prop('disabled', false)
            } else {
                btnSave.prop('disabled', true)
                btnCancel.prop('disabled', true)
            }
        }

        function generateNo() {
            let no = 1

            tblItem.find('tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        btnUpdate.click(function() {
            let index = $('#index-tr').val()

            if (!user.val()) {
                user.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'User tidak boleh kosong'
                })

            } else {
                // cek duplikasi pas update
                $('input[name="user[]"]').each(function(i) {
                    // i = index each
                    if ($(this).val() == user.val() && i != index) {
                        tblItem.find('tbody tr:eq(' + i + ')').remove()
                    }
                })

                $('#tbl-item tbody tr:eq(' + index + ')').html(`
                <td>
                    ${parseInt(index) + 1}
                    <input type="hidden" name="step[]" class="step" value="${parseInt(index) + 1}">
                </td>
                <td>
                    ${user.find('option:selected').text()}
                    <input type="hidden" name="user[]" class="user" value="${user.val()}">
                </td>
                <td>
                    <button type="button" class="btn btn-warning btn-xs me-1 btn-edit">
                        <i class="fas fa-edit"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-xs  btn-delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
                `)

                btnUpdate.hide()
                btnAdd.show()

                $('#index-tr').val('')
                $('#step').val('')

                user.val('')
            }
        })
    </script>
@endpush
