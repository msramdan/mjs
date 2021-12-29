@extends('layouts.master')
@section('title', 'Edit BAC Terima')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('bac_terima_edit') }}

        <form action="{{ route('bac-terima.update', $bacTerima->id) }}" method="POST" id="form-bac"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-3">
                    @include('inventory.bac-terima.include.purchase-info')
                </div>

                <div class="col-md-9">
                    @include('inventory.bac-terima.include.cart')
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- items --}}
    <script>
        const kode = $('#kode')
        const tanggal = $('#tanggal')

        const purchase = $('#purchase')
        const requestForm = $('#request-form')
        const tglPurchase = $('#tanggal-purchase')
        const catatanPurchase = $('#catatan-purchase')
        const totalPurchase = $('#total-purchase')
        const diskonPurchase = $('#diskon-purchase')
        const grandTotalPurchase = $('#grand-total-purchase')
        const supplier = $('#supplier')

        const subtotal = $('#subtotal')
        const harga = $('#harga')
        const qty = $('#qty')

        const produk = $('#produk')
        const produkId = $('#produk-id')
        const kodeProduk = $('#kode-produk')
        const unitProduk = $('#unit-produk')
        const qtyTerima = $('#qty-terima')
        const keterangan = $('#keterangan')

        const btnAdd = $('#btn-add')
        const btnUpdate = $('#btn-update')
        const btnSave = $('#btn-save')
        const btnCancel = $('#btn-cancel')

        const tblCart = $('#tbl-cart')

        getKode()

        purchase.change(function() {
            requestForm.text('Loading...')
            supplier.text('Loading...')
            catatanPurchase.text('Loading...')
            tglPurchase.text('Loading...')
            totalPurchase.text('Loading...')
            diskonPurchase.text('Loading...')
            grandTotalPurchase.text('Loading...')

            tblCart.find('tbody').html(`
                <tr>
                    <td colspan="9" class="text-center">Loading...</td>
                </tr>
            `)

            $.ajax({
                url: `/purchase/get-purchase-by-id/${purchase.val()}`,
                method: 'GET',
                success: function(res) {
                    setTimeout(() => {
                        requestForm.text(res.request_form.kode)
                        supplier.text(res.supplier.nama)
                        catatanPurchase.text(res.catatan ? res.catatan : '-')
                        totalPurchase.text(res.total)
                        diskonPurchase.text(res.diskon)
                        grandTotalPurchase.text(res.grand_total)

                        let dateString = res.tanggal
                        let dateObject = new Date(dateString)
                        tglPurchase.text(dateObject.toJSON()
                            .slice(0, 10)
                            .split('-')
                            .reverse()
                            .join('/'))

                        let detailPurchase = []

                        $.each(res.detail_purchase, function(index, value) {
                            detailPurchase.push(`
                                <tr>
                                    <td>${index = index + 1}</td>
                                    <td>
                                        ${value.item.kode +' - '+ value.item.nama}
                                        <input type="hidden" class="produk-hidden" name="produk[]" value="${value.item.kode +' - '+ value.item.nama}">
                                        <input type="hidden" class="produk-id-hidden" name="produk_id[]" value="${value.item_id}">
                                    </td>
                                    <td>
                                        ${value.item.unit.nama}
                                        <input type="hidden" class="unit-hidden" name="unit[]" value=" ${value.item.unit.nama}">
                                    </td>
                                    <td>
                                        ${formatRibuan(value.harga)}
                                        <input type="hidden" class="harga-hidden" name="harga[]" value="${value.harga}">
                                    </td>
                                    <td>
                                        ${value.qty}
                                        <input type="hidden" class="qty-hidden" name="qty[]" value="${value.qty}">
                                    </td>
                                    <td>
                                        ${formatRibuan(value.sub_total)}
                                        <input type="hidden" class="subtotal-hidden" name="sub_total[]" value="${value.sub_total}">
                                    </td>
                                    <td>
                                        0
                                        <input type="hidden" class="qty-terima-hidden" name="qty_terima[]" value="0">
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            `)
                        })

                        tblCart.find('tbody').html(detailPurchase)
                    }, 500);
                }
            })
        })

        tanggal.change(function() {
            kode.val('Loading...')

            getKode()
        })

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
                qtyTerima.prop('type', 'text')
                qtyTerima.prop('disabled', true)
                qtyTerima.val('Loading...')

                $.ajax({
                    url: '/inventory/item/get-item-by-id/' + $(this).val(),
                    method: 'GET',
                    success: function(res) {
                        kodeProduk.val(res.kode)
                        unitProduk.val(res.unit.nama)

                        setTimeout(() => {
                            qtyTerima.prop('type', 'number')
                            qtyTerima.prop('disabled', false)
                            qtyTerima.val('')
                            qtyTerima.focus()
                        }, 500)
                    }
                })
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

            } else if (!produk.val() || !qtyTerima.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data produk & qty tidak boleh kosong'
                })

            } else {

                $('#tbl-cart tbody tr:eq(' + index + ')').html(`
                    <td></td>
                    <td>
                        ${produk.val()}
                        <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                        <input type="hidden" class="produk-id-hidden" name="produk_id[]" value="${produkId.val()}">
                    </td>
                    <td>
                        ${unitProduk.val()}
                        <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                    </td>
                    <td>
                        ${formatRibuan(harga.val())}
                        <input type="hidden" class="harga-hidden" name="harga[]" value="${harga.val()}">
                    </td>
                    <td>
                        ${qty.val()}
                        <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                    </td>
                    <td>
                        ${formatRibuan(subtotal.val())}
                        <input type="hidden" class="subtotal-hidden" name="sub_total[]" value="${subtotal.val()}">
                    </td>
                    <td>
                        ${qtyTerima.val()}
                        <input type="hidden" class="qty-terima-hidden" name="qty_terima[]" value="${qtyTerima.val()}">
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
            }
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            btnAdd.hide()

            btnUpdate.show()

            produk.val($('.produk-hidden:eq(' + index + ')').val())
            produkId.val($('.produk-id-hidden:eq(' + index + ')').val())
            subtotal.val($('.subtotal-hidden:eq(' + index + ')').val())
            harga.val($('.harga-hidden:eq(' + index + ')').val())
            qty.val($('.qty-hidden:eq(' + index + ')').val())
            qtyTerima.val($('.qty-terima-hidden:eq(' + index + ')').val())
            unitProduk.val($('.unit-hidden:eq(' + index + ')').val())

            $('#index-tr').val(index)

            btnUpdate.prop('disabled', false)
            qtyTerima.focus()
        })

        $('#form-bac').submit(function(e) {
            e.preventDefault()

            btnSave.prop('disabled', true)
            btnSave.addClass('disabled')
            btnSave.text('loading...')

            btnCancel.prop('disabled', true)
            btnCancel.addClass('disabled')
            btnCancel.text('loading...')

            let BAC = new FormData(this)
            BAC.append('_method', 'PUT')

            $.ajax({
                type: 'POST',
                processData: false,
                contentType: false,
                url: '{{ route('bac-terima.update', $bacTerima->id) }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: BAC,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update data',
                        text: 'Berhasil'
                    }).then(function() {
                        window.location = '{{ route('bac-terima.index') }}'
                    })
                },
                error: function(xhr) {
                    btnSave.prop('disabled', false)
                    btnSave.removeClass('disabled')
                    btnSave.text('Update')

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

        // $('#kode, #tanggal, #keterangan, #produk, #qty, #nama, #file').on('change keyup', function() {
        //     cekForm()
        //     // cekTableLength()
        // })

        // $('#area-button').on('mouseover mouseenter mouseleave mousemove', function() {
        //     cekForm()
        //     // cekTableLength()
        // })

        function getKode() {
            $.ajax({
                url: '/inventory/bac-terima/generate-kode/' + tanggal.val(),
                method: 'GET',
                success: function(res) {
                    console.log(res.kode);
                    kode.val(res.kode)
                }
            })
        }

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
            qtyTerima.val('')
        }

        function generateNo() {
            let no = 1

            tblCart.find('tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        function formatRibuan(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
