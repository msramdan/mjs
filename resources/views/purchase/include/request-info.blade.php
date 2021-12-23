<div class="col-md-3">
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Request Form</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i
                        class="fa fa-redo"></i>
                </a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse">
                    <i class="fa fa-minus"></i>
                </a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-group mb-2">
                <label class="form-label" for="request-form">Request Form</label>
                <select class="form-select" id="request-form" name="request_form" required
                    {{ $show ? 'readonly' : '' }}>
                    @if (!$show)
                        <option value="" disabled selected>-- Pilih --</option>

                        @forelse ($requestForm as $item)
                            <option value="{{ $item->id }}"
                                {{ $purchase && $purchase->request_form_id == $item->id ? 'selected' : '' }}>
                                {{ $item->kode }}
                            </option>
                        @empty
                            <option value="" disabled>Data tidak ditemukan</option>
                        @endforelse
                    @else
                        <option value="" disabled selected>{{ $purchase->request_form->kode }}</option>
                    @endif

                </select>
            </div>
        </div>
    </div>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Detail Request Form</h4>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table" id="tbl-detail-request">
                    <tr>
                        <td width="35">Kode</td>
                        <td>:</td>
                        <td id="kode-request">{{ $purchase ? $purchase->request_form->kode : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">User</td>
                        <td>:</td>
                        <td id="user">{{ $purchase ? $purchase->request_form->user->name : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Category</td>
                        <td>:</td>
                        <td id="category">{{ $purchase ? $purchase->request_form->category_request->nama : '' }}</td>
                    </tr>
                    <tr>
                        <td width="35">Tanggal</td>
                        <td>:</td>
                        <td id="tanggal-request">
                            {{ $purchase ? $purchase->request_form->tanggal->format('d/m/Y') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="35">Status</td>
                        <td>:</td>
                        <td id="status">{{ $purchase ? $purchase->request_form->status : '' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
