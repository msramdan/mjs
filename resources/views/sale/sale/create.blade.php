@extends('layouts.master')
@section('title', 'Create Sale')

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('sale_create') }}

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"
        integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const spal = $('#spal')
        const kode = $('#kode')
        const namaKapal = $('#nama-kapal')
        const namaMuatan = $('#nama-muatan')
        const jmlMuatan = $('#jml-muatan')
        const pelabuhanMuat = $('#pelabuhan-muat')
        const pelabuhanBongkar = $('#pelabuhan-bongkar')
        const hargaUnit = $('#harga-unit')
        const hargaDemorage = $('#harga-demorage')

        const tanggal = $('#tanggal')
        const attn = $('#attn')
        const customer = $('#customer')

        const produk = $('#produk')
        const kodeProduk = $('#kode-produk')
        const unitProduk = $('#unit-produk')
        // const stok = $('#stok')
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

        const lamaWaktuHidden = $('#lama-waktu-hidden')
        const isDemorage = $('#is-demorage-hidden')
        const qtyTimeSheet = $('#qty-time-sheet-hidden')

        const config = {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        };

        const hargaCleave = new Cleave("#harga", config)
        const diskonCleave = new Cleave("#diskon", config)

        getKode()

        tanggal.change(function() {
            getKode()
        })

        spal.change(function() {
            customer.val('Loading...')

            namaKapal.text('Loading...')
            namaMuatan.text('Loading...')
            jmlMuatan.text('Loading...')
            pelabuhanMuat.text('Loading...')
            pelabuhanBongkar.text('Loading...')
            hargaUnit.text('Loading...')
            hargaDemorage.text('Loading...')

            $.ajax({
                url: '/sale/spal/get-spal-by-id/' + $(this).val(),
                method: 'get',
                success: function(res) {
                    // console.log(res);

                    if (res.time_sheets.length != 0) {
                        lamaWaktuHidden.val(
                            `${res.time_sheets[0].hari + ' Hari, ' + res.time_sheets[0].jam + ' Jam, '+ res.time_sheets[0].menit + ' Menit'}`
                        )
                    } else {
                        lamaWaktuHidden.val('')
                    }

                    setTimeout(() => {
                        customer.val(res.customer.nama)

                        namaKapal.text(res.nama_kapal)
                        namaMuatan.text(res.nama_muatan)
                        jmlMuatan.text(res.jml_muatan)
                        pelabuhanMuat.text(res.pelabuhan_muat)
                        pelabuhanBongkar.text(res.pelabuhan_bongkar)
                        hargaUnit.text(formatRibuan(res.harga_unit))
                        hargaDemorage.text(res.harga_demorage ? formatRibuan(res
                            .harga_demorage) : '-')

                        qtyTimeSheet.val(res.time_sheets[0].qty)
                    }, 500)
                },
            })
        })

        produk.change(function() {
            btnAdd.prop('disabled', true)
            btnUpdate.prop('disabled', true)

            if (!spal.val()) {
                spal.focus()
                produk.val('')

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Spal tidak boleh kosong'
                })

            } else {
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
                        // console.log(res);

                        // stok.val(res.stok)
                        kodeProduk.val(res.kode)
                        unitProduk.val(res.unit.nama)
                        isDemorage.val(res.is_demorage)

                        setTimeout(() => {
                            qty.prop('type', 'number')
                            qty.prop('disabled', false)

                            if (qtyTimeSheet.val()) {
                                qty.val(parseInt(qtyTimeSheet.val()))
                            } else {
                                qty.val(parseInt(jmlMuatan.text()))
                            }

                            // harga.prop('type', 'number')
                            harga.prop('disabled', false)

                            if (res.is_demorage) {
                                harga.val(hargaDemorage.text() != '-' ? hargaDemorage.text() :
                                    hargaUnit.text())
                                if (lamaWaktuHidden.val()) {
                                    $('#lama-waktu-small')
                                        .text(`Note: ${lamaWaktuHidden.val()}`)
                                        .show()
                                }
                            } else {
                                harga.val(hargaUnit.text())
                                $('#lama-waktu-small').text('').hide()
                            }

                            harga.focus()

                            btnAdd.prop('disabled', false)
                            btnUpdate.prop('disabled', false)
                        }, 500)
                    }
                })
            }
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

            } else if (!produk.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data produk tidak boleh kosong'
                })

            } else if (!harga.val()) {
                harga.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data harga tidak boleh kosong'
                })

            } else if (!qty.val()) {
                qty.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data qty & harga tidak boleh kosong'
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

                let subtotal = parseInt(removeComma(harga.val())) * qty.val()

                tblCart.find('tbody').append(`
                    <tr>
                        <td>${tblCart.find('tbody tr').length + 1}</td>
                        <td>
                            ${produk.find('option:selected').text()}
                            <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                            <input type="hidden" class="is-demorage-hidden" name="is_demorage[]" value="${isDemorage.val()}">
                        </td>
                        <td>${unitProduk.val()}</td>
                        <td>
                            ${formatRibuan(harga.val())}
                            <input type="hidden" class="harga-hidden" name="harga[]" value="${removeComma(harga.val())}">
                            <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                        </td>
                        <td>
                            ${qty.val()}
                            <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                        <td>
                            ${formatRibuan(subtotal)}
                            <input type="hidden" class="harga-hidden" name="subtotal[]" value="${subtotal}">
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

                $('#lama-waktu-small').text('').hide()
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

            } else if (!produk.val() || !harga.val()) {
                produk.focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Data produk & harga tidak boleh kosong'
                })

            } else {
                // cek duplikasi pas update
                $('input[name="produk[]"]').each(function(i) {
                    // i = index each
                    if ($(this).val() == produk.val() && i != index) {
                        tblCart.find('tbody tr:eq(' + i + ')').remove()
                    }
                })

                let subtotal = parseInt(removeComma(harga.val())) * qty.val()

                $('#tbl-cart tbody tr:eq(' + index + ')').html(`
                    <td></td>
                    <td>
                        ${produk.find('option:selected').text()}
                        <input type="hidden" class="produk-hidden" name="produk[]" value="${produk.val()}">
                        <input type="hidden" class="is-demorage-hidden" name="is_demorage[]" value="${isDemorage.val()}">
                    </td>
                    <td>${unitProduk.val()}</td>
                    <td>
                        ${formatRibuan(harga.val())}
                        <input type="hidden" class="harga-hidden" name="harga[]" value="${removeComma(harga.val())}">
                        <input type="hidden" class="unit-hidden" name="unit[]" value="${unitProduk.val()}">
                    </td>
                    <td>
                        ${qty.val()}
                        <input type="hidden" class="qty-hidden" name="qty[]" value="${qty.val()}">
                    <td>
                        ${formatRibuan(subtotal)}
                        <input type="hidden" class="harga-hidden" name="subtotal[]" value="${subtotal}">
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

                $('#lama-waktu-small').text('').hide()
            }
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            btnAdd.hide()
            btnUpdate.show()

            produk.val($('.produk-hidden:eq(' + index + ')').val())
            harga.val(formatRibuan($('.harga-hidden:eq(' + index + ')').val()))
            qty.val($('.qty-hidden:eq(' + index + ')').val())
            // stok.val($('.stok-hidden:eq(' + index + ')').val())
            unitProduk.val($('.unit-hidden:eq(' + index + ')').val())
            isDemorage.val($('.is-demorage-hidden:eq(' + index + ')').val())

            if ($('.is-demorage-hidden:eq(' + index + ')').val() == 'true' && lamaWaktuHidden.val() != '') {
                // console.log(`item ini demorage`);
                $('#lama-waktu-small').text(`Note: ${lamaWaktuHidden.val()}`).show()
            } else {
                // console.log(`item ini bukan demorage`);
                $('#lama-waktu-small').text(``).hide()
            }

            $('#index-tr').val(index)
        })

        $(document).on('click', '.btn-delete', function(e) {
            $(this).parent().parent().remove()

            generateNo()
            hitungTotal()
            hitungDiskon()
            cekTableLength()
        })

        $('#form-sale').submit(function(e) {
            e.preventDefault()
            btnSave.prop('disabled', true)
            btnSave.text('loading...')

            btnCancel.prop('disabled', true)
            btnCancel.text('loading...')

            let sale = {
                kode: kode.val(),
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
                type: 'POST',
                url: '{{ route('sale.store') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: sale,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Simpan data',
                        text: 'Berhasil'
                    }).then(function() {
                        setTimeout(() => {
                            window.location = '{{ route('sale.index') }}'
                        }, 500)
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

        diskon.on('change keyup', function() {
            hitungDiskon()
        })

        function hitungDiskon() {
            // if (!isNaN($('#diskon').val()) && $('#diskon').val() > 0) {
            xTotal = parseInt($('#total-hidden').val())
            xDiskon = (xTotal - parseInt(removeComma($('#diskon').val())))

            if (Number.isNaN(xDiskon)) {
                grandTotal.val(formatRibuan(xTotal))

                $('#grand-total-hidden').val(xTotal)
            } else {
                grandTotal.val(formatRibuan(xDiskon))

                $('#grand-total-hidden').val(xDiskon)
            }
            // }
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
                url: '/sale/sale/generate-kode/' + tanggal.val(),
                method: 'GET',
                success: function(res) {
                    setTimeout(() => {
                        kode.val(res.kode)
                    }, 500)
                }
            })
        }

        function removeComma(number) {
            return parseFloat(number.replace(/,/g, ''))
        }
    </script>
@endpush
