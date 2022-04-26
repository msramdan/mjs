@extends('layouts.master')
@section('title', 'Edit purchase')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('purchase_edit') }}

        <form action="{{ route('purchase.update', $purchase->id) }}" method="POST" id="form-purchase">
            @csrf
            @method('PUT')
            <div class="row">
                @include('purchase.include.request-info')

                @include('purchase.include.cart')
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        const requestForm = $('#request-form')
        const kodeRequest = $('#kode-request')
        const category = $('#category')
        const tglRequest = $('#tanggal-request')
        const status = $('#status')
        // const hargaUnit = $('#harga-unit')

        const tanggal = $('#tanggal')
        const attn = $('#attn')
        const user = $('#user')
        const kode = $('#kode')
        const supplier = $('#supplier')

        const produk = $('#produk')
        const kodeProduk = $('#kode-produk')
        const unitProduk = $('#unit-produk')
        const stok = $('#stok')
        const harga = $('#harga')
        const qty = $('#qty')
        const diskon = $('#diskon')
        const catatan = $('#catatan')
        const total = $('#total')
        const grandTotal = $('#grand-total')

        const btnAdd = $('#btn-add')
        const btnUpdate = $('#btn-update')
        const btnSave = $('#btn-save')
        const btnCancel = $('#btn-cancel')

        const tblCart = $('#tbl-cart')

        const allProduks = []

        getAll()

        tanggal.change(function() {
            getKode()
        })

        requestForm.change(function() {
            user.val('Loading...')
            kodeRequest.text('Loading...')
            category.text('Loading...')
            tglRequest.text('Loading...')
            status.text('Loading...')
            user.text('Loading...')
            // hargaUnit.text('Loading...')

            $.ajax({
                url: '/purchase/get-request-form-by-id/' + $(this).val(),
                method: 'get',
                success: function(res) {
                    setTimeout(() => {
                        kodeRequest.text(res.kode)
                        user.text(res.user.name)
                        category.text(res.category_request.nama)
                        status.text(res.status)

                        let dateString = res.tanggal

                        let dateObject = new Date(dateString)

                        tglRequest.text(dateObject.toJSON().slice(0, 10).split('-').reverse()
                            .join('/'))
                        // hargaUnit.text(res.harga_unit)

                        supplier.focus()
                    }, 500)
                },
            })
        })

        supplier.change(function() {
            produk.html(`<option value="" disabled selected>Loading...</option>`)

            $.ajax({
                url: '/inventory/item/get-item-by-supplier/' + $(this).val(),
                method: 'get',
                success: function(res) {
                    console.log(res);
                    setTimeout(() => {
                        let listProduk = []

                        if (res.length > 0) {
                            listProduk.push(
                                `<option value="" disabled selected>-- Pilih --</option>`)

                            $.each(res, function(index, value) {
                                listProduk.push(
                                    `<option value="${value.item_id}">${value.kode +' - '+value.nama}</option>`
                                )
                            })
                        } else {
                            listProduk.push(
                                `<option value="" disabled selected>Data tidak ditemukan</option>`
                            )

                            // listProduk.push(
                            //     `<option value="" disabled selected>-- Pilih --</option>`)

                            // for (let i = 0; i < allProduks[0].length; i++) {
                            //     listProduk.push(
                            //         `<option value="${allProduks[0][i].id}">${allProduks[0][i].kode +' - '+allProduks[0][i].nama}</option>`
                            //     )
                            // }

                            // $.each(allProduks, function(index, value) {
                            //     listProduk.push(
                            //         `<option value="${value[index].id}">${value[index].kode +' - '+value[index].nama}</option>`
                            //     )
                            // })
                        }

                        if (!attn.val()) {
                            attn.focus()
                        } else {
                            produk.focus()
                        }

                        produk.html(listProduk)
                        tblCart.find('tbody').html('')

                        hitungDiskon()
                        hitungTotal()
                        cekTableLength()
                    }, 500)
                }
            })
        })

        produk.change(function() {
            if (!requestForm.val()) {
                requestForm.focus()
                produk.val('')

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Request Form tidak boleh kosong'
                })

            } else {
                harga.prop('type', 'text')
                harga.prop('disabled', true)
                harga.val('Loading...')

                qty.prop('type', 'text')
                qty.prop('disabled', true)
                qty.val('Loading...')

                $.ajax({
                    url: '/inventory/item/get-item-and-supplier/' + $(this).val() + '/' + supplier.val(),
                    method: 'GET',
                    success: function(res) {

                        console.log(res);

                        if (res.type == 'with supplier') {
                            stok.val(res.data.item.stok)
                            kodeProduk.val(res.data.item.kode)
                            unitProduk.val(res.data.item.unit.nama)

                            setTimeout(() => {
                                harga.prop('type', 'number')
                                harga.prop('disabled', false)
                                harga.val(res.data.harga_beli)

                                qty.prop('type', 'number')
                                qty.prop('disabled', false)
                                qty.val('')
                                qty.focus()
                            }, 500)
                        } else {

                            stok.val(res.data.stok)
                            kodeProduk.val(res.data.kode)
                            unitProduk.val(res.data.unit.nama)

                            setTimeout(() => {
                                harga.prop('type', 'number')
                                harga.prop('disabled', false)
                                harga.val(res.data.harga_estimasi)

                                qty.prop('type', 'number')
                                qty.prop('disabled', false)
                                qty.val('')
                                qty.focus()
                            }, 500)
                        }

                    }
                })
            }
        })

        btnAdd.click(function() {
            if (!requestForm.val()) {
                requestForm.focus()

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

            } else if (!supplier.val()) {
                supplier.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Supplier tidak boleh kosong'
                })

            } else if (!attn.val()) {
                attn.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Attn. tidak boleh kosong'
                })

            } else if (!produk.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Produk tidak boleh kosong'
                })

            } else if (!harga.val() || harga.val() < 1) {
                harga.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Harga tidak boleh kosong dan minimal 1'
                })

            } else if (!qty.val() || qty.val() < 1) {
                qty.focus()
                qty.val('')

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Qty tidak boleh kosong dan minimal 1'
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

                let subtotal = harga.val() * qty.val()

                tblCart.find('tbody').append(`
                    <tr>
                        <td>${tblCart.find('tbody tr').length + 1}</td>
                        <td>
                            ${produk.find('option:selected').text()}
                            <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                        </td>
                        <td>${unitProduk.val()}</td>
                        <td>
                            ${formatRibuan(harga.val())}
                            <input type="hidden" class="harga-hidden" name="harga[]" value="${harga.val()}">
                            <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                        </td>
                        <td>
                            ${qty.val()}
                            <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                            <input type="hidden" class="stok-hidden" name="stok[]" value="${stok.val()}">
                        </td>
                        <td>
                            ${formatRibuan(subtotal)}
                            <input type="hidden" class="subtotal-hidden" name="subtotal[]" value="${subtotal}">
                        </td>
                        <td>
                            <button class="btn btn-warning btn-xs me-1 btn-edit" type="button" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-danger btn-xs btn-delete" type="button" title="Delete">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                `)

                generateNo()
                hitungTotal()
                hitungDiskon()
                clearForm()
                cekTableLength()

                produk.focus()
            }
        })

        btnUpdate.click(function() {
            let index = $('#index-tr').val()

            if (!requestForm.val()) {
                requestForm.focus()

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

            } else if (!supplier.val()) {
                supplier.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Supplier tidak boleh kosong'
                })

            } else if (!attn.val()) {
                attn.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Attn. tidak boleh kosong'
                })

            } else if (!produk.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Produk tidak boleh kosong'
                })

            } else if (!harga.val() || harga.val() < 1) {
                harga.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Harga tidak boleh kosong dan minimal 1'
                })

            } else if (!qty.val() || qty.val() < 1) {
                qty.focus()
                qty.val('')

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Qty tidak boleh kosong dan minimal 1'
                })

            } else {
                // cek duplikasi pas update
                $('input[name="produk[]"]').each(function(i) {
                    // i = index each
                    if ($(this).val() == produk.val() && i != index) {
                        tblCart.find('tbody tr:eq(' + i + ')').remove()
                    }
                })

                let subtotal = harga.val() * qty.val()

                $('#tbl-cart tbody tr:eq(' + index + ')').html(`
                    <td></td>
                    <td>
                        ${produk.find('option:selected').text()}
                        <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                    </td>
                    <td>${unitProduk.val()}</td>
                    <td>
                        ${formatRibuan(harga.val())}
                        <input type="hidden" class="harga-hidden" name="harga[]" value="${harga.val()}">
                        <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                    </td>
                    <td>
                        ${qty.val()}
                        <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                        <input type="hidden" class="stok-hidden" name="stok[]" value="${stok.val()}">
                    </td>
                    <td>
                        ${formatRibuan(subtotal)}
                        <input type="hidden" class="subtotal-hidden" name="subtotal[]" value="${subtotal}">
                    </td>
                    <td>
                        <button class="btn btn-warning btn-xs me-1 btn-edit" type="button" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>

                        <button class="btn btn-danger btn-xs btn-delete" type="button" title="Delete">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                `)

                clearForm()
                hitungTotal()
                hitungDiskon()
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
            harga.val($('.harga-hidden:eq(' + index + ')').val())
            qty.val($('.qty-hidden:eq(' + index + ')').val())
            stok.val($('.stok-hidden:eq(' + index + ')').val())
            unitProduk.val($('.unit-hidden:eq(' + index + ')').val())

            $('#index-tr').val(index)
        })

        $(document).on('click', '.btn-delete', function(e) {
            $(this).parent().parent().remove()

            generateNo()
            hitungTotal()
            hitungDiskon()
            cekTableLength()
        })

        $('#form-purchase').submit(function(e) {
            e.preventDefault()
            btnSave.prop('disabled', true)
            btnSave.text('loading...')

            btnCancel.prop('disabled', true)
            btnCancel.text('loading...')

            let purchase = {
                request_form: requestForm.val(),
                tanggal: tanggal.val(),
                supplier: supplier.val(),
                attn: attn.val(),
                kode: kode.val(),
                diskon: diskon.val(),
                catatan: catatan.val(),
                total: $('#total-hidden').val(),
                tax: $('#tax').is(":checked") ? 'yes' : null,
                grand_total: $('#grand-total-hidden').val(),
                produk: $('input[name="produk[]"]').map(function() {
                    return $(this).val()
                }).get(),
                harga: $('input[name="harga[]"]').map(function() {
                    return $(this).val()
                }).get(),
                qty: $('input[name="qty[]"]').map(function() {
                    return $(this).val()
                }).get(),
                subtotal: $('input[name="subtotal[]"]').map(function() {
                    return $(this).val()
                }).get(),
            }

            $.ajax({
                type: 'PUT',
                url: '{{ route('purchase.update', $purchase->id) }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: purchase,
                success: function(res) {
                    // console.log(res);

                    Swal.fire({
                        icon: 'success',
                        title: 'Update data',
                        text: 'Berhasil'
                    }).then(function() {
                        window.location = '{{ route('purchase.index') }}'
                    })
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        })

        diskon.on('change keyup', function() {
            hitungDiskon()
        })

        $('#tax').change(function(){
            hitungTax()
        })

        function hitungTax() {
            let tax = 0
            let diskon = $('#diskon').val() ? parseInt($('#diskon').val().replace(',', '')) : 0
            let total = parseInt($('#total').val().replace(',', ''))

            if ($('#tax').is(':checked')) {
                tax = (total - diskon) * 0.11
                console.log('cek')
                console.log(tax)
                $('#tax-text').text(`+ tax: ${formatRibuan(tax)}`)
            } else {
                console.log('ga')
                console.log(tax)
                $('#tax-text').text(``)
            }

            $('#grand-total-hidden').val((total - diskon) + tax)
            grandTotal.val(formatRibuan((total - diskon) + tax))
        }

        function hitungDiskon() {
            // let xTotal = parseInt($('#total-hidden').val())
            // let xDiskon = (xTotal - parseInt($('#diskon').val()))

            // // let tax = 0
            // // if ($(this).is(':checked')) {
            // //     tax = xDiskon * 0.11
            // // }

            // if (Number.isNaN(xDiskon)) {
            //     grandTotal.val(formatRibuan(xTotal))

            //     $('#grand-total-hidden').val(xTotal)
            // } else {
            //     grandTotal.val(formatRibuan(xDiskon))

            //     $('#grand-total-hidden').val(xDiskon)
            // }

            hitungTax()

        }

        function cekTableLength() {
            let cek = tblCart.find('tbody tr').length

            if (cek > 0) {
                btnSave.prop('disabled', false)
                btnCancel.prop('disabled', false)
            } else {
                btnSave.prop('disabled', true)
                btnCancel.prop('disabled', true)
            }
        }

        function clearForm() {
            kodeProduk.val('')
            produk.val('')
            unitProduk.val('')
            harga.val('')
            qty.val('')
        }

        function generateNo() {
            let no = 1

            tblCart.find('tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        function hitungTotal() {
            let xTotal = 0

            $('input[name="subtotal[]"]').map(function() {
                xTotal += parseInt($(this).val())
            }).get()

            $('#total').val(formatRibuan(xTotal))
            $('#grand-total').val(formatRibuan(xTotal))

            $('#grand-total-hidden').val(xTotal)
            $('#total-hidden').val(xTotal)
        }

        function formatRibuan(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        function getKode() {
            kode.val('Loading...')

            $.ajax({
                url: '/purchase/generate-kode/' + tanggal.val(),
                method: 'GET',
                success: function(res) {
                    setTimeout(() => {
                        kode.val(res.kode)
                    }, 500)
                }
            })
        }

        function getAll() {
            $.ajax({
                url: '/inventory/item/get-all/',
                method: 'GET',
                success: function(res) {
                    allProduks.push(res)
                }
            })
        }
    </script>
@endpush
