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
            <form id="form-jurnal">
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-4 mb-1">
                            <label class="form-label" for="tanggal">Tanggal Transaksi</label>

                            <div class="input-group mb-3">
                                <input class="form-control" type="date" id="tanggal" name="tanggal"
                                    placeholder="Tanggal Transaksi" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label class="form-label" for="no_bukti">No. Bukti</label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" id="no_bukti" name="no_bukti"
                                    placeholder="No. Bukti" required>
                            </div>
                        </div>
                    </div>
                    <button style="margin-bottom: 10px;" type="button" name="add_berkas" id="add_berkas"
                        class="btn btn-success btn-sm">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        Add
                    </button>

                    <table class="table table-bordered table-responsive" id="dynamic_field">
                        <thead>
                            <tr>
                                <th style="width:20%">Nama Akun </th>
                                <th style="width:35%">Deksripsi</th>
                                <th style="width:20%">Debit</th>
                                <th style="width:20%">Kredit</th>
                                <th style="width:5%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <table class="table" id="">
                        <tr>
                            <td style="width:20%">
                                <button id="simpan_data" type="submit" class="btn btn-danger">
                                    <i class="fas fa-save"></i>
                                    Create</button>
                                <a href="{{ route('jurnal-umum.index') }}" class="btn btn-info">
                                    <i class="fas fa-undo"></i> Kembali
                                </a>
                            </td>
                            <td style="width:35%"></td>
                            <td style="width:20%;font-size:14px"> <b>Total Debit :</b> <br>
                                <span id="sum_debit"></span>
                            </td>
                            <td style="width:20%;font-size:14px"> <b>Total Kredit :</b> <br>
                                <span id="sum_kredit"></span>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            var i = 1;
            $('#add_berkas').click(function() {
                i++;
                $('#dynamic_field tbody').append(`
                <tr id="row${i}">
                    <td>
                        <div class="form-group">
                            <select class="form-select" name="coa_id[]" required>
                            <option style="color: black;" value="" disabled selected>-- Pilih -- </option>
                            <?php foreach ($akunDetail as $key => $ad) { ?>
                                <option style="color:black" value="<?= $ad->id ?>">
                                    <?= $ad->kode ?> - <?= $ad->nama ?>
                                </option>
                            <?php } ?>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="deskripsi[]" class="form-control" placeholder="Deskripsi" required/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control nominal_debit_text" id="debit${i}"  placeholder=""  value="0"/>
                            <input type="hidden" class="form-control nominal_debit" id="debit_asli${i}" name="debit[]" placeholder="" value="0"/>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control nominal_kredit_text" id="kredit${i}" value="0"/>
                            <input type="hidden" class="form-control nominal_kredit" id="kredit_asli${i}" name="kredit[]" value="0"/>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger btn_remove2" name="remove" id="${i}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>`);

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
        $("#simpan_data").click(function(e) {
            e.preventDefault()
            $('#simpan_data').prop('disabled', true)
            $('#simpan_data').text('Loading...')

            var tanggal = $('#tanggal').val();
            var no_bukti = $('#no_bukti').val();
            var sum_debit = parseFloat($('#sum_debit').text().replace(/,/g, ''));
            var sum_kredit = parseFloat($('#sum_kredit').text().replace(/,/g, ''));

            if (!tanggal) {
                $('#tanggal').focus();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tanggal tidak boleh kosong',
                })
            } else if (!no_bukti) {
                $('#no_bukti').focus();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No bukti tidak boleh kosong',
                })
            } else if (sum_debit != sum_kredit) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Total debit dan total kredit harus sama',
                })
            } else {
                var jurnal_umum = {
                    tanggal: $('#tanggal').val(),
                    no_bukti: $('#no_bukti').val(),
                    coa_id: $('select[name="coa_id[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                    deskripsi: $('input[name="deskripsi[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                    kredit: $('input[name="kredit[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                    debit: $('input[name="debit[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                }

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    url: "{{ route('jurnal-umum.store') }}",
                    data: jurnal_umum,
                    dataType: "json",
                    success: function(result) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Simpan data',
                            text: 'Berhasil'
                        }).then(function() {
                            window.location = '{{ route('jurnal-umum.index') }}'
                        })
                    },
                    error: function(xhr, status, error) {
                        // console.log(xhr.responseText)
                        console.error('error njir');
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        })
                    }
                });
            }
        });
    </script>
@endpush
