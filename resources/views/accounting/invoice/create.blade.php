@extends('layouts.master')
@section('title', 'Create Invoice')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('invoice_create') }}

        <form action="{{ route('invoice.store') }}" method="POST" id="form-invoice">
            @csrf
            @method('POST')
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

        const tglInvoice = $('#tanggal-invoice')
        const tglDibayar = $('#tanggal-dibayar')
        const attn = $('#attn')
        const attnSale = $('#attn-sale')

        const kode = $('#kode')
        const produk = $('#produk')
        const kodeProduk = $('#kode-produk')
        const unitProduk = $('#unit-produk')

        const diskonHidden = $('#diskon-hidden')
        const sisaHidden = $('#sisa-hidden')
        const telahDibayarHidden = $('#telah-dibayar-hidden')
        const totalHidden = $('#total-hidden')
        const grandTotalHidden = $('#grand-total-hidden')

        const diskon = $('#diskon')
        const sisa = $('#sisa')
        const telahDibayar = $('#telah-dibayar')
        const total = $('#total')
        const grandTotal = $('#grand-total')

        const bayar = $('#bayar')

        const catatan = $('#catatan')
        const catatanSale = $('#catatan-sale')

        // const btnAdd = $('#btn-add')
        const btnUpdate = $('#btn-update')
        const btnSave = $('#btn-save')
        const btnCancel = $('#btn-cancel')

        const tblCart = $('#tbl-cart')
        const tblPayment = $('#tbl-payment')

        getKode()

        tglInvoice.change(function() {
            getKode()
        })

        sale.change(function() {
            spal.text('Loading...')
            status.text('Loading...')
            attnSale.text('Loading...')
            tglSale.text('Loading...')
            catatanSale.text('Loading...')

            diskon.val('Loading...')
            sisa.val('Loading...')
            telahDibayar.val('Loading...')
            total.val('Loading...')
            grandTotal.val('Loading...')

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
                        catatanSale.text(res.catatan)
                        status.text(res.lunas == 0 ? 'Belum Lunas' : 'Lunas')
                        attnSale.text(res.attn)

                        // telahDibayar.prop('type', 'number')
                        // grandTotal.prop('type', 'number')
                        // diskon.prop('type', 'number')
                        // sisa.prop('type', 'number')
                        telahDibayarHidden.val(res.total_dibayar)
                        grandTotalHidden.val(res.grand_total)
                        diskonHidden.val(res.diskon)
                        sisaHidden.val(res.grand_total - res.total_dibayar)
                        totalHidden.val(res.grand_total + res.diskon)

                        bayar.prop('max', sisa.val())

                        telahDibayar.val(formatRibuan(res.total_dibayar))
                        grandTotal.val(formatRibuan(res.grand_total))
                        diskon.val(formatRibuan(res.diskon))
                        sisa.val(formatRibuan(res.grand_total - res.total_dibayar))
                        total.val(formatRibuan(res.grand_total + res.diskon))

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
                                <td>
                                    ${value.qty}
                                    <input type="hidden" class="qty-hidden" name="qty[]" value="${value.qty}">
                                </td>
                                <td>
                                    ${value.sub_total}
                                    <input type="hidden" class="subtotal-hidden" name="subtotal[]" value="${value.sub_total}">
                                </td>
                            </tr>
                            `)
                        })

                        if (res.invoices.length > 0) {
                            $.each(res.invoices, function(index, value) {
                                let dateString = value.tanggal_invoice
                                let dateObject = new Date(dateString)

                                let formatTanggalInvoice = dateObject.toJSON()
                                    .slice(0, 10)
                                    .split('-')
                                    .reverse()
                                    .join('/')

                                payments.push(`
                                    <tr>
                                        <td>${noPayment++}</td>
                                        <td>${value.kode}</td>
                                        <td>${formatTanggalInvoice}</td>
                                        <td>${formatRibuan(value.dibayar)}</td>
                                        <td>${value.status}</td>
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

            if ($(this).val() > 0 || sale.val() || tanggal.val() || attn.val()) {
                btnSave.prop('disabled', false)
                btnSave.removeClass('disabled')
            } else {
                btnSave.prop('disabled', true)
                btnSave.addClass('disabled')
            }
            // }
        })

        function getKode() {
            kode.val('Loading...')

            $.ajax({
                url: '/accounting/invoice/generate-kode/' + tglInvoice.val(),
                method: 'GET',
                success: function(res) {
                    setTimeout(() => {
                        kode.val(res.kode)
                    }, 500)
                }
            })
        }

        function formatRibuan(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endpush
