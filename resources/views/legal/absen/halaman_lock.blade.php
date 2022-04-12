<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>PT MJS</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="{{ asset('template/assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/assets/css/transparent/app.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
</head>

<body class='pace-top'>

    <div class="app-cover"></div>
    <div id="app" class="app">

        <div class="coming-soon">
            <div class="coming-soon-header">
                <div class="bg-cover"></div>
            </div>
            <div class="coming-soon-content">
                @if ($data->logo_perusahaan != null)
                    <img src="{{ Storage::url('public/logo/') . $data->logo_perusahaan }}" alt="Logo Perusahaan"
                        class="img-fluid rounded" style="width:400px">
                @else
                    <img src="https://www.zonefresh.co.id/assets/images/product/default.jpg" alt="Logo Perusahaan"
                        class="img-fluid rounded" style="width: 150px;height: 150px;border-radius: 10%;">
                @endif
                <div class="desc">
                    <br>
                    <form action="" method="POST">
                        <div class="input-group input-group-lg mx-auto mb-2">
                            <span class="input-group-text border-0"><i class="fas fa-lock-open"></i></span>
                            <input type="password" name="password" class="form-control fs-13px border-0 shadow-none"
                                placeholder="Password" />
                            <button type="submit" name="un_lock" class="btn fs-13px btn-primary">Submit</button>
                        </div>
                    </form>
                    Silahkan masukan password untuk membuka halaman absensi.
                </div>

            </div>
            <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
                data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
        </div>
</body>

</html>
