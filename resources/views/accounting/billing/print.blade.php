<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Billing - {{ $billing->kode }}</title>

    <style>
        .invoice-box {
            /* max-width: 800px; */
            /* margin: auto; */
            padding: 10px;
            padding-bottom: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 14px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr td:nth-child(3) {
            text-align: right;
        }

        .invoice-box table tr td:nth-child(4) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 20px;
            line-height: 25px;
            color: #333;
            padding-top: 10px;
            padding-bottom: 0;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                {{-- <div style="float: left; margin: 0;">
                                    <img src="https://via.placeholder.com/150" width="80" height="80" />
                                </div> --}}

                                {{-- <div style="float: right; margin: 0;"> --}}
                                {{ $perusahaan->nama_perusahaan }} <br />
                                <div style="font-size: 14px;">
                                    {{ $perusahaan->email }}<br />

                                    {{ $perusahaan->telp }}<br />

                                    @if ($perusahaan->website)
                                        {{ $perusahaan->website }}<br />
                                    @endif

                                    {{ Str::limit($perusahaan->alamat_perusahaan, 50) }}
                                </div>
                                {{-- </div> --}}
                            </td>

                            <td>
                                <strong>#{{ $billing->kode }}</strong><br />
                                <strong>{{ $billing->tanggal_billing->format('d F Y') }}</strong><br />
                                <strong>{{ $billing->status }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                {{-- {{ $perusahaan->nama_perusahaan }}<br />
                                hello@mjs.com<br />
                                {{ Str::limit($perusahaan->alamat_perusahaan, 50) }} --}}
                            </td>

                            <td>
                                {{ $billing->purchase->supplier->nama }}<br />
                                {{ $billing->purchase->supplier->email }}<br />
                                {{ $billing->purchase->supplier->telp }}<br />
                                {{ $billing->purchase->supplier->alamat }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
                <td>Qty</td>
                <td>Subtotal</td>
            </tr>

            @foreach ($billing->purchase->detail_purchase as $ds)
                <tr class="item">
                    <td>{{ $ds->item->nama }}</td>
                    <td>Rp. {{ number_format($ds->harga, 0, ',', '.') }}</td>
                    <td>x{{ $ds->qty }}</td>
                    <td>Rp. {{ number_format($ds->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr class="item">
                <td></td>
                <td></td>
                <td><strong>Disc</strong></td>
                <td>Rp. {{ number_format($billing->purchase->diskon, 0, ',', '.') }}</td>
            </tr>

            <tr class="item">
                <td></td>
                <td></td>
                <td><strong>Grand Total</strong></td>
                <td><strong>Rp. {{ number_format($billing->purchase->grand_total, 0, ',', '.') }} </strong></td>
            </tr>
        </table>

        @if ($billing->catatan)
            <p style="margin-bottom: 0;"><strong>Note</strong></p>
            <p style="margin-top: 0; font-size: 13px;">
                <i>{{ $billing->catatan }}</i>
            </p>
        @endif
    </div>
</body>

</html>
