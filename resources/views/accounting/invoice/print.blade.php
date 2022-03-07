<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $invoice->kode }}</title>

    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        hr {
            border: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 1px;
        }

        .bordered-table {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        .borderless-table {
            border: none;
            border-collapse: collapse;
            width: 85%;
        }

        table tr td {
            padding-left: 10px;
            padding-right: 10px;
        }

        .border-right {
            border-right: 1pt solid black;
        }

        .sign {
            float: right;
            margin-right: 35px;
        }

        img {
            width: 150px;
            height: 100px;
            border-radius: 10%;
            object-fit: cover;
        }

    </style>
</head>

<body>
    <center>
        @if ($perusahaan->logo_perusahaan != null)
            <img src="{{ asset('/storage/logo/' . $perusahaan->logo_perusahaan) }}" alt="Logo Perusahaan">
        @else
            <img src="https://www.zonefresh.co.id/assets/images/product/default.jpg" alt="Logo Perusahaan">
        @endif
    </center>

    <hr>

    <center>
        <h3>INVOICE</h3>
    </center>

    <table class="bordered-table">
        <tr>
            <td>To</td>
            <td> : </td>
            <td class="border-right"> {{ $invoice->sale->spal->customer->nama }}</td>

            <td>Date</td>
            <td> : </td>
            <td class="border-right">{{ $invoice->tanggal_invoice->format('d-M-Y') }}</td>
        </tr>
        <tr>
            <td>Attn.</td>
            <td> : </td>
            <td class="border-right">{{ $invoice->attn }}</td>

            <td>Invoice No </td>
            <td> : </td>
            <td class="border-right">{{ $invoice->kode }}</td>
        </tr>
        <tr>
            {{-- address customer --}}
            <td>Address</td>
            <td> : </td>
            <td class="border-right">{{ $invoice->sale->spal->customer->alamat }}</td>

            <td>Address</td>
            <td> : </td>
            {{-- Str::limit($perusahaan->alamat_perusahaan, 50) --}}
            <td class="border-right">{{ $perusahaan->alamat_perusahaan }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td> : </td>
            <td class="border-right">{{ $invoice->sale->spal->customer->telp }} <br></td>

            <td>Phone</td>
            <td> : </td>
            <td class="border-right">{{ $perusahaan->telp }} <br></td>
        </tr>
    </table>

    <table class="bordered-table" style="margin-top: 25px;" border="1">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>DESCRIPTION</th>
                <th>PRICE(IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->sale->detail_sale as $ds)
                <tr>
                    <td>1</td>
                    <td>
                        <b>{{ $ds->item->nama }}</b>
                        <br>
                        Lorem ipsum dolor sit amet.
                    </td>
                    <td>Rp. {{ number_format($ds->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3">
                    <div>
                        <br>
                        <br>
                        <b><u>Note : </u></b>
                        <br>

                        {{-- {{ $invoice->catatan }} --}}
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus.
                        <br>
                        <br>
                    </div>

                    <div>
                        <b><u>Muatan : </u></b>
                        <br>

                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ullam natus adipisci pariatur aut
                        consequuntur sapiente animi tempora nihil rem officia.
                        <br>
                        <br>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <b>TOTAL</b>
                </td>
                <td>
                    <b>Rp. 200,000,000</b>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <b>Terbilang: Dua ratus juta rupiah</b>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- transfer ke -->
    <table class="borderless-table" style="margin-top: 25px;" cellspacing="0" cellpadding="0">
        <tr>
            <td>Mohon ditransfer ke : </td>
            <td>
                <p>
                    <u>
                        Bank BCA Cab. Epicentrum Walk Jakarta - Selatan
                    </u>
                </p>
                <p>Acc. No : 098767890098</p>
                <p>AN. PT. Marindo Jaya Sejahtera</p>
            </td>
        </tr>
    </table>


    <!-- ttd -->
    <div class="sign">
        <center>
            <p>Batam, {{ date('d F Y') }}</p>

            <br><br><br><br>

            <p>{{ auth()->user()->name }}</p>
        </center>
    </div>
</body>

</html>
