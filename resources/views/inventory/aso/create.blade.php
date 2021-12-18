@extends('layouts.master')
@section('title', 'Create ASO')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('aso_create') }}

        <form action="{{ route('aso.store') }}" method="POST" id="form-aso">
            @csrf
            @method('POST')
            <div class="row">
                @include('inventory.aso.include.bac-info')

                @include('inventory.aso.include.cart')
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        const bacPakai = $('#bac-pakai')
        const kodeBac = $('#kode')
        const tglBac = $('#tanggal-bac')
        const user = $('#user')
        const keterangan = $('#keterangan')

        const tanggal = $('#tanggal')
        const attn = $('#attn')

        const supplier = $('#supplier')

        const produk = $('#produk')
        const kodeProduk = $('#kode-produk')
        const unitProduk = $('#unit-produk')
        // const stok = $('#stok')
        const qtyValidasi = $('#qty-validasi')
        const qty = $('#qty')
        const diskon = $('#diskon')
        const catatan = $('#catatan')
        const total = $('#total')
        const grandTotal = $('#grand-total')

        // const btnAdd = $('#btn-add')
        const btnUpdate = $('#btn-update')
        const btnSave = $('#btn-save')
        const btnCancel = $('#btn-cancel')

        const tblCart = $('#tbl-cart')
        const tblFile = $('#tbl-file')

        bacPakai.change(function() {
            user.val('Loading...')
            kodeBac.text('Loading...')
            user.text('Loading...')
            tglBac.text('Loading...')
            keterangan.text('Loading...')

            tblCart.find('tbody').html(`
            <tr>
                <td colspan="6" class="text-center">Loading...</td>
            </tr>
            `)

            tblFile.find('tbody').html(`
            <tr>
                <td colspan="6" class="text-center">Loading...</td>
            </tr>
            `)

            $.ajax({
                url: '/inventory/bac-pakai/get-bac-pakai-by-id/' + $(this).val(),
                method: 'get',
                success: function(res) {
                    setTimeout(() => {
                        kodeBac.text(res.kode)
                        user.text(res.user.name)
                        keterangan.text(res.keterangan.slice(0, 200) + '...')

                        let dateString = res.tanggal
                        let dateObject = new Date(dateString)
                        tglBac.text(dateObject.toJSON().slice(0, 10).split('-').reverse()
                            .join('/'))

                        let noCart = 1
                        let items = []

                        let noFile = 1
                        let files = []

                        $.each(res.detail_bac_pakai, function(index, value) {
                            items.push(`
                            <tr>
                                <td>${noCart++}</td>
                                <td>
                                    ${value.item.kode +' - '+ value.item.nama}
                                    <input type="hidden" class="produk-hidden" name="produk[]"
                                        value="${value.item.kode +' - '+ value.item.nama}">
                                </td>
                                <td>
                                    ${value.item.unit.nama}
                                    <input type="hidden" class="unit-hidden" value="${value.item.unit.nama}">
                                </td>
                                <td>
                                    ${value.qty}
                                    <input type="hidden" class="qty-hidden" name="qty[]" value="${value.qty}">
                                </td>
                                <td>
                                    0
                                    <input type="hidden" class="qty-validasi-hidden" name="qty_validasi[]" value="0">
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            `)
                        })

                        $.each(res.file_bac_pakai, function(index, value) {
                            files.push(`
                            <tr>
                                <td>
                                    <div class="form-group">
                                    <input class="form-control nama" type="text" name="nama[]" id="nama" placeholder="Nama File" value="${value.nama}" disabled />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control file" type="text" name="file[]" id="file" value="${value.file}" disabled />
                                    </div>
                                </td>
                                <td>
                                    <a href="/inventory/bac-pakai/download/${value.file}"
                                    target="_blank" class="btn btn-primary btn-download ms-1">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                            `)
                        })

                        tblCart.find('tbody').html(items)
                        tblFile.find('tbody').html(files)

                        btnSave.prop('disabled', false)
                        btnSave.removeClass('disabled')
                    }, 500)
                },
            })
        })

        btnUpdate.click(function() {
            let index = $('#index-tr').val()

            if (!bacPakai.val()) {
                bacPakai.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Request Form tidak boleh kosong'
                })

            } else if (!tanggal.val()) {
                tanggal.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal tidak boleh kosong'
                })

            } else {
                $('#tbl-cart tbody tr:eq(' + index + ')').html(`
                    <td></td>
                    <td>
                        ${produk.val()}
                        <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                    </td>
                    <td>
                        ${unitProduk.val()}
                        <input type="hidden" class="unit-hidden" value="${unitProduk.val()}">
                    </td>
                    <td>
                        ${qty.val()}
                        <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                    </td>
                    <td>
                        ${qtyValidasi.val()}
                        <input type="hidden" class="qty-validasi-hidden" name="qty_validasi[]" value="${qtyValidasi.val()}">
                    </td>
                    <td>
                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                `)

                clearForm()
                generateNo()

                btnUpdate.prop('disabled', true)
                btnUpdate.addClass('disabled')
            }
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            btnUpdate.show()

            produk.val($('.produk-hidden:eq(' + index + ')').val())
            qty.val($('.qty-hidden:eq(' + index + ')').val())
            qtyValidasi.val($('.qty-validasi-hidden:eq(' + index + ')').val())
            unitProduk.val($('.unit-hidden:eq(' + index + ')').val())

            $('#index-tr').val(index)

            btnUpdate.prop('disabled', false)
            btnUpdate.removeClass('disabled')
        })

        $('#form-aso').submit(function(e) {
            e.preventDefault()
            btnSave.prop('disabled', true)
            btnSave.text('loading...')

            btnCancel.prop('disabled', true)
            btnCancel.text('loading...')

            $.ajax({
                type: 'POST',
                url: '{{ route('aso.store') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    bac_pakai: bacPakai.val(),
                    tanggal: tanggal.val(),
                    qty_validasi: $('input[name="qty_validasi[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                },
                success: function(res) {
                    console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Simpan data',
                        text: 'Berhasil'
                    }).then(function() {
                        window.location = '{{ route('aso.index') }}'
                    })
                },
                error: function(xhr) {
                    btnSave.prop('disabled', false)
                    btnSave.removeClass('disabled')
                    btnSave.text('Simpan')

                    btnCancel.prop('disabled', false)
                    btnCancel.removeClass('disabled')
                    btnCancel.text('Cancel')

                    $('#p-msg').text(xhr.responseJSON.message)

                    let errorMsg = []
                    $.each(xhr.responseJSON.errors, function(index, value) {
                        errorMsg.push(`<li><p class="mb-0">${value}</p></li>`)
                    })

                    $('#ul-msg').html(errorMsg)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        })

        // function cekTableLength() {
        //     let cek = tblCart.find('tbody tr').length

        //     if (cek > 0) {
        //         btnSave.prop('disabled', false)
        //         btnCancel.prop('disabled', false)
        //     } else {
        //         btnSave.prop('disabled', true)
        //         btnCancel.prop('disabled', true)
        //     }
        // }

        function clearForm() {
            kodeProduk.val('')
            produk.val('')
            unitProduk.val('')
            qtyValidasi.val('')
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
@endpush
