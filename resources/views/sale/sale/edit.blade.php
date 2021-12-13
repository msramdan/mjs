@extends('layouts.master')
@section('title', 'Edit Sale')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('sale_edit') }}

        <form action="{{ route('sale.store') }}" method="POST" id="form-sale">
            @csrf
            @method('POST')
            <div class="row">
                @include('sale.sale.include.spal-info')

                @include('sale.sale.include.cart')
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        const spal = $('#spal')
        const namaKapal = $('#nama-kapal')
        const namaMuatan = $('#nama-muatan')
        const jmlMuatan = $('#jml-muatan')
        const pelabuhanMuat = $('#pelabuhan-muat')
        const pelabuhanBongkar = $('#pelabuhan-bongkar')
        const hargaUnit = $('#harga-unit')

        const tanggal = $('#tanggal')
        const attn = $('#attn')
        const customer = $('#customer')

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

        btnSave.prop('disabled', false)
        btnCancel.prop('disabled', false)

        spal.change(function() {
            customer.val('Loading...')

            namaKapal.text('Loading...')
            namaMuatan.text('Loading...')
            jmlMuatan.text('Loading...')
            pelabuhanMuat.text('Loading...')
            pelabuhanBongkar.text('Loading...')
            hargaUnit.text('Loading...')

            $.ajax({
                url: '/sale/spal/get-spal-by-id/' + $(this).val(),
                method: 'get',
                success: function(res) {
                    setTimeout(() => {
                        customer.val(res.customer.nama)

                        namaKapal.text(res.nama_kapal)
                        namaMuatan.text(res.nama_muatan)
                        jmlMuatan.text(res.jml_muatan)
                        pelabuhanMuat.text(res.pelabuhan_muat)
                        pelabuhanBongkar.text(res.pelabuhan_bongkar)
                        hargaUnit.text(formatRibuan(res.harga_unit))
                    }, 500)
                },
            })
        })

        produk.change(function() {
            harga.prop('type', 'text')
            harga.prop('disabled', true)
            harga.val('Loading...')

            qty.prop('type', 'text')
            qty.prop('disabled', true)
            qty.val('Loading...')

            $.ajax({
                url: '/inventory/item/get-item-by-id/' + $(this).val(),
                method: 'get',
                success: function(res) {
                    stok.val(res.stok)
                    kodeProduk.val(res.kode)
                    unitProduk.val(res.unit.nama)

                    setTimeout(() => {
                        harga.prop('type', 'number')
                        harga.prop('disabled', false)
                        harga.val(parseInt(hargaUnit.text()))

                        qty.prop('type', 'number')
                        qty.prop('disabled', false)
                        qty.val('')
                        qty.focus()
                    }, 500)
                }
            })
        })

        btnAdd.click(function() {
            if (!spal.val()) {
                spal.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Spal tidak boleh kosong'
                })

            } else if (!tanggal.val()) {
                tanggal.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal tidak boleh kosong'
                })

            } else if (!attn.val()) {
                attn.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Attn. tidak boleh kosong'
                })

            } else if (!produk.val() || !harga.val() || !qty.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data (produk, harga, & qty) tidak boleh kosong'
                })

            } else if (parseInt(qty.val()) >= parseInt(stok.val())) {
                qty.val('')
                qty.focus()
                btnAdd.prop('disabled', true)

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Stok ${produk.find('option:selected').text()} hanya tersisa ${stok.val()}`
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
                        </td>
                        <td>
                            ${qty.val()}
                            <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                            <input type="hidden" class="stok-hidden" name="stok[]" value="${stok.val()}">
                            <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                        </td>
                        <td>
                            ${formatRibuan(subtotal)}
                            <input type="hidden" class="harga-hidden" name="subtotal[]" value="${subtotal}">
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
                hitungTotal()
                clearForm()
                cekTableLength()

                produk.focus()
            }
        })

        btnUpdate.click(function() {
            let index = $('#index-tr').val()

            if (!spal.val()) {
                spal.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Spal tidak boleh kosong'
                })

            } else if (!tanggal.val()) {
                tanggal.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tanggal tidak boleh kosong'
                })

            } else if (!attn.val()) {
                attn.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Attn. tidak boleh kosong'
                })

            } else if (!produk.val() || !harga.val() || !qty.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data (produk, harga, & qty) tidak boleh kosong'
                })

            } else if (parseInt(qty.val()) >= parseInt(stok.val())) {
                qty.val('')
                qty.focus()
                btnAdd.prop('disabled', true)

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Stok ${produk.find('option:selected').text()} hanya tersisa ${stok.val()}`
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
                    </td>
                    <td>
                        ${qty.val()}
                        <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                        <input type="hidden" class="stok-hidden" name="stok[]" value="${stok.val()}">
                        <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                    </td>
                    <td>
                        ${formatRibuan(subtotal)}
                        <input type="hidden" class="harga-hidden" name="subtotal[]" value="${subtotal}">
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
                hitungTotal()
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
            cekTableLength()
        })

        $('#form-sale').submit(function(e) {
            e.preventDefault()
            btnSave.prop('disabled', true)
            btnSave.text('loading...')

            btnCancel.prop('disabled', true)
            btnCancel.text('loading...')

            let sale = {
                spal: spal.val(),
                tanggal: tanggal.val(),
                attn: attn.val(),
                diskon: diskon.val(),
                catatan: catatan.val(),
                total: $('#total-hidden').val(),
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
                url: '{{ route('sale.update', $sale->id) }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: sale,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update data',
                        text: 'Berhasil'
                    }).then(function() {
                        setTimeout(() => {
                            window.location =
                                '{{ route('sale.index') }}'
                        }, 500)
                    })

                    console.log(res);
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

        diskon.on('change keyup', function() {
            xDiskon = (parseInt($('#total-hidden').val()) - parseInt($(this).val()))

            if (Number.isNaN(xDiskon)) {
                grandTotal.val(formatRibuan(parseInt($('#total-hidden').val())))

                $('#grand-total-hidden').val(parseInt($('#total-hidden').val()))
            } else {
                grandTotal.val(formatRibuan(xDiskon))

                $('#grand-total-hidden').val(xDiskon)
            }

        })

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
    </script>
@endpush
