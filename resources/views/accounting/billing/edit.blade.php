@extends('layouts.master')
@section('title', 'Edit Invoice')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('invoice_edit') }}

        <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" id="form-invoice">
            @csrf
            @method('PUT')
            <div class="row">
                @include('accounting.invoice.include.sale-info')

                @include('accounting.invoice.include.cart')
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        const sale = $('#sale')
        const kodeSale = $('#kode-sale')
        const tglSale = $('#tanggal-sale')
        const spal = $('#spal')
        const status = $('#status')

        const tanggal = $('#tanggal')
        const attn = $('#attn')
        const attnSale = $('#attn-sale')

        const kode = $('#kode')
        const produk = $('#produk')
        const kodeProduk = $('#kode-produk')
        const unitProduk = $('#unit-produk')
        const diskon = $('#diskon')
        const bayar = $('#bayar')
        const sisa = $('#sisa')
        const telahDibayar = $('#telah-dibayar')
        const catatan = $('#catatan')
        const total = $('#total')
        const grandTotal = $('#grand-total')

        // const btnAdd = $('#btn-add')
        const btnUpdate = $('#btn-update')
        const btnSave = $('#btn-save')
        const btnCancel = $('#btn-cancel')

        const tblCart = $('#tbl-cart')
        const tblPayment = $('#tbl-payment')

        tanggal.change(function() {
            getKode()
        })

        sale.change(function() {
            spal.text('Loading...')
            status.text('Loading...')
            // kodeSale.text('Loading...')
            attnSale.text('Loading...')
            tglSale.text('Loading...')
            catatan.text('Loading...')

            telahDibayar.val('Loading...')
            grandTotal.val('Loading...')
            diskon.val('Loading...')
            sisa.val('Loading...')
            catatan.val('Loading...')

            tblCart.find('tbody').html(`
            <tr>
                <td colspan="6" class="text-center">Loading...</td>
            </tr>
            `)

            tblPayment.find('tbody').html(`
            <tr>
                <td colspan="6" class="text-center">Loading...</td>
            </tr>
            `)

            $.ajax({
                url: '/sale/sale/get-sale-by-id/' + $(this).val(),
                method: 'get',
                success: function(res) {

                    setTimeout(() => {
                        // kodeSale.text(res.kode)
                        spal.text(res.spal.kode)
                        catatan.val(res.catatan.slice(0, 200) + '...')
                        status.text(res.status_pembayaran)
                        attnSale.text(res.attn)

                        telahDibayar.prop('type', 'number')
                        grandTotal.prop('type', 'number')
                        diskon.prop('type', 'number')
                        sisa.prop('type', 'number')
                        telahDibayar.val(parseInt(res.total_dibayar))
                        grandTotal.val(parseInt(res.grand_total))
                        diskon.val(parseInt(res.diskon))
                        sisa.val(parseInt(res.sisa))
                        total.val(parseInt(res.grand_total) + parseInt(res.diskon))
                        bayar.prop('max', sisa.val())

                        $('#sisa-hidden').val(sisa.val())

                        let dateString = res.tanggal
                        let dateObject = new Date(dateString)
                        tglSale.text(dateObject.toJSON().slice(0, 10).split('-').reverse()
                            .join('/'))

                        let noCart = 1
                        let items = []

                        let noPayment = 1
                        let payments = []

                        $.each(res.detail_sale, function(index, value) {
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
                                    ${value.harga}
                                    <input type="hidden" class="harga-hidden" name="harga[]" value="${value.harga}">
                                </td>
                            </tr>
                            `)
                        })

                        if (res.invoices.length > 0) {
                            $.each(res.invoices, function(index, value) {
                                let dateString = value.tanggal_dibayar
                                let dateObject = new Date(dateString)

                                let formatTanggalDibayar = dateObject.toJSON()
                                    .slice(0, 10)
                                    .split('-')
                                    .reverse()
                                    .join('/')

                                payments.push(`
                                    <tr>
                                        <td>${noPayment++}</td>
                                        <td>
                                            ${value.kode}
                                        </td>
                                        <td>
                                            ${formatTanggalDibayar}
                                        </td>
                                        <td>
                                            ${value.dibayar}
                                        </td>
                                        <td>
                                            ${value.sisa}
                                        </td>
                                    </tr>
                                `)
                            })

                            tblPayment.find('tbody').html(payments)
                        } else {
                            tblPayment.find('tbody').html(`
                                <tr>
                                    <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            `)
                        }

                        tblCart.find('tbody').html(items)

                        attn.focus()
                    }, 500)
                },
            })
        })

        bayar.on('keyup change', function() {
            // if (!isNaN($(this).val())) {
            // telahDibayar.val(parseInt(telahDibayar.val()) + parseInt($(this).val()))

            // sisa.val(parseInt(grandTotal.val()) - parseInt(telahDibayar.val()))

            if ($(this).val() > 0 || sale.val() || tanggal.val() || attn.val() || $(this).val() <= sisa.val()) {
                btnSave.prop('disabled', false)
                btnSave.removeClass('disabled')
            } else {
                btnSave.prop('disabled', true)
                btnSave.addClass('disabled')
            }
            // }
        })

        $('#tanggal-dibayar').change(function() {
            if ($(this).val()) {
                $('#status-invoice').val('Paid')

                // $('#status-invoice').prop('disabled', false)
                // $('#status-invoice').prop('required', true)
            } else {
                $('#status-invoice').val('Unpaid')

                // $('#status-invoice').prop('disabled', true)
                // $('#status-invoice').prop('required', false)
            }
        })

        function getKode() {
            kode.val('Loading...')

            $.ajax({
                url: '/accounting/invoice/generate-kode/' + tanggal.val(),
                method: 'GET',
                success: function(res) {
                    setTimeout(() => {
                        kode.val(res.kode)
                    }, 500)
                }
            })
        }
    </script>
@endpush
