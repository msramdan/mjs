@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <strong>Success!</strong>
        <br>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-success alert-dismissible fade show">
        <strong>Success!</strong>
        <br>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></span>
    </div>
@endif
