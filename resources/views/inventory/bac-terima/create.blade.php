@extends('layouts.master')
@section('title', 'Create BAC Terima')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('bac_terima_create') }}

        <form action="{{ route('bac-terima.store') }}" method="POST" id="form-bac" enctype="multipart/form-data">
            @include('inventory.bac-terima.include.cart')
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- items --}}
    <script>
        const kode = $('#kode')
        const tanggal = $('#tanggal')

        const produk = $('#produk')
        const kodeProduk = $('#kode-produk')
        const unitProduk = $('#unit-produk')
        const qty = $('#qty')
        const keterangan = $('#keterangan')

        const btnAdd = $('#btn-add')
        const btnUpdate = $('#btn-update')
        const btnSave = $('#btn-save')
        const btnCancel = $('#btn-cancel')

        const tblCart = $('#tbl-cart')

        produk.change(function() {
            if (!kode.val()) {
                kode.focus()
                produk.val('')

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Kode tidak boleh kosong'
                })

            } else if (!tanggal.val()) {
                tanggal.focus()
                produk.val('')

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal tidak boleh kosong'
                })

            } else {
                qty.prop('type', 'text')
                qty.prop('disabled', true)
                qty.val('Loading...')

                $.ajax({
                    url: '/inventory/item/get-item-by-id/' + $(this).val(),
                    method: 'get',
                    success: function(res) {
                        kodeProduk.val(res.kode)
                        unitProduk.val(res.unit.nama)

                        setTimeout(() => {
                            qty.prop('type', 'number')
                            qty.prop('disabled', false)
                            qty.val('')
                            qty.focus()
                        }, 500)
                    }
                })
            }
        })

        btnAdd.click(function() {
            if (!kode.val()) {
                kode.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'kode tidak boleh kosong'
                })

            } else if (!tanggal.val()) {
                tanggal.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal tidak boleh kosong'
                })

            } else if (!keterangan.val()) {
                keterangan.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Keterangan tidak boleh kosong'
                })

            } else if (!produk.val() || !qty.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data produk & qty tidak boleh kosong'
                })

            } else {

                // cek duplikasi produk
                $('input[name="produk[]"]').each(function() {
                    // cari index tr ke berapa
                    let index = $(this).parent().parent().index()

                    if ($(this).val() == produk.val()) {
                        // hapus tr berdasarkan index
                        tblCart.find('tbody tr:eq(' + index + ')').remove()

                        generateNo()
                    }
                })

                tblCart.find('tbody').append(`
                    <tr>
                        <td>${tblCart.find('tbody tr').length + 1}</td>
                        <td>
                            ${produk.find('option:selected').text()}
                            <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                        </td>
                        <td>
                            ${unitProduk.val()}
                            <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                        </td>
                        <td>
                            ${qty.val()}
                            <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
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

                generateNo()
                clearForm()
                cekTableLength()

                produk.focus()
            }
        })

        btnUpdate.click(function() {
            let index = $('#index-tr').val()

            if (!kode.val()) {
                kode.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'kode tidak boleh kosong'
                })

            } else if (!tanggal.val()) {
                tanggal.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal tidak boleh kosong'
                })

            } else if (!keterangan.val()) {
                keterangan.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Keterangan tidak boleh kosong'
                })

            } else if (!produk.val() || !qty.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data produk & qty tidak boleh kosong'
                })

            } else {
                // cek duplikasi pas update
                $('input[name="produk[]"]').each(function(i) {
                    // i = index each
                    if ($(this).val() == produk.val() && i != index) {
                        tblCart.find('tbody tr:eq(' + i + ')').remove()
                    }
                })

                $('#tbl-cart tbody tr:eq(' + index + ')').html(`
                    <td></td>
                    <td>
                        ${produk.find('option:selected').text()}
                        <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                    </td>
                    <td>
                        ${unitProduk.val()}
                        <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                    </td>
                    <td>
                        ${qty.val()}
                        <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
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

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            btnAdd.hide()

            btnUpdate.show()

            produk.val($('.produk-hidden:eq(' + index + ')').val())
            qty.val($('.qty-hidden:eq(' + index + ')').val())
            unitProduk.val($('.unit-hidden:eq(' + index + ')').val())

            $('#index-tr').val(index)
        })

        $(document).on('click', '.btn-delete', function(e) {
            $(this).parent().parent().remove()

            generateNo()
            cekTableLength()
        })

        $('#form-bac').submit(function(e) {
            e.preventDefault()
            btnSave.prop('disabled', true)
            btnSave.text('loading...')

            btnCancel.prop('disabled', true)
            btnCancel.text('loading...')

            $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                url: '{{ route('bac-terima.store') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: new FormData(this),
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Simpan data',
                        text: 'Berhasil'
                    }).then(function() {
                        window.location = '{{ route('bac-terima.index') }}'
                    })
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        })

        $('#kode, #tanggal, #keterangan, #produk, #qty, #nama, #file').on('change keyup', function() {
            cekForm()
            // cekTableLength()
        })

        $('#area-button').on('mouseover mouseenter mouseleave mousemove', function() {
            cekForm()
            // cekTableLength()
        })

        function cekForm() {
            if (!$('#nama').val() ||
                !$('#file').val() ||
                !$('#kode').val() ||
                !$('#tanggal').val() ||
                !$('#keterangan').val()
            ) {
                disableButton()
            } else {
                enableButton()
            }
        }

        function cekTableLength() {
            let cekTblCart = tblCart.find('tbody tr').length
            let cekTblFile = $('#tbl-file tbody tr').length

            if (cekTblCart > 0 || cekTblFile > 0) {
                enableButton()
            } else {
                disableButton()
            }
        }

        function disableButton() {
            btnSave.prop('disabled', true)
            btnCancel.prop('disabled', true)
        }

        function enableButton() {
            btnSave.prop('disabled', false)
            btnCancel.prop('disabled', false)
        }

        function clearForm() {
            kodeProduk.val('')
            produk.val('')
            unitProduk.val('')
            qty.val('')
        }

        function generateNo() {
            let no = 1

            tblCart.find('tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }
    </script>

    {{-- file --}}
    <script>
        const tableFile = $('#tbl-file tbody')

        $('#btn-add-file').click(function() {
            let tr = ` <tr>
                <td>
                    <div class="form-group">
                    <input class="form-control nama" type="text" name="nama[]" placeholder="Nama File" required />
                    </div>
                </td>
                <td>
                    <div class="form-group">
                    <input class="form-control file" type="file" name="file[]" required />
                    </div>
                </td>
                <td>
                    <button class="btn btn-danger btn-delete-file" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>`

            tableFile.append(tr)
        })

        $(document).on('click', '.btn-delete-file', function() {
            if (tableFile.find('tr').length > 1) {
                $(this).parent().parent().remove()
            }
        })
    </script>
@endpush
