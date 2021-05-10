@if (Session::has('message-success'))
    <div class="alert alert-success mb-0">
        <ul class="mb-0">
            @foreach (Session::get('message-success') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('message-error'))
    <div class="alert alert-danger mb-0">
        <ul class="mb-0">
            @foreach (Session::get('message-error') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
