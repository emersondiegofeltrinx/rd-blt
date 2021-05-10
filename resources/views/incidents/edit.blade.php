@extends('layout.main')

@section('breadcrumb')
    {{ __('messages.EditIncident') }}
@endsection

@section('content')
    <div class="mb-2">
        <a href="{{ route('incidents.index') }}" class="btn btn-primary">
            {{ __('messages.Back') }}
        </a>
    </div>

    <form method="post" action="{{ route('incidents.update', $incident->id) }}">
        @csrf
        @method('put')
        @include('incidents.fields')

        <div class="mt-2 text-end">
            <a href="{{ route('incidents.index') }}" class="btn btn-secondary">
                {{ __('messages.Cancel') }}
            </a>
            <button type="submit" class="btn btn-primary">
                {{ __('messages.Update') }}
            </button>
        </div>
    </form>
@endsection
