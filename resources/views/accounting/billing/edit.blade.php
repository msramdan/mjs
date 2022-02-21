@extends('layouts.master')
@section('title', 'Edit Billing')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('billing_edit') }}

        <form action="{{ route('billing.update', $billing->id) }}" method="POST" id="form-billing">
            @csrf
            @method('PUT')

            <div class="row">
                @include('accounting.billing.include.purchase-info')

                @include('accounting.billing.include.cart')
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        const purchase = $('#purchase')
        const kodePurchase = $('#kode-purchase')
        const tglPurchase = $('#tanggal-purchase')
        const requestForm = $('#request-form')
        const status = $('#status')

        const tglBilling = $('#tanggal-billing')
        const tglDibayar = $('#tanggal-dibayar')
        const attn = $('#attn')
        const attnPurchase = $('#attn-purchase')

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
        const catatanPurchase = $('#catatan-purchase')

        // const btnAdd = $('#btn-add')
        const btnUpdate = $('#btn-update')
        const btnSave = $('#btn-save')
        const btnCancel = $('#btn-cancel')

        const tblCart = $('#tbl-cart')
        const tblPayment = $('#tbl-payment')

        tglBilling.change(function() {
            getKode()
        })

        purchase.change(function() {
            requestForm.text('Loading...')
            status.text('Loading...')
            attnPurchase.text('Loading...')
            tglPurchase.text('Loading...')
            catatanPurchase.text('Loading...')

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
                url: '/purchase/get-purchase-by-id/' + $(this).val(),
                method: 'GET',
                success: function(res) {
                    console.log(res);
                    console.log(res.request_form);

                    setTimeout(() => {
                        // kodePurchase.text(res.kode)
                        requestForm.text(res.request_form.kode)
                        catatanPurchase.text(res.catatan ? res.catatan : '-')
                        status.text(res.lunas == 0 ? 'Belum Lunas' : 'Lunas')
                        attnPurchase.text(res.attn)

                        telahDibayarHidden.val(res.total_dibayar)
                        grandTotalHidden.val(res.grand_total)
                        diskonHidden.val(res.diskon)
                        sisaHidden.val(res.grand_total - res.total_dibayar)
                        totalHidden.val(res.grand_total + res.diskon)

                        bayar.prop('max', sisa.val())

                        telahDibayar.val(formatRibuan(res.total_dibayar))
                        grandTotal.val(formatRibuan(res.grand_total))
                        diskon.val(res.diskon ? formatRibuan(res.diskon) : 0)
                        sisa.val(formatRibuan(res.grand_total - res.total_dibayar))
                        total.val(formatRibuan(res.grand_total + res.diskon))

                        let dateString = res.tanggal
                        let dateObject = new Date(dateString)
                        tglPurchase.text(dateObject.toJSON().slice(0, 10).split('-').reverse()
                            .join('/'))

                        let noCart = 1
                        let items = []

                        let noPayment = 1
                        let payments = []

                        $.each(res.detail_purchase, function(index, value) {
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

                        if (res.billings.length > 0) {
                            $.each(res.billings, function(index, value) {
                                let dateString = value.tanggal_billing
                                let dateObject = new Date(dateString)

                                let formatTanggalbilling = dateObject.toJSON()
                                    .slice(0, 10)
                                    .split('-')
                                    .reverse()
                                    .join('/')

                                payments.push(`
                                    <tr>
                                        <td>${noPayment++}</td>
                                        <td>${value.kode}</td>
                                        <td>${formatTanggalbilling}</td>
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
            if ($(this).val() > 0 || purchase.val() || tanggal.val() || attn.val()) {
                btnSave.prop('disabled', false)
                btnSave.removeClass('disabled')
            } else {
                btnSave.prop('disabled', true)
                btnSave.addClass('disabled')
            }
        })

        tglDibayar.change(function() {
            let statusBilling = $('#status-billing')
            let akunBeban = $('#col-akun-beban')
            let akunSumber = $('#col-akun-sumber')

            if ($(this).val()) {
                statusBilling.val('Paid')
                akunBeban.show()
                akunSumber.show()
            } else {
                statusBilling.val('Unpaid')
                akunBeban.hide()
                akunSumber.hide()
            }
        })

        function getKode() {
            kode.val('Loading...')

            $.ajax({
                url: '/accounting/billing/generate-kode/' + tglBilling.val(),
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
        document.getElementById('yourBox').onchange = function() {
            document.getElementById('TextFeeBank').disabled = !this.checked;
        };
    </script>
@endpush
