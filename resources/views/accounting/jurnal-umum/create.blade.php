@extends('layouts.master')
@section('title', 'Create ' . trans('sidebar.sub_menu.jurnal_umum'))

@section('content')
    <div id="content" class="app-content">

        {{ Breadcrumbs::render('jurnal_umum_create') }}

        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">{{ trans('sidebar.sub_menu.jurnal_umum') }}</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload">
                        <i class="fa fa-redo"></i>
                    </a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <form action="">
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-4 mb-1">
                            <label class="form-label" for="start_date">Tanggal Transaksi</label>

                            <div class="input-group mb-3">
                                <input required="" class="form-control" required type="date" id="tanggal"
                                    name="start_date" placeholder="Tanggal Transaksi">
                            </div>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="form-label" for="end_date">No. Bukti</label>
                            <div class="input-group mb-3">
                                <input required="" class="form-control" required type="text" id="no_bukti" name="end_date"
                                    placeholder="No. Bukti">
                            </div>
                        </div>
                    </div>
                    <button style="margin-bottom: 10px;" type="button" name="add_berkas" id="add_berkas"
                        class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                    <table class="table table-bordered " id="dynamic_field">
                        <tr>
                            <th style="width:20%">Nama Akun </th>
                            <th style="width:35%">Deksripsi</th>
                            <th style="width:20%">Debit</th>
                            <th style="width:20%">Kredit</th>
                            <th style="width:5%">Action</th>
                        </tr>
                    </table>

                    <table class="table " id="">
                        <tr>
                            <td style="width:20%">
                                <button id="simpan_data" type="submit" class="btn btn-danger"><i class="fas fa-save"></i>
                                    Create</button>
                                <a href="{{ route('jurnal-umum.index') }}" class="btn btn-info"><i
                                        class="fas fa-undo"></i> Kembali</a>
                            </td>
                            <td style="width:35%"></td>
                            <td style="width:20%;font-size:14px"> <b>Total Debit :</b> <br> <span id="sum_debit"></span>
                            </td>
                            <td style="width:20%;font-size:14px"> <b>Total Kredit :</b> <br> <span id="sum_kredit"></span>
                            </td>
                            <th style="width:5%"></th>
                        </tr>
                    </table>

                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><select required name="account_coa_id[]" class="form-control"><option style="color: black;" value="">-- Pilih -- </option><?php foreach ($coa as $key => $data) { ?><option style="color:black" value="<?php echo $data->id; ?>"><?php echo $data->kode; ?> - <?php echo $data->nama; ?> </option><?php } ?></select></td><td><input type="text" required class="form-control" placeholder="Deskripsi" /> </td><td><input type="text" value="0" class="form-control nominal_debit_text" id="debit' +
                    i +
                    '"  placeholder=""  /> <input value="0" type="hidden" class="form-control nominal_debit" id="debit_asli' +
                    i +
                    '" name="debit[]" placeholder="" value="" /></td><td><input type="text" class="form-control nominal_kredit_text" id="kredit' +
                    i +
                    '" value="0"  /> <input value="0" type="hidden" class="form-control nominal_kredit" id="kredit_asli' +
                    i +
                    '" name="kredit[]"   /></td><td><button type="button" name="remove" id="' +
                    i +
                    '" class="btn btn-danger btn_remove2"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>'
                );
                var kredit = 'kredit' + i
                var debit = 'debit' + i
                var reserve = 'reserve' + i

                var tanpa_rupiah_expense = document.getElementById(kredit);
                if (tanpa_rupiah_expense) {
                    tanpa_rupiah_expense.addEventListener('keyup', function(e) {
                        tanpa_rupiah_expense.value = formatRupiah(this.value);
                        let str = kredit;
                        let res = str.replace(/kredit/g, "");
                        $('#kredit_asli' + res).val(tanpa_rupiah_expense.value.replace(/\./g, ''))
                    });
                }
                //debit
                var debit_rupiah_expense = document.getElementById(debit);
                if (debit_rupiah_expense) {
                    debit_rupiah_expense.addEventListener('keyup', function(e) {
                        debit_rupiah_expense.value = formatRupiah(this.value);

                        let str = debit;
                        let res = str.replace(/debit/g, "");
                        $('#debit_asli' + res).val(debit_rupiah_expense.value.replace(/\./g, ''))
                    });
                }
            });

            // untuk hadle detail remark ketika update kredit
            $(document).on('keyup', '.db_kredit', function() {
                var id = $(this).closest('input').attr('id');
                var strBaru = id.replace('kredit_db_text', 'kredit_db');
                var a = document.getElementById(id);
                if (a) {
                    a.addEventListener('keyup', function(e) {
                        a.value = formatRupiah(this.value);
                        $('#' + strBaru).val(a.value.replace(/\./g, ''))
                    });
                }
            });
            // untuk hadle detail remark ketika update debit
            $(document).on('keyup', '.db_debit', function() {
                var id2 = $(this).closest('input').attr('id');
                var strBaru2 = id2.replace('debit_db_text', 'debit_db');
                var a2 = document.getElementById(id2);
                if (a2) {
                    a2.addEventListener('keyup', function(e) {
                        a2.value = formatRupiah(this.value);
                        $('#' + strBaru2).val(a2.value.replace(/\./g, ''))
                    });
                }
            });
            // untuk hadle detail remark ketika update reserve
            $(document).on('keyup', '.db_reserve', function() {
                var id3 = $(this).closest('input').attr('id');
                var strBaru3 = id3.replace('reserve_db_text', 'reserve_db');
                var a3 = document.getElementById(id3);
                if (a3) {
                    a3.addEventListener('keyup', function(e) {
                        a3.value = formatRupiah(this.value);
                        $('#' + strBaru3).val(a3.value.replace(/\./g, ''))
                    });
                }
            });

            $(document).on('click', '.btn_remove2', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                calc_total_debit();
                calc_total_kredit();
            });

            $(document).on('click', '.btn_remove2', function() {
                var bid = this.id;
                var trid = $(this).closest('tr').attr('id');
                $('#' + trid + '').remove();
                calc_total_debit();
                calc_total_kredit();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).on('keyup mouseup', '.nominal_debit_text', function() {
            calc_total_debit();
        })

        $(document).on('keyup mouseup', '.nominal_kredit_text', function() {
            calc_total_kredit();
        })

        $('#add_berkas').click(function() {
            calc_total_debit();
            calc_total_kredit();
        })

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        function convertToRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++)
                if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ',';
            return rupiah.split('', rupiah.length - 1).reverse().join('');
        }

        function calc_total_debit() {
            var sum_debit = 0;
            $(".nominal_debit").each(function() {
                nominal = parseFloat($(this).val());
                if (!nominal) {
                    nominal = 0;
                } else {
                    nominal = parseFloat($(this).val());
                }
                sum_debit += nominal
            });
            $('#sum_debit').text(convertToRupiah(sum_debit));
        }

        function calc_total_kredit() {
            var sum_kredit = 0;
            $(".nominal_kredit").each(function() {
                nominal = parseFloat($(this).val());
                if (!nominal) {
                    nominal = 0;
                } else {
                    nominal = parseFloat($(this).val());
                }
                sum_kredit += nominal
            });
            $('#sum_kredit').text(convertToRupiah(sum_kredit));
        }
    </script>

    <script>
        $("#simpan_data").click(function() {
            var tanggal = $('#tanggal').val();
            var no_bukti = $('#no_bukti').val();
            if (!tanggal) {
                alert('Transaction date has not been filled in');
                $('#tanggal').focus();
            } else if (!no_bukti) {
                alert('transaction number has not been filled in');
                $('#no_bukti').focus();
            } else {
                if (confirm('are you sure to save this transaction?')) {
                    $.ajax({
                        type: "POST",
                        url: "",
                        data: {
                            'process_simpan': true,
                            'tanggal': tanggal,
                            'no_bukti': no_bukti,
                        },
                        dataType: "json",
                        success: function(result) {
                            console.log(result)
                        }

                    });
                }
            }



        });
    </script>


@endpush
