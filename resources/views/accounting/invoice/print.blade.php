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
        @if ($perusahaan->logo_perusahaan != null)
            <img src="https://lh5.googleusercontent.com/cZa50BVIn6L4bPNloBLPluqyceKScQTtID5BrZXRYI7D4_JPhunRHyUczoKgFfM_Euqfe0SYAOKh0vbz"
                alt="Logo Perusahaan">
        @else
            <img src="https://www.zonefresh.co.id/assets/images/product/default.jpg" alt="Logo Perusahaan">
        @endif
    </center>

    <hr>

    <center>
        <h2>INVOICE</h2>
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

        <tr>
            <td></td>
            <td> </td>
            <td class="border-right"></td>

            <td style="color: white">.</td>
            <td></td>
            <td class="border-right"></td>
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
            {{-- @foreach ($invoice->sale->detail_sale as $ds)
                <tr>
                    <td>1</td>
                    <td>
                        <b>{{ $ds->item->nama }}</b>
                        <br>
                        Lorem ipsum dolor sit amet.
                    </td>
                    <td>Rp. {{ number_format($ds->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach --}}

            <tr>
                <td>1</td>
                <td colspan="1">
                    <p>{{ $invoice->catatan ? $invoice->catatan : 'Tidak ada catatan' }}</p>
                </td>
                <td>
                    <p>Rp.
                        <span style="float: right">{{ number_format($invoice->dibayar) }}</span>
                    </p>
                </td>
            </tr>

            @foreach ($related_invoices as $ri)
                <tr>
                    <td>
                        <p>{{ $no++ }}</p>
                    </td>
                    <td colspan="1">
                        <p>Pembayaran tgl
                            {{ date('d M Y', strtotime($ri->tanggal_dibayar)) }}
                        </p>
                    </td>
                    <td>
                        <p>
                            Rp.
                            <span style="float: right">({{ number_format($ri->dibayar) }})</span>
                        </p>
                    </td>
                </tr>
                @php
                    $totalDibayar += $ri->dibayar;
                @endphp
            @endforeach

            <tr>
                <td></td>
                <td>
                    <p>
                        <b><u>Muatan : </u></b>
                        <br>
                        {{ $invoice->sale->spal->jml_muatan }} Ton x
                        Rp.{{ number_format($invoice->sale->spal->harga_unit) }}/Ton

                        <span style="float: right">
                            Rp
                            {{ number_format($invoice->sale->spal->jml_muatan * $invoice->sale->spal->harga_unit) }}
                        </span>
                        <br>
                        <br>
                    </p>
                </td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <b style="float: right">TOTAL</b>
                </td>
                <td>
                    <b> Rp. </b>
                    <span style="float: right">
                        <b>{{ number_format($invoice->sale->grand_total - $totalDibayar) }}</b>
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

            <br><br><br><br><br>

            <p>Siti Khoerunisah</p>
        </center>
    </div>
</body>

</html>
