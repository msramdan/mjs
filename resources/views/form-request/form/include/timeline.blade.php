@php
$cekStatus = [];
@endphp

@foreach ($requestForm->status_request_forms as $srf)
    @php
        if ($srf->setting_category_request->user_id == auth()->id()) {
            $cekStatus['user'] = true;
            $cekStatus['info'] = $srf->status;
            $cekStatus['setting_category_request_form_id'] = $srf->setting_category_request_form_id;
        }
    @endphp
@endforeach

<div class="panel panel-inverse mb-3">
    <div class="panel-heading">
        <h4 class="panel-title">Timeline Approve</h4>
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
        @if (empty($show) && $cekStatus && $cekStatus['user'] == true)
            <form action="{{ route('request-form.set-status') }}" method="POST">
                @csrf
                @method('POST')

                <input type="hidden" name="setting_category_request_form_id"
                    value="{{ $cekStatus ? $cekStatus['setting_category_request_form_id'] : '' }}">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="text" id="user" name="user" class="form-control"
                                value="{{ auth()->user()->name }}" readonly required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="waktu">Waktu</label>
                            <input type="text" id="waktu" name="waktu" class="form-control"
                                value="{{ date('d/m/Y H:i') }}" readonly required>
                        </div>
                    </div>

                    <input type="hidden" name="request_form_id" value="{{ $requestForm->id }}" required>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status_rf">Status</label>
                            <select id="status_rf" name="status_rf" class="form-select" required>
                                <option value="" disabled selected>-- Pilih --</option>
                                <option value="Approve"
                                    {{ $cekStatus && $cekStatus['info'] == 'Approve' ? 'selected' : '' }}>Approve
                                </option>
                                <option value="Waiting"
                                    {{ $cekStatus && $cekStatus['info'] == 'Waiting' ? 'selected' : '' }}>Waiting
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="button"></label>
                            <button type="submit" class="btn btn-primary form-control">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <hr class="my-4" />
        @endif

        <div class="timeline">
            @foreach ($requestForm->status_request_forms as $i => $srf)
                <div class="timeline-item">
                    <div class="timeline-time">
                        <span class="date">{{ $srf->updated_at->diffForHumans() }}</span>
                        <span class="time">{{ $srf->updated_at->format('H:i') }}</span>
                    </div>
                    <div class="timeline-icon">
                        <a href="javascript:;">&nbsp;</a>
                    </div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <div class="userimage">
                                @if ($srf->setting_category_request->user->foto)
                                    <img src="{{ asset('storage/img/user/' . $srf->setting_category_request->user->foto) }}"
                                        alt="Foto User" style="width: 40px; height: 40px; object-fit: cover;" />
                                @else
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($srf->setting_category_request->user->email))) }}&s=128"
                                        alt="Foto User">
                                @endif
                            </div>
                            <div class="username">
                                <a href="javascript:;">
                                    {{ $srf->setting_category_request->user->name }}
                                </a>
                            </div>
                        </div>

                        <div class="timeline-body">
                            <div class="mb-3">
                                <h5 class="mb-1">
                                    Status:
                                    {!! $srf->status == 'Approve' ? 'Approve <i class="fa fa-check-circle text-blue ms-1"></i>' : 'Waiting <i class="fa fa-stopwatch text-warning ms-1"></i>' !!}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- loading --}}
            {{-- <div class="timeline-item">
                <div class="timeline-icon">
                    <a href="javascript:;">&nbsp;</a>
                </div>

                <div class="timeline-content">
                    <div class="timeline-body">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border spinner-border-sm me-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Loading...
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('template/assets/js/demo/timeline.demo.js') }}"
        type="8c39c8c897b4445bf4bfaf53-text/javascript">
    </script>
@endpush
