@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class=" alert alert-danger mt-3">
            {{ $error }}
        </div>
    @endforeach
@endif
