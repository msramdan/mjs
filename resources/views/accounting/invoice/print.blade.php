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
            font-size: 11px;
            padding-right: 50px;
            padding-left: 50px;
        }

        hr {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 1px;
            border-left: none;
            border-right: none;
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

        /* table tr td {
            padding-left: 5px;
            padding-right: 5pt;
        } */

        .border-right {
            border-right: 1pt solid black;
        }

        .sign {
            float: right;
            margin-right: 35px;
        }

        img {
            width: 220px;
            height: 120px;
            border-radius: 10%;
            object-fit: cover;
        }

    </style>
</head>

<body>
    @php
        $no = 2;
        $totalDibayar = 0;

        function penyebut($nilai)
        {
            $nilai = abs($nilai);

            $huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

            $temp = '';

            if ($nilai < 12) {
                $temp = ' ' . $huruf[$nilai];
            } elseif ($nilai < 20) {
                $temp = penyebut($nilai - 10) . ' belas';
            } elseif ($nilai < 100) {
                $temp = penyebut($nilai / 10) . ' puluh' . penyebut($nilai % 10);
            } elseif ($nilai < 200) {
                $temp = ' seratus' . penyebut($nilai - 100);
            } elseif ($nilai < 1000) {
                $temp = penyebut($nilai / 100) . ' ratus' . penyebut($nilai % 100);
            } elseif ($nilai < 2000) {
                $temp = ' seribu' . penyebut($nilai - 1000);
            } elseif ($nilai < 1000000) {
                $temp = penyebut($nilai / 1000) . ' ribu' . penyebut($nilai % 1000);
            } elseif ($nilai < 1000000000) {
                $temp = penyebut($nilai / 1000000) . ' juta' . penyebut($nilai % 1000000);
            } elseif ($nilai < 1000000000000) {
                $temp = penyebut($nilai / 1000000000) . ' milyar' . penyebut(fmod($nilai, 1000000000));
            } elseif ($nilai < 1000000000000000) {
                $temp = penyebut($nilai / 1000000000000) . ' trilyun' . penyebut(fmod($nilai, 1000000000000));
            }

            return $temp;
        }

        function terbilang($nilai)
        {
            if ($nilai < 0) {
                $hasil = 'minus ' . trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }

            return ucwords($hasil) . ' Rupiah';
        }
    @endphp
    <center>
        <img src="{{ 'template/logo.png' }}" alt="" style="width:350px">
    </center>
    <hr>
    <center>
        <h2>INVOICE</h2>
    </center>
    <table class="bordered-table" border="1">
        <tr>
            <td style="width: 50%">
                <table class="table">
                    <tr>
                        <td style="width: 25%">To</td>
                        <td style="width: 5%">:</td>
                        <td style="width: 75%">{{ $invoice->sale->spal->customer->nama }}</td>
                    </tr>
                    <tr>
                        <td style="width: 25%">Address</td>
                        <td style="width: 5%">:</td>
                        <td style="width: 75%">{{ $invoice->sale->spal->customer->alamat }}</td>
                    </tr>
                    <tr>
                        <td style="width: 25%">Attn</td>
                        <td style="width: 5%">:</td>
                        <td style="width: 75%">{{ $invoice->attn }}</td>
                    </tr>
                    <tr>
                        <td style="width: 25%; color:white">.</td>
                        <td style="width: 5%; color:white">.</td>
                        <td style="width: 75%; color:white">.</td>
                    </tr>
                    <tr>
                        <td style="width: 25%; color:white">.</td>
                        <td style="width: 5%; color:white">.</td>
                        <td style="width: 75%; color:white">.</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%">
                <table class="table">
                    <tr>
                        <td style="width: 25%">Date</td>
                        <td style="width: 5%">:</td>
                        <td style="width: 75%">{{ $invoice->tanggal_invoice->format('d-M-Y') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 25%">Invoice No</td>
                        <td style="width: 5%">:</td>
                        <td style="width: 75%">{{ $invoice->kode }}</td>
                    </tr>
                    <tr>
                        <td style="width: 25%">Address</td>
                        <td style="width: 5%">:</td>
                        <td style="width: 75%">{{ $perusahaan->alamat_perusahaan }}</td>
                    </tr>
                    <tr>
                        <td style="width: 25%">Phone</td>
                        <td style="width: 5%">:</td>
                        <td style="width: 75%">{{ $perusahaan->telp }}</td>
                    </tr>
                    <tr>
                        <td style="width: 25%; color:white">.</td>
                        <td style="width: 5%; color:white">.</td>
                        <td style="width: 75%; color:white">.</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>


    <table class="bordered-table" style="margin-top: 25px;" border="1">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 45%">DESCRIPTION</th>
                <th style="width: 50%">PRICE(IDR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding:5px; height:150px;vertical-align: text-top;border-bottom-style: none;">1</td>
                <td style="padding:5px;vertical-align: text-top;border-bottom-style: none; ">
                    {{ $invoice->catatan ? $invoice->catatan : 'Tidak ada catatan' }}</td>
                <td style="padding:5px;vertical-align: text-top;border-bottom-style: none;">Rp. <span
                        style="float: right">{{ number_format($invoice->dibayar) }}</span></td>
            </tr>

            <?php
                if ($jml_invoce_terkait > 0) { ?>
                <tr>
                    <td style="border-top-style: none;border-bottom-style: none;padding:5px"></td>
                    <td style="border-top-style: none;border-bottom-style: none;padding:5px">
                       <b><u>Histori Pembayaran</u></b>
                    </td>
                    <td style="border-top-style: none;border-bottom-style: none;padding:5px"> </td>
                </tr>
            <?php   } ?>
            @foreach ($related_invoices as $ri)
                <tr>
                    <td style="border-top-style: none;border-bottom-style: none;padding:5px">
                        {{-- {{ $no++ }} --}}
                    </td>
                    <td style="border-top-style: none;border-bottom-style: none;padding:5px">
                       - Pembayaran Tanggal
                        {{ date('d M Y', strtotime($ri->tanggal_dibayar)) }}
                    </td>
                    <td style="border-top-style: none;border-bottom-style: none;padding:5px">
                        Rp.
                        <span style="float: right">({{ number_format($ri->dibayar) }})</span>
                    </td>
                </tr>
                @php
                    $totalDibayar += $ri->dibayar;
                @endphp
            @endforeach

            <tr>
                <td style="border-top-style: none;padding:5px"></td>
                <td style="border-top-style: none;padding:5px">
                    <p>
                        <b><u>Muatan : </u></b> <br>
                        {{ $invoice->sale->spal->jml_muatan }} Ton x
                        Rp.{{ number_format($invoice->sale->spal->harga_unit) }}/Ton

                        <span style="float: right">
                            Rp
                            {{ number_format($invoice->sale->spal->jml_muatan * $invoice->sale->spal->harga_unit) }}
                        </span>
                    </p><br>
                </td>
                <td style="border-top-style: none;padding:5px"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <b style="float: right;padding-right:5px">TOTAL</b>
                </td>
                <td>
                    <b style="padding-left: 5px"> Rp. </b>
                    <span style="float: right">
                        <b>{{ number_format($invoice->dibayar) }}</b>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <b>Terbilang:
                        {{ terbilang($invoice->sale->grand_total - $totalDibayar) }}#
                    </b>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- transfer ke -->
    <table class="borderless-table" style="margin-top: 5px;" cellspacing="0" cellpadding="0">
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

            <br><br><br><br><br>

            <p>Siti Khoerunisah</p>
        </center>
    </div>
</body>

</html>
